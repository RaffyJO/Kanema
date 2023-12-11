<?php

use MongoDB\BSON\ObjectId;

if (session_status() != PHP_SESSION_ACTIVE)
    session_start();

require_once('src/lib/Functions/Connections/DB.php');
require_once('src/lib/Functions/URLDetection.php');
require_once('src/lib/Functions/MongoUtils.php');

class ProductModel
{
    function getItem(string $itemName): array
    {
        try {
            $db = new DB();
            $connection = $db->getConnection();
            if ($connection == null) die(print_r("Connection is Null", true));

            $collection = $connection->selectCollection('kanema', 'Product');
            $cursor = null;

            $isValidObjectId = MongoUtils::isValidObjectId($itemName);

            if ($isValidObjectId)
                $cursor = $collection->find(['_id' => new ObjectId($itemName)]);
            else
                $cursor = $collection->find(['name' => new MongoDB\BSON\Regex("$itemName", "i")]);



            if ($cursor) {
                $data = array();

                foreach ($cursor as $key) {
                    array_push(
                        $data,
                        array('_id' => strval($key->_id), 'name' => $key->name, 'price' => $key->price, 'category' => $key->category, 'imgUrl' => $key->imgUrl, 'stock' => $key->stock, 'available' => $key->available)

                    );
                }

                return array('data' => $data);
            } else {
                return array('error' => 'Something went wrong');
            }
        } catch (Exception $th) {
            return array('error' => $th);
        }
    }

    function findOneItem(string $itemName): array
    {
        try {
            $db = new DB();
            $connection = $db->getConnection();
            if ($connection == null) die(print_r("Connection is Null", true));

            $collection = $connection->selectCollection('kanema', 'Product');
            $cursor = null;

            $isValidObjectId = MongoUtils::isValidObjectId($itemName);

            if ($isValidObjectId)
                $cursor = $collection->findOne(['_id' => new ObjectId($itemName)]);
            else
                $cursor = $collection->findOne(['name' => new MongoDB\BSON\Regex("$itemName", "i")]);

            if ($cursor) {
                return array('data' => array('_id' => strval($cursor->_id), 'name' => $cursor->name, 'price' => $cursor->price, 'category' => $cursor->category, 'imgUrl' => $cursor->imgUrl, 'stock' => $cursor->stock, 'available' => $cursor->available));
            } else {
                return array('error' => 'Something went wrong');
            }
        } catch (Exception $th) {
            return array('error' => $th);
        }
    }

    public function getAll(): array
    {
        try {
            $db = new DB();
            $connection = $db->getConnection();
            if ($connection == null) die(print_r("Connection is Null", true));

            $collection = $connection->selectCollection('kanema', 'Product');
            $cursor = $collection->find([]);


            if ($cursor) {
                $data = array();

                foreach ($cursor as $key) {
                    array_push(
                        $data,
                        array('_id' => strval($key->_id), 'name' => $key->name, 'price' => $key->price, 'category' => $key->category, 'imgUrl' => $key->imgUrl, 'stock' => $key->stock, 'available' => $key->available)

                    );
                }

                return array('data' => $data);
            } else {
                return array('error' => 'Something went wrong');
            }
        } catch (Exception $th) {
            return array('error' => $th);
        }
    }

    public function updateItem(string $itemID, array $itemPayload): bool
    {
        // {
        //     "_id": "656e6ebc0a04f3555c2e4815",
        //     "name": "Cocacola",
        //     "price": 5000,
        //     "category": "drink",
        //     "imgUrl": "https://clipart-library.com/images_k/coca-cola-bottle-transparent-background/coca-cola-bottle-transparent-background-17.png",
        //     "stock": 2,
        //     "available": true
        //   }
        try {
            $db = new DB();
            $connection = $db->getConnection();

            if ($connection == null) die(print_r("Connection is Null", true));

            $collection = $connection->selectCollection('kanema', 'Product');
            $updateResult = $collection->updateOne(['_id' => new ObjectId($itemID)], ['$set' => $itemPayload]);


            if ($updateResult->getMatchedCount() === 1) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $th) {
            printf($th->getMessage());
            return false;
        }
    }
}

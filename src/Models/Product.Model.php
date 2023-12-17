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
                $cursor = $collection->find(['_id' => new ObjectId($itemName), 'is_deleted' => false]);
            else
                $cursor = $collection->find(['name' => new MongoDB\BSON\Regex("$itemName", "i"), 'is_deleted' => false]);



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
                $cursor = $collection->findOne(['_id' => new ObjectId($itemName), 'is_deleted' => false]);
            else
                $cursor = $collection->findOne(['name' => new MongoDB\BSON\Regex("$itemName", "i"), 'is_deleted' => false]);

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
            $cursor = $collection->find(['is_deleted' => false]);


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

    public function getAllHistory(): array
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

    public function create(array $payload): bool
    {
        try {
            $db = new DB();
            $connection = $db->getConnection();

            if ($connection == null) die(print_r("Connection is Null", true));

            $collection = $connection->selectCollection('kanema', 'Product');
            // var_dump($payload);
            $insertResult = $collection->insertMany($payload);


            if ($insertResult->getInsertedCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $th) {
            printf($th->getMessage());
            return false;
        }
    }

    public function delete(ObjectId $id): bool
    {
        try {
            $db = new DB();
            $connection = $db->getConnection();

            if ($connection == null) die(print_r("Connection is Null", true));

            $target = $this->findOneItem($id->__toString());
            if (count($target['data']) < 1) return false;

            $collection = $connection->selectCollection('kanema', 'Product');
            $deleteResult = $collection->updateOne(['_id' => $id], ['$set' => ['is_deleted' => true]]);


            if ($deleteResult->isAcknowledged() === true) {
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

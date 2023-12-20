<?php
require_once('src/lib/Functions/Connections/DB.php');
require_once('src/Models/Product.Model.php');


use MongoDB\BSON\ObjectId;

class OrderModel
{
    public function createOrder(array $payload): bool
    {
        try {
            $db = new DB();
            $connection = $db->getConnection();
            if ($connection == null) die(print_r("Connection is Null", true));
            $productModel = new ProductModel();

            $stockAvailable = true;

            foreach ($payload['details'] as $key => $value) {
                $targetItem = $productModel->findOneItem($value['Product_id']);

                if ($targetItem['data']['stock'] < $value['qty'])
                    $stockAvailable = false;
            }

            if (!$stockAvailable) {
                echo json_encode(array('error' => "Out of Stock"));
                return false;
            }

            $collection = $connection->selectCollection('kanema', 'Transaction');
            $cursor = $collection->insertOne($payload);

            if ($cursor->getInsertedCount() > 0) {
                $updateStatus = true;

                foreach ($payload['details'] as $key => $value) {
                    $targetItem = $productModel->findOneItem($value['Product_id']);

                    $targetItem['data']['stock'] -= $value['qty'];
                    $id = $targetItem['data']['_id'];

                    if ($targetItem['data']['stock'] < 1) $targetItem['data']['available'] = false;

                    unset($targetItem['data']['_id']);

                    $updateState = $productModel->updateItem($id, $targetItem['data']);

                    if (!$updateState) $updateStatus = false;
                }

                if ($updateStatus)
                    return true;

                return false;
            } else {
                return false;
            }
            return false;
        } catch (Exception $th) {
            printf($th->getMessage());
            echo json_encode(array('error' => $th->getMessage()));
            return false;
        }
    }

    public function callCleanedDataSeller(): string
    {
        try {
            $db = new DB();
            $connection = $db->getConnection();
            if ($connection == null) die(print_r("Connection is Null", true));

            $collection = $connection->selectCollection('kanema', 'BestSellerYearClean');
            $response = $collection->find([]);

            $cursor = $response;
            if ($cursor) {
                $data = array();

                foreach ($cursor as $key) {
                    array_push(
                        $data,
                        array(
                            '_id' => $key->_id,
                            'details' => $key->details,
                            'total' => $key->total,
                            'food' => $key->food,
                            'drink' => $key->drink,
                            'selledProduct' => $key->selledProduct,
                        )

                    );
                }

                return json_encode(array('data' => $data));
            } else {
                return json_encode(array('error' => 'Something went wrong'));
            }
        } catch (Exception $th) {
            printf($th);
            return json_encode(array('error' => $th));
        }
    }

    public function callCleanedData(): string
    {
        try {
            $db = new DB();
            $connection = $db->getConnection();
            if ($connection == null) die(print_r("Connection is Null", true));

            $collection = $connection->selectCollection('kanema', 'TransactionCleanedData');
            $response = $collection->find([]);

            $cursor = $response;
            if ($cursor) {
                $data = array();


                foreach ($cursor as $key) {
                    array_push(
                        $data,
                        array(
                            '_id' => $key->_id,
                            'details' => $key->details,
                            'total' => $key->total,
                            'food' => $key->food,
                            'drink' => $key->drink,
                            'selledProduct' => $key->selledProduct,
                        )

                    );
                }

                return json_encode(array('data' => $data));
            } else {
                return json_encode(array('error' => 'Something went wrong'));
            }
        } catch (Exception $th) {
            printf($th);
            return json_encode(array('error' => $th));
        }
    }

    public function getAll(): array
    {
        try {
            $db = new DB();
            $connection = $db->getConnection();
            if ($connection == null) die(print_r('Connection is Null', true));

            $collection = $connection->selectCollection('kanema', 'TransactionJOIN');
            $cursor = $collection->find([], ['sort' => ['timestamp' => -1]]);

            if ($cursor) {
                $data = array();
                foreach ($cursor as $key) {

                    array_push(
                        $data,
                        array(
                            '_id' => strval($key->_id),
                            'user' => $key->creator,
                            'time' => $key->timestamp,
                            'qty' => sizeof($key->details),
                            'total' => $key->total,
                            'details' => $key->details
                        )
                    );
                }
                //var_dump($data);

                return array('data' => $data);
            } else {
                return array('error' => 'Something went wrong');
            }
        } catch (Exception $th) {
            return array('error' => $th);
        }
    }

    public function get(String $search): array
    {
        try {
            $db = new DB();
            $connection = $db->getConnection();
            if ($connection == null) die(print_r("Connection is Null", true));

            $collection = $connection->selectCollection('kanema', 'TransactionJOIN');
            $cursor = null;

            $isValidObjectId = MongoUtils::isValidObjectId($search);

            if ($isValidObjectId)
                $cursor = $collection->find(['_id' => new ObjectId($search)]);
            else
                $cursor = $collection->find(['creator' => new MongoDB\BSON\Regex($search, "i")]);



            if ($cursor) {
                $data = array();

                foreach ($cursor as $key) {
                    array_push(
                        $data,
                        array(
                            '_id' => strval($key->_id),
                            'user' => $key->creator,
                            'time' => $key->timestamp,
                            'qty' => sizeof($key->details),
                            'total' => $key->total,
                            'details' => $key->details
                        )
                    );
                }

                return array('data' => $data);
            } else {
                return array('error' => 'Something went wrong');
            }
        } catch (Exception $th) {
            return array('error' => $th->getMessage());
        }
    }

    public function transactionCount(): string
    {
        $db = new DB();
        $connection = $db->getConnection();
        if ($connection == null) die(print_r("Connection is Null", true));

        $collection = $connection->selectCollection('kanema', 'Transaction');
        $cursor = $collection->aggregate([['$count' => 'countTransaction']]);

        $data = null;

        foreach ($cursor as $key) {
            $data = $key->countTransaction;
        }

        return json_encode(array('count' => $data));
    }

    public function countTransactionToday()
    {
        $db = new DB();
        $connection = $db->getConnection();
        if ($connection == null) die(print_r("Connection is Null", true));

        $collection = $connection->selectCollection('kanema', 'Transaction');
        $cursor = $collection->find([]);

        if ($cursor) {
            $counter = 0;

            foreach ($cursor as $key) {
                date_default_timezone_set('Asia/Jakarta');
                $date = gmdate("Y-m-d", $key->timestamp);

                if ($date == gmdate("Y-m-d", time()))
                    $counter++;
            }
        }

        return json_encode(array('count' => $counter));
    }

    public function countTransactionYesterday()
    {
        $db = new DB();
        $connection = $db->getConnection();
        if ($connection == null) die(print_r("Connection is Null", true));

        $collection = $connection->selectCollection('kanema', 'Transaction');
        $cursor = $collection->find([]);

        if ($cursor) {
            $counter = 0;

            foreach ($cursor as $key) {
                $date = gmdate("Y-m-d", $key->timestamp);
                if ($date === gmdate("Y-m-d", strtotime('-1 day', time())))
                    $counter++;
            }
        }

        return json_encode(array('count' => $counter));
    }
}

<?php
require_once('src/lib/Functions/Connections/DB.php');
require_once('src/Models/Product.Model.php');


use MongoDB\BSON\ObjectId;

class RequestModel
{
    public  function get(string $orderID): array
    {
        try {
            $db = new DB();
            $connection = $db->getConnection();
            if ($connection == null) die(print_r("Connection is Null", true));

            $collection = $connection->selectCollection('kanema', 'RequerstClenaedData');
            $cursor = null;

            $cursor = $collection->find(['_id' => new ObjectId($orderID)]);



            if ($cursor) {
                $data = array();

                foreach ($cursor as $key) {
                    array_push(
                        $data,
                        $key
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

    public  function getAll(): array
    {
        try {
            $db = new DB();
            $connection = $db->getConnection();
            if ($connection == null) die(print_r("Connection is Null", true));

            $collection = $connection->selectCollection('kanema', 'RequerstClenaedData');
            $cursor = null;

            $cursor = $collection->find([]);



            if ($cursor) {
                $data = array();

                foreach ($cursor as $key) {
                    array_push(
                        $data,
                        $key
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
}

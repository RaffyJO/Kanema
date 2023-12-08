<?php

if (session_status() != PHP_SESSION_ACTIVE)
    session_start();

require 'src/lib/Functions/Connections/DB.php';
require('src/lib/Functions/URLDetection.php');

class ProductModel
{
    public function getAll(): array
    {
        try {
            $db = new DB();
            $connection = $db->getConnection();
            if ($connection == null) die(print_r("Connection is Null", true));

            $collection = $connection->selectCollection('kanema', 'Product');
            $cursor = $collection->find([]);


            if ($cursor) {
                // var_dump($arr);
                $data = array();

                foreach ($cursor as $key) {
                    array_push(
                        $data,
                        // array('name' => $key->name, 'price' => $key->price, 'available' => $key->available)
                        $key

                    );
                }
                // var_dump($data);

                return array('data' => $data);
            } else {
                return array('error' => 'Something went wrong');
            }
        } catch (Exception $th) {
            return array('error' => $th);
        }
    }
}

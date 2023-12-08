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
                $data = array();
                //             "_id": 1,
                //   "name": "Mie Goreng",
                //   "price": 5000,
                //   "category": "food",
                //   "imgUrl": "https://indomie.com.au/wp-content/uploads/2019/05/noodle.png",
                //   "stock": 10,
                //   "available": true

                foreach ($cursor as $key) {
                    array_push(
                        $data,
                        array('_id' => strval($key->_id), 'name' => $key->name, 'price' => $key->price, 'category' => $key->category, 'imgUrl' => $key->imgUrl, 'stock' => $key->stock, 'available' => $key->available)

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

<?php
class OrderModel
{
    public function createOrder(array $payload): bool
    {
        try {
            $db = new DB();
            $connection = $db->getConnection();
            if ($connection == null) die(print_r("Connection is Null", true));

            $collection = $connection->selectCollection('kanema', 'order');
            $cursor = $collection->bulkWrite($payload);


            if ($cursor) {
                $data = array();

                foreach ($cursor as $key) {
                    array_push(
                        $data,
                        array('_id' => strval($key->_id), 'name' => $key->name, 'price' => $key->price, 'category' => $key->category, 'imgUrl' => $key->imgUrl, 'stock' => $key->stock, 'available' => $key->available)

                    );
                }
                // var_dump($data);

                return true;
            } else {
                return array('error' => 'Something went wrong');
            }
        } catch (Exception $th) {
            printf($th->getMessage());
            return false;
        }
    }
}

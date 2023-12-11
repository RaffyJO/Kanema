<?php
require_once('src/lib/Functions/Connections/DB.php');
require_once('src/Models/Product.Model.php');

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
                // {
                //     "_id": {
                //       "$oid": "6576c7ae1982e66341792f68"
                //     },
                //     "creator": "administrator",
                //     "timestamp": {
                //       "year": 2023,
                //       "month": 12
                //     },
                //     "details": [
                //       {
                //         "productName": "Cocacola",
                //         "category": "drink",
                //         "qty": 2,
                //         "subtotal": 10000
                //       },
                //       {
                //         "productName": "Susu",
                //         "category": "drink",
                //         "qty": 2,
                //         "subtotal": 10000
                //       },
                //       {
                //         "productName": "Mie Goreng",
                //         "category": "food",
                //         "qty": 2,
                //         "subtotal": 10000
                //       },
                //       {
                //         "productName": "Ayam Goreng",
                //         "category": "food",
                //         "qty": 2,
                //         "subtotal": 10000
                //       }
                //     ]
                //   }
                foreach ($cursor as $key) {
                    array_push(
                        $data,
                        array(
                            '_id' => $key->_id,
                            'details' => $key->details
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
}

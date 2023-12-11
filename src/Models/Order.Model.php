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

            if (!$stockAvailable) return false;

            $collection = $connection->selectCollection('kanema', 'Transaction');
            $cursor = $collection->insertOne($payload);

            if ($cursor->getInsertedCount() > 0) {
                $updateStatus = true;

                foreach ($payload['details'] as $key => $value) {
                    $targetItem = $productModel->findOneItem($value['Product_id']);

                    // var_dump($targetItem['data']);

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
}

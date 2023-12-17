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

    public  function getRAW(string $orderID): array
    {
        try {
            $db = new DB();
            $connection = $db->getConnection();
            if ($connection == null) die(print_r("Connection is Null", true));

            $collection = $connection->selectCollection('kanema', 'Request');
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

    public  function update(ObjectId $id, array $payload): array
    {
        $productModel = new ProductModel();

        try {
            $db = new DB();
            $connection = $db->getConnection();
            if ($connection == null) die(print_r("Connection is Null", true));

            $collection = $connection->selectCollection('kanema', 'Request');
            $cursor = null;

            $strID = $id->__toString();
            $requestData = $this->getRAW($strID)['data'][0];
            unset($requestData['_id']);

            $updatedData = $this->changeProperties($payload, $requestData);

            $cursor = $collection->updateOne(['_id' => $id], ['$set' => $updatedData]);

            if ($cursor->isAcknowledged() === true) {
                $updateState = true;
                $createState = true;
                $deleteState = true;

                $createIsDone = true;
                $updateIsDone = true;
                $deleteIsDone = true;

                $updateCounter = 0;
                if (count($payload['update']) > 0) {
                    foreach ($payload['update'] as $key => $value) {
                        if ($value['status'] === 'approved') {
                            $updateStatus = $productModel->updateItem($strID, $value);

                            if (!$updateStatus) {
                                $updateState = false;
                            }
                        }

                        if ($value['status'] !== 'pending') $updateCounter++;
                    }
                }

                if (!$updateState) return array('error' => 'Something went wrong on update');
                if ($updateCounter < count($payload['update']) && count($payload['update']) != 0) $updateIsDone = false;
                echo 'UP';
                var_dump($updateCounter < count($payload['update']) && count($payload['update']) != 0);

                $fieldToIn = array();
                $createCounter = 0;
                if (count($payload['create']) > 0) {
                    foreach ($payload['create'] as $key => $value) {
                        if ($value['status'] === 'approved')
                            array_push($fieldToIn, $value['fields']);

                        if ($value['status'] !== 'pending')  $createCounter++;
                    }


                    if (count($fieldToIn) > 0) {
                        $createStatus = $productModel->create($fieldToIn);

                        if (!$createStatus) $createState = false;
                    }
                }


                if (!$createState) return array('error' => 'Something went wrong on create');
                if ($createCounter < count($payload['create']) && count($payload['create']) != 0) $createIsDone = false;
                echo 'CR';
                var_dump($createCounter);
                var_dump($createCounter < count($payload['create']) && count($payload['create']) != 0);

                $deleteCounter = 0;
                if (count($payload['delete']) > 0) {
                    foreach ($payload['delete'] as $key => $value) {
                        if ($value['status'] === 'approved') {
                            $deleteID = ((array)$value['productID'])['$oid'];

                            $deleteStatus = $productModel->delete(new ObjectId($deleteID));
                            if (!$deleteStatus) {
                                $deleteState = false;
                            }
                        }

                        if ($value['status'] !== 'pending')
                            $deleteCounter++;
                    }
                }

                if (!$deleteState) return array('error' => 'Something went wrong on delete');
                if ($deleteCounter < count($payload['delete']) && count($payload['delete']) != 0) $deleteIsDone = false;
                echo 'DEL';
                var_dump($deleteCounter < count($payload['delete']) && count($payload['delete']) != 0);

                echo 'C';
                var_dump($createIsDone);
                echo 'U';
                var_dump($updateIsDone);
                echo 'D';
                var_dump($deleteIsDone);

                if ($createIsDone && $updateIsDone && $deleteIsDone) {
                    $doneState = $collection->updateOne(['_id' => $id], ['$set' => ['done' => true]]);

                    if ($doneState->isAcknowledged() === true) {
                        return array('status' => 'success', '_id' => $id);
                    }
                } else {
                    $doneState = $collection->updateOne(['_id' => $id], ['$set' => ['done' => false]]);

                    if ($doneState->isAcknowledged() === true) {
                        return array('status' => 'success', '_id' => $id);
                    }
                }
            }
            // else {
            //     return array('error' => 'Something went wrong');
            // }
            return array('error' => 'Something went wrong');
        } catch (Exception $th) {
            return array('error' => $th->getMessage());
        }
    }

    private function changeProperties(array $payload, $currentData)
    {
        $valueRequest = array();
        // var_dump($payload);
        // echo json_encode($currentData['requests']);

        foreach ($currentData['requests'] as $key => $value) {
            $requestContent = (array)$value;

            if ($value->type === 'update') {
                foreach ($payload['update'] as $Pkey => $Pvalue) {
                    if (((array)$Pvalue['productID'])['$oid'] === ((array)$value->itemID)['oid']) {
                        $requestContent['status'] = $Pvalue['status'];
                    }
                }
            }

            if ($value->type === 'create') {
                foreach ($payload['create'] as $Pkey => $Pvalue) {
                    if ($Pvalue['fields'] === ((array)$value->field)) {
                        $requestContent['status'] = $Pvalue['status'];
                    }
                }
            }

            if ($value->type === 'delete') {
                foreach ($payload['delete'] as $Pkey => $Pvalue) {
                    if (((array)$Pvalue['productID'])['$oid'] === ((array)$value->itemID)['oid']) {
                        $requestContent['status'] = $Pvalue['status'];
                    }
                }
            }
            array_push($valueRequest, $requestContent);
        }

        $currentData['requests'] = $valueRequest;
        return $currentData;
    }
}

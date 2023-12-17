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

                foreach ($cursor as $key => $value) {
                    array_push(
                        $data,
                        array($key => $value)
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

    public  function findOneRaw(string $orderID): array
    {
        try {
            $db = new DB();
            $connection = $db->getConnection();
            if ($connection == null) die(print_r("Connection is Null", true));

            $collection = $connection->selectCollection('kanema', 'Request');
            $cursor = null;

            $cursor = $collection->findOne(['_id' => new ObjectId($orderID)]);

            if ($cursor) {
                // $data = array();

                // var_dump();
                // foreach ($cursor as $key => $value) {
                //     if ($key === 'requests') {
                //         array_push(
                //             $data,
                //             array($key => array($value))
                //         );
                //     } else {
                //         array_push(
                //             $data,
                //             array($key => $value)
                //         );
                //     }
                // }

                return array('data' => $cursor);
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
            $requestData = $this->findOneRaw($strID)['data'];
            unset($requestData['_id']);

            $updatedData = $this->changeProperties($payload, $requestData);
            // return array('status' => 'success', '_id' => $updatedData);

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
                        var_dump($value);
                        if ($value['status'] === 'approved') {
                            $updIDStr = ((array)$value['productID'])['$oid'];
                            $updateStatus = $productModel->updateItem($updIDStr, $value['new']);

                            if (!$updateStatus) {
                                $updateState = false;
                            }
                        }

                        if ($value['status'] !== 'pending') $updateCounter++;
                    }
                }

                if (!$updateState) return array('error' => 'Something went wrong on update');
                if ($updateCounter < count($payload['update']) && count($payload['update']) != 0) $updateIsDone = false;

                $fieldToIn = array();
                $createCounter = 0;
                if (count($payload['create']) > 0) {
                    foreach ($payload['create'] as $key => $value) {
                        if ($value['status'] === 'approved') {
                            array_push($fieldToIn, $value['fields']);
                        }

                        if ($value['status'] !== 'pending')  $createCounter++;
                    }


                    if (count($fieldToIn) > 0) {
                        $createStatus = $productModel->create($fieldToIn);

                        if (!$createStatus) $createState = false;
                    }
                }


                if (!$createState) return array('error' => 'Something went wrong on create');
                if ($createCounter < count($payload['create']) && count($payload['create']) != 0) $createIsDone = false;

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
            return array('error' => 'Something went wrong');
        } catch (Exception $th) {
            return array('error' => $th->getMessage());
        }
    }

    private function changeProperties(array $payload, $currentData)
    {
        $requestContent = (array)$currentData;

        foreach ($currentData['requests'] as $key => $value) {
            if ($key == 'type' && $value == 'update') {
                foreach ($payload['update'] as $Pkey => $Pvalue) {
                    // var_dump(((array)$Pvalue['productID'])['$oid']);
                    // var_dump(((array)$currentData['requests']->itemID)['oid']);
                    if (((array)$Pvalue['productID'])['$oid'] == ((array)$currentData['requests']->itemID)['oid']) {
                        $requestContent['requests']->status = $Pvalue['status'];
                    }
                }
            }

            if ($key == 'type' && $value == 'create') {
                foreach ($payload['create'] as $Pkey => $Pvalue) {
                    if ($Pvalue['fields'] == ((array)$currentData['requests']->field)) {
                        $requestContent['requests']->status = $Pvalue['status'];
                    }
                }
            }

            if ($key == 'type' && $value == 'delete') {
                foreach ($payload['delete'] as $Pkey => $Pvalue) {
                    if (((array)$Pvalue['productID'])['$oid'] == ((array)$currentData['requests']->itemID)['oid']) {
                        $requestContent['requests']->status = $Pvalue['status'];
                    }
                }
            }
        }

        return $requestContent;
    }

    public function create(array $payload): array
    {
        try {
            $db = new DB();
            $connection = $db->getConnection();
            if ($connection == null) die(print_r("Connection is Null", true));

            $collection = $connection->selectCollection('kanema', 'Request');
            $cursor = $collection->insertOne($payload);

            if ($cursor->isAcknowledged() === true) {
                return array('status' => 'success', '_id' => $cursor->getInsertedId());
            }
            return array('error' => 'Something went wrong');
        } catch (Exception $th) {
            return array('error' => $th->getMessage());
        }
    }
}

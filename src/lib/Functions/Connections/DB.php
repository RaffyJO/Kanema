<?php

class DB
{
    function getConnection()
    {
        $retryInterval = 1;

        for ($i = 0; $i < 5; $i++) {
            try {
                $USER = base64_decode(getenv('DB_USERNAME'));
                $PASSWORD = base64_decode(getenv('DB_PASSWORD'));
                $connectionString = "mongodb+srv://$USER:$PASSWORD@kanema-cluster.1m1asvm.mongodb.net/?retryWrites=true&w=majority";

                $client = new MongoDB\Client($connectionString);

                $client->selectDatabase('admin')->command(['ping' => 1]);

                // var_dump($connectionString);

                return $client;
            } catch (MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
                if ($i < 5) {
                    echo "Connection attempt $i failed. Retrying in $retryInterval seconds...\n";
                    sleep($retryInterval);
                } else {
                    echo "All connection attempts failed.\n";
                    throw $e;
                }
            } catch (Throwable $ex) {
                echo "Connection Failed";
                throw $ex->getMessage();
            }
        }
    }
}

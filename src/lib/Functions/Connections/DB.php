<?php

function getConnection()
{
    $retryInterval = 1;

    for ($i = 0; $i < 5; $i++) {
        try {
            $USER = base64_decode(getenv('DB_USERNAME'));
            $PASSWORD = base64_decode(getenv('DB_PASSWORD'));
            $connectionString = "mongodb+srv://$USER:$PASSWORD@kanema-cluster.1m1asvm.mongodb.net/?retryWrites=true&w=majority";

            $client = new MongoDB\Client($connectionString);

            // var_dump($client->executeCommand('test', new MongoDB\Driver\Command(['ping' => 1])));
            $client->selectDatabase('admin')->command(['ping' => 1]);

            return $client;
        } catch (MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
            if ($i < 5) {
                echo "Connection attempt $i failed. Retrying in $retryInterval seconds...\n";
                sleep($retryInterval); // Wait before retrying
            } else {
                // If all retries are exhausted, throw the last exception
                echo "All connection attempts failed.\n";
                throw $e;
            }
        } catch (Throwable $ex) {
            echo "Connection Failed";
            throw $ex->getMessage();
        }
    }
}

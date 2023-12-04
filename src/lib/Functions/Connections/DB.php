<?php
use MongoDB\Driver\Manager;

function getConnection() {
    try {
        $USER = getenv('MONGO_USER');
        $PASSWORD = getenv('MONGO_PASSWORD');
        $connectionString = "mongodb+srv://$USER:$PASSWORD@kanema-cluster.1m1asvm.mongodb.net/?retryWrites=true&w=majority";
        
        $manager = new Manager($connectionString);

        // var_dump($manager->executeCommand('test', new MongoDB\Driver\Command(['ping' => 1])));
        $manager->executeCommand('test', new MongoDB\Driver\Command(['ping' => 1]));

        return $manager;
    } catch (Throwable $ex) {
         echo "Connection Failed";
         throw $ex;
        //  die(print_r($ex, true));
        //  return null;
     }
}
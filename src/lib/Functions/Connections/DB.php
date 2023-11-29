<?php
use MongoDB\Driver\Manager;

function getConnection() {
    try {
        $connectionString = getenv('MONGO_CONNECTION_STRING');
        $manager = new Manager($connectionString);

        // var_dump($manager->executeCommand('test', new MongoDB\Driver\Command(['ping' => 1])));

        return $manager;
    } catch (Throwable $ex) {
         echo "Connection Failed";
         die(print_r($ex, true));
         return null;
     }
}
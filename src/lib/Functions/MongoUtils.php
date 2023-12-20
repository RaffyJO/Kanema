<?php

use MongoDB\BSON\ObjectId;

class MongoUtils
{
    public static function isValidObjectId($str): bool
    {
        try {
            if (is_string($str)) {
                new ObjectId($str);
                return true;
            }

            return $str instanceof \MongoDB\BSON\ObjectID;
        } catch (\Throwable $th) {
            return false;
        }

        // Regular expression pattern for a valid ObjectId
        // $pattern = '/^[0-9a-fA-F]{24}$/';

        // // Check if the string matches the ObjectId pattern
        // return preg_match($pattern, $str);
    }
}

<?php
class MongoUtils
{
    public static function isValidObjectId($str)
    {
        // Regular expression pattern for a valid ObjectId
        $pattern = '/^[0-9a-fA-F]{24}$/';

        // Check if the string matches the ObjectId pattern
        return preg_match($pattern, $str);
    }
}

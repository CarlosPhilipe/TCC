<?php
namespace backend\models;

class ListType {

    static $listTypes;

    public static function getType($id) {
       return self::$listTypes[$id];
    }

    public static function setType($type) {
       self::$listTypes["{$type->getId()}"] = $type;
    }

    public static function list() {
       return self::$listTypes;
    }
    public static function clearAll() {
       return self::$listTypes = null;
    }

}

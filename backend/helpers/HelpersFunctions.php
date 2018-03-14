<?php
namespace backend\helpers;

class HelpersFunctions {
  public static function dd($argument) {
    echo "<pre>";
    print_r($argument);
    echo "</pre>";
  }

  public static function formateNameCamelCaseToDown($name) {
    $CCAlphabet = require(__DIR__.'/CamelCaseHelper.php');
    foreach ($CCAlphabet as $key => $value) {
      $name = str_replace($key, $value, $name);
    }
    if (strpos($name, '_') === 0) {
      $name = substr($name, 1);
    }
    return $name;
  }

  public static function formateNameCamelCaseToUp($name) {
    $CCAlphabet = require(__DIR__.'/CamelCaseHelper.php');
    foreach ($CCAlphabet as $key => $value) {
      $CCAlphabet = str_replace($value, $key, $CCAlphabet);
    }
    return $name;
  }

  public static function mapAttributesOfBD($name) {
    $CCAlphabet = require(__DIR__.'/ListMappingTypesOfDB.php');
    $name = strtolower($name);
    if ( array_key_exists("{$name}", $CCAlphabet) ) {
        return $CCAlphabet["{$name}"];
    }
    return $CCAlphabet["text"];
  }

  public static function convertebleList($current) {
    $removeList = require(__DIR__ . '/ListMappingAttributes.php');
    foreach ($removeList as $key => $value) {
      $current = str_replace($key, $value, $current);
    }
    return $current;
  }

  public static function removeList($current) {
    $removeList = require(__DIR__ . '/../helpers/RemoveList.php');
    foreach ($removeList as $key => $value) {
      $current = str_replace($key, $value, $current);
    }
    return $current;
  }

  public static function verifyIfNameIsNativeType($name) {
    $CCAlphabet = require(__DIR__.'/ListMappingTypesOfDB.php');
    // var_dump($CCAlphabet);
    $name = strtolower($name);
    // echo $name;

    return array_key_exists($name, $CCAlphabet);
  }
}

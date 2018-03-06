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
    if (strpos($name, '_') == 0) { $name = substr($name, 1);}
    return $name;
  }

  public static function formateNameCamelCaseToUp($name) {
    $CCAlphabet = require(__DIR__.'/CamelCaseHelper.php');
    foreach ($CCAlphabet as $key => $value) {
      $CCAlphabet = str_replace($value, $key, $CCAlphabet);
    }
    return $name;
  }
}

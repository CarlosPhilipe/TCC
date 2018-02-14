<?php
namespace backend\helpers;

class HelpersFunction {
  public function dd($argument){
    echo "<pre>";
    print_r($argument);
    echo "</pre>";
  }
}

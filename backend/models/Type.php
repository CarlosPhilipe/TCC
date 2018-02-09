<?php
namespace backend\models;

use Object;

class Type {
    public $id;
    public $name;

    function __construct($id = '', $name = ''){
      $this->id = $id;
      $this->name = $name;
    }

    // //setters
    // public function setId($id) {
    //   $this->id = $id;
    // }
    //
    // public function setName($name) {
    //   $this->name = $name;
    // }
    //
    // //getters
    // public function getId() {
    //   $this->id;
    // }
    //
    // public function getName() {
    //   $this->name;
    // }
}

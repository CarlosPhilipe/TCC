<?php
namespace backend\models;

use Object;

class Type {
    private $id;
    private $name;
    private $isNative;


    function __construct($id = '', $name = '', $isNative = true){
      $this->id = $id;
      $this->name = $name;
      $this->isNative = $isNative;
    }

    //setters
    public function setId($id) {
      $this->id = $id;
    }

    public function setName($name) {
      $this->name = $name;
    }

    public function setIsNative($isNative) {
      $this->isNative = $isNative;
    }

    //getters
    public function getId() {
      return $this->id;
    }

    public function getName() {
      return $this->name;
    }

    public function getIsNative() {
      $this->isNative;
    }
}

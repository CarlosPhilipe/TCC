<?php
namespace backend\models;

use Object;

class MappingObject {

  private $xmlObject;

  public function MappingObject($xmlObject = null) {
      $this->xmlObject = $xmlObject;
  }

  public function getClassName() {
     $classKeys = [];
     $it = $this->xmlObject->content->Model->namespaceOwnedElement->Class;
     foreach ($it as $value) {
       $classKeys[] = $value->attributes()->name;
     }
     return $classKeys;
  }

  public function getClasses() {
     $classes = [];
     $it = $this->xmlObject->content->Model->namespaceOwnedElement->Class;
     foreach ($it as $value) {
       $classes[] = $value->attributes();
     }
     return $classes;
  }

  // gettes e settes

  public function setXmlObject($xmlObject) {
      $this->xmlObject = $xmlObject;
  }

  public function getXmlObject($xmlObject) {
      $this->xmlObject;
  }
  // $className;
  //
  // $listAttributes;
  //
  // $listValuesTypes;


}

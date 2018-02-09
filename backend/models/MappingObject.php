<?php
namespace backend\models;

use Object;

class MappingObject {

  private $xmlObject;

  public function __construct($xmlObject = null) {
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
       $classes[] = $value->attributes()->name;
     }
     return $classes;
  }

  public function getNativeTypes() {
     $classes = [];
     $it = $this->xmlObject->content->Primitive;
     foreach ($it as $value) {
       $classes[] = $value;//->attributes()->name;
     }
     return $classes;
  }


  // gettes e settes

  public function setXmlObject($xmlObject) {
      $this->xmlObject = $xmlObject;
  }

  public function getXmlObject() {
      $this->xmlObject;
  }
  // $className;
  //
  // $listAttributes;
  //
  // $listValuesTypes;


}

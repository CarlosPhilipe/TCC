<?php
namespace backend\models;

use Object;
use backend\models\ListType;
use Exception;

class MappingObject {

  private $xmlObject;

  public function __construct($xmlObject = null) {
      $this->xmlObject = $xmlObject;
  }

  public function getClassName() {
     $classKeys = [];
     $it = $this->xmlObject->content->Model->namespaceOwnedElement->Class;
     if (!$it) {
       throw new Exception('Dont has Class Names getClassName');
     }
     foreach ($it as $value) {
       $classKeys[] = $value->attributes()->name;
     }
     return $classKeys;
  }

  public function getClasses() {
     $classes = [];
     $it = $this->xmlObject->content->Model->namespaceOwnedElement->Class;
     foreach ($it as $value) {
       $classes[] = $value;
     }
     return $classes;
  }

  public function getNativeTypes() {
     $classes = [];
     $it = $this->xmlObject->content->Primitive;
     if (!$it) {
       throw new Exception('Dont has Native Types getNativeTypes');
     }
     foreach ($it as $value) {
       $classes[] = $value;
     }
     return $classes;
  }

  public function getStructureClasses() {
     $it = $this->getClasses();
     $classes = [];
     $attributes = [];

     foreach ($it as $value) {
         $sc = [];
         $sc['name'] = $value->attributes()->name;
         $sc['visibility'] = $value->modelElementVisibility->attributes()->value;
         $attributes = $value->classifierFeature->Attribute;

         for ($i=0; $i < count($attributes); $i++) {
           $attribute = $attributes[$i];
           $sc['attributes'][$i]['name'] = $attribute->attributes()->name;
           $sc['attributes'][$i]['type_id'] = $attribute->structuralFeatureType->Classifier->attributes()->idref;
           $sc['attributes'][$i]['type'] = ListType::getType("{$attribute->structuralFeatureType->Classifier->attributes()->idref}")->getName();
         }
         $classes[] = $sc;
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

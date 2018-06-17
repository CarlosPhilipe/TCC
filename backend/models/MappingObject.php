<?php
namespace backend\models;

use backend\models\ListType;
use backend\models\Association;
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
         if ($attributes) {
           for ($i=0; $i < count($attributes); $i++) {
             $attribute = $attributes[$i];
             $sc['attributes'][$i]['name'] = $attribute->attributes()->name;
             $sc['attributes'][$i]['type_id'] = $attribute->structuralFeatureType->Classifier->attributes()->idref;
             $sc['attributes'][$i]['type'] = ListType::getType("{$attribute->structuralFeatureType->Classifier->attributes()->idref}")->getName();
           }
         }
         $classes[] = $sc;
     }
     return $classes;
  }

  public function getStructureAssociations() {
     $classKeys = [];
     $it = $this->xmlObject->content->Model->namespaceOwnedElement->Association;
     $associations = [];
     $attributes = [];

     foreach ($it as $value) {
         $it2 = $value->associationConnection->AssociationEnd;
         foreach ($it2 as $value2) {
             $association = new Association();
             $association->setAssociateOwner(ListType::getType("{$value2->featureOwner->Classifier->attributes()->idref}")->getName());
             $association->setAssociateParticipant(ListType::getType("{$value2->associationEndParticipant->Classifier->attributes()->idref}")->getName());
             $association->setUpperValue($value2->structuralFeatureMultiplicity->Multiplicity->multiplicityRange->MultiplicityRange->attributes()->upper);
             $association->setLowerValue($value2->structuralFeatureMultiplicity->Multiplicity->multiplicityRange->MultiplicityRange->attributes()->lower);
             $associations[] = $association;
         }
     }
     return $associations;
  }

  public function getConsolidedAssociations() {
     $associations = $this->getStructureAssociations();
     $classKeys = [];
     $it = $this->xmlObject->content->Model->namespaceOwnedElement->Association;
     $associationsConsolided = [];

     foreach ($associations as $item) {
         if ($item->getNotUsed()) {
           foreach ($associations as $association) {
             if ($item->getAssociateOwner() == $association->getAssociateParticipant()
                && $item->getAssociateParticipant() == $association->getAssociateOwner()
                && $item->getNotUsed()) {
                  if ($association->getUpperValue() == -1 && $item->getUpperValue() !=  -1) {
                    $consolidedAssociation = [
                      'name' => $item->getAssociateOwner().'Belongs'.$item->getAssociateParticipant(),
                      'mainClass' => $item->getAssociateOwner(),
                      'mainCardinate' => $item->getUpperValue(),
                      'secondClass' => $item->getAssociateParticipant(),
                      'secondCardinate' => $association->getUpperValue()
                    ];
                  } else {
                    $consolidedAssociation = [
                      'name' => $item->getAssociateOwner().'Has'.$item->getAssociateParticipant(),
                      'mainClass' => $item->getAssociateParticipant(),
                      'mainCardinate' => $association->getUpperValue(),
                      'secondClass' => $item->getAssociateOwner(),
                      'secondCardinate' => $item->getUpperValue()
                    ];
                  }
                  $item->setNotUsed(false);
                  $association->setNotUsed(false);
                  $associationsConsolided[] = $consolidedAssociation;
                 }
           }
         }

     }
     return $associationsConsolided;
  }


  // gettes e settes

  public function setXmlObject($xmlObject) {
      $this->xmlObject = $xmlObject;
  }

  public function getXmlObject() {
      $this->xmlObject;
  }


}

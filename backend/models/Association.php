<?php
namespace backend\models;

class Association {
    private $id;
    private $name;
    private $associateOwner;
    private $associateParticipant;
    private $upperValue;
    private $lowerValue;
    private $notUsed;
    private $isAssociationClass;

    function __construct($id = '', $name = '', $isNative = true){
      $this->id = $id;
      $this->name = $name;
      $this->isNative = $isNative;
      $this->notUsed = true;
      $this->isAssociationClass = false;
    }

    //setters
    public function setId($id) {
      $this->id = $id;
    }

    public function setName($name) {
      $this->name = $name;
    }

    public function setAssociateOwner($associateOwner) {
      $this->associateOwner = $associateOwner;
    }

    public function setAssociateParticipant($associateParticipant) {
      $this->associateParticipant = $associateParticipant;
    }

    public function setUpperValue($upperValue) {
      $this->upperValue = $upperValue;
    }

    public function setLowerValue($lowerValue) {
      $this->lowerValue = $lowerValue;
    }

    public function setNotUsed($notUsed) {
      $this->notUsed = $notUsed;
    }

    public function setIsAssociationClass($isAssociationClass) {
      $this->isAssociationClass = $isAssociationClass;
    }

    //getters
    public function getId() {
      return $this->id;
    }

    public function getName() {
      return $this->name;
    }

    public function getAssociateOwner() {
      return $this->associateOwner;
    }

    public function getAssociateParticipant() {
      return $this->associateParticipant;
    }

    public function getUpperValue() {
      return $this->upperValue;
    }

    public function getLowerValue() {
      return $this->lowerValue;
    }

    public function getNotUsed() {
      return $this->notUsed;
    }

    public function getIsAssociationClass() {
      return $this->isAssociationClass;
    }
}

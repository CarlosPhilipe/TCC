<?php
namespace backend\modules\generator\migrate;

use backend\helpers\HelpersFunctions;

class GeneratorMigrate {

    const TAB = '   ';
    const CLASS_NAME = '{CLASS_NAME}';
    const CONTENT = '{CONTENT}';
    const TABLE_NAME = '{TABLE_NAME}';
    const TAGET_TABLE_NAME = '{TAGET_TABLE_NAME}';
    const ATTRIBUTE = '{ATTRIBUTE}';
    const FK_NAME = '{FK_NAME}';



    public static function generateMigrations($classes) {
      foreach ($classes as $key => $value) {
        if (!HelpersFunctions::verifyIfNameIsNativeType($value['name'])) {
          $nameFile = GeneratorMigrate::createMigration('create_table',$value['name']);
          GeneratorMigrate::setClassName($nameFile, GeneratorMigrate::getOutputPath().$nameFile);
          GeneratorMigrate::setTableName($value['name'], GeneratorMigrate::getOutputPath().$nameFile);
          GeneratorMigrate::setContent($value, GeneratorMigrate::getOutputPath().$nameFile);
        }
      }
    }

    public static function generateMigrationsForForeingKeys($associations) {
      foreach ($associations as $key => $value) {
          $nameFile = GeneratorMigrate::createMigration('add_foreing_key',$value['name']);
          GeneratorMigrate::setClassName($nameFile, GeneratorMigrate::getOutputPath().$nameFile);
          GeneratorMigrate::setTableName($value['mainClass'], GeneratorMigrate::getOutputPath().$nameFile);
          GeneratorMigrate::setAttributeForeingKey($value['secondClass'], GeneratorMigrate::getOutputPath().$nameFile);
          GeneratorMigrate::setFKName($value['secondClass'],$value['mainClass'], GeneratorMigrate::getOutputPath().$nameFile);
          GeneratorMigrate::setTargetClassName($value['secondClass'], GeneratorMigrate::getOutputPath().$nameFile);
      }
    }


    public static function createMigration($type, $name) {
        $inputPath = __DIR__."/templates/$type.php";

        $name = HelpersFunctions::formateNameCamelCaseToDown($name);

        $className = 'm'.GeneratorMigrate::getCorrentTime().'_'.$name;
        $pathName = GeneratorMigrate::getOutputPath().$className.'.php';
        try {
            if (copy($inputPath, $pathName)) {
              return $className;
            } else {
              return null;
            }
        } catch (Exception $e) {
          return false;
      }
    }


    public static function setClassName($className, $inputPath) {
        $text = implode('', file($inputPath.'.php'));
        $text = str_replace(GeneratorMigrate::CLASS_NAME, $className, $text);
        $file = fopen($inputPath.'.php', 'w');
        fwrite($file, $text);
        fclose($file);
    }

    public static function setTargetClassName($targetClassName, $inputPath) {
        $name = HelpersFunctions::formateNameCamelCaseToDown($targetClassName);
        $text = implode('', file($inputPath.'.php'));
        $text = str_replace(GeneratorMigrate::TAGET_TABLE_NAME, "'$name'", $text);
        $file = fopen($inputPath.'.php', 'w');
        fwrite($file, $text);
        fclose($file);
    }

    public static function setAttributeForeingKey($className, $inputPath) {
        $text = implode('', file($inputPath.'.php'));
        $fkName = HelpersFunctions:: convertToForeingKeyName($className);
        $text = str_replace(GeneratorMigrate::ATTRIBUTE, "'$fkName'", $text);
        $file = fopen($inputPath.'.php', 'w');
        fwrite($file, $text);
        fclose($file);
    }

    public static function setFKName($className, $targetClass, $inputPath) {
        $text = implode('', file($inputPath.'.php'));
        $fkName = HelpersFunctions:: convertToForeingKeyName($className);
        $targetClass = HelpersFunctions:: convertToForeingKeyName($targetClass);
        $text = str_replace(GeneratorMigrate::FK_NAME, "'fk_{$fkName}_in_{$targetClass}'", $text);
        $file = fopen($inputPath.'.php', 'w');
        fwrite($file, $text);
        fclose($file);
    }

    public static function setTableName($tableName, $inputPath) {
        $tableName = HelpersFunctions::formateNameCamelCaseToDown($tableName);
        $text = implode('', file($inputPath.'.php'));
        $text = str_replace(GeneratorMigrate::TABLE_NAME, "'$tableName'", $text);
        $file = fopen($inputPath.'.php', 'w');
        fwrite($file, $text);
        fclose($file);
    }


    public static function setContent($class, $inputPath) {
      $TAB = GeneratorMigrate::TAB;
      $content = '';
      if (isset($class['attributes'])) {
          $ats = $class['attributes'];
          foreach ($ats as $attribute) {
            $attribute['name'] = HelpersFunctions::formateNameCamelCaseToDown($attribute['name']);
            $attribute['type'] = HelpersFunctions::mapAttributesOfBD($attribute['type']);
            $content .= "\n$TAB$TAB$TAB$TAB'{$attribute['name']}' => {$attribute['type']},";
          }
      }
      $text = implode('', file($inputPath.'.php'));
      $text = str_replace(GeneratorMigrate::CONTENT, $content, $text);
      $file = fopen($inputPath.'.php', 'w');
      fwrite($file, $text);
      fclose($file);
    }


    public static function getCorrentTime() {
      return date('ymd_His');
    }


    public static function getOutputPath() {
      return  __DIR__."/../../../../console/migrations/";
    }


    public static function clearAll() {
      //  return self::$listTypes = null;
    }

}

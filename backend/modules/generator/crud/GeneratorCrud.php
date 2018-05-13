<?php
namespace backend\modules\generator\crud;

use backend\helpers\HelpersFunctions;

class GeneratorCrud {

    const TAB = '   ';
    const CLASS_NAME = '{CLASS_NAME}';
    const CONTENT = '{CONTENT}';
    const TABLE_NAME = '{TABLE_NAME}';
    const TAGET_TABLE_NAME = '{TAGET_TABLE_NAME}';
    const ATTRIBUTE = '{ATTRIBUTE}';
    const FK_NAME = '{FK_NAME}';



    public static function generateModels($classes) {
      foreach ($classes as $key => $value) {
        if (!HelpersFunctions::verifyIfNameIsNativeType($value['name'])) {
           $tableName = HelpersFunctions::formateNameCamelCaseToDown($value['name']);
           $cmd = "cd ../../ &&";
           $cmd.= " php yii gii/model";
           $cmd.= " --ns='frontend\\models'";
           $cmd.= " --tableName=".$tableName;
           $cmd.= " --modelClass=".$value['name']." <yes.cmd";
           $out = shell_exec($cmd);
        }
      }
      $out = shell_exec('mv ../../console/models/*.php ../../frontend/models/');
    }

}

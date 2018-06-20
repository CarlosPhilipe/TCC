<?php

namespace backend\modules\generator\menu;

use backend\helpers\HelpersFunctions;

class GeneratorMenu {

    const TAB = '   ';
    const CONTENT_MENU = '{CONTENT_MENU}';
    const INPUT_PATH = __dir__.'/../../../../frontend/views/layouts/';


    public static function generateMenus($classes) {
      GeneratorMenu::moveFile();
      GeneratorMenu::setContentMenu($classes);
    }

    public static function moveFile() {
        $cmd = "cp ".__dir__."/template/menu.php ".GeneratorMenu::INPUT_PATH."main.php";
        $out = shell_exec($cmd);
        echo "$cmd";
        echo $out;
    }


    public static function setContentMenu($classes) {
      $content = '';
      foreach ($classes as $key => $value) {
        if (!HelpersFunctions::verifyIfNameIsNativeType($value['name'])) {
          $viewName = HelpersFunctions::formateNameCamelCaseToDown($value['name']);
          $viewName = str_replace('_', '-', $viewName);
          $content .= "\n\$menuItems[] = ['label' => '{$value['name']}', 'url' => ['/{$viewName}/index']];";
        }
      }
      $text = implode('', file(GeneratorMenu::INPUT_PATH.'main.php'));
      $text = str_replace(GeneratorMenu::CONTENT_MENU, $content, $text);
      $file = fopen(GeneratorMenu::INPUT_PATH.'main.php', 'w');
      fwrite($file, $text);
      fclose($file);
    }



}




 ?>

<?php
return array_merge(
  [
      'bootstrap' => ['gii'],
      'modules' => [
        'gii' => [
          'class' => 'yii\gii\Module',
          'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.178.20'],
          'generators' => [ //here
              'crud' => [ // generator name
                  'class' => 'backend\modules\generators\crud\Generator', // generator class
                  'templates' => [ //setting for out templates
                      'myCrud' => '@backend/modules/generators/crud/default', // template name => path to template
                  ]
              ]
          ],
      ],
    ]
  ]
);

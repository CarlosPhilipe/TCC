<?php
namespace backend\controllers;

use backend\helpers\HelpersFunctions;
use backend\models\ListType;
use backend\models\MappingObject;
use backend\models\Type;
use backend\models\UploadForm;
use backend\modules\generator\migrate\GeneratorMigrate;
use backend\modules\generator\crud\GeneratorCrud;
use common\models\LoginForm;
use SimpleXMLElement;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class ConstructorController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['reader-tester', 'logout', 'index', 'form', 'reader', 'movefile', 'pre-render', 'pos-render'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPreRender()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->upload()) {
                // $this->redirect(['pos-render']);
                $this->actionReader();
            }
        }

        return $this->render('pre-render', ['model' => $model]);
    }

    public function actionPosRender()
    {


        return $this->render('pos-render', ['model' => true]);
    }


    public function actionReader()
    {
          $current = implode('', file(UploadForm::getPath() . 'doc.xml'));
          // remove Prefixes desnecessary
          $current = HelpersFunctions::removeList($current);
          // convert key expressions
          $current = HelpersFunctions::convertebleList($current);

          $xmlObject = new SimpleXMLElement($current);
          $mappingObject = new MappingObject();

          $mappingObject->setXmlObject($xmlObject);

          $types = $mappingObject->getNativeTypes();
          foreach ($types as $typeItem) {
            ListType::setType( new Type($typeItem->attributes()->id, $typeItem->attributes()->name));
          }

          $classes= $mappingObject->getClasses();
          foreach ($classes as $classeItem) {
            ListType::setType( new Type($classeItem->attributes()->id, $classeItem->attributes()['name']));
          }

          $classes = $mappingObject->getStructureClasses();
          GeneratorMigrate::generateMigrations($classes);
          sleep(1);
          $associations = $mappingObject->getConsolidedAssociations();
          GeneratorMigrate::generateMigrationsForForeingKeys($associations);

          $out = shell_exec('cd ../../ && php yii migrate <yes.cmd');

          // var_dump($out);

          GeneratorCrud::generateModels($classes);

          return $this->redirect(['pos-render']);

    }


    public function actionReaderTester()
    {
          $current = implode('', file(UploadForm::getPath() . 'doc.xml'));
          // remove Prefixes desnecessary
          $current = HelpersFunctions::removeList($current);
          // convert key expressions
          $current = HelpersFunctions::convertebleList($current);

          $xmlObject = new SimpleXMLElement($current);
          $mappingObject = new MappingObject();

          $mappingObject->setXmlObject($xmlObject);

          $types = $mappingObject->getNativeTypes();
          foreach ($types as $typeItem) {
            ListType::setType( new Type($typeItem->attributes()->id, $typeItem->attributes()->name));
          }

          $classes= $mappingObject->getClasses();
          foreach ($classes as $classeItem) {
            ListType::setType( new Type($classeItem->attributes()->id, $classeItem->attributes()['name']));
          }

          $classes = $mappingObject->getStructureClasses();
          GeneratorMigrate::generateMigrations($classes);
          sleep(1);
          $associations = $mappingObject->getConsolidedAssociations();
          GeneratorMigrate::generateMigrationsForForeingKeys($associations);

          $out = shell_exec('cd ../../ && php yii migrate <yes.cmd');

          // $out =
          echo "<pre>";
          GeneratorCrud::generateModels($classes);
          var_dump($out);
          // var_dump($classes);

    }

    public function actionMovefile(){
      echo $nameFile;
    }

}

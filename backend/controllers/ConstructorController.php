<?php
namespace backend\controllers;

use backend\helpers\HelpersFunctions;
use backend\models\ListType;
use backend\models\MappingObject;
use backend\models\Type;
use backend\models\UploadForm;
use backend\modules\generator\migrate\GeneratorMigrate;
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
                        'actions' => ['logout', 'index', 'form', 'reader', 'movefile'],
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


    public function actionForm()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                // file is uploaded successfully
                return;
            }
        }

        return $this->render('form', ['model' => $model]);
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
      echo "<pre>";
      $lc = $mappingObject->getStructureClasses();

      foreach ($lc as $key => $value) {
        $nameFile = GeneratorMigrate::createMigration('create_table',$value['name']);
        GeneratorMigrate::setClassName($nameFile, GeneratorMigrate::getOutputPath().$nameFile);
        GeneratorMigrate::setTableName($value['name'], GeneratorMigrate::getOutputPath().$nameFile);
        GeneratorMigrate::setContent($value, GeneratorMigrate::getOutputPath().$nameFile);
      }
    }


    public function actionMovefile(){
      echo $nameFile;
    }

}

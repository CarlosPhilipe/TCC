<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\UploadForm;
use backend\models\MappingObject;
use backend\models\Type;
use backend\models\ListType;
use backend\helpers\ListMappingAttributes;
use backend\helpers\HelpersFunction;
use backend\modules\generator\migrate\GeneratorMigrate;
use yii\web\UploadedFile;
use SimpleXMLElement;

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
      $current = $this->removeList($current);
      // convert key expressions
      $current = $this->convertebleList($current);

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
      // foreach ($lc as $key => $value) {
      //   print_r($value['name']);
      //   $ats = $value['attributes'];
      //   foreach ($ats as $attribute) {
      //     print_r($attribute);
      //   }
      // }

      foreach ($lc as $key => $value) {
        $nameFile = GeneratorMigrate::createMigration('create_table',$value['name']);
        GeneratorMigrate::setClassName($nameFile, GeneratorMigrate::getOutputPath().$nameFile);
        GeneratorMigrate::setTableName($value['name'], GeneratorMigrate::getOutputPath().$nameFile);
        GeneratorMigrate::setContent($value, GeneratorMigrate::getOutputPath().$nameFile);
      }
    }

    private function removeList($current) {
      $removeList = require(__DIR__ . '/../helpers/RemoveList.php');
      foreach ($removeList as $key => $value) {
        $current = str_replace($key, $value, $current);
      }
      return $current;
    }

    private function convertebleList($current) {
      $removeList = require(__DIR__ . '/../helpers/ListMappingAttributes.php');
      foreach ($removeList as $key => $value) {
        $current = str_replace($key, $value, $current);
      }
      return $current;
    }


    /**
     * Converts XML document to array.
     * @param string|\SimpleXMLElement $xml xml to process.
     * @return array XML array representation.
     */
    protected function convertXmlToArray($xml)
    {
        if (is_string($xml)) {
            $xml = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        }
        $result = (array) $xml;
        foreach ($result as $key => $value) {
            if (!is_scalar($value)) {
                $result[$key] = $this->convertXmlToArray($value);
            }
        }
        return $result;
    }

    public function actionMovefile(){
      echo $nameFile;
    }

}

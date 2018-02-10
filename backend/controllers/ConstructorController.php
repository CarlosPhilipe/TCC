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
use backend\helps\ListMappingAttributes;
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
                        'actions' => ['logout', 'index', 'form', 'reader'],
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
      $listTypes = [];
      $removeList = require(__DIR__ . '/../helps/RemoveList.php');
      $list = require(__DIR__ . '/../helps/ListMappingAttributes.php');

      $current = implode('', file(UploadForm::getPath() . 'doc.xml'));
      foreach ($removeList as $key => $value) {
        $current = str_replace($key,$value, $current);
      }
      foreach ($list as $key => $value) {
        $current = str_replace($key,$value, $current);
        //echo "$key => $value<br>";
        //print_r($value);
      }
      $content = 'content';
      // $ex = 'extension';
      //$xml = simplexml_load_string($current);
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
      print_r(ListType::getType('fc-0b7f0721c8ce083da9a69735570555ff'));
      print_r(ListType::list());
      // echo $mappingObject->getClassName()[2];
      //  print_r($xmlObject);
      // print_r($xmlObject->${'content'});
      // foreach ($xmlObject as $value) {
      //   print_r($value);
      // }

    }

    public function parse(Response $response)
    {
        $contentType = $response->getHeaders()->get('content-type', '');
        if (preg_match('/charset=(.*)/i', $contentType, $matches)) {
            $encoding = $matches[1];
        } else {
            $encoding = 'UTF-8';
        }
        $dom = new \DOMDocument('1.0', $encoding);
        $dom->loadXML($response->getContent(), LIBXML_NOCDATA);
        return $this->convertXmlToArray(simplexml_import_dom($dom->documentElement));
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

}

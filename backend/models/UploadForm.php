<?php
namespace backend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public  $file;

    public static function getPath() {
        return __dir__ . '/../web/path-files/';
    }


    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xml'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->file->saveAs( UploadForm::getPath() . 'doc.xml');
            return true;
        } else {
            return false;
        }
    }
}

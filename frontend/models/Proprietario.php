<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proprietario".
 *
 * @property integer $id
 * @property string $nome
 *
 * @property Carro[] $carros
 */
class Proprietario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proprietario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarros()
    {
        return $this->hasMany(Carro::className(), ['proprietario_id' => 'id']);
    }
}

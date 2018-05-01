<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carro".
 *
 * @property integer $id
 * @property string $num_chassi
 * @property string $placa
 * @property integer $ano_fabricacao
 * @property integer $proprietario_id
 *
 * @property Proprietario $proprietario
 */
class Carro extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'carro';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ano_fabricacao', 'proprietario_id'], 'integer'],
            [['num_chassi', 'placa'], 'string', 'max' => 255],
            [['proprietario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proprietario::className(), 'targetAttribute' => ['proprietario_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'num_chassi' => 'Num Chassi',
            'placa' => 'Placa',
            'ano_fabricacao' => 'Ano Fabricacao',
            'proprietario_id' => 'Proprietario ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProprietario()
    {
        return $this->hasOne(Proprietario::className(), ['id' => 'proprietario_id']);
    }
}

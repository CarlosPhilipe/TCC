<?php
use yii\db\Schema;
use yii\db\Migration;

class m180427_233543_carro_has_seguro extends Migration
{
    public function up()
    {
        // add foreign
        $this->addColumn(
            'seguro',
            'carro_id',
            $this->integer(11));

        $this->addForeignKey(
            'fk-carro_id',
            'seguro',
            'carro_id',
            'carro',
            'id',
            'CASCADE',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        // drops foreign
        $this->dropForeignKey(
          'fk-carro_id',
          'seguro'
      );
    }
}

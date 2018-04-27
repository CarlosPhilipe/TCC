<?php
use yii\db\Schema;
use yii\db\Migration;

class m180427_194418_carro_belongs_fabricante extends Migration
{
    public function up()
    {
        // add foreign
        $this->addColumn(
            'carro',
            'fabricante_id',
            $this->integer(11));

        $this->addForeignKey(
            'fk-fabricante_id',
            'carro',
            'fabricante_id',
            'fabricante',
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
          'fk-fabricante_id',
          'carro'
      );
    }
}

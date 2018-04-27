<?php
use yii\db\Schema;
use yii\db\Migration;

class m180427_194418_proprietario_has_carro extends Migration
{
    public function up()
    {
        // add foreign
        $this->addColumn(
            'carro',
            'proprietario_id',
            $this->integer(11));

        $this->addForeignKey(
            'fk-proprietario_id',
            'carro',
            'proprietario_id',
            'proprietario',
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
          'fk-proprietario_id',
          'carro'
      );
    }
}

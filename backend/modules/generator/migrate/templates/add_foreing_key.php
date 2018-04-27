<?php
use yii\db\Schema;
use yii\db\Migration;

class {CLASS_NAME} extends Migration
{
    public function up()
    {
        // add foreign
        $this->addColumn(
            {TABLE_NAME},
            {ATTRIBUTE},
            $this->integer(11));

        $this->addForeignKey(
            {FK_NAME},
            {TABLE_NAME},
            {ATTRIBUTE},
            {TAGET_TABLE_NAME},
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
          {FK_NAME},
          {TABLE_NAME}
      );
    }
}

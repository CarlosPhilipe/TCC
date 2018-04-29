<?php

use yii\db\Schema;
use yii\db\Migration;

class m180427_233542_seguro extends Migration
{
    public function up()
    {
        $this->createTable('seguro', [
            'id' => Schema::TYPE_PK,
            'valor_contrato' =>  $this->double(),
        ]);
    }

    public function down()
    {
        $this->dropTable('seguro');
    }
}

<?php

use yii\db\Schema;
use yii\db\Migration;

class m180502_012637_proprietario extends Migration
{
    public function up()
    {
        $this->createTable('proprietario', [
            'id' => Schema::TYPE_PK,
            'nome' => $this->string(),
        ]);
    }

    public function down()
    {
        $this->dropTable('proprietario');
    }
}

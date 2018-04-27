<?php

use yii\db\Schema;
use yii\db\Migration;

class m180427_194417_fabricante extends Migration
{
    public function up()
    {
        $this->createTable('fabricante', [
            'id' => Schema::TYPE_PK,
            'nome' => $this->string(),
        ]);
    }

    public function down()
    {
        $this->dropTable('fabricante');
    }
}

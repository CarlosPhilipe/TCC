<?php

use yii\db\Schema;
use yii\db\Migration;

class m180427_194417_carro extends Migration
{
    public function up()
    {
        $this->createTable('carro', [
            'id' => Schema::TYPE_PK,
            'num_chassi' => $this->string(),
            'placa' => $this->string(),
            'ano_fabricacao' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable('carro');
    }
}

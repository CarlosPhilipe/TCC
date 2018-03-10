<?php

use yii\db\Schema;
use yii\db\Migration;

class {CLASS_NAME} extends Migration
{
    public function up()
    {
        $this->createTable({TABLE_NAME}, [
            'id' => Schema::TYPE_PK,{CONTENT}
        ]);
    }

    public function down()
    {
        $this->dropTable({TABLE_NAME});
    }
}

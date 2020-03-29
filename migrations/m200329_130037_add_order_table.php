<?php

use yii\db\Migration;

class m200329_130037_add_order_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'qty' => $this->integer(),
            'sum' => $this->float(),
            'status' => $this->boolean()->defaultValue(0),
            'name' => $this->string(255),
            'email' => $this->string(255),
            'phone' => $this->string(255),
            'address' => $this->string(255),
        ]);
    }
    
    public function safeDown()
    {
        $this->dropTable('order');
    }
}

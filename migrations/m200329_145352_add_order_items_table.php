<?php

use yii\db\Migration;

class m200329_145352_add_order_items_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('order_items', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'product_id' => $this->integer(),
            'name' => $this->string(255),
            'price' => $this->float(),
            'qty_item' => $this->integer(),
            'sum_item' => $this->float(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('order_items');
    }
}

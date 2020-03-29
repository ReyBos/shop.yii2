<?php

use yii\db\Migration;

class m200329_145907_add_ForeignKey_to_order_items_table extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('order_items', 'product_id', $this->integer(10)->unsigned());
        
        $this->addForeignKey('fk-order_items-product', 'order_items', 'product_id', 'product', 'id');
        $this->addForeignKey('fk-order_items-order', 'order_items', 'order_id', 'order', 'id');
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-order_items-product',
            'order_items'
        );
        
        $this->dropForeignKey(
            'fk-order_items-order',
            'order_items'
        );
    }
}

<?php

use yii\db\Migration;

class m200401_191036_create_user_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255),
            'password' => $this->string(255),
            'auth_key' => $this->string(255),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('user');
    }
}

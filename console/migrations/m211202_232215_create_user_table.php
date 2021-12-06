<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m211202_232215_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(),
            'password_hash' => $this->string(),
            'password_reset_token'=> $this->string(),
            'verification_token'=> $this->string(),
            'auth_key' => $this->string(),
            'email' => $this->string()->defaultValue(null),
            'status'=> $this->integer(),
            'created_at'=> $this->integer(),
            'updated_at'=> $this->integer(),
            'password' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}

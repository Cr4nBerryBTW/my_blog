<?php

use yii\db\Migration;

/**
 * Class m211219_180519_add_admin_and_delete_pass
 */
class m211219_180519_add_admin_and_delete_pass extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'isAdmin', 'integer');
        $this->dropColumn('user', 'password');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211219_180519_add_admin_and_delete_pass cannot be reverted.\n";

        return false;
    }
    */
}

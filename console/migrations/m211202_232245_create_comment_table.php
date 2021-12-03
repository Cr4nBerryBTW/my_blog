<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m211202_232245_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'text' => $this->string(),
            'user_id' => $this->integer(),
            'article_id' => $this->integer(),
            'status' => $this->integer(),
        ]);

        // user_id for comment
        // create index for column 'user_id'
        $this->createIndex(
            'inx_post_user_id',
            'comment',
            'user_id'
        );

        // if delete user then delete comment
        // add foreign key for table 'user'
        $this->addForeignKey(
            'fk_post_index_id',
            'comment',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // article_id for comment
        // create index for column 'article_id'
        $this->createIndex(
            'inx_article_id',
            'comment',
            'article_id'
        );

        // if delete article then delete comment
        // add foreign key for table 'article'
        $this->addForeignKey(
            'fk_article_id',
            'comment',
            'article_id',
            'article',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comment}}');
    }
}

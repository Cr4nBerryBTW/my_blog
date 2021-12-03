<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article_tag}}`.
 */
class m211202_232337_create_article_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%article_tag}}', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ]);

        // article_id for comment
        // create index for column 'article_id'
        $this->createIndex(
            'inx_article_id',
            'article_tag',
            'article_id'
        );

        // if delete article then delete connection between article and tag
        // add foreign key for table 'article'
        $this->addForeignKey(
            'fk_article_article_id',
            'article_tag',
            'article_id',
            'article',
            'id',
            'CASCADE'
        );

        // tag_id for comment
        // create index for column 'article_id'
        $this->createIndex(
            'inx_tag_id',
            'article_tag',
            'tag_id'
        );

        // if delete tag then delete connection between article and tag
        // add foreign key for table 'article'
        $this->addForeignKey(
            'fk_tag_id',
            'article_tag',
            'tag_id',
            'tag',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%article_tag}}');
    }
}

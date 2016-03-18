<?php

use yii\db\Schema;
use yii\db\Migration;

class m160219_090802_create_articles extends Migration
{
    public function up()
    {
        $this->createTable('article_category',
            [
                'id' => $this->primaryKey(),
                'parent_id' => $this->integer(),
            ]);
        $this->addForeignKey('article_category_fk', 'article_category', 'parent_id', 'article_category', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('article',
            [
                'id' => $this->primaryKey(),
                'category_id' => $this->integer(),
            ]);
        $this->addForeignKey('article_category_article_fk', 'article', 'category_id', 'article_category', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('article_category_translation',
            [
                'id' => $this->primaryKey(),
                'language_id' => $this->integer(),
                'category_id' => $this->integer(),
                'name' => $this->string(),
                'text' => $this->text(),
                'short_text' => $this->text(),
            ]);
        $this->addForeignKey('article_category_translation_category_fk', 'article_category_translation', 'category_id', 'article_category', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('article_translation',
        [
            'id' => $this->primaryKey(),
            'language_id' => $this->integer(),
            'article_id' => $this->integer(),
            'name' => $this->string(),
            'text' => $this->text(),
            'short_text' => $this->text(),
        ]);
        $this->addForeignKey('article_translation_article_fk', 'article_translation', 'article_id', 'article', 'id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropForeignKey('article_category', 'article_category');
        $this->dropForeignKey('article_category', 'article');
        $this->dropForeignKey('article_category_translation_category', 'article_category_translation');
        $this->dropForeignKey('article_translation_article', 'article_translation');

        $this->dropTable('article_category');
        $this->dropTable('article');
        $this->dropTable('article_category_translation');
        $this->dropTable('article_translation');

        return true;
    }
}

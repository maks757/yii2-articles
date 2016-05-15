<?php

use yii\db\Migration;

/**
 * Handles adding show_articles_column to table `article_category_table`.
 */
class m160515_070420_add_show_articles_column_to_article_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if ($this->getDb()->getTableSchema('article_category')) {
            $this->addColumn('article_category', 'show_articles', $this->boolean());
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        if ($this->getDb()->getTableSchema('article_category')) {
            $this->dropColumn('article_category', 'show_articles');
        }
    }
}

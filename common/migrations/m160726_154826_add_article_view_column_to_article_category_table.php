<?php

use yii\db\Migration;

/**
 * Handles adding article_view_column to table `article_category_table`.
 */
class m160726_154826_add_article_view_column_to_article_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if ($this->getDb()->getTableSchema('article_category')) {
            $this->addColumn('article_category', 'article_view', $this->string());
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        if ($this->getDb()->getTableSchema('article_category')) {
            $this->dropColumn('article_category', 'article_view');
        }
    }
}

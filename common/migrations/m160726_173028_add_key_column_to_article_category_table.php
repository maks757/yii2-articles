<?php

use yii\db\Migration;

/**
 * Handles adding key_column to table `article_category_table`.
 */
class m160726_173028_add_key_column_to_article_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if ($this->getDb()->getTableSchema('article_category')) {
            $this->addColumn('article_category', 'key', $this->string());
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        if ($this->getDb()->getTableSchema('article_category')) {
            $this->dropColumn('article_category', 'key');
        }
    }
}

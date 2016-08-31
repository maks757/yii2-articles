<?php

use yii\db\Migration;

/**
 * Handles adding show_column to table `article_table`.
 */
class m160515_062040_add_show_column_to_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if ($this->getDb()->getTableSchema('article')) {
            $this->addColumn('article', 'show', $this->boolean());
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        if ($this->getDb()->getTableSchema('article')) {
            $this->dropColumn('article', 'show');
        }
    }
}

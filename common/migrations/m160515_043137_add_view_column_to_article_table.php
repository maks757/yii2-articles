<?php

use yii\db\Migration;

/**
 * Handles adding view_column to table `article_table`.
 */
class m160515_043137_add_view_column_to_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if ($this->getDb()->getTableSchema('article')) {
            $this->addColumn('article', 'view', $this->string());
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        if ($this->getDb()->getTableSchema('article')) {
            $this->dropColumn('article', 'view');
        }
    }
}

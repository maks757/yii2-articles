<?php

use yii\db\Migration;

/**
 * Handles adding position_column to table `article_table`.
 */
class m160515_061539_add_position_column_to_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if ($this->getDb()->getTableSchema('article')) {
            $this->addColumn('article', 'position', $this->integer());
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        if ($this->getDb()->getTableSchema('article')) {
            $this->dropColumn('article', 'position');
        }
    }
}

<?php

use yii\db\Migration;

/**
 * Handles adding key to table `article`.
 */
class m161028_114728_add_key_column_to_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if ($this->getDb()->getTableSchema('article')) {
            $this->addColumn('article', 'key', $this->string());
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        if ($this->getDb()->getTableSchema('article')) {
            $this->dropColumn('article', 'key');
        }
    }
}

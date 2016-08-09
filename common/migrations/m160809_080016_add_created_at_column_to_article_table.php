<?php

use yii\db\Migration;

/**
 * Handles adding created_at_column to table `article_table`.
 */
class m160809_080016_add_created_at_column_to_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('article', 'created_at', $this->dateTime());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('article', 'created_at');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles adding updated_at_column to table `article_table`.
 */
class m160809_080008_add_updated_at_column_to_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('article', 'updated_at', $this->dateTime());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('article', 'updated_at');
    }
}

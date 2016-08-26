<?php

use yii\db\Migration;

/**
 * Handles adding color_column to table `article_table`.
 */
class m160819_091125_add_color_column_to_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('article', 'color', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('article', 'color');
    }
}

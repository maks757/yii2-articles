<?php

use yii\db\Migration;

/**
 * Handles adding color_column to table `article_table`.
 */
class m160819_091126_add_color_column_to_article_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('article_category', 'color', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('article_category', 'color');
    }
}

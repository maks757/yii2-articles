<?php

use yii\db\Migration;

/**
 * Handles adding author_id_column to table `article_table`.
 */
class m160809_075911_add_author_id_column_to_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('article', 'author_id', $this->integer());
        $this->addForeignKey('article_author_id:user_id', 'article', 'author_id', 'user', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('article_author_id:user_id', 'article');
        $this->dropColumn('article', 'author_id');
    }
}

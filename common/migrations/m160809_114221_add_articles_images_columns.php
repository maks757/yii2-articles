<?php

use yii\db\Migration;

class m160809_114221_add_articles_images_columns extends Migration
{
    public function up()
    {
        $this->addColumn('article', 'social', $this->string());
        $this->addColumn('article', 'thumbnail', $this->string());
        $this->addColumn('article', 'menu_item', $this->string());
    }

    public function down()
    {
        $this->dropColumn('article', 'social');
        $this->dropColumn('article', 'thumbnail');
        $this->dropColumn('article', 'menu_item');
    }

}

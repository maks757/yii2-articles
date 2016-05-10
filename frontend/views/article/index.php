<?php

use bl\articles\common\entities\Article;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 *
 * @var $article Article
 */

?>

<?= \bl\articles\frontend\widgets\ArticlesNav::widget([
    'activeItemTemplate' => '<b>{label}</b>'
]) ?>

<h1><?= $article->getTranslation()->name ?></h1>
<p><?= $article->getTranslation()->text ?></p>
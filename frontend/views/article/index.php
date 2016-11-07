<?php

use maks757\articles\common\entities\Article;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 *
 * @var $article Article
 */

?>

<?= \maks757\articles\frontend\widgets\ArticlesNav::widget([
    'activeItemTemplate' => '<b>{label}</b>'
]) ?>

<h1><?= $article->getTranslation()->name ?></h1>
<p><?= $article->getTranslation()->text ?></p>
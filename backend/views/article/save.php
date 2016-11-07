<?php
use maks757\articles\backend\assets\TabsAsset;
use maks757\articles\backend\components\form\ArticleImageForm;
use maks757\articles\common\entities\Article;
use maks757\articles\common\entities\ArticleTranslation;
use maks757\articles\common\entities\Category;
use maks757\multilang\entities\Language;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * @var $image_form ArticleImageForm
 * @var $languages Language[]
 * @var $selectedLanguage Language
 * @var $article Article
 * @var $article_translation ArticleTranslation
 * @var $categories Category[]
 */

$this->title = 'Save article';

TabsAsset::register($this);
?>

<ul class="tabs">
    <li>
        <?=Html::a(Yii::t('articles', 'Basic'), Url::to(['add-basic',  'articleId' => $article->id, 'languageId' => $languageId]), ['class' => 'image']);?>
    </li>
    <li>
        <?=Html::a(Yii::t('articles', 'Images'), Url::to(['add-images',  'articleId' => $article->id, 'languageId' => $languageId]), ['class' => 'image']);?>
    </li>
</ul>


<?php Pjax::begin([
    'linkSelector' => '.image',
    'enablePushState' => true,
    'timeout' => 10000
]);
?>

<?= $this->render($viewName, $params);
?>
<? Pjax::end(); ?>
<?php
use bl\articles\backend\assets\TabsAsset;
use bl\articles\backend\components\form\ArticleImageForm;
use bl\articles\common\entities\Article;
use bl\articles\common\entities\ArticleTranslation;
use bl\articles\common\entities\Category;
use bl\multilang\entities\Language;
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
<?=Html::a('Общие', Url::to(['add-basic',  'articleId' => $article->id, 'languageId' => $languageId]), ['class' => 'image']);?>
<?=Html::a('Изображения', Url::to(['add-images',  'articleId' => $article->id, 'languageId' => $languageId]), ['class' => 'image']);?>


<? Pjax::begin([
    'linkSelector' => '.image',
    'enablePushState' => true,
    'timeout' => 5000
]);
?>

<?= $this->render($viewName, $params);
?>
<? Pjax::end(); ?>
<?php
use bl\articles\entities\CategoryTranslation;
use bl\articles\entities\ArticleTranslation;
use bl\multilang\entities\Language;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $category CategoryTranslation */
/* @var $languages Language[] */
/* @var $parents CategoryTranslation[] */
/* @var $baseLanguage Language */
/* @var $baseParent CategoryTranslation */
/* @var $articles ArticleTranslation[] */
/* @var $baseLanguageUser Language */
$this->title = Yii::t('bl', 'Panel materials');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-list"></i>
                <?= Yii::t('bl', 'List materials') ?>
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <? if (!empty($articles)): ?>
                        <thead>
                        <tr>
                            <th class="col-lg-3"><?= Yii::t('bl', 'Title') ?></th>
                            <th class="col-lg-3"><?= Yii::t('bl', 'Category') ?></th>
                            <th class="col-lg-3"><?= Yii::t('bl', 'Description') ?></th>
                            <th class="col-lg-3"><?= Yii::t('bl', 'Language') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach ($articles as $article): ?>
                            <tr>
                                <td>
                                    <? $name = ArrayHelper::index($article->translations, 'language_id'); ?>
                                    <?= !empty($name[$baseLanguageUser->id]->name) ? $name[$baseLanguageUser->id]->name : $article->translations[0]->name ?>
                                </td>
                                <td>
                                    <?
                                    if (!empty($article->category->translations) && !empty($article->category_id))
                                        $parent = ArrayHelper::index($article->category->translations, 'language_id');
                                    echo !empty($parent[$baseLanguageUser->id]->name)
                                        ? !empty($article->category_id) ? $parent[$baseLanguageUser->id]->name : ''
                                        : $article->category->translations[0]->name;
                                    ?>
                                </td>
                                <td>
                                    <? $parent = ArrayHelper::index($article->translations, 'language_id'); ?>
                                    <?= StringHelper::truncate(
                                        strip_tags(!empty($parent[$baseLanguageUser->id]->short_text)
                                            ? $parent[$baseLanguageUser->id]->short_text
                                            : $article->translations[0]->short_text)
                                        , 50, '...') ?>
                                </td>
                                <td>
                                    <? if(is_array($languages)): ?>
                                        <? $lang_category = ArrayHelper::index($article->translations, 'language_id') ?>
                                        <? foreach ($languages as $language): ?>
                                            <a href="<?= Url::to([
                                                'save',
                                                'articleId' => $article->id,
                                                'languageId' => $language->id
                                            ]) ?>"
                                               type="button"
                                               class="btn btn-<?= $lang_category[$language->id] ? 'success' : 'danger'
                                               ?> btn-xs"><?= $language->name ?></a>
                                        <? endforeach; ?>
                                    <? else: ?>
                                        <a href="<?= Url::to([
                                            'save',
                                            'articleId' => $article->id,
                                            'languageId' => $languages->id
                                        ]) ?>"
                                           type="button" class="btn btn-success btn-xs">
                                            <?= $languages->name?></a>
                                    <? endif; ?>
                                </td>
                            </tr>
                        <? endforeach; ?>
                        </tbody>
                    <? endif; ?>
                </table>
                <a href="<?= Url::to(['/articles/article/save', 'languageId' => $baseLanguage->id]) ?>"
                   class="btn btn-primary pull-right">
                    <i class="fa fa-user-plus"></i> <?= Yii::t('bl', 'Add') ?>
                </a>
            </div>
        </div>
    </div>
</div>



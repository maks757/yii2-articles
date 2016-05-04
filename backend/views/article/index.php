<?php
use bl\articles\common\entities\Article;
use bl\multilang\entities\Language;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $languages Language[] */
/* @var $articles Article[] */
$this->title = 'Articles';
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-list"></i>
                <?= 'Articles list' ?>
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <? if (!empty($articles)): ?>
                        <thead>
                        <tr>
                            <th class="col-lg-3"><?= 'Title' ?></th>
                            <th class="col-lg-3"><?= 'Category' ?></th>
                            <th class="col-lg-3"><?= 'Description' ?></th>
                            <? if(count($languages) > 1): ?>
                                <th class="col-lg-3"><?= 'Language' ?></th>
                            <? endif; ?>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach ($articles as $article): ?>
                            <tr>
                                <td>
                                    <?= $article->translation->name ?>
                                </td>
                                <td>
                                    <? if(!empty($article->category)): ?>
                                        <?= $article->category->translation->name ?>
                                    <? endif; ?>
                                </td>
                                <td>
                                    <?= StringHelper::truncate(strip_tags($article->translation->short_text), 30, '...') ?>
                                </td>
                                <td>
                                    <? if(count($languages) > 1): ?>
                                        <? $translations = ArrayHelper::index($article->translations, 'language_id') ?>
                                        <? foreach ($languages as $language): ?>
                                            <a href="<?= Url::to([
                                                'save',
                                                'articleId' => $article->id,
                                                'languageId' => $language->id
                                            ]) ?>"
                                               type="button"
                                               class="btn btn-<?= $translations[$language->id] ? 'success' : 'danger'
                                               ?> btn-xs"><?= $language->name ?></a>
                                        <? endforeach; ?>
                                    <? endif; ?>
                                </td>
                                <td>
                                    <!-- TODO: link to current language -->
                                    <a href="<?= Url::to([
                                        'save',
                                        'articleId' => $article->id,
                                        'languageId' => $article->translation->language->id
                                    ])?>" class="glyphicon glyphicon-edit text-warning btn btn-default btn-sm">
                                    </a>
                                </td>
                            </tr>
                        <? endforeach; ?>
                        </tbody>
                    <? endif; ?>
                </table>
                <!-- TODO: languageId -->
                <a href="<?= Url::to(['/articles/article/save', 'languageId' => Language::getCurrent()->id]) ?>"
                   class="btn btn-primary pull-right">
                    <i class="fa fa-user-plus"></i> <?= 'Add' ?>
                </a>
            </div>
        </div>
    </div>
</div>



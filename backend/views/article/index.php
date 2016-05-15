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
                            <th class="col-lg-1"><?= 'Position' ?></th>
                            <th class="col-lg-3"><?= 'Title' ?></th>
                            <th class="col-lg-3"><?= 'Category' ?></th>
                            <th class="col-lg-3"><?= 'Description' ?></th>
                            <? if(count($languages) > 1): ?>
                                <th class="col-lg-3"><?= 'Language' ?></th>
                            <? endif; ?>
                            <th>Show</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach ($articles as $article): ?>
                            <tr>
                                <td class="text-center">
                                    <?= $article->position ?>
                                    <a href="<?= Url::to([
                                        'up',
                                        'id' => $article->id
                                    ]) ?>" class="glyphicon glyphicon-arrow-up text-primary pull-left">
                                    </a>
                                    <a href="<?= Url::to([
                                        'down',
                                        'id' => $article->id
                                    ]) ?>" class="glyphicon glyphicon-arrow-down text-primary pull-left">
                                    </a>
                                </td>
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
                                               class="btn btn-<?= !empty($translations[$language->id]) ? 'primary' : 'danger'
                                               ?> btn-xs"><?= $language->name ?></a>
                                        <? endforeach; ?>
                                    <? endif; ?>
                                </td>

                                <td class="text-center">
                                    <a href="<?= Url::to([
                                        'switch-show',
                                        'id' => $article->id
                                    ]) ?>">
                                        <? if ($article->show): ?>
                                            <i class="glyphicon glyphicon-ok text-primary"></i>
                                        <? else: ?>
                                            <i class="glyphicon glyphicon-minus text-danger"></i>
                                        <? endif; ?>
                                    </a>
                                </td>

                                <td>
                                    <a href="<?= Url::to([
                                        'save',
                                        'articleId' => $article->id,
                                        'languageId' => $article->translation->language->id
                                    ])?>" class="glyphicon glyphicon-edit text-warning btn btn-default btn-sm">
                                    </a>
                                </td>

                                <td>
                                    <a href="<?= Url::to([
                                        'remove',
                                        'id' => $article->id
                                    ])?>" class="glyphicon glyphicon-remove text-danger btn btn-default btn-sm">
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



<?php
use bl\articles\common\entities\CategoryTranslation;
use bl\multilang\entities\Language;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $category CategoryTranslation */
/* @var $languages Language[] */

$this->title = 'Article categories list';
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-list"></i>
                <?= 'Categories list'?>
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <? if(!empty($categories)): ?>
                        <thead>
                        <tr>
                            <th><?= 'Name'?></th>
                            <th><?= 'Parent name'?></th>
                            <? if(count($languages) > 1): ?>
                                <th class="col-lg-3"><?= 'Language' ?></th>
                            <? endif; ?>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach($categories as $category): ?>
                            <tr>
                                <td>
                                    <?= $category->translation->name ?>
                                </td>
                                <td>
                                    <? if(!empty($category->parent)): ?>
                                        <?= $category->parent->translation->name ?>
                                    <? endif; ?>
                                </td>
                                <td>
                                    <? if(count($languages) > 1): ?>
                                        <? $translations = ArrayHelper::index($category->translations, 'language_id') ?>
                                        <? foreach ($languages as $language): ?>
                                            <a href="<?= Url::to([
                                                'save',
                                                'categoryId' => $category->id,
                                                'languageId' => $language->id
                                            ]) ?>"
                                               type="button"
                                               class="btn btn-<?= !empty($translations[$language->id]) ? 'primary' : 'danger'
                                               ?> btn-xs"><?= $language->name ?></a>
                                        <? endforeach; ?>
                                    <? endif; ?>
                                </td>
                                <td>
                                    <a href="<?= Url::to(['save', 'categoryId' => $category->id, 'languageId' => Language::getCurrent()->id])?>">
                                        <i class="glyphicon glyphicon-pencil text-warning"></i>
                                    </a>
                                    <br>
                                    <a href="<?= Url::to(['delete', 'id' => $category->id])?>">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        <? endforeach; ?>
                        </tbody>
                    <? endif; ?>
                </table>
                <a href="<?= Url::to(['/articles/category/save', 'languageId' => Language::getCurrent()->id])?>" class="btn btn-primary pull-right">
                    <i class="fa fa-user-plus"></i> <?= 'Add' ?>
                </a>
            </div>
        </div>
    </div>
</div>


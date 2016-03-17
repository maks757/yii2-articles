<?php
use bl\articles\models\CategoryTranslation;
use bl\multilang\articles\Language;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
/* @var $category CategoryTranslation */
/* @var $baseLanguageUser Language */
/* @var $languages Language[] */
/* @var $baseLanguage Language */

$this->title = Yii::t('category.view', 'Category panel');
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-list"></i>
                <?= Yii::t('category.view', 'List categories')?>
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <? if(!empty($categories)): ?>
                    <thead>
                    <tr>
                        <th><?= Yii::t('category.view', 'Name')?></th>
                        <th><?= Yii::t('category.view', 'Parent name')?></th>
                        <th><?= Yii::t('category.view', 'Languages')?></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        <? foreach($categories as $category): ?>
                        <tr>
                            <td>
                                <? $name = ArrayHelper::index($category->translations, 'language_id'); ?>
                                <?= !empty($name[$baseLanguageUser->id]->name) ? $name[$baseLanguageUser->id]->name : $category->translations[0]->name ?>
                            </td>
                            <td>
                                <? $parent = ArrayHelper::index($categories, 'id')?>
                                <? if(!empty($parent[$category->parent_id]->translations)): ?>
                                    <? $parentLang = ArrayHelper::index($parent[$category->parent_id]->translations, 'language_id'); ?>
                                    <?= !empty($parentLang[$baseLanguageUser->id]->name) ? $parentLang[$baseLanguageUser->id]->name : $parent[$category->parent_id]->translations[0]->name;?>
                                <? endif; ?>
                            </td>
                            <td>
                                <? if(is_array($languages)):?>
                                    <? $lang_category = ArrayHelper::index($category->translations, 'language_id')?>
                                    <? foreach($languages as $language): ?>
                                        <a href="<?= Url::to([
                                            'save',
                                            'categoryId' => $category->id,
                                            'languageId' => $language->id
                                            ]) ?>"
                                            type="button"
                                                class="btn btn-<?= $lang_category[$language->id] ? 'success' : 'danger'
                                        ?> btn-xs"><?= $language->name?></a>
                                    <? endforeach; ?>
                                <? else: ?>
                                    <a href="<?= Url::to([
                                        'save',
                                        'categoryId' => $category->id,
                                        'languageId' => $languages->id
                                    ]) ?>"
                                       type="button" class="btn btn-success btn-xs">
                                        <?= $languages->name?></a>
                                <? endif; ?>
                            </td>
                            <td>
                                <a href="<?= Url::to(['save', 'categoryId' => $category->id])?>">
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
                <a href="<?= Url::to(['/articles/category/save', 'language_id' => $baseLanguage->id])?>" class="btn btn-primary pull-right">
                    <i class="fa fa-user-plus"></i> <?= Yii::t('category.view', 'Add') ?>
                </a>
            </div>
        </div>
    </div>
</div>


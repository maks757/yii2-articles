<?php
use maks757\articles\common\entities\CategoryTranslation;
use maks757\multilang\entities\Language;
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
                    <?php if(!empty($categories)): ?>
                        <thead>
                        <tr>
                            <th class="col-md-3"><?= 'Name'?></th>
                            <th class="col-md-2"><?= 'Parent name'?></th>
                            <?php if(count($languages) > 1): ?>
                                <th class="col-lg-3"><?= 'Language' ?></th>
                            <?php endif; ?>
                            <th class="text-center">Show</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($categories as $category): ?>
                            <tr>
                                <td>
                                    <?= $category->translation->name ?>
                                </td>
                                <td>
                                    <?php if(!empty($category->parent)): ?>
                                        <?= $category->parent->translation->name ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if(count($languages) > 1): ?>
                                        <?php $translations = ArrayHelper::index($category->translations, 'language_id') ?>
                                        <?php foreach ($languages as $language): ?>
                                            <a href="<?= Url::to([
                                                'save',
                                                'categoryId' => $category->id,
                                                'languageId' => $language->id
                                            ]) ?>"
                                               type="button"
                                               class="btn btn-<?= !empty($translations[$language->id]) ? 'primary' : 'danger'
                                               ?> btn-xs"><?= $language->name ?></a>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <a href="<?= Url::to([
                                        'switch-show',
                                        'id' => $category->id
                                    ]) ?>">
                                        <?php if ($category->show): ?>
                                            <i class="glyphicon glyphicon-ok text-primary"></i>
                                        <?php else: ?>
                                            <i class="glyphicon glyphicon-minus text-danger"></i>
                                        <?php endif; ?>
                                    </a>
                                </td>

                                <td>
                                    <a href="<?= Url::to(['save', 'categoryId' => $category->id, 'languageId' => Language::getCurrent()->id])?>"
                                        class="glyphicon glyphicon-edit text-warning btn btn-default btn-sm">
                                    </a>
                                    <br>
                                </td>

                                <td>
                                    <a href="<?= Url::to(['delete', 'id' => $category->id])?>"
                                        class="glyphicon glyphicon-remove text-danger btn btn-default btn-sm">
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    <?php endif; ?>
                </table>
                <a href="<?= Url::to(['/articles/category/save', 'languageId' => Language::getCurrent()->id])?>" class="btn btn-primary pull-right">
                    <i class="fa fa-user-plus"></i> <?= 'Add' ?>
                </a>
            </div>
        </div>
    </div>
</div>


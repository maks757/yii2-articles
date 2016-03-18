<?php
use dosamigos\tinymce\TinyMce;
use bl\multilang\entities\Language;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/* @var $languages Language[] */
/* @var $baseCategory integer */
/* @var $parents array CategoryTranslation */
/* @var $baseLanguage Language */
$this->title = Yii::t('bl.articles.category.view', 'Panel article');
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-list"></i>
                <?= Yii::t('bl.articles.category.view', 'Category')?>
            </div>
            <div class="panel-body">
                <? $addForm = ActiveForm::begin(['action' => Url::to(['/articles/category/save', 'categoryId' => $baseCategory, 'languageId' => $baseLanguage->id]), 'method'=>'post']) ?>
                    <?= Html::activeHiddenInput($model, 'category_id', ['value' => $baseCategory]) ?>
                    <?= Html::activeHiddenInput($model, 'language_id', ['value' => $baseLanguage->id]) ?>
                    <div class="dropdown">
                        <button class="btn btn-warning btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <?= $baseLanguage->name ?>
                            <span class="<?= is_array($languages) ? 'caret' : ''?>"></span>
                        </button>
                        <? if(is_array($languages)): ?>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <? foreach($languages as $language): ?>
                                    <li>
                                        <a href="
                                        <?= Url::to([
                                            'categoryId' => $baseCategory,
                                            'languageId' => $language->id])?>
                                        ">
                                            <?= $language->name?>
                                        </a>
                                    </li>
                                <? endforeach; ?>
                            </ul>
                        <? endif; ?>
                    </div>
                    <div class="form-group field-toolscategoryform-parent has-success">
                        <label class="control-label" for="toolscategoryform-parent"><?= Yii::t('bl.articles.category.view', 'Parent') ?></label>
                        <select id="toolscategoryform-parent" class="form-control" name="ValidCategoryForm[parent_id]">
                            <option value="">-- <?= Yii::t('bl.articles.category.view', 'Empty') ?> --</option>
                            <? foreach($parents as $parent): ?>
                                <option <?= $model->parent_id === $parent->category->id ? 'selected' : '' ?>  value="<?= $parent->category->id?>"><?= $parent->name ?></option>
                            <? endforeach; ?>
                        </select>
                        <div class="help-block"></div>
                    </div>
                    <?= $addForm->field($model, 'name', [
                        'inputOptions' => [
                            'class' => 'form-control'
                        ]
                    ])->label(Yii::t('bl.articles.category.view', 'Name'))
                    ?>
                    <?= $addForm->field($model, 'short_text', [
                        'inputOptions' => [
                            'class' => 'form-control'
                        ]
                    ])->widget(TinyMce::className(), [
                        'options' => ['rows' => 10],
                        'language' => 'ru',
                        'clientOptions' => [
                            'plugins' => [
                                'textcolor colorpicker',
                                "advlist autolink lists link charmap print preview anchor",
                                "searchreplace visualblocks code fullscreen",
                                "insertdatetime media table contextmenu paste"
                            ],
                            'toolbar' => "undo redo | forecolor backcolor | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                        ]
                    ])->label(Yii::t('bl.articles.category.view', 'Short description.'))
                    ?>
                    <?= $addForm->field($model, 'text', [
                        'inputOptions' => [
                            'class' => 'form-control'
                        ]
                    ])->widget(TinyMce::className(), [
                        'options' => ['rows' => 20],
                        'language' => 'ru',
                        'clientOptions' => [
                            'plugins' => [
                                'textcolor colorpicker',
                                "advlist autolink lists link charmap print preview anchor",
                                "searchreplace visualblocks code fullscreen",
                                "insertdatetime media table contextmenu paste"
                            ],
                            'toolbar' => "undo redo | forecolor backcolor | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                        ]
                    ])->label(Yii::t('bl.articles.category.view', 'Full description.'))
                    ?>
                    <input type="submit" class="btn btn-primary pull-right" value="<?= Yii::t('bl.articles.category.view', 'Save') ?>">
                <? ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>


<?php
use maks757\articles\common\entities\Article;
use maks757\articles\common\entities\ArticleTranslation;
use maks757\articles\common\entities\Category;
use maks757\multilang\entities\Language;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $languages Language[] */
/* @var $selectedLanguage Language */
/* @var $article Article */
/* @var $article_translation ArticleTranslation */
/* @var $categories Category[] */

$this->title = 'Save article';
?>

<?php $form = ActiveForm::begin(['method'=>'post']) ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-list"></i>
                <?= Yii::t('articles', 'Basic') ?>
            </div>
            <div class="panel-body">
                <?php if(count($languages) > 1): ?>
                    <div class="dropdown">
                        <button class="btn btn-warning btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <?= $selectedLanguage->name ?>
                            <span class="caret"></span>
                        </button>
                        <?php if(count($languages) > 1): ?>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <?php foreach($languages as $language): ?>
                                    <li>
                                        <a href="
                                            <?= Url::to([
                                            'save',
                                            'articleId' => $article->id,
                                            'languageId' => $language->id])?>
                                            ">
                                            <?= $language->name?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div class="form-group field-validarticleform-category_id required has-success">
                    <label class="control-label" for="validarticleform-category_id"><?= 'Category' ?></label>
                    <select id="article-category_id" class="form-control" name="Article[category_id]">
                        <option value="">-- <?= 'Empty' ?> --</option>
                        <?php if(!empty($categories)): ?>
                            <?php foreach($categories as $category): ?>
                                <option <?= $article->category_id == $category->id ? 'selected' : '' ?> value="<?= $category->id?>">
                                    <?= $category->getTranslation($selectedLanguage->id)->name ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <div class="help-block"></div>
                </div>
                <?= $form->field($article_translation, 'name', [
                    'inputOptions' => [
                        'class' => 'form-control'
                    ]
                ])->label('Name')
                ?>

                <?= $form->field($article, 'color', [
                    'inputOptions' => [
                        'class' => 'form-control',
                        'type' => 'color'
                    ]
                ])->label('Color')
                ?>

                <?= $form->field($article_translation, 'short_text', [
                    'inputOptions' => [
                        'class' => 'form-control'
                    ]
                ])->widget(TinyMce::className(), [
                    'options' => ['rows' => 10],
                    'language' => 'ru',
                    'clientOptions' => [
                        'relative_urls' => true,
                        'remove_script_host' => false,
                        'verify_html' => false,
                        'plugins' => [
                            'textcolor colorpicker',
                            "advlist autolink lists link charmap print preview anchor",
                            "searchreplace visualblocks code fullscreen",
                            "insertdatetime media table contextmenu paste",
                            'image'
                        ],
                        'toolbar' => "undo redo | forecolor backcolor | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                    ]
                ])
                    ->label('Short description' )
                ?>
                <?= $form->field($article_translation, 'text', [
                    'inputOptions' => [
                        'class' => 'form-control'
                    ]
                ])->widget(TinyMce::className(), [
                    'options' => ['rows' => 20],
                    'language' => 'ru',
                    'clientOptions' => [
                        'relative_urls' => true,
//                        'remove_script_host' => false,
                        'verify_html' => false,
                        'plugins' => [
                            'textcolor colorpicker',
                            "advlist autolink lists link charmap print preview anchor",
                            "searchreplace visualblocks code fullscreen",
                            "insertdatetime media table contextmenu paste",
                            'image'
                        ],
                        'toolbar' => "undo redo | forecolor backcolor | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                    ]
                ])->label('Full description')
                ?>
                <input type="submit" class="btn btn-primary pull-right" value="<?= 'Save' ?>">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-list"></i>
                <?= 'Seo Data' ?>
            </div>
            <div class="panel-body">
                <?= $form->field($article_translation, 'seoUrl', [
                    'inputOptions' => [
                        'class' => 'form-control'
                    ]
                ])->label('Seo Url')
                ?>

                <?= $form->field($article_translation, 'seoTitle', [
                    'inputOptions' => [
                        'class' => 'form-control'
                    ]
                ])->label('Seo Title')
                ?>

                <?= $form->field($article_translation, 'seoDescription', [
                    'inputOptions' => [
                        'class' => 'form-control'
                    ]
                ])->textarea(['rows' => 3])->label('Seo Description')
                ?>

                <?= $form->field($article_translation, 'seoKeywords', [
                    'inputOptions' => [
                        'class' => 'form-control'
                    ]
                ])->textarea(['rows' => 3])->label('Seo Keywords')
                ?>
                <input type="submit" class="btn btn-primary pull-right" value="<?= 'Save' ?>">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-list"></i>
                <?= 'Tech' ?>
            </div>
            <div class="panel-body">
                <?= $form->field($article, 'view', [
                    'inputOptions' => [
                        'class' => 'form-control'
                    ]
                ])->label('View Name')
                ?>
                <?= $form->field($article, 'key', [
                    'inputOptions' => [
                        'class' => 'form-control'
                    ]
                ])->label('Key')
                ?>
                <input type="submit" class="btn btn-primary pull-right" value="<?= 'Save' ?>">
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

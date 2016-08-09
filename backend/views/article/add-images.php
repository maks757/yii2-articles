<?php
/**
 * @author Albert Gainutdinov <xalbert.einsteinx@gmail.com>
 *
 * @var $article Article
 * @var $image_form ArticleImageForm
 * @var $languageId Language
 */
use bl\articles\backend\components\form\ArticleImageForm;
use bl\articles\common\entities\Article;
use bl\multilang\entities\Language;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

?>

<? Pjax::begin([
    'linkSelector' => '.image',
    'enablePushState' => true,
    'timeout' => 5000
]);
?>

<h2><?= \Yii::t('shop', 'Images'); ?></h2>
<? $addForm = ActiveForm::begin(['method' => 'post', 'options' => ['enctype' => 'multipart/form-data']]) ?>
<table class="table-bordered table-condensed table-stripped table-hover">
    <thead class="thead-inverse">
    <tr>
        <th class="text-center col-md-1">
            <?= \Yii::t('shop', 'Type'); ?>
        </th>
        <?php if (!empty($article->menu_item) || !empty($article->thumbnail) || !empty($article->social)) : ?>
            <th class="text-center col-md-2">
                <?= \Yii::t('shop', 'Image preview'); ?>
            </th>
            <th class="text-center col-md-5">
                <?= \Yii::t('shop', 'Image URL'); ?>
            </th>
        <?php endif; ?>
        <th class="text-center col-md-3">
            <?= \Yii::t('shop', 'Upload'); ?>
        </th>
        <?php if (!empty($article->menu_item) || !empty($article->thumbnail) || !empty($article->social)) : ?>
            <th class="text-center col-md-1">
                <?= \Yii::t('shop', 'Delete'); ?>
            </th>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="text-center">
            <?= \Yii::t('shop', 'Menu item'); ?>
        </td>
        <?php if (!empty($article->menu_item) || !empty($article->thumbnail) || !empty($article->social)) : ?>
            <td>
                <?php if (!empty($article->menu_item)) : ?>
                    <img data-toggle="modal" data-target="#menuItemModal"
                         src="/images/articles/menu_item/<?= $article->menu_item . '-small.jpg'; ?>"
                         class="thumb">
                    <!-- Modal -->
                    <div id="menuItemModal" class="modal fade" role="dialog">
                        <img style="display: block" class="modal-dialog"
                             src="/images/articles/menu_item/<?= $article->menu_item . '-thumb.jpg'; ?>">
                    </div>
                <?php endif; ?>
            </td>
            <td>
                <?php if (!empty($article->menu_item)) : ?>
                    <input type="text" class="form-control" disabled=""
                           value="<?= '/images/articles/menu_item/' . $article->menu_item . '-big.jpg'; ?>">
                <?php endif; ?>
            </td>
        <?php endif; ?>
        <td>
            <?= $addForm->field($image_form, 'menu_item')->fileInput()->label(\Yii::t('shop', 'Upload image')); ?>
        </td>
        <?php if (!empty($article->menu_item) || !empty($article->thumbnail) || !empty($article->social)) : ?>
            <td class="text-center">
                <?php if (!empty($article->menu_item)) : ?>
                    <a href="<?= Url::toRoute(['delete-image', 'id' => $article->id, 'type' => 'menu_item']); ?>"
                       class="glyphicon glyphicon-remove text-danger btn btn-default btn-sm"></a>
                <?php endif; ?>
            </td>
        <?php endif; ?>
    </tr>
    <tr>
        <td class="text-center">
            <?= \Yii::t('shop', 'Thumbnail'); ?>
        </td>
        <?php if (!empty($article->menu_item) || !empty($article->thumbnail) || !empty($article->social)) : ?>
            <td>
                <?php if (!empty($article->thumbnail)) : ?>
                <img data-toggle="modal" data-target="#thumbnailModal"
                     src="/images/articles/thumbnail/<?= $article->thumbnail . '-small.jpg'; ?>"
                     class="thumb">
                <!-- Modal -->
                <div id="thumbnailModal" class="modal fade" role="dialog">
                    <img style="display: block" class="modal-dialog"
                         src="/images/articles/thumbnail/<?= $article->thumbnail . '-thumb.jpg'; ?>">
                    <?php endif; ?>
                </div>
            </td>
            <td>
                <?php if (!empty($article->thumbnail)) : ?>
                    <input type="text" class="form-control" disabled=""
                           value="<?= '/images/articles/thumbnail/' . $article->thumbnail . '-big.jpg'; ?>">
                <?php endif; ?>
            </td>
        <?php endif; ?>
        <td>
            <?= $addForm->field($image_form, 'thumbnail')->fileInput()->label(\Yii::t('shop', 'Upload image')); ?>
        </td>
        <?php if (!empty($article->menu_item) || !empty($article->thumbnail) || !empty($article->social)) : ?>
            <td class="text-center">
                <?php if (!empty($article->thumbnail)) : ?>
                    <a href="<?= Url::toRoute(['delete-image', 'id' => $article->id, 'type' => 'thumbnail']); ?>"
                       class="glyphicon glyphicon-remove text-danger btn btn-default btn-sm"></a>
                <?php endif; ?>
            </td>
        <?php endif; ?>
    </tr>
    <tr>
        <td class="text-center">
            <?= \Yii::t('shop', 'For social networks'); ?>
        </td>
        <?php if (!empty($article->menu_item) || !empty($article->thumbnail) || !empty($article->social)) : ?>
            <td>
                <?php if (!empty($article->social)) : ?>
                    <img data-toggle="modal" data-target="#socialModal"
                         src="/images/articles/social/<?= $article->social . '-small.jpg'; ?>"
                         class="thumb">
                    <!-- Modal -->
                    <div id="socialModal" class="modal fade" role="dialog">
                        <img style="display: block" class="modal-dialog"
                             src="/images/articles/social/<?= $article->social . '-thumb.jpg'; ?>">
                    </div>
                <?php endif; ?>
            </td>
            <td>
                <?php if (!empty($article->social)) : ?>
                    <input type="text" class="form-control" disabled=""
                           value="<?= '/images/articles/social/' . $article->social . '-big.jpg'; ?>">
                <?php endif; ?>
            </td>
        <?php endif; ?>
        <td>
            <?= $addForm->field($image_form, 'social')->fileInput()->label(\Yii::t('shop', 'Upload image')); ?>
        </td>
        <?php if (!empty($article->menu_item) || !empty($article->thumbnail) || !empty($article->social)) : ?>
            <td class="text-center">
                <?php if (!empty($article->social)) : ?>
                    <a href="<?= Url::toRoute(['delete-image', 'id' => $article->id, 'type' => 'social']); ?>"
                       class="glyphicon glyphicon-remove text-danger btn btn-default btn-sm"></a>
                <?php endif; ?>
            </td>
        <?php endif; ?>
    </tr>
    </tbody>
</table>

<?= Html::submitButton(\Yii::t('shop', 'Add'), ['class' => 'btn btn-primary']) ?>

<? ActiveForm::end(); ?>
<? Pjax::end(); ?>
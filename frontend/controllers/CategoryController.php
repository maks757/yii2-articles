<?php
namespace maks757\articles\frontend\controllers;

use maks757\articles\common\entities\Category;
use yii\web\Controller;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class CategoryController extends Controller
{
    public function actionIndex($id) {
        /* @var Category $category */
        $category = Category::findOne($id);

        $categoryTranslation = $category->translation;

        if(!empty($categoryTranslation->seoTitle)) {
            $this->view->title = $categoryTranslation->seoTitle;
        }
        else {
            $this->view->title = $categoryTranslation->name;
        }
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => html_entity_decode($categoryTranslation->seoDescription)
        ]);
        $this->view->registerMetaTag([
            'name' => 'keywords',
            'content' => html_entity_decode($categoryTranslation->seoKeywords)
        ]);

        return $this->render(!empty($category->view) ? $category->view : 'index', [
            'category' => $category
        ]);
    }
}
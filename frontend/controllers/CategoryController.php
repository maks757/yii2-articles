<?php
namespace bl\articles\frontend\controllers;

use bl\articles\common\entities\Category;
use yii\web\Controller;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class CategoryController extends Controller
{
    public function actionIndex($id) {
        $category = Category::findOne($id);

        $categoryTranslation = $category->translation;

        $this->view->title = $categoryTranslation->seoTitle;
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => html_entity_decode($categoryTranslation->seoDescription)
        ]);
        $this->view->registerMetaTag([
            'name' => 'keywords',
            'content' => html_entity_decode($categoryTranslation->seoKeywords)
        ]);

        return $this->render('index', [
            'category' => $category
        ]);
    }
}
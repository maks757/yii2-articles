<?php

/*
 * @author Maxim Cherednyk maks757q@gmail.com
*/
namespace maks757\articles\backend\controllers;

use maks757\articles\common\entities\Category;
use maks757\articles\common\entities\CategoryTranslation;
use maks757\multilang\entities\Language;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

class CategoryController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'roles' => ['viewArticleCategoryList'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['save', 'switch-show'],
                        'roles' => ['editArticleCategories'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['delete'],
                        'roles' => ['deleteArticleCategories'],
                        'allow' => true,
                    ],
                ],
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'categories' => Category::find()->with(['translations'])->all(),
            'languages' => Language::findAll(['active' => true])
        ]);
    }

    public function actionSave($languageId = null, $categoryId = null)
    {
        if (!empty($categoryId)) {
            $category = Category::findOne($categoryId);
            $category_translation = CategoryTranslation::find()->where([
                'category_id' => $categoryId,
                'language_id' => $languageId
            ])->one();
            if(empty($category_translation))
                $category_translation = new CategoryTranslation();
        } else {
            $category = new Category();
            $category_translation = new CategoryTranslation();
        }

        if(Yii::$app->request->isPost) {
            $category->load(Yii::$app->request->post());
            $category_translation->load(Yii::$app->request->post());

            if($category->validate() && $category_translation->validate())
            {
                $category->save();
                $category_translation->category_id = $category->id;
                $category_translation->language_id = $languageId;
                $category_translation->save();
                Yii::$app->getSession()->setFlash('success', 'Data were successfully modified.');
                return $this->redirect(Url::toRoute('/articles/category'));
            }
            else
                Yii::$app->getSession()->setFlash('danger', 'Failed to change the record.');
        }

        return $this->render('edit', [
            'category' =>  $category,
            'category_translation' => $category_translation,
            'categories' => Category::find()->with('translations')->all(),
            'selectedLanguage' => Language::findOne($languageId),
            'languages' => Language::findAll(['active' => true])
        ]);
    }

    public function actionDelete($id)
    {
        $model = Category::find()->where(['id' => $id])->one();
        if($model->delete())
            return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionSwitchShow($id) {
        /* @var Category $article */
        if($article = Category::findOne($id)) {
            $article->show = !$article->show;
            $article->save();
        }

        return $this->redirect(Url::to(['/articles/category']));
    }
}
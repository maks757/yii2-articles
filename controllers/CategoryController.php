<?php

/*
 * @author Maxim Cherednyk maks757q@gmail.com
*/
namespace bl\articles\controllers;

use bl\multilang\entities\Language;
use bl\articles\entities\Category;
use bl\articles\entities\CategoryTranslation;
use bl\articles\models\LanguageModel;
use bl\articles\models\ValidCategoryForm;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

class CategoryController extends Controller
{

//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'actions' => ['index', 'save', 'delete'],
//                        'allow' => true,
//                        'roles' => ['editArticles'],
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
//        ];
//    }

    public $parent;
    public $languages;
    public $module;

    public function actions()
    {
        $this->module = Yii::$app->controller->module;
        $this->parent = CategoryTranslation::getAllCategory();

        $this->languages = Language::find()->where(['show' => true]);
        if(!$this->module->multiLanguage)
            $this->languages = $this->languages->andWhere(['default' => true]);
        $this->languages = $this->languages->all();
    }

    public function actionIndex()
    {
        $categories = Category::find()
            ->with(['translations' => function($query){
                $query = $query->addOrderBy(['name' => SORT_ASC]);
                    if(!$this->module->multiLanguage)
                        $query->andWhere(['language_id' => Language::getDefault()->id]);
            }])
            ->all();

        return $this->render('index', [
            'categories' => $categories,
            'languages' => $this->languages,
            'baseLanguageUser' => $language = Language::find()->where(['lang_id' => Yii::$app->language])->one(),
            'baseLanguage' => Language::getDefault()
        ]);
    }

    public function actionSave($languageId = null, $categoryId = null)
    {
        $language = Language::findOrDefault($languageId);

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

        return $this->render('edit',
            [
                'category' =>  $category,
                'category_translation' => $category_translation,
                'parents' => $this->parent,
                'languages' => $this->languages,
                'baseLanguage' => $language,
                'baseCategory' => $categoryId
            ]);
    }

    public function actionDelete($id)
    {
        $model = Category::find()->where(['id' => $id])->one();
        if($model->delete())
            return $this->redirect(\Yii::$app->request->referrer);
    }
}
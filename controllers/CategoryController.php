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

class CategoryController extends Controller
{

    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'save', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }*/

    public $parent;
    public $language;
    public $module;

    public function actions()
    {
        $this->module = Yii::$app->controller->module;
        $this->parent = CategoryTranslation::getAllCategory();
        if($this->module->multiLanguage)
            $this->language = Language::find()->where(['show' => true])->all();
        else
            $this->language = $this->module->modelLanguage;
    }

    public function actionIndex()
    {
        $categories = Category::find()
            ->with(['translations' => function($query){
                $query->addOrderBy(['name' => SORT_ASC]);
            }])
            ->all();

        $dataView = [
            'categories' => $categories,
            'languages' => $this->language,
            'baseLanguageUser' => $this->language
        ];

        if($this->module->multiLanguage)
        {
            $dataView['baseLanguageUser'] = $language = Language::find()->where(['lang_id' => Yii::$app->language])->one();
            $dataView['baseLanguage'] = $language = Language::find()->where(['lang_id' => Yii::$app->sourceLanguage])->one();
        }

        return $this->render('index', $dataView);
    }

    public function actionSave($languageId = null, $categoryId = null)
    {
        $language = LanguageModel::findDefaultLanguage($languageId, $this->module);

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
                'languages' => $this->language,
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
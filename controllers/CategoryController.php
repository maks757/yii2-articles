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

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    Yii::$app->controller->module->rules
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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
        $model = new ValidCategoryForm();
        $categories = Category::find()
            ->with(['translations' => function($query){
                $query->addOrderBy(['name' => SORT_ASC]);
            }])
            ->all();

        $dataView = [
            'model' => $model,
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

    public function actionSave()
    {
        $category_id = \Yii::$app->request->get('categoryId');
        $model = new ValidCategoryForm();
        $language = LanguageModel::findDefaultLanguage(Yii::$app->request->get('languageId'), $this->module);

        $category = CategoryTranslation::find()
            ->where(['category_id' => $category_id, 'language_id' => $language->id])
            ->one();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if($model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Data successfully written.');
            } else {
                Yii::$app->getSession()->setFlash('danger', 'Failed to change the record.');
                return $this->redirect(Url::toRoute('/articles/category'));
            }
        } elseif(!empty($category)) {
            $model = new ValidCategoryForm([
                'parent_id' => $category->category->parent_id,
                'category_id' => $category_id,
                'language_id' => $language->id,
                'name' => $category->name,
                'text' => $category->text,
                'short_text' => $category->short_text
            ]);
        }



        return $this->render('edit',
            [
                'model' =>  $model,
                'parents' => $this->parent,
                'languages' => $this->language,
                'baseLanguage' => $language,
                'baseCategory' => $category_id
            ]);
    }

    public function actionDelete($id)
    {
        $model = Category::find()->where(['id' => $id])->one();
        if($model->delete())
            return $this->redirect(\Yii::$app->request->referrer);
    }
}
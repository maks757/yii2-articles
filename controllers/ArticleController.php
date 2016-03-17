<?php

namespace common\modules\article\controllers;

use bl\multilang\entities\Language;
use bl\articles\entities\Article;
use bl\articles\entities\Category;
use bl\articles\entities\CategoryTranslation;
use bl\articles\models\ValidArticleForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class ArticleController extends Controller
{
    public $language;
    public $languages;
    public $parent;
    public $baseParent;
    public function actions()
    {
        $this->module = Yii::$app->controller->module;

        if($this->module->multiLanguage) {
            $this->languages = Language::find()->where(['show' => true])->all();
            $this->language = Language::findOrDefault(Yii::$app->request->get('languageId'));
        } else {
            $this->languages = $this->module->modelLanguage;
            $this->language = $this->module->modelLanguage;
        }
        $this->baseParent = CategoryTranslation::getOneCategory(Yii::$app->request->get('articleId'));
        $this->parent = CategoryTranslation::getAllCategory();
    }

    public function actionIndex()
    {
        $article = Article::find()->with(['category', 'category.translations', 'translations'])->all();
        if($this->module->multiLanguage)
            $userLanguage = Language::find()->where(['lang_id' => Yii::$app->language])->one();
        else
            $userLanguage = $this->module->modelLanguage;
        return $this->render('index',
            [
                'articles' => $article,
                'parents' => $this->parent,
                'languages' => $this->languages,
                'baseLanguageUser' => $userLanguage,
                'baseLanguage' => $this->language,
                'baseParent' => $this->baseParent,
            ]);
    }

    public function actionSave(){
        $model = new ValidArticleForm();
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save())
                Yii::$app->getSession()->setFlash('success', 'Data were successfully modified.');
            else
                Yii::$app->getSession()->setFlash('danger', 'Failed to change the record.');
        }

        foreach(Category::find()->with('translations')->all() as $value){
            $categories[] = ArrayHelper::index($value->translations, 'language_id')[$this->language->id];
        }

        $data_article = Article::find()->where([
                'id' => Yii::$app->request->get('articleId')
            ])
            ->with(['translations' => function($query) {
                $query->andWhere(['language_id' => Yii::$app->request->get('languageId')]);
            }, 'category'])->one();

        if(!empty($data_article)) {
            $article = ArrayHelper::index($data_article->translations, 'language_id');
            $baseCategory = $data_article->category->id;
            $model = new ValidArticleForm([
                'id' => $data_article->id,
                'category_id' => Yii::$app->request->get('articleId'),
                'language_id' => Yii::$app->request->get('languageId'),
                'name' => $article[$this->language->id]->name,
                'short_text' => $article[$this->language->id]->short_text,
                'text' => $article[$this->language->id]->text,
            ]);
        }

        return $this->render('save',
        [
            'model' => $model,
            'categories' => $categories,
            'baseCategory' => $baseCategory,
            'languages' => $this->languages,
            'baseLanguage' => $this->language,
        ]);
    }
}

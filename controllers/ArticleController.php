<?php

namespace bl\articles\controllers;

use bl\articles\entities\ArticleTranslation;
use bl\multilang\entities\Language;
use bl\articles\entities\Article;
use bl\articles\entities\Category;
use bl\articles\entities\CategoryTranslation;
use bl\articles\models\ValidArticleForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ArticleController extends Controller
{

    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'save'],
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

    public function actionSave($languageId = null, $articleId = null){

        foreach(Category::find()->with('translations')->all() as $value){
            $categories[] = ArrayHelper::index($value->translations, 'language_id')[$this->language->id];
        }

        if (!empty($articleId)) {
            $article = Article::findOne($articleId);
            $article_translation = ArticleTranslation::find()->where([
                'article_id' => $articleId,
                'language_id' => $languageId
            ])->one();
            if(empty($article_translation))
                $article_translation = new ArticleTranslation();
        } else {
            $article = new Article();
            $article_translation = new ArticleTranslation();
        }
        if(Yii::$app->request->isPost) {
            $article->load(Yii::$app->request->post());
            $article_translation->load(Yii::$app->request->post());

            if($article->validate() && $article_translation->validate())
            {
                $article->save();
                $article_translation->article_id = $article->id;
                $article_translation->language_id = $languageId;
                $article_translation->save();
                Yii::$app->getSession()->setFlash('success', 'Data were successfully modified.');
                return $this->redirect(Url::toRoute('/articles/article'));
            }
            else
                Yii::$app->getSession()->setFlash('danger', 'Failed to change the record.');
        }

        return $this->render('save',
            [
                'article' => $article,
                'article_translation' => $article_translation,
                'categories' => $categories,
                'baseCategory' => $articleId,
                'languages' => $this->languages,
                'baseLanguage' => $this->language,
            ]);
    }
}

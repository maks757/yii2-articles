<?php

namespace bl\articles\backend\controllers;

use bl\articles\common\entities\Article;
use bl\articles\common\entities\ArticleTranslation;
use bl\articles\common\entities\Category;
use bl\multilang\entities\Language;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class ArticleController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index',
            [
                'articles' => Article::find()->with(['category', 'category.translations', 'translations'])->all(),
                'languages' => Language::findAll(['active' => true])
            ]);
    }

    public function actionSave($languageId = null, $articleId = null){

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
                'categories' => Category::find()->with('translations')->all(),
                'selectedLanguage' => Language::findOne($languageId),
                'languages' => Language::findAll(['active' => true])
            ]);
    }
}

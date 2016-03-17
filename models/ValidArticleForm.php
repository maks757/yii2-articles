<?php
/*
 * @author Cherednyk Maxim maks757q@gmail.com
*/

namespace bl\articles\models;

use bl\articles\entities\Article;
use bl\articles\entities\ArticleTranslation;
use Yii;
use yii\base\Model;
use yii\db\Exception;

class ValidArticleForm extends Model
{
    public $id;

    public $category_id;
    public $language_id;

    public $name;
    public $text;
    public $short_text;

    public function rules()
    {
        return [
            [['id', 'category_id'], 'number'],
            [['name', 'language_id'], 'required'],
            [['short_text', 'text'], 'string'],
        ];
    }

    public function save(){
        $transactionArticle = \Yii::$app->db->beginTransaction();
        try{
            $helpArticleTranslation = ArticleTranslation::find()
                ->where([
                    'language_id' => $this->language_id,
                    'article_id' => $this->id,
                ])
                ->with(['article' => function ($query) {
                    $query->andWhere(['category_id' => $this->category_id]);
                }])->one();
            if(empty($helpArticleTranslation->id)) {
                $helpArticleTranslation = new ArticleTranslation();
            }
            $helpArticleTranslation->language_id = $this->language_id;
            $helpArticleTranslation->name = $this->name;
            $helpArticleTranslation->short_text = $this->short_text;
            $helpArticleTranslation->text = $this->text;
            if(!empty($this->id)) {
                $helpArticleTranslation->article_id = $this->id;
            }
            else{
                $helpArticle = new Article();
                $helpArticle->category_id = $this->category_id;
                $helpArticle->save();
                $transactionArticle->commit();
                $helpArticleTranslation->article_id = $helpArticle->id;
            }
            $helpArticleTranslation->save();
            $transactionArticle->commit();
        }
        catch(Exception $ex)
        {
            $transactionArticle->rollBack();
            return false;
        }
        return true;
    }
}
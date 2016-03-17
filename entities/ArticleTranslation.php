<?php
namespace bl\articles\entities;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "help_article_translation".
 *
 * @property integer $id
 * @property integer $language_id
 * @property string $name
 * @property string $text
 * @property string $short_text
 *
 * @property Language $language
 * @property Article $article
 */
class ArticleTranslation extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_translation';
    }

    public static function getOneArticle($id){
        $model = Category::find()
            ->andWhere(['id' => $id])->one();
        if(empty($model->id))
            return $id;
        return $model;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }
}

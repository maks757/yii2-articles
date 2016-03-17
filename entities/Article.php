<?php
namespace bl\articles\entities;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "help_article".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $created
 * @property string $updated
 *
 * @property Category $category
 * @property ArticleTranslation[] $helpArticleTranslations
 */
class Article extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(ArticleTranslation::className(), ['article_id' => 'id']);
    }
}

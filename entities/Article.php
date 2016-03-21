<?php
namespace bl\articles\entities;
use Yii;
use yii\db\ActiveRecord;

/**
 * Article
 *
 * @property integer $id
 * @property integer $category_id
 */
class Article extends ActiveRecord
{

    public function rules()
    {
        return [
            ['category_id', 'number'],
        ];
    }

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

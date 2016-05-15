<?php
namespace bl\articles\common\entities;
use bl\multilang\behaviors\TranslationBehavior;
use Yii;
use yii\db\ActiveRecord;

/**
 * Article
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $view
 *
 * @property Category $category
 * @property ArticleTranslation[] translations
 * @property ArticleTranslation translation
 */
class Article extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'translation' => [
                'class' => TranslationBehavior::className(),
                'translationClass' => ArticleTranslation::className(),
                'relationColumn' => 'article_id'
            ]
        ];
    }

    public function rules()
    {
        return [
            ['category_id', 'number'],
            ['view', 'string']
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

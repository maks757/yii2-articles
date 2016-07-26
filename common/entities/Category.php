<?php
namespace bl\articles\common\entities;

use bl\multilang\behaviors\TranslationBehavior;
use yii\db\ActiveRecord;

/**
 * Category model
 *
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 *
 * @property integer $id
 * @property string $key
 * @property integer $parent_id
 * @property boolean $show
 * @property boolean $show_articles
 * @property string $view
 * @property string $article_view
 *
 * @property CategoryTranslation[] $translations
 * @property CategoryTranslation $translation
 */
class Category extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'translation' => [
                'class' => TranslationBehavior::className(),
                'translationClass' => CategoryTranslation::className(),
                'relationColumn' => 'category_id'
            ]
        ];
    }

    public function rules()
    {
        return [
            ['parent_id', 'number'],
            [['show', 'show_articles'], 'boolean'],
            [['view', 'article_view'], 'string'],
            ['key', 'unique']
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_category';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(Category::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(CategoryTranslation::className(), ['category_id' => 'id']);
    }
}
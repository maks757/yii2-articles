<?php
/*
 * @author Maxim Cherednyk maks757q@gmail.com
*/
namespace bl\articles\entities;

use yii\db\ActiveRecord;
/**
 * Category model
 *
 * @property integer $id
 * @property integer $parent_id
 */
class Category extends ActiveRecord
{

    public function rules()
    {
        return [
            ['parent_id', 'number']
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
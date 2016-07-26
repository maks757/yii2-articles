<?php
namespace bl\articles\common\entities;

use bl\multilang\entities\Language;
use bl\seo\behaviors\SeoDataBehavior;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * CategoryTranslation model
 *
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $language_id
 * @property integer $name
 * @property integer $text
 * @property integer $short_text
 */
class CategoryTranslation extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'seoData' => [
                'class' => SeoDataBehavior::className()
            ]
        ];
    }

    public function rules()
    {
        return [
            [['category_id', 'language_id'], 'number'],
            [['name', 'text', 'short_text'], 'string'],
            // seo data
            [['seoUrl', 'seoTitle', 'seoDescription', 'seoKeywords'], 'string']
        ];
    }
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'text' => 'Text',
            'short_text' => 'Short text',
        ];
    }

    public static function tableName() {
        return 'article_category_translation';
    }
    public static function getAllCategory(){
        return ArrayHelper::index(CategoryTranslation::find()->orderBy('language_id DESC, category_id DESC')->all(), 'category_id');
    }
    public static function getOneCategory($id){
        $model = CategoryTranslation::find();
        if(!empty($id))
            $model->andWhere(['category_id' => $id]);
        return $model->one();
    }
    public function getCategory() {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
    public function getLanguage() {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }
}
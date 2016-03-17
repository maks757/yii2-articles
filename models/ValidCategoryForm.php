<?php

/*
 * @author Maxim Cherednyk maks757q@gmail.com
*/
namespace bl\articles\models;

use bl\articles\entities\Category;
use bl\articles\entities\CategoryTranslation;
use yii\base\Model;
use yii\db\Exception;

class ValidCategoryForm extends Model
{
    public $category_id;
    public $language_id;
    public $parent_id;

    public $name;
    public $short_text;
    public $text;


    public function rules()
    {
        return [
            [['category_id', 'parent_id'], 'number'],
            [['short_text', 'text'], 'string'],
            [['name', 'language_id'], 'required'],
        ];
    }

    public function save()
    {
        $transactionCategory = \Yii::$app->db->beginTransaction();
        try {
            if (empty($articleCategoryTranslation = CategoryTranslation::find()
                ->where(['category_id' => $this->category_id, 'language_id' => $this->language_id])->one())) ;
                $articleCategoryTranslation = new CategoryTranslation();

            if (!empty($this->category_id))
                $parent = Category::findOne($articleCategoryTranslation->category->id);
            else
                $parent = new Category();

            if (!empty($parent)) {
                $parent->parent_id = $this->parent_id;
                $parent->save();
                $transactionCategory->commit();
                $this->category_id = $parent->id;
            }
            $articleCategoryTranslation->category_id = $this->category_id;
            $articleCategoryTranslation->language_id = $this->language_id;
            $articleCategoryTranslation->name = $this->name;
            $articleCategoryTranslation->text = $this->text;
            $articleCategoryTranslation->short_text = $this->short_text;
            $articleCategoryTranslation->save();
            $transactionCategory->commit();
        } catch (Exception $ex) {
            $transactionCategory->rollBack();
            return $ex->getMessage();
        }
        return true;
    }
}
<?php

namespace bl\articles\backend\components\form;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use bl\imagable\Imagable;


/**
 * @author Albert Gainutdinov <xalbert.einsteinx@gmail.com>
 */

class ArticleImageForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $social;
    public $thumbnail;
    public $menu_item;

    public function rules()
    {
        return [
            [['social', 'thumbnail', 'menu_item'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $dir = Yii::getAlias('@frontend/web/images/articles');

            $imagable = \Yii::$app->imagable;
            $imagable->imagesPath = Yii::getAlias('@frontend/web/images/articles');
            $image_name = [];

            /** @var Imagable $this */
            if (!empty($this->social)) {
                $this->social->saveAs($dir . $this->social->baseName . '.jpg');
                $image_name['social'] = $imagable->create('social', $dir . $this->social->baseName . '.jpg');
                unlink($dir . $this->social->baseName . '.jpg');
            }

            /** @var Imagable $this */
            if (!empty($this->thumbnail)) {
                $this->thumbnail->saveAs($dir . $this->thumbnail->baseName . '.jpg');
                $image_name['thumbnail'] = $imagable->create('thumbnail', $dir . $this->thumbnail->baseName . '.jpg');
                unlink($dir . $this->thumbnail->baseName . '.jpg');
            }

            /** @var Imagable $this */
            if (!empty($this->menu_item)) {

                $this->menu_item->saveAs($dir . $this->menu_item->baseName . '.jpg');
                $image_name['menu_item'] = $imagable->create('menu_item', $dir . $this->menu_item->baseName . '.jpg');
                unlink($dir . $this->menu_item->baseName . '.jpg');
            }
            return $image_name;
        } else {
            return false;
        }
    }
}
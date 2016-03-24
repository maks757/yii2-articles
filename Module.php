<?php

namespace bl\articles;

use bl\multilang\entities\Language;
use bl\articles\models\LanguageModel;
use yii\db\Exception;
use yii\helpers\Console;
use yii\web\Application;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'bl\articles\controllers';

    public $defaultRoute = 'article';
    /**
     * Multi language
     **/
    public $multiLanguage = false;
    /**
     * Default params
     * 'translate' => 'en-US';
     *
     * basic translations {'en-US', 'ru-RU'}
     **/
    public $translate;
    /**
     * If you want to implement their own translations for our module you need to add the module parameter
     * 'activeTranslate' => false,
     * and use the category name
     * 'bl.articles'
     **/
    public $activeTranslate = true;

    public function init()
    {
        parent::init();
        if($this->activeTranslate){
            $this->registerTranslations();
        }
    }

    public function registerTranslations()
    {
        if(!empty($this->translate))
            \Yii::$app->language = $this->translate;

        \Yii::$app->i18n->translations['bl.articles'] = [
            'class'          => 'yii\i18n\PhpMessageSource',
            'basePath'       => '@vendor/black-lamp/yii2-articles/lang',
            'fileMap'        => [
                'bl.articles' => 'message.php'
            ],
        ];
    }


}

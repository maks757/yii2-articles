<?php

namespace bl\articles;

use bl\multilang\entities\Language;
use bl\articles\models\LanguageModel;
use yii\db\Exception;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'bl\articles\controllers';
    /**
     * Multi language
    **/
    public $multiLanguage = false;
    /**
     * Default params
     * 'languageName' => 'English';
     **/
    public $languageName;


    public $modelLanguage;

    public function init()
    {
        parent::init();
        $this->registerTranslations();
        if(!$this->multiLanguage){
            $this->modelLanguage = new LanguageModel();
            if(!empty($this->languageName)) {
                $this->modelLanguage->name = $this->languageName;
            }
        } else {
            try {
                Language::find()->one();
            } catch(Exception $ex) {
                throw new Exception('Table "language" not exist, please preset the desired module - "path module", or not use multi-lingual version of the module.');
            }
        }
    }

    public function registerTranslations()
    {
        \Yii::$app->i18n->translations['modules/users/*'] = [
            'class'          => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
//            'basePath'       => '@vendor/black-lamp/articles/lang',
//            'fileMap'        => [
//            ],
        ];
    }

}

<?php

namespace bl\articles;

use bl\multilang\entities\Language;
use bl\articles\models\LanguageModel;
use yii\db\Exception;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'common\modules\article\controllers';
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
}

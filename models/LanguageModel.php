<?php
/*
 * @author Cherednyk Maxim maks757q@gmail.com
*/


namespace bl\articles\models;


use bl\multilang\entities\Language;

class LanguageModel
{
    public $id = 1;
    public $name = 'English';

    public static function findDefaultLanguage($languageId, $module) {
        if($module->multiLanguage) {
            $language = Language::findOrDefault($languageId);
        } else {
            $language = $module->modelLanguage;
        }
        return $language;
    }
}
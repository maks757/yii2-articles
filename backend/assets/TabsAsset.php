<?php
namespace bl\articles\backend\assets;
use yii\web\AssetBundle;

/**
 * @author Albert Gainutdinov <xalbert.einsteinx@gmail.com>
 */

class TabsAsset extends AssetBundle
{
    public $sourcePath = '@vendor/black-lamp/yii2-articles/backend/web';

    public $css = [
        'css/tabs.css',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
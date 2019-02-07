<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 07.02.19
 * Time: 0:27
 */

namespace app\assets;


use yii\web\AssetBundle;

class VueAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
        'js/axios.min.js',
        YII_DEBUG ? 'js/vue.js' : 'js/vue.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
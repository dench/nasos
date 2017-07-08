<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 18.03.17
 * Time: 21:46
 */

namespace app\assets;


use yii\web\AssetBundle;

class PhotoSwipe extends AssetBundle
{
    public $sourcePath = '@bower/photoswipe/dist';
    public $css = [
        '/css/photoswipe/photoswipe.min.css',
        '/css/photoswipe/default-skin.min.css',
    ];
    public $js = [
        'photoswipe.min.js',
        'photoswipe-ui-default.min.js',
    ];
    public $depends = [
        'app\assets\SiteAsset'
    ];
}
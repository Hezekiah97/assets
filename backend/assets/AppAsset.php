<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // 'css/site.css',
        "assets_ui/css/icons.min.css",
        "assets_ui/css/app.min.css",
        'assets_ui/css/vendor/responsive.bootstrap5.css',
    ];
    public $js = [
        // 'assets_ui/js/vendor/jquery.min.js',
        'assets_ui/js/vendor.min.js',
        'assets_ui/js/app.min.js',
        // 'assets_ui/js/pages/demo.dashboard-projects.js',
        // 'assets_ui/js/vendor/responsive.bootstrap5.min.js',
        'assets_ui/js/main.js',
        'assets_ui/js/popper.min.js',
        'assets_ui/js/bootbox.min.js',
        'assets_ui/js/confirmSwal.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        // 'yii\bootstrap4\BootstrapAsset',
        // 'yii\bootstrap4\BootstrapPluginAsset',
    ];
    
}

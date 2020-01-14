<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [


        'template/dist/css/style.min.css',
       //'template/dist/css/style.css',

        'template/assets/libs/flot/css/float-chart.css',

    ];
    public $js = [
     //  'js/yii_overrides.js',
  //  "template/assets/libs/jquery/dist/jquery.min.js",
    "template/assets/libs/popper.js/dist/umd/popper.min.js",
    //"template/assets/libs/bootstrap/dist/js/bootstrap.min.js",
    "template/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js",
    "template/assets/extra-libs/sparkline/sparkline.js",
    "template/dist/js/waves.js",
    "template/dist/js/sidebarmenu.js",
    "template/dist/js/custom.min.js",

    ];
    public $depends = [
       'yii\web\YiiAsset',
    'yii\bootstrap4\BootstrapAsset',
        //additional import of third party alert project
         'app\assets\SweetAlertAsset',
    ];
}

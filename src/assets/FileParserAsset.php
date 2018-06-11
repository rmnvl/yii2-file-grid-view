<?php

namespace rmnvl\yii2FileGridView\src\assets;

use yii\web\AssetBundle;

class FileParserAsset extends AssetBundle
{
    public $js = [
        'js/index.js'
    ];

    public $css = [
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];

    public function init()
    {
        // Tell AssetBundle where the assets files are
        $this->sourcePath = __DIR__ . "";
        parent::init();
    }
}
<?php

namespace Zelenin\yii\SemanticUI\assets;

use Yii;
use yii\web\AssetBundle;

class SemanticUIJSAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vendor/bower/semantic/dist';

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'Zelenin\yii\SemanticUI\assets\SemanticUICSSAsset'
    ];

    public function init()
    {
        $postfix = YII_DEBUG ? '' : '.min';
        $this->js[] = 'semantic' . $postfix . '.js';

        parent::init();
    }
}

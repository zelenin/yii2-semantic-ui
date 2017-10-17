<?php

namespace Zelenin\yii\SemanticUI\assets;

use Yii;
use yii\web\AssetBundle;

class SemanticUICSSAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vendor/bower/semantic/dist';
	
	/**
     * @var array
     */
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    public function init()
    {
        $postfix = YII_DEBUG ? '' : '.min';
        $this->css[] = 'semantic' . $postfix . '.css';

        parent::init();
    }
}

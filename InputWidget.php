<?php

namespace Zelenin\yii\SemanticUI;

use Zelenin\yii\SemanticUI\assets\SemanticUIJSAsset;

class InputWidget extends \yii\widgets\InputWidget
{
    public $options = [];
    public $clientOptions = [];

    public function registerJsAsset()
    {
        SemanticUIJSAsset::register($this->getView());
    }
}

<?php

namespace Zelenin\yii\SemanticUI;

use Zelenin\yii\SemanticUI\assets\SemanticUIJSAsset;

class InputWidget extends \yii\widgets\InputWidget
{
    public $options = [];
    public $clientOptions = [];

    public function init()
    {
        parent::init();
        isset($this->options['id'])
            ? $this->setId($this->options['id'])
            : $this->options['id'] = $this->getId();
    }

    public function registerJsAsset()
    {
        SemanticUIJSAsset::register($this->getView());
    }
}

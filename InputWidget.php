<?php

namespace Zelenin\yii\SemanticUI;

use Zelenin\yii\SemanticUI\assets\SemanticUIJSAsset;

class InputWidget extends \yii\widgets\InputWidget
{
    /**
     * @var array
     */
    public $options = [];

    /**
     * @var array
     */
    public $clientOptions = [];

    public function init()
    {
        parent::init();
        isset($this->options['id'])
            ? $this->setId($this->options['id'])
            : $this->options['id'] = $this->getId();

        if (is_array($this->options)) {
            foreach($this->options as $name => $value) {
                if (property_exists($this, $name)) {
                    $this->$name = $value;
                }
            }
        }
    }

    public function registerJsAsset()
    {
        SemanticUIJSAsset::register($this->getView());
    }
}

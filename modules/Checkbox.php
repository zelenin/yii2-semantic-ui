<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\Html;
use Zelenin\yii\SemanticUI\InputWidget;

class Checkbox extends InputWidget
{
    public $label;
    public $labelOptions = [];
    public $checked = false;

    public $template = '<div class="ui checkbox">{input}{label}</div>';

    public function run()
    {
        $this->options['label'] = null;
        $input = $this->renderInput();
        $label = $this->renderLabel();

        echo strtr($this->template, [
            '{label}' => $label,
            '{input}' => $input
        ]);
    }

    public function renderInput()
    {
        return $this->hasModel()
            ? Html::activeCheckbox($this->model, $this->attribute, $this->options)
            : Html::checkbox($this->name, $this->checked, $this->options);
    }

    public function renderLabel()
    {
        return $this->hasModel()
            ? Html::activeLabel($this->model, $this->attribute, $this->labelOptions)
            : Html::label($this->label, $this->getId(), $this->labelOptions);
    }
}

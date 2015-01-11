<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\Html;

class Radio extends Checkbox
{
    public $template = '<div class="ui radio checkbox">{input}{label}</div>';

    public function renderInput()
    {
        return $this->hasModel()
            ? Html::activeRadio($this->model, $this->attribute, $this->options)
            : Html::radio($this->name, $this->checked, $this->options);
    }
}

<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\Html;

class Radio extends Checkbox
{
    public $radioOptions = [];

    public $type = self::TYPE_RADIO;
    const TYPE_RADIO = 'radio';

    public function renderInput()
    {
        if (!isset($this->radioOptions['id'])) {
            $id = $this->getId() . '-' . ($this->hasModel() ? $this->attribute : $this->name);
            $this->radioOptions['id'] = $id;
        }
        return $this->hasModel()
            ? Html::activeRadio($this->model, $this->attribute, $this->radioOptions)
            : Html::radio($this->name, $this->checked, $this->radioOptions);
    }

    public function renderLabel()
    {
        if (!isset($this->labelOptions['for'])) {
            $this->labelOptions['for'] = $this->radioOptions['id'];
        }
        return $this->hasModel()
            ? Html::activeLabel($this->model, $this->attribute, $this->labelOptions)
            : Html::label($this->label, $this->labelOptions['for'], $this->labelOptions);
    }
}

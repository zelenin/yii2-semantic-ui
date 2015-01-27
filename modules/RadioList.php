<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\Html;

class RadioList extends CheckboxList
{
    public function renderInput()
    {
        return $this->hasModel()
            ? Html::activeRadioList($this->model, $this->attribute, $this->items, $this->options)
            : Html::radioList($this->name, $this->selection, $this->items, $this->options);
    }

    public function getDefaultItem()
    {
        return function ($index, $label, $name, $checked, $value) {
            return Html::tag(
                'div',
                Radio::widget([
                    'name' => $name,
                    'label' => $label,
                    'checked' => $checked,
                    'inputOptions' => $this->inputOptions,
                    'labelOptions' => $this->labelOptions
                ]),
                ['class' => 'field']
            );
        };
    }
}

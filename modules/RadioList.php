<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class RadioList extends CheckboxList
{
    /**
     * @return string
     */
    public function renderInput()
    {
        return $this->hasModel()
            ? Html::activeRadioList($this->model, $this->attribute, $this->items, $this->options)
            : Html::radioList($this->name, $this->selection, $this->items, $this->options);
    }

    /**
     * @return callable
     */
    public function getDefaultItem()
    {
        return function ($index, $label, $name, $checked, $value) {
            $inputOptions = $this->inputOptions;
            $inputOptions['value'] = ArrayHelper::getValue($inputOptions, 'value', $value);
            return Html::tag(
                'div',
                Radio::widget([
                    'name' => $name,
                    'label' => $label,
                    'checked' => $checked,
                    'inputOptions' => $inputOptions,
                    'labelOptions' => $this->labelOptions
                ]),
                ['class' => 'field']
            );
        };
    }
}

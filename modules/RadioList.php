<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\Html;

class RadioList extends CheckboxList
{
    public $itemTemplate = '<div class="field"><div class="ui radio checkbox">{input}{label}</div></div>';

    public function renderInput()
    {
        if (!array_key_exists('item', $this->options)) {
            $this->options['item'] = function ($index, $label, $name, $checked, $value) {
                $id = $this->getId() . '-' . $index;
                $label = Html::label($label, $id, $this->labelOptions);
                $input = Html::radio($name, $checked, array_merge($this->itemOptions, ['id' => $id]));
                return strtr($this->itemTemplate, [
                    '{label}' => $label,
                    '{input}' => $input
                ]);
            };
        }

        return $this->hasModel()
            ? Html::activeRadioList($this->model, $this->attribute, $this->items, $this->options)
            : Html::radioList($this->name, $this->selection, $this->items, $this->options);
    }
}

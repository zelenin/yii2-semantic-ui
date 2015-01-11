<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\Html;
use Zelenin\yii\SemanticUI\InputWidget;

class CheckboxList extends InputWidget
{
    public $items = [];
    public $selection = null;

    public $labelOptions = [];
    public $itemOptions = [];

    public $template = '<div class="grouped fields">{inputList}</div>';
    public $itemTemplate = '<div class="field"><div class="ui checkbox">{input}{label}</div></div>';

    public function run()
    {
        $input = $this->renderInput();
        echo strtr($this->template, [
            '{inputList}' => $input
        ]);
    }

    public function renderInput()
    {
        if (!array_key_exists('item', $this->options)) {
            $this->options['item'] = function ($index, $label, $name, $checked, $value) {
                $id = $this->getId() . '-' . $index;
                $label = Html::label($label, $id, $this->labelOptions);
                $input = Html::checkbox($name, $checked, array_merge($this->itemOptions, ['id' => $id]));
                return strtr($this->itemTemplate, [
                    '{label}' => $label,
                    '{input}' => $input
                ]);
            };
        }

        return $this->hasModel()
            ? Html::activeCheckboxList($this->model, $this->attribute, $this->items, $this->options)
            : Html::checkboxList($this->name, $this->selection, $this->items, $this->options);
    }
}

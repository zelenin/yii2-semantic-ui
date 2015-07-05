<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use Zelenin\yii\SemanticUI\InputWidget;

class CheckboxList extends InputWidget
{
    /**
     * @var array
     */
    public $items = [];

    /**
     * @var mixed
     */
    public $selection = null;

    /**
     * @var array
     */
    public $labelOptions = [];

    /**
     * @var array
     */
    public $inputOptions = [];

    /**
     * @var array
     */
    public $listOptions = [];

    public function run()
    {
        $this->prepareOptions();
        echo $this->renderInput();
    }

    /**
     * @return string
     */
    public function renderInput()
    {
        return $this->hasModel()
            ? Html::activeCheckboxList($this->model, $this->attribute, $this->items, $this->options)
            : Html::checkboxList($this->name, $this->selection, $this->items, $this->options);
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
                Checkbox::widget([
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

    public function prepareOptions()
    {
        $defaultItem = $this->getDefaultItem();
        $this->options['item'] = ArrayHelper::getValue($this->options, 'item', $defaultItem);
        $this->options['itemOptions'] = $this->listOptions;
        Html::addCssClass($this->options, 'grouped inline fields');
    }
}

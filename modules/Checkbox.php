<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use Zelenin\yii\SemanticUI\InputWidget;

class Checkbox extends InputWidget
{
    /**
     * @var string
     */
    public $label;
    /**
     * @var array
     */
    public $labelOptions = [];

    /**
     * @var array
     */
    public $inputOptions = [];

    /**
     * @var bool
     */
    public $checked = false;

    /**
     * @var string
     */
    public $type = self::TYPE_CHECKBOX;
    const TYPE_CHECKBOX = '';
    const TYPE_SLIDER = 'slider';
    const TYPE_TOGGLE = 'toggle';

    /**
     * @var bool
     */
    public $readOnly = false;
    const TYPE_READONLY = 'read-only';

    /**
     * @var bool
     */
    public $disabled = false;
    const TYPE_DISABLED = 'disabled';

    /**
     * @var bool
     */
    public $fitted = false;
    const TYPE_FITTED = 'fitted';

    public function run()
    {
        $this->registerJs();
        $this->prepareInputId();

        Html::addCssClass($this->options, 'ui ' . $this->type . ' checkbox');
        if ($this->readOnly) {
            Html::addCssClass($this->options, self::TYPE_READONLY);
        }
        if ($this->disabled) {
            Html::addCssClass($this->options, self::TYPE_DISABLED);
        }
        if ($this->fitted) {
            Html::addCssClass($this->options, self::TYPE_FITTED);
        }

        echo Html::tag('div', $this->renderInput() . $this->renderLabel(), $this->options);
    }

    /**
     * @return string
     */
    public function renderInput()
    {
        $this->inputOptions['label'] = null;
        return $this->hasModel()
            ? Html::activeCheckbox($this->model, $this->attribute, $this->inputOptions)
            : Html::checkbox($this->name, $this->checked, $this->inputOptions);
    }

    public function prepareInputId()
    {
        if (!isset($this->inputOptions['id'])) {
            $id = $this->getId() . '-' . ($this->hasModel() ? $this->attribute : $this->name);
            $this->inputOptions['id'] = $id;
        }
    }

    /**
     * @return string
     */
    public function renderLabel()
    {
        if (!isset($this->labelOptions['for'])) {
            $this->labelOptions['for'] = ($this->hasModel() ? $this->attribute : $this->name);
        }
        return $this->hasModel()
            ? Html::activeLabel($this->model, $this->attribute, $this->labelOptions)
            : Html::label($this->label, $this->labelOptions['for'], $this->labelOptions);
    }

    public function registerJs()
    {
        $this->registerJsAsset();
        $clientOptions = $this->clientOptions ? Json::encode($this->clientOptions) : null;
        $this->getView()->registerJs('jQuery("#' . $this->options['id'] . '").checkbox(' . $clientOptions . ');');
    }
}

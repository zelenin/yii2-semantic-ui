<?php

namespace Zelenin\yii\SemanticUI\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use Zelenin\yii\SemanticUI\modules\Checkbox;
use Zelenin\yii\SemanticUI\modules\CheckboxList;
use Zelenin\yii\SemanticUI\modules\Dropdown;
use Zelenin\yii\SemanticUI\modules\RadioList;

class ActiveField extends \yii\widgets\ActiveField
{
    public $labelOptions = [];

    public $options = ['class' => 'field'];
    public $inputOptions = [];

    public $errorOptions = ['class' => 'ui red pointing label'];
    public $hintOptions = ['class' => 'ui pointing label'];

    public $template = "{label}\n{input}\n{hint}\n{error}";
    public $checkboxTemplate = '<div class="ui checkbox">{input}{label}{hint}{error}</div>';

    public function render($content = null)
    {
        $this->registerStyles();
        return parent::render($content);
    }

    public function registerStyles()
    {
        $classNamesToSelectors = function ($classNames) {
            return '.' . implode('.', preg_split('/\s+/', $classNames, -1, PREG_SPLIT_NO_EMPTY));
        };
        $this->form->getView()->registerCss('
        ' . $classNamesToSelectors($this->errorOptions['class']) . ' {
            display: none;
        }
        ' . $classNamesToSelectors($this->form->errorCssClass) . ' ' . $classNamesToSelectors($this->errorOptions['class']) . ' {
            display: inline-block;
        }
        ');
    }

    public function checkbox($options = [], $enclosedByLabel = true)
    {
        $this->parts['{label}'] = '';
        $this->parts['{input}'] = Checkbox::widget([
            'class' => Checkbox::className(),
            'model' => $this->model,
            'attribute' => $this->attribute,
            'options' => $options,
            'label' => Html::activeLabel($this->model, $this->attribute, $this->labelOptions)
        ]);
        return $this;
    }

    public function checkboxList($items, $options = [])
    {
        $this->parts['{input}'] = CheckboxList::widget([
            'class' => CheckboxList::className(),
            'model' => $this->model,
            'attribute' => $this->attribute,
            'items' => $items,
            'options' => $options
        ]);
        return $this;
    }

    public function radioList($items, $options = [])
    {
        $this->parts['{input}'] = RadioList::widget([
            'class' => RadioList::className(),
            'model' => $this->model,
            'attribute' => $this->attribute,
            'items' => $items,
            'options' => $options
        ]);
        return $this;
    }

    public function dropDownList($items, $options = [])
    {
        $multiple = ArrayHelper::remove($options, 'multiple', false);
        $upward = ArrayHelper::remove($options, 'upward', false);
        $compact = ArrayHelper::remove($options, 'compact', false);
        $disabled = ArrayHelper::remove($options, 'disabled', false);
        $fluid = ArrayHelper::remove($options, 'fluid', false);
        $search = ArrayHelper::remove($options, 'search', true);
        $defaultText = ArrayHelper::remove($options, 'defaultText', '');

        $this->parts['{input}'] = Dropdown::widget([
            'class' => Dropdown::className(),
            'model' => $this->model,
            'attribute' => $this->attribute,
            'items' => $items,
            'options' => $options,
            'search' => $search,
            'multiple' => $multiple,
            'upward' => $upward,
            'compact' => $compact,
            'disabled' => $disabled,
            'fluid' => $fluid,
            'defaultText' => $defaultText
        ]);
        return $this;
    }
}

<?php

namespace Zelenin\yii\SemanticUI;

use Yii;
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

    public $template = "{label}\n{input}\n{hint}\n{error}";
    public $checkboxTemplate = '<div class="ui checkbox">{input}{label}{hint}{error}</div>';

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
        $this->parts['{input}'] = Dropdown::widget([
            'class' => Dropdown::className(),
            'model' => $this->model,
            'attribute' => $this->attribute,
            'items' => $items,
            'options' => $options
        ]);
        return $this;
    }
}

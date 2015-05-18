<?php

namespace Zelenin\yii\SemanticUI\widgets;

use Closure;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use Zelenin\yii\SemanticUI\modules\Checkbox;

class CheckboxColumn extends \yii\grid\CheckboxColumn
{
    protected function renderHeaderCellContent()
    {
        $name = rtrim($this->name, '[]') . '_all';
        $id = $this->grid->options['id'];
        $options = Json::encode([
            'name' => $this->name,
            'multiple' => $this->multiple,
            'checkAll' => $name,
        ]);
        $this->grid->getView()->registerJs("jQuery('#$id').yiiGridView('setSelectionColumn', $options);");

        if ($this->header !== null || !$this->multiple) {
            return parent::renderHeaderCellContent();
        } else {
            return Checkbox::widget([
                'name' => $name,
                'checked' => false,
                'inputOptions' => [
                    'class' => 'select-on-check-all'
                ]
            ]);
        }
    }

    protected function renderDataCellContent($model, $key, $index)
    {
        if ($this->checkboxOptions instanceof Closure) {
            $options = call_user_func($this->checkboxOptions, $model, $key, $index, $this);
        } else {
            $options = $this->checkboxOptions;
            if (!isset($options['value'])) {
                $options['value'] = is_array($key) ? Json::encode($key) : $key;
            }
        }
        $options['id'] = ArrayHelper::getValue($options, 'id', rtrim($this->name, '[]') . '-' . $key);
        return Checkbox::widget([
            'name' => $this->name,
            'checked' => !empty($options['checked']),
            'inputOptions' => $options
        ]);
    }
}

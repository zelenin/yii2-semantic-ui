<?php

namespace Zelenin\yii\SemanticUI;

use Closure;
use Zelenin\yii\SemanticUI\modules\Checkbox;

class CheckboxColumn extends \yii\grid\CheckboxColumn
{
    protected function renderHeaderCellContent()
    {
        $name = rtrim($this->name, '[]') . '_all';
        $id = $this->grid->options['id'];
        $options = json_encode([
            'name' => $this->name,
            'multiple' => $this->multiple,
            'checkAll' => $name,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $this->grid->getView()->registerJs("jQuery('#$id').yiiGridView('setSelectionColumn', $options);");

        if ($this->header !== null || !$this->multiple) {
            return parent::renderHeaderCellContent();
        } else {
            return Checkbox::widget([
                'name' => $name,
                'checked' => false,
                'checkboxOptions' => [
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
                $options['value'] = is_array($key) ? json_encode($key, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : $key;
            }
        }
        return Checkbox::widget([
            'name' => $this->name,
            'checked' => !empty($options['checked']),
            'checkboxOptions' => $options
        ]);
    }
}

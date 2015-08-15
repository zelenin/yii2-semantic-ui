<?php

namespace Zelenin\yii\SemanticUI\widgets;

use Closure;
use Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\JsExpression;
use Zelenin\yii\SemanticUI\modules\Checkbox;

class CheckboxColumn extends \yii\grid\CheckboxColumn
{
    /**
     * @return string
     *
     * @throws Exception
     */
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
                'inputOptions' => [
                    'class' => 'select-on-check-all'
                ],
                'clientOptions' => [
                    'onChecked' => new JsExpression('function() {
                        var $childCheckbox = $(this).closest("#' . $this->grid->options['id'] . '").find("input[name=\'' . $this->name . '\']").closest(".checkbox");
                        $childCheckbox.checkbox("check");
                    }'),
                    'onUnchecked' => new JsExpression('function() {
                        var $childCheckbox = $(this).closest("#' . $this->grid->options['id'] . '").find("input[name=\'' . $this->name . '\']").closest(".checkbox");
                        $childCheckbox.checkbox("uncheck");
                    }')
                ]
            ]);
        }
    }

    /**
     * @param mixed $model
     * @param mixed $key
     * @param int $index
     *
     * @return string
     *
     * @throws Exception
     */
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
            'inputOptions' => $options,
            'clientOptions' => [
                'fireOnInit' => true,
                'onChange' => new JsExpression('function() {
                    var $parentCheckbox = $(".select-on-check-all").closest(".checkbox"),
                    $checkbox = $("#' . $this->grid->options['id'] . '").find("input[name=\'' . $this->name . '\']").closest(".checkbox"),
                    allChecked = true,
                    allUnchecked = true;

                    $checkbox.each(function() {
                        if ($(this).checkbox("is checked")) {
                            allUnchecked = false;
                        } else {
                            allChecked = false;
                        }
                    });

                    if(allChecked) {
                        $parentCheckbox.checkbox("set checked");
                    } else if(allUnchecked) {
                        $parentCheckbox.checkbox("set unchecked");
                    } else {
                        $parentCheckbox.checkbox("set indeterminate");
                    }
                }'),
            ]
        ]);
    }
}

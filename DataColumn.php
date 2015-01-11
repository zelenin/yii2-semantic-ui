<?php

namespace Zelenin\yii\SemanticUI;

use yii\base\Model;
use yii\helpers\Html;
use Zelenin\yii\SemanticUI\modules\Dropdown;

class DataColumn extends \yii\grid\DataColumn
{
    public $filterDropdownOptions = ['class' => 'ui fluid dropdown', 'id' => null];
    public $filterInputOptions = ['class' => '', 'id' => null];

    protected function renderFilterCellContent()
    {
        if (is_string($this->filter)) {
            return $this->filter;
        }

        $model = $this->grid->filterModel;

        if ($this->filter !== false && $model instanceof Model && $this->attribute !== null && $model->isAttributeActive($this->attribute)) {
            if ($model->hasErrors($this->attribute)) {
                Html::addCssClass($this->filterOptions, 'has-error');
                $error = Html::error($model, $this->attribute, $this->grid->filterErrorOptions);
            } else {
                $error = '';
            }
            if (is_array($this->filter)) {
                $options = array_merge(['prompt' => ''], $this->filterDropdownOptions);
                return Dropdown::widget([
                    'model' => $model,
                    'attribute' => $this->attribute,
                    'items' => $this->filter,
                    'options' => $options
                ]). ' ' . $error;
            } else {
                return '<div class="ui input">' . Html::activeTextInput($model, $this->attribute, $this->filterInputOptions) . '</div> ' . $error;
            }
        } else {
            return parent::renderFilterCellContent();
        }
    }
}

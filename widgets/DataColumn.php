<?php

namespace Zelenin\yii\SemanticUI\widgets;

use yii\base\Model;
use yii\helpers\Html;
use Zelenin\yii\SemanticUI\Elements;
use Zelenin\yii\SemanticUI\modules\Select;

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
                $error = Html::error($model, $this->attribute, $this->grid->filterErrorOptions);
            } else {
                $error = '';
            }
            if (is_array($this->filter)) {
                $options = array_merge(['prompt' => ''], $this->filterDropdownOptions);
                if ($model->hasErrors($this->attribute)) {
                    Html::addCssClass($options, 'error');
                }
                return Select::widget([
                    'model' => $model,
                    'attribute' => $this->attribute,
                    'items' => $this->filter,
                    'options' => $options,
                    'search' => true
                ]) . ' ' . $error;
            } else {
                $options = ['class' => 'fluid'];
                if ($model->hasErrors($this->attribute)) {
                    Html::addCssClass($options, 'error');
                }
                return Elements::input(Html::activeTextInput($model, $this->attribute, $this->filterInputOptions) . $error, $options);
            }
        } else {
            return parent::renderFilterCellContent();
        }
    }
}

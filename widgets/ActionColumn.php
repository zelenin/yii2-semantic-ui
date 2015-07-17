<?php

namespace Zelenin\yii\SemanticUI\widgets;

use Yii;
use yii\helpers\Html;
use Zelenin\yii\SemanticUI\Elements;

class ActionColumn extends \yii\grid\ActionColumn
{
    /**
     * @var string
     */
    public $template = '<div class="ui basic tiny compact icon buttons">{view}{update}{delete}</div>';

    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model, $key) {
                return Html::a(Elements::icon('eye'), $url, [
                    'class' => 'ui button',
                    'title' => Yii::t('yii', 'View'),
                    'data-pjax' => '0',
                ]);
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model, $key) {
                return Html::a(Elements::icon('pencil'), $url, [
                    'class' => 'ui button',
                    'title' => Yii::t('yii', 'Update'),
                    'data-pjax' => '0',
                ]);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model, $key) {
                return Html::a(Elements::icon('trash'), $url, [
                    'class' => 'ui button',
                    'title' => Yii::t('yii', 'Delete'),
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ]);
            };
        }
    }
}

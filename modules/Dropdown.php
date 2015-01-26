<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use Zelenin\yii\SemanticUI\InputWidget;

class Dropdown extends InputWidget
{
    public $items = [];
    public $selection = null;

    public function run()
    {
        $this->registerJsAsset();
        Html::addCssClass($this->options, 'ui dropdown');
        echo $this->hasModel()
            ? Html::activeDropDownList($this->model, $this->attribute, $this->items, $this->options)
            : Html::dropDownList($this->name, $this->selection, $this->items, $this->options);
        $clientOptions = empty($this->clientOptions)
            ? null
            : Json::encode($this->clientOptions);
        $this->getView()->registerJs('jQuery( "#' . $this->options['id'] . '" ).dropdown(' . $clientOptions . ');', View::POS_END);
    }
}

<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use Zelenin\yii\SemanticUI\InputWidget;

class Select extends InputWidget
{
    public $items = [];
    public $selection = null;

    public $search = false;
    const TYPE_SEARCH = 'search';

    public $fluid = false;
    const TYPE_FLUID = 'fluid';

    public $compact = false;
    const TYPE_COMPACT = 'compact';

    public $disabled = false;
    const TYPE_DISABLED = 'disabled';

    public $upward = false;
    const TYPE_UPWARD = 'upward';

    public function run()
    {
        $this->registerJs();

        Html::addCssClass($this->options, 'ui dropdown');

        if ($this->search) {
            Html::addCssClass($this->options, self::TYPE_SEARCH);
        }
        if ($this->fluid) {
            Html::addCssClass($this->options, self::TYPE_FLUID);
        }
        if ($this->disabled) {
            Html::addCssClass($this->options, self::TYPE_DISABLED);
        }
        if ($this->compact) {
            Html::addCssClass($this->options, self::TYPE_COMPACT);
        }
        if ($this->upward) {
            Html::addCssClass($this->options, self::TYPE_UPWARD);
        }

        echo $this->hasModel()
            ? Html::activeDropDownList($this->model, $this->attribute, $this->items, $this->options)
            : Html::dropDownList($this->name, $this->selection, $this->items, $this->options);
    }

    public function registerJs()
    {
        $this->registerJsAsset();
        $clientOptions = $this->clientOptions ? Json::encode($this->clientOptions) : null;
        $this->getView()->registerJs('jQuery("#' . $this->options['id'] . '").dropdown(' . $clientOptions . ');', View::POS_END);
    }
}

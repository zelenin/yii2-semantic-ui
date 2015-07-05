<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use Zelenin\yii\SemanticUI\InputWidget;

class Select extends InputWidget
{
    /**
     * @var array
     */
    public $items = [];

    /**
     * @var mixed
     */
    public $selection = null;

    /**
     * @var bool
     */
    public $search = false;
    const TYPE_SEARCH = 'search';

    /**
     * @var bool
     */
    public $fluid = false;
    const TYPE_FLUID = 'fluid';

    /**
     * @var bool
     */
    public $compact = false;
    const TYPE_COMPACT = 'compact';

    /**
     * @var bool
     */
    public $disabled = false;
    const TYPE_DISABLED = 'disabled';

    /**
     * @var bool
     */
    public $upward = false;
    const TYPE_UPWARD = 'upward';

    /**
     * @var bool
     */
    public $multiple = false;

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
        if ($this->multiple) {
            $this->options['multiple'] = true;
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

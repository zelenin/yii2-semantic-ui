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

    public $type = self::TYPE_SELECTION;
    const TYPE_DEFAULT = '';
    const TYPE_SELECTION = 'selection';

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

    public $defaultText;

    public $icon = '<i class="dropdown icon"></i>';

    public function run()
    {
        $this->registerJs();

        Html::addCssClass($this->options, 'ui ' . $this->type . ' dropdown');

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

        echo Html::tag(
            'div',
            $this->renderHiddenInput() . $this->renderText() . $this->renderDropdown(),
            $this->options
        );
    }

    public function renderHiddenInput()
    {
        return $this->hasModel()
            ? Html::activeHiddenInput($this->model, $this->attribute, [])
            : Html::hiddenInput($this->name, $this->selection, []);
    }

    public function renderText()
    {
        return Html::tag('div', $this->defaultText, ['class' => 'default text']);
    }

    public function renderDropdown()
    {
        return
            $this->icon .
            Html::tag('div', $this->renderItems(), ['class' => 'menu']);
    }

    public function renderItems()
    {
        $items = '';
        foreach ($this->items as $key => $item) {
            if (is_array($item)) {
                $items .= $this->renderHeader($key);
                $rawItems = $item;
                foreach ($rawItems as $key => $item) {
                    $items .= $this->renderItem($key, $item);
                }
            } elseif (empty($item)) {
                $items .= $this->renderDivider();
            } else {
                $items .= $this->renderItem($key, $item);
            }
        }
        return $items;
    }

    public function renderHeader($item)
    {
        return Html::tag('div', $item, ['class' => 'header']);
    }

    public function renderDivider()
    {
        return Html::tag('div', '', ['class' => 'divider']);
    }

    public function renderItem($key, $item)
    {
        return Html::tag('div', $item, [
            'data' => ['value' => $key],
            'class' => 'item'
        ]);
    }

    public function registerJs()
    {
        $this->registerJsAsset();
        $clientOptions = $this->clientOptions ? Json::encode($this->clientOptions) : null;
        $this->getView()->registerJs('jQuery("#' . $this->getId() . '").dropdown(' . $clientOptions . ');', View::POS_END);
    }
}

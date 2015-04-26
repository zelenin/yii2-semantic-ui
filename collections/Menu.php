<?php

namespace Zelenin\yii\SemanticUI\collections;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use Zelenin\yii\SemanticUI\Elements;
use Zelenin\yii\SemanticUI\Widget;

class Menu extends Widget
{
    public $route;
    public $params;

    public $items = [];
    public $rightMenuItems = [];
    public $subMenuItems = [];

    public $options = [];
    public $rightMenuOptions = [];
    public $subMenuOptions = [];

    public $itemOptions = [];

    public $vertical = false;
    const TYPE_VERTICAL = 'vertical';

    public $tabular = false;
    const TYPE_TABULAR = 'tabular';

    public $topAttached = false;
    const TYPE_TOP_ATTACHED = 'top attached';

    public $tiered = false;
    const TYPE_TIERED = 'tiered';

    public $secondary = false;
    const TYPE_SECONDARY = 'secondary';

    public $pointing = false;
    const TYPE_POINTING = 'pointing';

    public $text = false;
    const TYPE_TEXT = 'text';

    public $fluid = false;
    const TYPE_FLUID = 'fluid';

    public $borderless = false;
    const TYPE_BORDERLESS = 'borderless';

    public $inverted = false;
    const TYPE_INVERTED = 'inverted';

    public $color;
    const COLOR_GREEN = 'green';
    const COLOR_RED = 'red';
    const COLOR_BLUE = 'blue';
    const COLOR_ORANGE = 'orange';
    const COLOR_PURPLE = 'purple';
    const COLOR_TEAL = 'teal';

    public $size;
    const SIZE_SMALL = 'small';
    const SIZE_LARGE = 'large';

    public $encodeLabels = true;

    public $activateItems = true;
    public $activateParents = false;
    public $hideEmptyItems = true;

    public function init()
    {
        parent::init();
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }
        if ($this->params === null) {
            $this->params = Yii::$app->getRequest()->getQueryParams();
        }
    }

    public function run()
    {
        Html::addCssClass($this->options, 'ui menu');
        if ($this->vertical) {
            Html::addCssClass($this->options, self::TYPE_VERTICAL);
        }
        if ($this->tabular) {
            Html::addCssClass($this->options, self::TYPE_TABULAR);
        }
        if ($this->topAttached) {
            Html::addCssClass($this->options, self::TYPE_TOP_ATTACHED);
        }
        if ($this->tiered) {
            Html::addCssClass($this->options, self::TYPE_TIERED);
        }
        if ($this->secondary) {
            Html::addCssClass($this->options, self::TYPE_SECONDARY);
        }
        if ($this->pointing) {
            Html::addCssClass($this->options, self::TYPE_POINTING);
        }
        if ($this->text) {
            Html::addCssClass($this->options, self::TYPE_TEXT);
        }
        if ($this->fluid) {
            Html::addCssClass($this->options, self::TYPE_FLUID);
        }
        if ($this->inverted) {
            Html::addCssClass($this->options, self::TYPE_INVERTED);
        }
        if ($this->color) {
            Html::addCssClass($this->options, $this->color);
        }
        if ($this->size) {
            Html::addCssClass($this->options, $this->size);
        }
        if ($this->borderless) {
            Html::addCssClass($this->options, self::TYPE_BORDERLESS);
        }

        $tag = ArrayHelper::remove($this->options, 'tag', 'div');
        echo Html::tag($tag, $this->renderItems(), $this->options);
    }

    public function renderItems()
    {
        Html::addCssClass($this->rightMenuOptions, 'right menu');
        Html::addCssClass($this->subMenuOptions, 'ui sub menu');
        return
            (
            $this->tiered
                ?
                Html::tag('div', $this->renderMenuPart($this->items) . Html::tag('div', $this->renderMenuPart($this->rightMenuItems), $this->rightMenuOptions), ['class' => 'menu'])
                : $this->renderMenuPart($this->items) . Html::tag('div', $this->renderMenuPart($this->rightMenuItems), $this->rightMenuOptions)
            ) .
            ($this->subMenuItems ? Html::tag('div', $this->renderMenuPart($this->subMenuItems), $this->subMenuOptions) : '');
    }

    public function renderMenuPart($items)
    {
        if ($items) {
            $items = $this->normalizeItems($items, $hasActiveChild);

            $lines = '';
            foreach ($items as $i => $item) {
                Html::addCssClass($item['options'], 'item');
                if ($item['active']) {
                    Html::addCssClass($item['options'], 'active');
                }

                if (isset($item['items'])) {
                    Html::addCssClass($item['options'], 'ui simple dropdown');
                    $item['label'] =
                        Elements::icon('dropdown') .
                        $item['label'] .
                        Html::tag('div', $this->renderMenuPart($item['items']), ['class' => 'menu']);
                    $menu = $this->renderItem($item);
                } else {
                    $menu = $this->renderItem($item);
                }
                $lines .= $menu;
            }
            return $lines;
        } else {
            return '';
        }
    }

    public function renderItem($item)
    {
        if (isset($item['header'])) {
            Html::addCssClass($item['options'], 'header');
            return Html::tag('div', $item['header'], $item['options']);
        } else {
            if (isset($item['url'])) {
                return Html::a($item['label'], Url::to($item['url']), $item['options']);
            } else {
                return Html::tag('div', $item['label'], $item['options']);
            }
        }
    }

    protected function normalizeItems($items, &$active)
    {
        foreach ($items as $i => $item) {

            if (!ArrayHelper::getValue($item, 'visible', true)) {
                unset($items[$i]);
                continue;
            }

            $item['label'] = ArrayHelper::getValue($item, 'label', '');
            $encodeLabel = ArrayHelper::getValue($item, 'encode', $this->encodeLabels);
            $items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            if (isset($items[$i]['header'])) {
                $items[$i]['header'] = $encodeLabel ? Html::encode($item['header']) : $item['header'];
            }

            $hasActiveChild = false;
            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
                if (empty($items[$i]['items']) && $this->hideEmptyItems) {
                    unset($items[$i]['items']);
                    if (!isset($item['url'])) {
                        unset($items[$i]);
                        continue;
                    }
                }
            }

            if (!isset($item['active'])) {
                $items[$i]['active'] = ($this->activateParents && $hasActiveChild) || ($this->activateItems && $this->isItemActive($item));
            } elseif ($item['active']) {
                $active = true;
            }
            $item['options'] = ArrayHelper::getValue($items, 'options', $this->itemOptions);
        }

        return array_values($items);
    }

    protected function isItemActive($item)
    {
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = $item['url'][0];
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }
            if (ltrim($route, '/') !== $this->route) {
                return false;
            }
            unset($item['url']['#']);

            if (count($item['url']) > 1) {
                foreach (array_splice($item['url'], 1) as $name => $value) {
                    if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                        return false;
                    }
                }
            }
            return true;
        }
        return false;
    }
}

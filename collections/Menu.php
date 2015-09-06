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
    /**
     * @var string
     */
    public $route;

    /**
     * @var array
     */
    public $params;

    /**
     * @var array
     */
    public $items = [];

    /**
     * @var array
     */
    public $rightMenuItems = [];

    /**
     * @var array
     */
    public $subMenuItems = [];

    /**
     * @var array
     */
    public $options = [];

    /**
     * @var array
     */
    public $rightMenuOptions = [];

    /**
     * @var array
     */
    public $subMenuOptions = [];

    /**
     * @var array
     */
    public $itemOptions = [];

    /**
     * @var bool
     */
    public $vertical = false;
    const TYPE_VERTICAL = 'vertical';

    /**
     * @var bool
     */
    public $tabular = false;
    const TYPE_TABULAR = 'tabular';

    /**
     * @var bool
     */
    public $topAttached = false;
    const TYPE_TOP_ATTACHED = 'top attached';

    /**
     * @var bool
     */
    public $tiered = false;
    const TYPE_TIERED = 'tiered';

    /**
     * @var bool
     */
    public $secondary = false;
    const TYPE_SECONDARY = 'secondary';

    /**
     * @var bool
     */
    public $pointing = false;
    const TYPE_POINTING = 'pointing';

    /**
     * @var bool
     */
    public $text = false;
    const TYPE_TEXT = 'text';

    /**
     * @var bool
     */
    public $fluid = false;
    const TYPE_FLUID = 'fluid';
    /**
     * @var bool
     */
    public $borderless = false;
    const TYPE_BORDERLESS = 'borderless';

    /**
     * @var bool
     */
    public $inverted = false;
    const TYPE_INVERTED = 'inverted';

    /**
     * @var string
     */
    public $color;

    /**
     * @var string
     */
    public $size;

    /**
     * @var bool
     */
    public $encodeLabels = true;

    /**
     * @var bool
     */
    public $activateItems = true;

    /**
     * @var bool
     */
    public $activateParents = false;

    /**
     * @var bool
     */
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

    /**
     * @return string
     */
    public function renderItems()
    {
        Html::addCssClass($this->rightMenuOptions, 'right menu');
        Html::addCssClass($this->subMenuOptions, 'ui sub menu');

        $leftMenuPart = $this->items ? $this->renderMenuPart($this->items) : '';
        $rightMenuPart = $this->rightMenuItems ? Html::tag('div', $this->renderMenuPart($this->rightMenuItems), $this->rightMenuOptions) : '';
        return
            (
            $this->tiered
                ?
                Html::tag('div', $leftMenuPart . $rightMenuPart, ['class' => 'menu'])
                : $leftMenuPart . $rightMenuPart
            ) .
            ($this->subMenuItems ? Html::tag('div', $this->renderMenuPart($this->subMenuItems), $this->subMenuOptions) : '');
    }

    /**
     * @param $items
     *
     * @return string
     */
    public function renderMenuPart($items)
    {
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
                    $item['label'] .
                    Elements::icon('dropdown') .
                    Html::tag('div', $this->renderMenuPart($item['items']), ['class' => 'menu']);

                $menu = $this->renderItem($item);
            } else {
                $menu = $this->renderItem($item);
            }
            $lines .= $menu;
        }
        return $lines;
    }

    /**
     * @param $item
     *
     * @return string
     */
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

    /**
     * @param array $items
     * @param bool $active
     *
     * @return array
     */
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

    /**
     * @param array $item
     *
     * @return bool
     */
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

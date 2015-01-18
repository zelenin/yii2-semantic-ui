<?php

namespace Zelenin\yii\SemanticUI\collections;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use Zelenin\yii\SemanticUI\Widget;

class Menu extends Widget
{
    public $route;
    public $params;

    public $options = ['class' => 'ui menu'];

    public $items = [];
    public $rightItems = [];
    public $itemOptions = [];

    public $firstItemCssClass;
    public $lastItemCssClass;
    public $activeCssClass = 'active';

    public $linkTemplate = '<a class="{class}" href="{url}">{label}</a>';
    public $labelTemplate = '{label}';
    public $dropdownTemplate = '<div class="ui dropdown simple item"><i class="dropdown icon"></i>{item}{submenu}</div>';
    public $submenuTemplate = '<div class="menu transition">{items}</div>';

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
        $items = $this->normalizeItems($this->items, $hasActiveChild);
        $rightItems = $this->normalizeItems($this->rightItems, $hasActiveChild);
        if (!empty($items)) {
            $options = $this->options;
            $tag = ArrayHelper::remove($options, 'tag', 'div');
            if ($rightItems) {
                $rightMenu = Html::tag($tag, $this->renderItems($rightItems), ['class' => 'right menu']);
                echo Html::tag($tag, $this->renderItems($items) . $rightMenu, $options);
            } else {
                echo Html::tag($tag, $this->renderItems($items), $options);
            }
        }
    }

    protected function renderItems($items)
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item) {
            $options = ArrayHelper::merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $class = ['item'];

            if ($item['active']) {
                $class[] = $this->activeCssClass;
            }
            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }

            if (!empty($class)) {
                if (empty($options['class'])) {
                    $item['options']['class'] = implode(' ', $class);
                } else {
                    $item['options']['class'] .= ' ' . implode(' ', $class);
                }
            }

            if (!empty($item['items'])) {
                $menu = strtr($this->dropdownTemplate, [
                    '{item}' => $this->renderItem($item),
                    '{submenu}' => strtr($this->submenuTemplate, [
                        '{items}' => $this->renderItems($item['items'])
                    ])
                ]);
            } else {
                $menu = $this->renderItem($item);
            }

            $lines[] = $menu;
        }

        return implode("\n", $lines);
    }

    protected function renderItem($item)
    {
        if (isset($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);

            return strtr($template, [
                '{url}' => Url::to($item['url']),
                '{label}' => $item['label'],
                '{class}' => $item['options']['class']
            ]);
        } else {
            $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);

            return strtr($template, [
                '{label}' => $item['label']
            ]);
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
                if ($this->activateParents && $hasActiveChild || $this->activateItems && $this->isItemActive($item)) {
                    $active = $items[$i]['active'] = true;
                } else {
                    $items[$i]['active'] = false;
                }
            } elseif ($item['active']) {
                $active = true;
            }
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

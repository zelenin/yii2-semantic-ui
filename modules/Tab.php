<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use Zelenin\yii\SemanticUI\Widget;

class Tab extends Widget
{
    /**
     * @var array
     */
    public $items = [];

    /**
     * @var array
     */
    public $labelOptions = [];

    /**
     * @var array
     */
    public $contentOptions = [
        'class' => 'bottom attached segment'
    ];

    /**
     * @var array
     */
    public $options = [
        'class' => 'ui top attached tabular menu'
    ];

    const STATE_ACTIVE = 'active';

    public function run()
    {
        $this->registerJs();
        $this->normalizeItems();

        echo $this->renderMenu() . $this->renderTabs();
    }

    /**
     * @return string
     */
    public function renderMenu()
    {
        $items = '';
        foreach ($this->items as $item) {
            Html::addCssClass($item['labelOptions'], 'item');
            $item['labelOptions']['data-tab'] = $item['uniqueId'];
            if ($item[self::STATE_ACTIVE]) {
                Html::addCssClass($item['labelOptions'], self::STATE_ACTIVE);
            }
            $items .= Html::a($item['label'], null, $item['labelOptions']);
        }
        return Html::tag('div', $items, $this->options);
    }

    /**
     * @return string
     */
    public function renderTabs()
    {
        $items = '';
        foreach ($this->items as $item) {
            Html::addCssClass($item['contentOptions'], 'ui tab');
            $item['contentOptions']['data-tab'] = $item['uniqueId'];
            if ($item[self::STATE_ACTIVE]) {
                Html::addCssClass($item['contentOptions'], self::STATE_ACTIVE);
            }
            $items .= Html::tag('div', $item['content'], $item['contentOptions']);
        }
        return $items;
    }

    public function normalizeItems()
    {
        $items = [];
        $i = 1;
        $isActive = false;
        foreach ($this->items as $item) {
            $item['labelOptions'] = array_merge($this->labelOptions, ArrayHelper::getValue($item, 'labelOptions', []));
            $item['contentOptions'] = array_merge($this->contentOptions, ArrayHelper::getValue($item, 'contentOptions', []));
            if (!array_key_exists('uniqueId', $item)) {
                $item['uniqueId'] = $this->getId() . '-tab-' . $i;
            }

            if (isset($item[self::STATE_ACTIVE])) {
                if ($item[self::STATE_ACTIVE] && !$isActive) {
                    $isActive = true;
                }
            } else {
                $item[self::STATE_ACTIVE] = false;
            }

            $items[] = $item;
            $i++;
        }
        if (!$isActive && isset($items[0])) {
            $items[0][self::STATE_ACTIVE] = true;
        }
        $this->items = $items;
    }

    public function registerJs()
    {
        $this->registerJsAsset();
        $clientOptions = $this->clientOptions ? Json::encode($this->clientOptions) : null;
        $this->getView()->registerJs('jQuery("#' . $this->getId() . ' .item").tab(' . $clientOptions . ');');
    }
}

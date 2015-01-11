<?php

/**
 * @todo inverted
 * @todo nested
 */

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\Html;
use Zelenin\yii\SemanticUI\Widget;

class Accordion extends Widget
{
    public $items = [];
    public $itemTemplate = '<div class="title"><i class="dropdown icon"></i>{title}</div><div class="content">{content}</div>';

    public $encodeTitle = true;
    public $encodeContent = true;

    const TYPE_STYLED = 'styled';
    public $styled = false;

    const TYPE_FLUID = 'fluid';
    public $fluid = false;

    const TYPE_VERTICAL = 'vertical';
    public $vertical = false;

    public function run()
    {
        $this->registerJs();

        Html::addCssClass($this->options, 'ui accordion');
        if ($this->styled) {
            Html::addCssClass($this->options, self::TYPE_STYLED);
        }
        if ($this->fluid) {
            Html::addCssClass($this->options, self::TYPE_FLUID);
        }
        if ($this->vertical) {
            Html::addCssClass($this->options, self::TYPE_VERTICAL);
        }
        echo Html::tag('div', $this->renderItems(), $this->options);
    }

    public function renderItems()
    {
        $items = '';
        foreach ($this->items as $item) {
            $items .= $this->renderItem($item['title'], $item['content']);
        }
        return $items;
    }

    public function renderItem($title, $content)
    {
        return strtr($this->itemTemplate, [
            '{title}' => $this->encodeTitle ? Html::encode($title) : $title,
            '{content}' => $this->encodeContent ? Html::encode($content) : $content
        ]);
    }

    public function registerJs()
    {
        $this->registerJsAsset();
        $view = $this->getView();
        $view->registerJs('jQuery("#' . $this->getId() . '").accordion();');
    }
}

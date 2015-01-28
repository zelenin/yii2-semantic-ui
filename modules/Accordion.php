<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use Zelenin\yii\SemanticUI\Elements;
use Zelenin\yii\SemanticUI\Widget;

class Accordion extends Widget
{
    public $items = [];

    public $titleOptions = [];
    public $contentOptions = [];

    const TYPE_STYLED = 'styled';
    public $styled = false;

    const TYPE_FLUID = 'fluid';
    public $fluid = false;

    const TYPE_VERTICAL = 'vertical';
    public $vertical = false;

    const TYPE_INVERTED = 'inverted';
    public $inverted = false;

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
        if ($this->inverted) {
            Html::addCssClass($this->options, self::TYPE_INVERTED);
            echo Elements::segment(Html::tag('div', $this->renderItems(), $this->options), ['class' => self::TYPE_INVERTED]);
        } else {
            echo Html::tag('div', $this->renderItems(), $this->options);
        }
    }

    public function renderItems()
    {
        $items = '';
        foreach ($this->items as $item) {
            $items .= $this->renderItem($this->normalizeItem($item));
        }
        return $items;
    }

    public function renderItem($item)
    {
        return $this->renderTitle($item) . $this->renderContent($item);
    }

    public function renderTitle($item)
    {
        $encode = ArrayHelper::getValue($this->titleOptions, 'encode', true);
        $title = Elements::icon('dropdown') . ($encode ? Html::encode($item['title']) : $item['title']);
        $options = $this->titleOptions;
        Html::addCssClass($options, 'title');
        if ($item['active']) {
            Html::addCssClass($options, 'active');
        }
        return Html::tag('div', $title, $options);
    }

    public function renderContent($item)
    {
        $encode = ArrayHelper::getValue($this->contentOptions, 'encode', true);
        $content = $encode ? Html::encode($item['content']) : $item['content'];
        $options = $this->contentOptions;
        Html::addCssClass($options, 'content');
        if ($item['active']) {
            Html::addCssClass($options, 'active');
        }
        return Html::tag('div', $content, $options);
    }

    public function normalizeItem($item)
    {
        $item['active'] = ArrayHelper::remove($item, 'active', false);
        return $item;
    }

    public function registerJs()
    {
        $this->registerJsAsset();
        $clientOptions = $this->clientOptions ? Json::encode($this->clientOptions) : null;
        $this->getView()->registerJs('jQuery("#' . $this->options['id'] . '").accordion(' . $clientOptions . ');');
    }
}

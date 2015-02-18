<?php

namespace Zelenin\yii\SemanticUI\collections;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use Zelenin\yii\SemanticUI\Widget;

class Breadcrumb extends Widget
{
    public $links = [];
    public $homeLink;
    public $itemOptions = [];
    public $encodeLabels = true;

    public $divider = self::DIVIDER_NORMAL;
    const DIVIDER_NORMAL = ' <div class="divider"> / </div> ';
    const DIVIDER_CHEVRON = ' <i class="right chevron icon divider"></i> ';

    public $size;
    const SIZE_SMALL = 'small';
    const SIZE_LARGE = 'large';
    const SIZE_HUGE = 'huge';

    public function run()
    {
        Html::addCssClass($this->options, 'ui breadcrumb');
        if ($this->size) {
            Html::addCssClass($this->options, $this->size);
        }

        echo Html::tag('div', $this->renderItems(), $this->options);
    }

    public function renderItems()
    {
        $items = [];
        if ($homelink = $this->getHomeLink()) {
            $items[] = $homelink;
        }

        foreach ($this->links as $item) {
            if (!is_array($item)) {
                $item = [
                    'label' => $item
                ];
            }
            $items[] = $this->renderItem($item);
        }
        return implode($this->divider, $items);
    }

    private function getHomeLink()
    {
        if ($this->homeLink === null) {
            $this->homeLink = [
                'label' => Yii::t('yii', 'Home'),
                'url' => Yii::$app->getHomeUrl(),
            ];
        }
        return $this->homeLink !== false
            ? $this->renderItem($this->homeLink)
            : false;
    }

    protected function renderItem($item)
    {
        $item['label'] = $this->encodeLabels ? Html::encode($item['label']) : $item['label'];

        $options = ArrayHelper::getValue($item, 'options', $this->itemOptions);
        Html::addCssClass($options, 'section');

        if (isset($item['url'])) {
            $link = Html::a($item['label'], $item['url'], $options);
        } else {
            Html::addCssClass($options, 'active');
            $link = Html::tag('div', $item['label'], $options);
        }
        return $link;
    }
}

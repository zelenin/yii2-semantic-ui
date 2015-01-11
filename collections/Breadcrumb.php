<?php

namespace Zelenin\yii\SemanticUI\collections;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use Zelenin\yii\SemanticUI\Widget;

class Breadcrumb extends Widget
{
    const SIZE_NORMAL = '';
    const SIZE_SMALL = 'small';
    const SIZE_LARGE = 'large';
    const SIZE_HUGE = 'huge';

    const DIVIDER_NORMAL = "\n<div class=\"divider\"> / </div>\n";
    const DIVIDER_CHEVRON = '<i class="right chevron icon divider"></i>';

    public $tag = 'div';
    public $size = self::SIZE_NORMAL;
    public $divider = self::DIVIDER_NORMAL;

    public $itemOptions = [];
    public $encodeLabels = true;
    public $homeLink;
    public $links = [];
    public $itemTemplate = '{link}';
    public $activeItemTemplate = '<div class="active section">{link}</div>';

    public function run()
    {
        if (empty($this->links)) {
            return;
        }
        $links = [];
        if ($homelink = $this->getHomeLink()) {
            $links[] = $homelink;
        }

        foreach ($this->links as $link) {
            if (!is_array($link)) {
                $link = ['label' => $link];
            }
            $links[] = $this->renderItem($link, isset($link['url']) ? $this->itemTemplate : $this->activeItemTemplate);
        }

        Html::addCssClass($this->options, 'ui ' . $this->size . ' breadcrumb');

        echo Html::tag($this->tag, implode($this->divider, $links), $this->options);
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
            ? $this->renderItem($this->homeLink, $this->itemTemplate)
            : false;
    }

    protected function renderItem($item, $template)
    {
        if (isset($item['label'])) {
            $item['label'] = $this->encodeLabels ? Html::encode($item['label']) : $item['label'];
        } else {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }
        if (!isset($item['template'])) {
            $item['template'] = $template;
        }

        if (isset($item['url'])) {
            if (!isset($item['options'])) {
                $item['options'] = $this->itemOptions;
            }
            Html::addCssClass($item['options'], 'section');
            $link = Html::a($item['label'], $item['url'], $item['options']);
        } else {
            $link = $item['label'];
        }
        return strtr($item['template'], ['{link}' => $link]);
    }
}

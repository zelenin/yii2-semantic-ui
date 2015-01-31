<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use Zelenin\yii\SemanticUI\Widget;

class Rating extends Widget
{
    public $type;
    const TYPE_STAR = 'star';
    const TYPE_HEART = 'heart';

    public $size;
    const SIZE_MINY = 'miny';
    const SIZE_TINY = 'tiny';
    const SIZE_SMALL = 'small';
    const SIZE_LARGE = 'large';
    const SIZE_HUGE = 'huge';
    const SIZE_MASSIVE = 'massive';

    public function run()
    {
        $this->registerJs();

        Html::addCssClass($this->options, 'ui rating');

        if ($this->type) {
            Html::addCssClass($this->options, $this->type);
        }
        if ($this->size) {
            Html::addCssClass($this->options, $this->size);
        }

        echo Html::tag('div', '', $this->options);
    }

    public function registerJs()
    {
        $this->registerJsAsset();
        $clientOptions = $this->clientOptions ? Json::encode($this->clientOptions) : null;
        $this->getView()->registerJs('jQuery("#' . $this->getId() . '").rating(' . $clientOptions . ');');
    }
}

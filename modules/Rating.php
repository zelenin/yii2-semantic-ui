<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use Zelenin\yii\SemanticUI\Widget;

class Rating extends Widget
{
    /**
     * @var string
     */
    public $type;
    const TYPE_STAR = 'star';
    const TYPE_HEART = 'heart';

    /**
     * @var string
     */
    public $size;

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

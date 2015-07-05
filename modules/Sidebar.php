<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use Zelenin\yii\SemanticUI\Widget;

class Sidebar extends Widget
{
    /**
     * @var string
     */
    public $content;

    /**
     * @var bool
     */
    public $visible = false;
    const TYPE_VISIBLE = 'visible';

    /**
     * @var string
     */
    public $width;
    const WIDTH_THIN = 'thin';
    const WIDTH_VERY_THIN = 'very thin';
    const WIDTH_WIDE = 'wide';
    const WIDTH_VERY_WIDE = 'very wide';

    public function run()
    {
        $this->registerJs();

        Html::addCssClass($this->options, 'ui sidebar');

        if ($this->visible) {
            Html::addCssClass($this->options, self::TYPE_VISIBLE);
        }
        if ($this->width) {
            Html::addCssClass($this->options, $this->width);
        }

        echo Html::tag('div', $this->content, $this->options);
    }

    public function registerJs()
    {
        $this->registerJsAsset();
        $clientOptions = $this->clientOptions ? Json::encode($this->clientOptions) : null;
        $this->getView()->registerJs('jQuery("#' . $this->getId() . '").sidebar(' . $clientOptions . ');');
    }
}

<?php

namespace Zelenin\yii\SemanticUI\modules;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use Zelenin\yii\SemanticUI\Widget;

class Embed extends Widget
{
    /**
     * @var string
     */
    public $source;
    const SOURCE_YOUTUBE = 'youtube';
    const SOURCE_VIMEO = 'vimeo';

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $placeholder;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $icon;

    public function run()
    {
        $this->registerJs();

        Html::addCssClass($this->options, 'ui embed');

        $this->options['data']['source'] = $this->source;
        $this->options['data']['id'] = $this->id;

        if ($this->placeholder) {
            $this->options['data']['placeholder'] = $this->placeholder;
        }
        if ($this->url) {
            $this->options['data']['url'] = $this->url;
        }
        if ($this->icon) {
            $this->options['data']['icon'] = $this->icon;
        }

        echo Html::tag('div', '', $this->options);
    }

    public function registerJs()
    {
        $this->registerJsAsset();
        $clientOptions = $this->clientOptions ? Json::encode($this->clientOptions) : null;
        $this->getView()->registerJs('jQuery("#' . $this->getId() . '").embed(' . $clientOptions . ');', View::POS_END);
    }
}

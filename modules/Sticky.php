<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use Zelenin\yii\SemanticUI\Widget;

class Sticky extends Widget
{
    public function init()
    {
        parent::init();

        $this->registerJs();

        Html::addCssClass($this->options, 'ui sticky');
        echo Html::beginTag('div', $this->options);
    }

    public function run()
    {
        echo Html::endTag('div');
    }

    public function registerJs()
    {
        $this->registerJsAsset();
        $clientOptions = $this->clientOptions ? Json::encode($this->clientOptions) : null;
        $this->getView()->registerJs('jQuery("#' . $this->options['id'] . '").sticky(' . $clientOptions . ');');
    }
}

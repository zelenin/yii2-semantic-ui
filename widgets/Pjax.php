<?php

namespace Zelenin\yii\SemanticUI\widgets;

use yii\helpers\Html;
use Zelenin\yii\SemanticUI\Elements;

class Pjax extends \yii\widgets\Pjax
{
    public $loader;

    public function init()
    {
        Html::addCssClass($this->options, 'dimmable');
        if (!$this->loader) {
            $this->loader = Elements::dimmer(Elements::loader(), ['class' => 'active inverted']);
        }
        parent::init();
    }

    public function registerClientScript()
    {
        parent::registerClientScript();
        $this->getView()->registerJs('
        var pjaxLoader = "' . addslashes($this->loader) . '";
        jQuery(document).on("pjax:start", function() {
            jQuery("#' . $this->options['id'] . '").append(pjaxLoader);
        });
        ');
    }
}

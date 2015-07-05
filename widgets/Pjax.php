<?php

namespace Zelenin\yii\SemanticUI\widgets;

use yii\helpers\Html;
use yii\helpers\Inflector;
use Zelenin\yii\SemanticUI\Elements;

class Pjax extends \yii\widgets\Pjax
{
    /**
     * @var string
     */
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
        var pjaxLoader_' . $this->getSanitizedId() . ' = "' . addslashes($this->loader) . '";
        jQuery(document).on("pjax:start", "#' . $this->options['id'] . '", function() {
            jQuery("#' . $this->options['id'] . '").append(pjaxLoader_' . $this->getSanitizedId() . ');
        });
        ');
    }

    /**
     * @return string
     */
    private function getSanitizedId()
    {
        return Inflector::camelize($this->options['id']);
    }
}

<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use Zelenin\yii\SemanticUI\Elements;
use Zelenin\yii\SemanticUI\Widget;

class Modal extends Widget
{
    /**
     * @var string
     */
    public $closeButton = '<i class="close icon"></i>';

    /**
     * @var string
     */
    public $header;
    /**
     * @var array
     */
    public $headerOptions = [];

    /**
     * @var string
     */
    public $content;
    /**
     * @var array
     */
    public $contentOptions = [];

    /**
     * @var string
     */
    public $actions;
    /**
     * @var array
     */
    public $actionsOptions = [];

    /**
     * @var string
     */
    public $type = self::TYPE_STANDARD;
    const TYPE_BASIC = 'basic';
    const TYPE_STANDARD = 'standard';

    /**
     * @var bool
     */
    public $fullscreen = false;
    const TYPE_FULLSCREEN = 'fullscreen';

    /**
     * @var string
     */
    public $size;

    public function init()
    {
        parent::init();

        $this->registerJs();

        Html::addCssClass($this->options, 'ui ' . $this->type . ' modal');
        if ($this->fullscreen) {
            Html::addCssClass($this->options, self::TYPE_FULLSCREEN);
        }
        if ($this->size) {
            Html::addCssClass($this->options, $this->size);
        }

        echo Html::beginTag('div', $this->options);
        echo $this->renderCloseButton();
        echo $this->renderHeader();
        Html::addCssClass($this->contentOptions, 'content');
        echo Html::beginTag('div', $this->contentOptions);
    }

    public function run()
    {
        echo Html::endTag('div');
        echo $this->renderActions();
        echo Html::endTag('div');
    }

    /**
     * @return string
     */
    public function renderCloseButton()
    {
        return $this->closeButton;
    }

    /**
     * @return null|string
     */
    public function renderHeader()
    {
        Html::addCssClass($this->headerOptions, 'header');
        return $this->header ? Html::tag('div', $this->header, $this->headerOptions) : null;
    }

    /**
     * @return null|string
     */
    public function renderActions()
    {
        Html::addCssClass($this->actionsOptions, 'actions');
        return $this->actions ? Html::tag('div', $this->actions, $this->actionsOptions) : null;
    }

    /**
     * @param string $content
     * @param array $options
     *
     * @return string
     */
    public function renderToggleButton($content, $options = [])
    {
        if (!isset($options['id'])) {
            $options['id'] = $this->getId() . '-button';
        }

        $this->getView()->registerJs('
        jQuery("#' . $options['id'] . '").on("click", function(event) {
            event.preventDefault();
            jQuery("#' . $this->getId() . '").modal("show");
        });
        ');

        return Elements::button($content, $options);
    }

    public function registerJs()
    {
        $this->registerJsAsset();
        $clientOptions = $this->clientOptions ? Json::encode($this->clientOptions) : null;
        $this->getView()->registerJs('jQuery("#' . $this->options['id'] . '").modal(' . $clientOptions . ');');
    }
}

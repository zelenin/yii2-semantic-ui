<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use Zelenin\yii\SemanticUI\Widget;

class Progress extends Widget
{
    /**
     * @var string
     */
    public $label;

    /**
     * @var string
     */
    public $progress;

    /**
     * @var string
     */
    public $state;
    const STATE_ACTIVE = 'active';
    const STATE_SUCCESS = 'success';
    const STATE_WARNING = 'warning';
    const STATE_ERROR = 'error';
    const STATE_DISABLED = 'disabled';

    /**
     * @var bool
     */
    public $inverted = false;
    const TYPE_INVERTED = 'inverted';

    /**
     * @var bool
     */
    public $indicating = false;
    const TYPE_INDICATING = 'indicating';

    /**
     * @var string
     */
    public $attached;
    const ATTACHED_TOP = 'top attached';
    const ATTACHED_BOTTOM = 'bottom attached';

    /**
     * @var string
     */
    public $size;

    /**
     * @var string
     */
    public $color;

    public function run()
    {
        $this->registerJs();

        Html::addCssClass($this->options, 'ui progress');

        if ($this->indicating) {
            Html::addCssClass($this->options, self::TYPE_INDICATING);
        }
        if ($this->inverted) {
            Html::addCssClass($this->options, self::TYPE_INVERTED);
        }
        if ($this->attached) {
            Html::addCssClass($this->options, $this->attached);
        }
        if ($this->size) {
            Html::addCssClass($this->options, $this->size);
        }
        if ($this->state) {
            Html::addCssClass($this->options, $this->state);
        }
        if ($this->color) {
            Html::addCssClass($this->options, $this->color);
        }

        echo Html::tag('div', $this->renderBar() . $this->renderLabel(), $this->options);
    }

    /**
     * @return string
     */
    public function renderBar()
    {
        return Html::tag('div', $this->renderProgress(), ['class' => 'bar']);;
    }

    /**
     * @return string
     */
    public function renderLabel()
    {
        if ($this->label) {
            return Html::tag('div', $this->label, ['class' => 'label']);
        } else {
            return '';
        }
    }

    /**
     * @return string
     */
    public function renderProgress()
    {
        if ($this->progress) {
            return Html::tag('div', $this->progress, ['class' => 'progress']);
        } else {
            return '';
        }
    }

    public function registerJs()
    {
        $this->registerJsAsset();
        $clientOptions = $this->clientOptions ? Json::encode($this->clientOptions) : null;
        $this->getView()->registerJs('jQuery("#' . $this->options['id'] . '").progress(' . $clientOptions . ');');
    }
}

<?php

namespace Zelenin\yii\SemanticUI\collections;

use Yii;
use yii\helpers\Html;
use Zelenin\yii\SemanticUI\Elements;
use Zelenin\yii\SemanticUI\Widget;

class Message extends Widget
{
    public $icon = false;
    const TYPE_ICON = 'icon';

    public $hidden = false;
    const TYPE_HIDDEN = 'hidden';

    public $visible = false;
    const TYPE_VISIBLE = 'visible';

    public $floating = false;
    const TYPE_FLOATING = 'floating';

    public $compact = false;
    const TYPE_COMPACT = 'compact';

    public $attached = false;
    const TYPE_ATTACHED = 'attached';

    public $type;
    const TYPE_WARNING = 'warning';
    const TYPE_INFO = 'info';
    const TYPE_POSITIVE = 'positive';
    const TYPE_SUCCESS = 'success';
    const TYPE_NEGATIVE = 'negative';
    const TYPE_ERROR = 'error';

    public $size;
    const SIZE_SMALL = 'small';
    const SIZE_LARGE = 'large';
    const SIZE_HUGE = 'huge';
    const SIZE_MASSIVE = 'massive';

    public $color;
    const COLOR_BLACK = 'black';
    const COLOR_YELLOW = 'yellow';
    const COLOR_GREEN = 'green';
    const COLOR_BLUE = 'blue';
    const COLOR_ORANGE = 'orange';
    const COLOR_PURPLE = 'purple';
    const COLOR_PINK = 'pink';
    const COLOR_RED = 'red';
    const COLOR_TEAL = 'teal';

    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, 'ui message');
        if ($this->icon) {
            Html::addCssClass($this->options, self::TYPE_ICON);
        }
        if ($this->hidden) {
            Html::addCssClass($this->options, self::TYPE_HIDDEN);
        }
        if ($this->visible) {
            Html::addCssClass($this->options, self::TYPE_VISIBLE);
        }
        if ($this->floating) {
            Html::addCssClass($this->options, self::TYPE_FLOATING);
        }
        if ($this->compact) {
            Html::addCssClass($this->options, self::TYPE_COMPACT);
        }
        if ($this->attached) {
            Html::addCssClass($this->options, self::TYPE_ATTACHED);
        }
        if ($this->size) {
            Html::addCssClass($this->options, $this->size);
        }
        if ($this->color) {
            Html::addCssClass($this->options, $this->color);
        }
        if ($this->type) {
            Html::addCssClass($this->options, $this->type);
        }

        echo Html::beginTag('div', $this->options);
    }

    public function run()
    {
        echo Html::endTag('div');
    }

    public function renderCloseButton($options = [])
    {
        if (!isset($options['id'])) {
            $options['id'] = $this->getId() . '-close-button';
        }

        $this->getView()->registerJs('
        jQuery("#' . $options['id'] . '").on("click", function(event) {
            jQuery("#' . $this->getId() . '").fadeOut();
        });
        ');

        return Elements::icon('close', $options);
    }
}

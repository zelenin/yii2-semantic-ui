<?php

namespace Zelenin\yii\SemanticUI\collections;

use Yii;
use yii\helpers\Html;
use Zelenin\yii\SemanticUI\Elements;
use Zelenin\yii\SemanticUI\Widget;

class Message extends Widget
{
    /**
     * @var bool
     */
    public $icon = false;
    const TYPE_ICON = 'icon';

    /**
     * @var bool
     */
    public $hidden = false;
    const TYPE_HIDDEN = 'hidden';

    /**
     * @var bool
     */
    public $visible = false;
    const TYPE_VISIBLE = 'visible';

    /**
     * @var bool
     */
    public $floating = false;
    const TYPE_FLOATING = 'floating';

    /**
     * @var bool
     */
    public $compact = false;
    const TYPE_COMPACT = 'compact';

    /**
     * @var bool
     */
    public $attached = false;
    const TYPE_ATTACHED = 'attached';

    /**
     * @var string
     */
    public $type;
    const TYPE_WARNING = 'warning';
    const TYPE_INFO = 'info';
    const TYPE_POSITIVE = 'positive';
    const TYPE_SUCCESS = 'success';
    const TYPE_NEGATIVE = 'negative';
    const TYPE_ERROR = 'error';

    /**
     * @var string
     */
    public $size;

    /**
     * @var string
     */
    public $color;

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

    /**
     * @param array $options
     *
     * @return string
     */
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

<?php

namespace Zelenin\yii\SemanticUI;

use yii\base\InvalidConfigException;
use yii\helpers\Html;

class ActiveForm extends \yii\widgets\ActiveForm
{
    const SIZE_SMALL = 'small';
    const SIZE_NORMAL = 'normal';
    const SIZE_LARGE = 'large';

    public $fieldClass = 'Zelenin\yii\SemanticUI\ActiveField';
    public $options = ['class' => 'ui form'];

    public $size = self::SIZE_NORMAL;
    public $inverted = false;

    public function init()
    {
        if (!in_array($this->size, $this->getSizes())) {
            throw new InvalidConfigException('Invalid size: ' . $this->size);
        }

        if ($this->size !== self::SIZE_NORMAL) {
            Html::addCssClass($this->options, $this->size);
        }

        if ($this->inverted === true) {
            Html::addCssClass($this->options, 'inverted');
        }
        parent::init();
    }

    public function getSizes()
    {
        return [
            self::SIZE_SMALL,
            self::SIZE_NORMAL,
            self::SIZE_LARGE
        ];
    }
}

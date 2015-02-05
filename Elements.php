<?php

namespace Zelenin\yii\SemanticUI;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Elements
{
    public static function icon($icon, $options = [])
    {
        Html::addCssClass($options, $icon . ' icon');
        return Html::tag(ArrayHelper::remove($options, 'tag', 'i'), '', $options);
    }

    public static function button($content, $options = [])
    {
        return static::renderElement('button', $content, $options);
    }

    public static function buttonsGroup($content, $options = [])
    {
        return static::renderElement('buttons', $content, $options);
    }

    public static function divider($content = '', $options = [])
    {
        return static::renderElement('divider', $content, $options);
    }

    public static function flag($flag, $options = [])
    {
        Html::addCssClass($options, $flag . ' flag');
        return Html::tag(ArrayHelper::remove($options, 'tag', 'i'), '', $options);
    }

    public static function header($content, $options = [])
    {
        return static::renderElement('header', $content, $options);
    }

    public static function image($src, $options = [])
    {
        Html::addCssClass($options, 'ui ' . ArrayHelper::remove($options, 'class') . ' image');
        return Html::img($src, $options);
    }

    public static function imagesGroup($content, $options = [])
    {
        return static::renderElement('images', $content, $options);
    }

    public static function input($content, $options = [])
    {
        return static::renderElement('input', $content, $options);
    }

    public static function label($content, $options = [])
    {
        return static::renderElement('label', $content, $options);
    }

    public static function labelsGroup($content, $options = [])
    {
        return static::renderElement('labels', $content, $options);
    }

    public static function listWrapper($content, $options = [])
    {
        return static::renderElement('list', $content, $options);
    }

    public static function listItem($content, $options = [])
    {
        return static::renderElement('item', $content, $options);
    }

    public static function dimmer($content, $options = [])
    {
        return static::renderElement('dimmer', $content, $options);
    }

    public static function loader($content = '', $options = [])
    {
        return static::renderElement('loader', $content, $options);
    }

    public static function rail($content, $options = [])
    {
        return static::renderElement('rail', $content, $options);
    }

    public static function reveal($content, $options = [])
    {
        return static::renderElement('reveal', $content, $options);
    }

    public static function segment($content, $options = [])
    {
        return static::renderElement('segment', $content, $options);
    }

    public static function steps($content, $options = [])
    {
        return static::renderElement('steps', $content, $options);
    }

    public static function step($content, $options = [])
    {
        return static::renderElement('step', $content, $options);
    }

    /**
     * @param string $type
     * @param string $content
     * @param array $options
     * @return string
     */
    public static function renderElement($type, $content, $options = [])
    {
        Html::addCssClass($options, 'ui ' . ArrayHelper::remove($options, 'class') . ' ' . $type);
        return Html::tag(ArrayHelper::remove($options, 'tag', 'div'), $content, $options);
    }
}

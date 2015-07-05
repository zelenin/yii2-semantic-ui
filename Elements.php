<?php

namespace Zelenin\yii\SemanticUI;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Elements
{
    /**
     * @param string $content
     * @param array $options
     *
     * @return string
     */
    public static function button($content, $options = [])
    {
        return static::renderElement('button', $content, $options);
    }

    /**
     * @param string $content
     * @param array $options
     *
     * @return string
     */
    public static function buttonsGroup($content, $options = [])
    {
        return static::renderElement('buttons', $content, $options);
    }

    /**
     * @param string $content
     * @param array $options
     *
     * @return string
     */
    public static function divider($content = '', $options = [])
    {
        return static::renderElement('divider', $content, $options);
    }

    /**
     * @param string $flag
     * @param array $options
     * @return string
     */
    public static function flag($flag, $options = [])
    {
        Html::addCssClass($options, $flag . ' flag');
        return Html::tag(ArrayHelper::remove($options, 'tag', 'i'), '', $options);
    }

    /**
     * @param string $icon
     * @param array $options
     *
     * @return string
     */
    public static function icon($icon, $options = [])
    {
        Html::addCssClass($options, $icon . ' icon');
        return Html::tag(ArrayHelper::remove($options, 'tag', 'i'), '', $options);
    }

    /**
     * @param string $content
     * @param array $options
     *
     * @return string
     */
    public static function header($content, $options = [])
    {
        return static::renderElement('header', $content, $options);
    }

    /**
     * @param string $src
     * @param array $options
     *
     * @return string
     */
    public static function image($src, $options = [])
    {
        Html::addCssClass($options, 'ui ' . ArrayHelper::remove($options, 'class') . ' image');
        return Html::img($src, $options);
    }

    /**
     * @param string $content
     * @param array $options
     *
     * @return string
     */
    public static function imagesGroup($content, $options = [])
    {
        return static::renderElement('images', $content, $options);
    }

    /**
     * @param string $content
     * @param array $options
     *
     * @return string
     */
    public static function input($content, $options = [])
    {
        return static::renderElement('input', $content, $options);
    }

    /**
     * @param string $content
     * @param array $options
     *
     * @return string
     */
    public static function label($content, $options = [])
    {
        return static::renderElement('label', $content, $options);
    }

    /**
     * @param string $content
     * @param array $options
     *
     * @return string
     */
    public static function labelsGroup($content, $options = [])
    {
        return static::renderElement('labels', $content, $options);
    }

    /**
     * @param string $content
     * @param array $options
     *
     * @return string
     */
    public static function listWrapper($content, $options = [])
    {
        return static::renderElement('list', $content, $options);
    }

    /**
     * @param string $content
     * @param array $options
     *
     * @return string
     */
    public static function listItem($content, $options = [])
    {
        return static::renderElement('item', $content, $options);
    }

    /**
     * @param string $content
     * @param array $options
     *
     * @return string
     */
    public static function dimmer($content, $options = [])
    {
        return static::renderElement('dimmer', $content, $options);
    }

    /**
     * @param string $content
     * @param array $options
     *
     * @return string
     */
    public static function loader($content = '', $options = [])
    {
        return static::renderElement('loader', $content, $options);
    }

    /**
     * @param string $content
     * @param array $options
     *
     * @return string
     */
    public static function rail($content, $options = [])
    {
        return static::renderElement('rail', $content, $options);
    }

    /**
     * @param string $content
     * @param array $options
     *
     * @return string
     */
    public static function reveal($content, $options = [])
    {
        return static::renderElement('reveal', $content, $options);
    }

    /**
     * @param string $content
     * @param array $options
     *
     * @return string
     */
    public static function segments($content, $options = [])
    {
        return static::renderElement('segments', $content, $options);
    }

    /**
     * @param string $content
     * @param array $options
     *
     * @return string
     */
    public static function segment($content, $options = [])
    {
        return static::renderElement('segment', $content, $options);
    }

    /**
     * @param string $content
     * @param array $options
     *
     * @return string
     */
    public static function steps($content, $options = [])
    {
        return static::renderElement('steps', $content, $options);
    }

    /**
     * @param string $content
     * @param array $options
     *
     * @return string
     */
    public static function step($content, $options = [])
    {
        return static::renderElement('step', $content, $options);
    }

    /**
     * @param string $type
     * @param string $content
     * @param array $options
     *
     * @return string
     */
    public static function renderElement($type, $content, $options = [])
    {
        $tag = ArrayHelper::remove($options, 'tag', 'div');

        $class = ArrayHelper::remove($options, 'class');
        Html::addCssClass($options, 'ui ' . $class . ' ' . $type);

        return Html::tag($tag, $content, $options);
    }
}

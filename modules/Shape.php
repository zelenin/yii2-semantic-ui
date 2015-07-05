<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use Zelenin\yii\SemanticUI\Widget;

class Shape extends Widget
{
    /**
     * @var array
     */
    public $sides = [];

    /**
     * @var string
     */
    public $type;
    const TYPE_CUBE = 'cube';
    const TYPE_TEXT = 'text';

    /**
     * @var bool
     */
    public $fluid = false;
    const TYPE_FLUID = 'fluid';

    /**
     * @var bool
     */
    public $compact = false;
    const TYPE_COMPACT = 'compact';

    /**
     * @var bool
     */
    public $disabled = false;
    const TYPE_DISABLED = 'disabled';

    /**
     * @var bool
     */
    public $upward = false;
    const TYPE_UPWARD = 'upward';

    public function run()
    {
        $this->registerJs();

        Html::addCssClass($this->options, 'ui shape');

        if ($this->type) {
            Html::addCssClass($this->options, $this->type);
        }

        echo Html::tag('div', Html::tag('div', $this->renderSides(), ['class' => 'sides']), $this->options);
    }

    /**
     * @return string
     */
    public function renderSides()
    {
        $sides = '';
        foreach ($this->normalizeSides($this->sides) as $side) {
            $sides .= $this->renderSide($side);
        }
        return $sides;
    }

    /**
     * @param array $side
     * @return string
     */
    public function renderSide($side)
    {
        $sideOptions = ['class' => 'side'];
        if ($side['active']) {
            Html::addCssClass($sideOptions, 'active');
        }
        return Html::tag('div', $side['content'], $sideOptions);
    }

    /**
     * @param array $sides
     * @return array
     */
    public function normalizeSides($sides)
    {
        $items = [];
        $isActive = false;
        foreach ($sides as $side) {
            if (isset($side['active'])) {
                if ($side['active'] && !$isActive) {
                    $isActive = true;
                }
            } else {
                $side['active'] = false;
            }
            $items[] = $side;
        }
        if (!$isActive && isset($items[0])) {
            $items[0]['active'] = true;
        }
        return $items;
    }

    public function registerJs()
    {
        $this->registerJsAsset();
        $clientOptions = $this->clientOptions ? Json::encode($this->clientOptions) : null;
        $this->getView()->registerJs('jQuery("#' . $this->getId() . '").shape(' . $clientOptions . ');');
    }
}

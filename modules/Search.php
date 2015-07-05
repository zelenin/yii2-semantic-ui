<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use Zelenin\yii\SemanticUI\Elements;
use Zelenin\yii\SemanticUI\Widget;

class Search extends Widget
{
    /**
     * @var string
     */
    public $input;

    /**
     * @var bool
     */
    public $loading = true;
    const TYPE_LOADING = 'loading';

    /**
     * @var bool
     */
    public $fluid = false;
    const TYPE_FLUID = 'fluid';

    /**
     * @var bool
     */
    public $category = false;
    const TYPE_CATEGORY = 'category';

    /**
     * @var bool
     */
    public $rightAligned = false;
    const TYPE_RIGHT_ALIGNED = 'right aligned';

    public function run()
    {
        $this->registerJs();

        Html::addCssClass($this->options, 'ui search');
        if ($this->loading) {
            Html::addCssClass($this->options, self::TYPE_LOADING);
        }
        if ($this->fluid) {
            Html::addCssClass($this->options, self::TYPE_FLUID);
        }
        if ($this->category) {
            Html::addCssClass($this->options, self::TYPE_CATEGORY);
        }
        if ($this->rightAligned) {
            Html::addCssClass($this->options, self::TYPE_RIGHT_ALIGNED);
        }

        echo Html::tag('div', $this->renderInput() . $this->renderResults(), $this->options);
    }

    /**
     * @return string
     */
    public function renderInput()
    {
        return $this->input ?: Elements::input(Html::input('text', null, null, ['class' => 'prompt']));
    }

    /**
     * @return string
     */
    public function renderResults()
    {
        return Html::tag('div', null, ['class' => 'results']);
    }

    public function registerJs()
    {
        $this->registerJsAsset();
        $clientOptions = $this->clientOptions ? Json::encode($this->clientOptions) : null;
        $this->getView()->registerJs('jQuery("#' . $this->options['id'] . '").search(' . $clientOptions . ');');
    }
}

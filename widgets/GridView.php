<?php

namespace Zelenin\yii\SemanticUI\widgets;

class GridView extends \yii\grid\GridView
{
    /**
     * @var array
     */
    public $tableOptions = ['class' => 'ui table'];

    /**
     * @var string
     */
    public $dataColumnClass = 'Zelenin\yii\SemanticUI\widgets\DataColumn';

    /**
     * @var array
     */
    public $pager = ['class' => 'Zelenin\yii\SemanticUI\widgets\LinkPager'];
}

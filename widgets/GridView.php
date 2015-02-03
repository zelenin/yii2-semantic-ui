<?php

namespace Zelenin\yii\SemanticUI\widgets;

class GridView extends \yii\grid\GridView
{
    public $tableOptions = ['class' => 'ui very basic table'];
    public $dataColumnClass = 'Zelenin\yii\SemanticUI\widgets\DataColumn';
    public $pager = ['class' => 'Zelenin\yii\SemanticUI\widgets\LinkPager'];
}

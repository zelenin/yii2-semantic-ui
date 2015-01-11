<?php

namespace Zelenin\yii\SemanticUI;

class GridView extends \yii\grid\GridView
{
    public $tableOptions = ['class' => 'ui very basic table'];
    public $dataColumnClass = 'Zelenin\yii\SemanticUI\DataColumn';
}

<?php

namespace Zelenin\yii\SemanticUI;

class DetailView extends \yii\widgets\DetailView
{
    public $options = ['class' => 'ui definition table'];
    public $template = '<tr><td>{label}</td><td>{value}</td></tr>';
}

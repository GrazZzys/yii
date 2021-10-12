<?php

use yii\grid\DataColumn;
use yii\helpers\Html;

$this->title = 'Post';

echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'title',
        'text',
    ]
]);
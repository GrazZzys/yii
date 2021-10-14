<?php

use yii\grid\DataColumn;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Post';

echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'title',
        'text',
    ]
]);
?>
<?php
$form = ActiveForm::begin([
    'id' => 'change-form',
    'method' => 'GET',
    'action' => ['/change'],
    'options' => ['class' => 'form-horizontal'],
]); ?>
<?= Html::activeHiddenInput($model, 'id')?>
<?= Html::submitButton('Изменить', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end() ?>
<?php
$form = ActiveForm::begin([
    'id' => 'delete-form',
    'method' => 'DELETE',
    'action' => ['/delete'],
    'options' => ['class' => 'form-horizontal'],
]); ?>
    <?= Html::activeHiddenInput($model, 'id')?>
    <?= Html::submitButton('Удалить пост', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end() ?>



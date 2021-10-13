<?php
/**
 *
 * @var $model
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Create post';

$form = ActiveForm::begin([
    'id' => 'create-form',
    'method' => 'POST',
    'action' => ['/add'],
    'options' => ['class' => 'form-horizontal'],
]); ?>
<?= $form->field($model, 'title')->textInput()->hint('Заголовок') ?>
<?= $form->field($model, 'text')->textarea()->hint('Содержание')?>
<?= Html::submitButton('Создать', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end() ?>

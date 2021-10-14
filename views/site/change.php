<?php
/**
 *
 * @var $model
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Change post';

$form = ActiveForm::begin([
    'id' => 'update-form',
    'method' => 'PUT',
    'action' => ['/update'],
    'options' => ['class' => 'form-horizontal'],
]); ?>
    <?= Html::activeHiddenInput($model, 'id')?>
    <?= $form->field($model, 'title')->textInput()->hint('Новый заголовок') ?>
    <?= $form->field($model, 'text')->textarea()->hint('Новое содержание')?>
    <?= Html::submitButton('Обновить пост', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end() ?>

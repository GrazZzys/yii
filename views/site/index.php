<?php

/**
 * @var $dataProvider
 * @var $model
 */
    /* @var $this yii\web\View */
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;

    $this->title = 'News';
?>
<?php
    $form = ActiveForm::begin([
        'id' => 'search-form',
        'method' => 'GET',
        'action' => ['/posts'],
        'options' => ['class' => 'form-horizontal'],
    ]); ?>
    <?= $form->field($model, 'query')->textInput()->hint('Искать по названию')?>
    <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end() ?>

<?php
    echo \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'title',
            'text',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'headerOptions' => ['width' => '80'],
                'buttons' => [
                    'view' => function($url,$model){
                        return Html::a('Открыть', "/post?id=$model->id");
                    },
                ],
            ],

        ],
    ]);
?>

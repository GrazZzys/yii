<?php

/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'News';
?>

<div class="site-index">
    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Новости</h1>
        <form class="text-center" action="/posts" method="GET">
            <input name="title" type="text" placeholder="Введите название поста"><br><br>
            <button type="submit" class="btn btn-outline-secondary">Искать новость</button>
        </form>
    </div>
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
    <?php
    echo Html::beginForm('update', 'GET');
    echo Html::label('Изменить');
    echo Html::input('text', 'id');
    echo Html::input('text', 'title');
    echo Html::input('text', 'text');
    echo Html::submitButton();
    echo Html::endForm();
    ?>
    <div class="col-lg-4">
        <h2>Добавить новость</h2>
        <form action="add" method="GET">
            <input name="title" type="text">
            <textarea name="text" cols="21" rows="10"></textarea>
            <button type="submit"  class="btn btn-outline-secondary">Добавить новость</button>
        </form>
    </div>
</div>

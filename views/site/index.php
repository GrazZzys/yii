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
    try {
        echo \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                ],
                [
                    'attribute' => 'id'
                ],
                [
                    'attribute' => 'title'
                ],
                [
                    'attribute' => 'text'
                ],
            ]
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    ?>
    <?php
    echo Html::beginForm('update', 'GET');
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

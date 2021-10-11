<?php

/* @var $this yii\web\View */

$this->title = 'News';
?>
<script>
    function updatePost(id){

        let item = document.getElementById("pop").hidden = false
        let item2 = document.getElementById("popId").value = id;
        console.log(id)
        console.log(item)
    }
</script>

<div class="site-index">
    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Новости</h1>
        <form class="text-center" action="/posts" method="GET">
            <input name="title" type="text" placeholder="Введите название поста"><br><br>
            <button type="submit" class="btn btn-outline-secondary">Искать новость</button>
        </form>
    </div>
    <div id="pop" hidden="true" class="col-lg-4">
        <form action="update" method="GET">
            <input id="popId" name="id" type="hidden" value="">
            <input name="title" type="text">
            <textarea name="text" cols="21" rows="10"></textarea>
            <button type="submit"  class="btn btn-outline-secondary">Изменить новость</button>
        </form>
        <?php if( Yii::$app->session->hasFlash('success') ): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::$app->session->getFlash('success'); ?>
        </div>
        <?php endif;?>
    </div>
        <?php if(isset($posts[0])): ?>
        <div class="body-content">
            <div class="row">
                <?php foreach ($posts as $post): ?>
                    <div id="<<?=$post['id']?>>"  class="col-lg-4">
                        <h2><?=$post['title']?></h2>
                        <p><?=$post['text']?></p>
                        <form action="">
                            <button type="button"  class="btn btn-outline-secondary" onclick="updatePost(<?= $post['id']?>)">Редактировать новость</button>
                        </form>
                        <form action="delete" method="GET">
                            <input name="id" type="hidden" value="<?= $post['id']?>">
                            <button type="submit"  class="btn btn-outline-secondary">Удалить новость</button>
                        </form>
                    </div>
                <?php endforeach;?>
            </div>
        <?php else:?>
            <div class="jumbotron text-center bg-transparent">
                <h1 class="display-4">Нет новостей</h1>
            </div>
        </div>
        <?php endif;?>
        <div class="col-lg-4">
            <h2>Добавить новость</h2>
            <form action="add" method="GET">
                <input name="title" type="text">
                <textarea name="text" cols="21" rows="10"></textarea>
                <button type="submit"  class="btn btn-outline-secondary">Добавить новость</button>
            </form>
        </div>
</div>

<?php

namespace app\controllers;

use app\models\Posts;
use Yii;
use yii\web\Controller;

class PostService
{
    public function all()
    {
        $db = new Posts();
        return $db->getAll();
    }

    public function view($title)
    {
        $db = new Posts();
        return $db->getPostByName($title);
    }

    public function delete($id)
    {
        $db = new Posts();
        return $db->deletePost($id);
    }

    public function update($id, $title, $text)
    {
        $bd = new Posts();
        return $bd->updatePost($id, $title, $text);
    }

    public function add($title, $text)
    {
        $bd = new Posts();
        return $bd->addPost($title, $text);
    }

}
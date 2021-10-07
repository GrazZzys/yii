<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Posts extends ActiveRecord
{
    public function getAll()
    {
        $connection = Yii::$app->db;
        $command = $connection->CreateCommand("SELECT * FROM posts");
        return $command->queryAll();
    }
    public function getPostByName($title)
    {
        $connection = Yii::$app->db;
        $command = $connection->CreateCommand("select * from posts WHERE title = \"$title\"");
        return $command->queryAll();
    }
    public function deletePost($id)
    {
        $connection = Yii::$app->db;
        $connection->CreateCommand()->delete('posts', "id = $id")->execute();

    }
    public function addPost($title, $text)
    {
        $connection = Yii::$app->db;
        $connection->CreateCommand()->batchInsert('posts', ['title', 'text', 'author'], [[$title, $text, Yii::$app->user->id]])->execute();
    }
    public function updatePost($id, $title, $text)
    {
        $connection = Yii::$app->db;
        $connection->CreateCommand()->update('posts', ['title' => $title, 'text' => $text], "id = $id")->execute();
    }
}
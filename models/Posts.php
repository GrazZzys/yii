<?php

namespace app\models;

use phpDocumentor\Reflection\Types\Mixed_;
use Yii;
use yii\base\Model;
use yii\db\DataReader;
use yii\db\Exception;

/**
 * Post model
 */
class Posts extends Model
{
    /**
     * @return array|DataReader
     * @throws Exception
     */
    public static function getAll()
    {
        $connection = Yii::$app->db;
        $command = $connection->CreateCommand("SELECT * FROM posts");
        return $command->queryAll();
    }

    /**
     * @param int $id
     * @return array|DataReader
     * @throws Exception
     */
    public function getPostById(int $id)
    {
        $connection = Yii::$app->db;
        $command = $connection->CreateCommand("select * from posts WHERE id = \"$id\"");
        return $command->queryAll();
    }

    /**
     * @param string $title
     * @return array|DataReader
     * @throws Exception
     */
    public function getPostByName(string $title)
    {
        $connection = Yii::$app->db;
        $command = $connection->CreateCommand("select * from posts WHERE title = \"$title\"");
        return $command->queryAll();
    }

    /**
     * @param int $id
     * @return int
     * @throws Exception
     */
    public function deletePost(int $id): int
    {
        $connection = Yii::$app->db;
        return $connection->CreateCommand()->delete('posts', "id = $id")->execute();
    }

    /**
     * @param string $title
     * @param string $text
     * @param string $author
     * @return int
     * @throws Exception
     */
    public function addPost(string $title, string $text, string $author = ''): int
    {
        $connection = Yii::$app->db;
        return $connection->CreateCommand()->batchInsert('posts', ['title', 'text', 'author'], [[$title, $text, $author]])->execute();
    }

    /**
     * @param int $id
     * @param string $title
     * @param string $text
     * @return int
     * @throws Exception
     */
    public function updatePost(int $id, string $title, string $text): int
    {
        $connection = Yii::$app->db;
        return $connection->CreateCommand()->update('posts', ['title' => $title, 'text' => $text], "id = $id")->execute();
    }
}
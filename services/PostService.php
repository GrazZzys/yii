<?php

namespace app\services;

use app\models\Posts;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use yii\base\ExitException;
use yii\db\DataReader;
use yii\db\Exception;

/**
 * Post service
 */
class PostService
{
    /**
     * Get and return all posts
     * @return array|DataReader
     * @throws Exception
     */
    public function all()
    {

        $db = new Posts();
        return $db->getAll();

    }

    /**
     * Get and return posts by title
     * @param string $title
     * @return array|DataReader
     * @throws Exception
     */
    public function view(string $title)
    {
        $db = new Posts();
        return $db->getPostByName($title);
    }

    /**
     * Get and return posts du id
     * @param int $id
     * @return array|DataReader
     * @throws Exception
     */
    public function viewById(int $id)
    {
        $db = new Posts();
        return $db->getPostById($id);
    }

    /**
     * Delete post
     * @param int $id
     * @return int
     * @throws Exception
     */
    public function delete(int $id)
    {
        $db = new Posts();
        return $db->deletePost($id);
    }

    /**
     * Update post
     * @param int $id
     * @param string $title
     * @param string $text
     * @return int
     * @throws Exception
     */
    public function update(int $id, string $title, string $text): int
    {
        $bd = new Posts();
        return $bd->updatePost($id, $title, $text);
    }

    /**
     * Add post
     * @param string $title
     * @param string $text
     * @param string $author
     * @return int
     * @throws Exception
     */
    public function add(string $title, string $text, string $author): int
    {
        $bd = new Posts();
        return $bd->addPost($title, $text, $author);
    }
}
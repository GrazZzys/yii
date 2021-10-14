<?php

namespace app\services;
use app\models\Posts;

class PostService
{
    /**
     *
     * @return array
     * @throws \yii\db\Exception
     */
    public function all(): array
    {
        $db = new Posts();
        return $db->all();
    }

    /**
     * @param string $title
     * @return array
     * @throws \yii\db\Exception
     */
    public function view(string $title): array
    {
        $db = new Posts();
        return $db->getPostByTitle($title);
    }

    /**
     * @param int $id
     * @return Posts
     * @throws \yii\db\Exception
     */
    public function viewById(int $id) : Posts
    {
        $db = new Posts();
        return $db->getPostById($id);
    }

    /**
     * @param string $title
     * @param string $text
     * @param string $author
     * @return bool
     */
    public function add(string $title, string $text, string $author): bool
    {
        $db = new Posts();
        return $db->add($title, $text, $author);
    }

    /**
     * @param int $id
     * @return false|int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function delete(int $id)
    {
        $db = new Posts();
        return $db->remove($id);
    }

    /**
     * @param int $id
     * @param string $title
     * @param string $text
     * @param string $author
     * @return int
     * @throws \Throwable
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function update(int $id, string $title, string $text): int
    {
        $db = new Posts();
        return $db->change($id, $title, $text);
    }
}
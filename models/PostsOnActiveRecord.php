<?php

namespace app\models;
use app\models\Posts;
use Codeception\Template\Api;

class PostsOnActiveRecord
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
     * @return array
     * @throws \yii\db\Exception
     */
    public function viewById(int $id): array
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
        return $db->delete($id);
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
    public function update(int $id, string $title, string $text, string $author): int
    {
        $db = new Posts();
        return $db->change($id, $title, $text, $author);
    }
}
<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Exception;

/**
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string $author
 */
class Posts extends ActiveRecord
{
    /**
     * return table name
     *
     * @return string
     */
    public static function tableName() : string
    {
        return '{{posts}}';
    }

    /**
     * @return array
     * @throws Exception
     */
    public function all(): array
    {
        $res = self::find()->all();
        if(empty($res))
            throw new Exception('Ничего не найдено');
        return $res;
    }

    /**
     * @param string $title
     * @return array
     * @throws Exception
     */
    public function getPostByTitle(string $title) : array
    {
        $res = self::findAll(['title' => $title]);
        if(empty($res))
            throw new Exception('Ничего не найдено');
        return $res;
    }

    /**
     * @param int $id
     * @return Posts
     * @throws Exception
     */
    public function getPostById(int $id): Posts
    {
        $res = self::findOne($id);
        if(empty($res))
            throw new Exception('Пост не найден');
        return $res;
    }

    /**
     * @param string $title
     * @param string $text
     * @param string $author
     * @return bool
     * @throws Exception
     * @throws \Throwable
     */
    public function add(string $title, string $text, string $author) : bool
    {
        $post = new ApiPosts();
        $post->title = $title;
        $post->text = $text;
        $post->author = $author;
        $res = $post->insert();
        if ($res === false)
            throw new Exception('Ошибка добавления поста');
        return $res;
    }

    /**
     * @param int $id
     * @return int
     * @throws Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(int $id): int
    {
        $post = self::findOne($id);
        if(empty($post))
            throw new Exception('Пост не найден');
        $res = $post->delete();
        if($res === false)
            throw new Exception('Ошибка удаления');
        return $res;
    }

    /**
     * @param int $id
     * @param string $title
     * @param string $text
     * @return int
     * @throws Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function change(int $id, string $title, string $text) : int
    {
        $post = self::findOne($id);
        if(empty($post))
            throw new Exception('Пост не найден');
        $post->title = $title;
        $post->text = $text;
        $res = $post->update();
        if($res === false)
            throw new Exception('Ошибка обновления');
        else if ($res === 0)
            throw new Exception('Нечего обновлять');
        return $res;
    }
}
<?php

namespace app\services;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\Exception;

class DataService extends ActiveRecord
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
     * @return ActiveDataProvider
     * @throws Exception
     */
    public function all(): ActiveDataProvider
    {
        $query = self::find();

        if (empty($query))
            throw new Exception('Ничего не найдено');

        return new ActiveDataProvider([
            'query' => $query
        ]);
    }

    /**
     * @param $title
     * @return ActiveDataProvider
     * @throws Exception
     */
    public function getByTitle($title) : ActiveDataProvider
    {
        $query = self::find()->where(['title' => $title]);

        if (empty($query))
            throw new Exception('Ничего не найдено');

        return new ActiveDataProvider([
            'query' => $query
        ]);
    }

    /**
     * @param $id
     * @return ActiveDataProvider
     * @throws Exception
     */
    public function getById($id) : ActiveDataProvider
    {
        $query = self::find()->where(['id' => $id]);

        if (empty($query))
            throw new Exception('Ничего не найдено');

        return new ActiveDataProvider([
            'query' => $query
        ]);
    }
}
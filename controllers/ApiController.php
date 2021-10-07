<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\Response;
use app\models\ApiPosts;

class ApiController extends ActiveController
{
    public $modelClass = 'app\models\ApiPosts';

    public function actionIndex()
    {
        $posts = ApiPosts::find();
        return $this->asJson($posts);
    }
    public function actionView($id)
    {
        $post = ApiPosts::findOne(['id' => $id]);
        return $this->asJson($post);
    }
    public function actionViewByTitle($title)
    {
        $posts = ApiPosts::findAll(['title'=>$title]);
        return $this->asJson($posts);
    }

    public function actionAdd()
    {
        $params = Yii::$app->request->post();
        $newPost = new ApiPosts();
        $newPost->title = $params['title'];
        $newPost->text = $params['text'];
        $newPost->author = Yii::$app->user->id;
        $newPost->save();
        return $this->asJson(Yii::$app->db->getLastInsertID());
    }

    public function actionPut($id)
    {
        $params = Yii::$app->request->post();
        $newPost = ApiPosts::findOne(['id' => $id]);
        $newPost->title = $params['title'];
        $newPost->text = $params['text'];
        if($newPost->update() === false)
            return $this->asJson('Failed');
        return $this->asJson('Successful');
    }
}
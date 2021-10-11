<?php

namespace app\controllers;

use Yii;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\Response;
use app\models\ApiPosts;
use app\services\PostService;

/**
 * Post API
 */
class ApiController extends Controller
{
    /**
     * @return Response
     */
    public function actionIndex(): Response
    {
        $posts = new PostService();
        return $this->asJson($posts->all());
    }

    /**
     * @param int $id
     * @return Response
     */
    public function actionView(int $id): Response
    {
        $post = new PostService();
        return $this->asJson($post->viewById($id));
    }

    /**
     * @param string $title
     * @return Response
     */
    public function actionViewByTitle(string $title): Response
    {
        $posts = new PostService();
        return $this->asJson($posts->view($title));
    }

    /**
     * @return Response
     */
    public function actionAdd(): Response
    {
        $params = Yii::$app->request->post();
        $post = new PostService();
        $post->add($params['title'], $params['text'], $params['author']);
        return $this->asJson(1);///////////////////////////////////
    }

    /**
     * @param int $id
     * @return Response
     */
    public function actionPut(int $id): Response
    {
        $params = Yii::$app->request->post();
        $post = new PostService();
        $post->update($id, $params['title'], $params['text']);
        return $this->asJson(1);///////////////////////////////////
    }

    /**
     * @param int $id
     * @return Response
     */
    public function actionDelete(int $id): Response
    {
        $post = new PostService();
        $post->delete($id);
        return $this->asJson(1);///////////////////////////////////
    }
}
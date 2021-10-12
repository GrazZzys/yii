<?php

namespace app\controllers;


use app\services\PostService;
use Yii;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\Response;

/**
 * API
 */
class ApiController extends Controller
{
    /**
     * @return Response
     */
    public function actionIndex(): Response
    {
        $post = new PostService();
        try{
            return $this->asJson($post->all());
        } catch (Exception $e){
            return $this->asJson($e->getMessage());
        }
    }

    /**
     * @param string $title
     * @return Response
     */
    public function actionView(string $title): Response
    {
        $post = new PostService();
        try{
            return $this->asJson($post->view($title));
        }catch (Exception $e){
            return $this->asJson($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return Response
     */
    public function actionViewById(int $id): Response
    {
        $post = new PostService();
        try{
            return $this->asJson($post->viewById($id));
        }catch (Exception $e){
            return $this->asJson($e->getMessage());
        }
    }

    /**
     * @return Response
     * @throws \Throwable
     */
    public function actionAdd(): Response
    {
        $params = Yii::$app->request->post();
        $post = new PostService();
        try{
            return $this->asJson($post->add($params['title'], $params['text'], $params['author']));
        }catch (Exception $e){
            return $this->asJson($e->getMessage());
        }

    }

    /**
     * @param int $id
     * @return Response
     */
    public function actionUpdate(int $id): Response
    {
        $params = Yii::$app->request->post();
        $post = new PostService();
        try {
            $res = $post->update($id, $params['title'], $params['text'], $params['author']);
            return $this->asJson($res);
        } catch (Exception $e) {
            return $this->asJson($e->getMessage());
        } catch (\Throwable $e) {
            return $this->asJson($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Throwable
     */
    public function actionDelete(int $id): Response
    {
        $post = new PostService();
        try {
            return $this->asJson($post->delete($id));
        } catch (Exception $e) {
            return $this->asJson($e->getMessage());
        }
    }
}
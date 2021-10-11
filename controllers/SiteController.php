<?php

namespace app\controllers;

use app\models\ApiPosts;
use app\services\PostService;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'update', 'add', 'delete'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['update', 'delete'],
                        'allow' => true,
                        'roles' => ['updatePost'],
                        'roleParams' => function() {
                            return ['post' => ApiPosts::findOne(['id' => Yii::$app->request->get('id')])];
                        },
                    ],
                    [
                        'actions' => ['add'],
                        'allow' => true,
                        'roles' => ['createPost'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    /**
     * Displays homepage and all posts.
     *
     * @return string
     */
    public function actionIndex() : string
    {
        $posts = new PostService();
        $data =  ['posts' => $posts->all()];
        return $this->render('index', $data);
    }

    /**
     * Displays homepage and posts by title.
     *
     * @param string $title
     * @return string
     */
    public function actionView(string $title): string
    {
        $posts = new PostService();
        $res = $posts->view($title);
        try{
            if(empty($res))
                throw new Exception("Ничего не найдено");
        }catch (Exception $e){
            Yii::$app->session->setFlash('success', $e->getMessage());
        }
        $data = ['posts' => $res];
        return $this->render('index', $data);
    }
    public function actionViewById(string $title): string
    {
        $posts = new PostService();
        $data = ['posts' => $posts->view($title)];
        return $this->render('index', $data);
    }

    /**
     * Delete post by id.
     *
     * @param int $id
     * @return Response
     */
    public function actionDelete(int $id): Response
    {
        $posts = new PostService();
        $result = $posts->delete($id);
        return $this->redirect('/');
    }

    /**
     * Update post by id.
     *
     * @param int $id
     * @param string $title
     * @param string $text
     * @return Response
     */
    public function actionUpdate(int $id, string $title, string $text): Response
    {
        $posts = new PostService();
        $result = $posts->update($id, $title, $text);
        return $this->redirect('/');
    }

    /**
     * Add post.
     *
     * @param string $title
     * @param string $text
     * @return Response
     */
    public function actionAdd(string $title, string $text): Response
    {
        $posts = new PostService();
        $result = $posts->add($title, $text, Yii::$app->user->id);
        return $this->redirect('/');
    }
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}

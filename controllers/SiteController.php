<?php

namespace app\controllers;

use app\models\ApiPosts;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Posts;

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
                'only' => ['logout', 'update-post', 'add-post', 'delete-post'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['update-post', 'delete-post'],
                        'allow' => true,
                        'roles' => ['updatePost'],
                        'roleParams' => function() {
                            return ['post' => ApiPosts::findOne(['id' => Yii::$app->request->get('id')])];
                        },
                    ],
                    [
                        'actions' => ['add-post'],
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
    public function actions()
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $bd = new Posts();
        if (!empty(yii::$app->request->get()))
        {
            $postTitle = yii::$app->request->get()['input'];
            $posts = $bd->getPostByName($postTitle);

            return $this->render('index', ['posts' => $posts]);
        }
        else{
            $posts = $bd->getAll();
            return $this->render('index', ['posts' => $posts]  );
        }
    }

    public function actionDeletePost($id)
    {
        $bd = new Posts();
        $bd->deletePost($id);
        return $this->redirect('/');
    }

    public function actionUpdatePost($id, $title, $text)
    {
            $bd = new Posts();
            $bd->updatePost($id, $title, $text);
            return $this->redirect('/');
    }
    public function actionAddPost($title, $text)
    {
        $bd = new Posts();
        $bd->addPost($title, $text);
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

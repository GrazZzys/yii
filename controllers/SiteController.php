<?php

namespace app\controllers;

use app\models\ApiPosts;
use app\services\DataService;
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
     * @throws \yii\db\Exception
     */
    public function actionIndex() : string
    {
        $dataService = new DataService();
        $dataProvider = $dataService->all();
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * Displays homepage and posts by title.
     *
     * @param string $title
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionView(string $title): string
    {
        $dataService = new DataService();
        $dataProvider = $dataService->getByTitle($title);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * Delete post by id.
     *
     * @param int $id
     * @return Response
     * @throws \Throwable
     */
    public function actionDelete(int $id): Response
    {
        $post = new PostService();
        try {
            $this->asJson($post->delete($id));
            Yii::$app->session->setFlash('success', 'success');
        } catch (Exception $e) {
            Yii::$app->session->setFlash('danger', $e->getMessage());
        }
        return $this->redirect('/');
    }

    /**
     * Update post by id.
     *
     * @param int $id
     * @param string $title
     * @param string $text
     * @return Response
     * @throws \Throwable
     */
    public function actionUpdate(int $id, string $title='', string $text=''): Response
    {
        $params = Yii::$app->request->post();
        $post = new PostService();
        try {
            $res = $post->update($id, $title, $text);
            Yii::$app->session->setFlash('success', 'success');
        } catch (Exception $e) {
            Yii::$app->session->setFlash('danger', $e->getMessage());
        }
        return $this->redirect('/');
    }

    /**
     * Add post.
     *
     * @param string $title
     * @param string $text
     * @return Response
     */
    public function actionAdd(string $title, string $text=''): Response
    {
        $post = new PostService();
        try{
            $post->add($title, $text, Yii::$app->user->id);
            Yii::$app->session->setFlash('success', 'success');
        }catch (Exception $e){
            Yii::$app->session->setFlash('danger', $e->getMessage());
        }
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

<?php

namespace app\controllers;

use app\models\ApiPosts;
use app\models\SearchForm;
use app\models\UpdateForm;
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
                            return ['post' => ApiPosts::findOne(['id' => Yii::$app->request->post('UpdateForm')['id']])];
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
        $searchForm = new SearchForm();
        $dataService = new DataService();
        $dataProvider = $dataService->all();
        return $this->render('index', ['dataProvider' => $dataProvider, 'model' => $searchForm]);
    }

    /**
     * Displays homepage and posts by title.
     *
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionView(): string
    {
        $params = Yii::$app->request->get('SearchForm');
        $dataService = new DataService();
        $searchForm = new SearchForm();
        $dataProvider = $dataService->getByTitle($params['query']);
        return $this->render('index', ['dataProvider' => $dataProvider, 'model' => $searchForm]);
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionViewById(int $id): string
    {
        $dataService = new DataService();
        $dataProvider = $dataService->getById($id);
        $updateForm = new UpdateForm($id);
        return $this->render('post', ['dataProvider' => $dataProvider, 'model' => $updateForm]);
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionViewChange(): string
    {
        $params = Yii::$app->request->get('UpdateForm');
        $updateForm = new UpdateForm($params['id']);
        return $this->render('change', ['model' => $updateForm]);
    }

    public function actionViewCreate(): string
    {
        $updateForm = new UpdateForm();
        return $this->render('create', ['model' => $updateForm]);
    }

    /**
     * Delete post by id.
     *
     * @param int $id
     * @return Response
     * @throws \Throwable
     */
    public function actionDelete(): Response
    {
        $params = Yii::$app->request->post('UpdateForm');
        $post = new PostService();
        try {
            $post->delete($params['id']);
            Yii::$app->session->setFlash('success', 'success');
        } catch (Exception $e) {
            Yii::$app->session->setFlash('danger', $e->getMessage());
        }
        return $this->redirect('/');
    }

    /**
     * Update post by id.
     *
     * @return Response
     * @throws \Throwable
     */
    public function actionUpdate(): Response
    {
        $params = Yii::$app->request->post('UpdateForm');
        $post = new PostService();
        try {
            $res = $post->update($params['id'], $params['title'], $params['text']);
            Yii::$app->session->setFlash('success', 'success');
        } catch (Exception $e) {
            Yii::$app->session->setFlash('danger', $e->getMessage());
        }
        return $this->redirect('/');
    }

    /**
     * Add post.
     *
     * @return Response
     */
    public function actionAdd(): Response
    {
        $params = Yii::$app->request->post('UpdateForm');
        $post = new PostService();
        try{
            $post->add($params['title'], $params['text'], Yii::$app->user->id);
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

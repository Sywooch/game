<?php

namespace app\controllers;

use app\models\Game;
use app\models\GameSearch;
//use app\models\Sitemap;
use Yii;
use yii\caching\DbDependency;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
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

    /*
     * when updating the site this action show to user
     */
    public function actionOffline(){
        return $this->render('offline');
    }

    /*
     * result yandex search page
     */
    public function actionSearch($searchid, $text, $web)
    {
        return $this->render('search');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack('/admin/gameadmin/index');
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /*
     * страница вопрос-ответ
     */
    public function actionAnswer(){
        return $this->render('answer');
    }

    public function actionError(){
        $this->render('error');
    }

    /*
     * sitemap of site
     */
    public function actionSitemap(){

        header('Content-type: application/xml');

        $duration = 600;//кешируем на 180сек

        $items = Yii::$app->db->createCommand('SELECT alias, title, updated_at FROM tbl_game WHERE publish_status=1 AND updated_at<'.time())->cache($duration)->queryAll();

        $category = Yii::$app->db->createCommand('SELECT alias, title FROM tbl_category')->cache($duration)->queryAll();

        $host = Yii::$app->request->hostInfo;

        echo  $this->renderPartial('sitemap', array('host'=>Yii::$app->request->hostInfo,'items'=>$items,'category'=>$category));

        Yii::$app->end();
    }

}

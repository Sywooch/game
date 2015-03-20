<?php

namespace app\controllers;

use app\models\CategorySearch;
use Yii;
use app\models\Game;
use app\models\GameSearch;
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\data\ActiveDataProvider;
use app\models\Category;

/**
 * GameController implements the CRUD actions for Game model.
 */
class GameController extends Controller
{
//    public function behaviors()
//    {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['post'],
//                ],
//            ],
//        ];
//    }


    public function behaviors()
    {
        return [

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'favorite'  => ['post'],
                    'deletefavoritegame'=>['post'],
                    'view'   => ['get'],
                    'create' => ['get', 'post'],
                    'update' => ['get', 'put', 'post'],
                    'delete' => ['post', 'delete'],
                ],
            ],

//            'pageCache' => [
//                'class' => PageCache::className(),
//                'except' => ['login', 'logout'],
//                'duration' => 5, // seconds
//                'variations' => [
//                    Yii::$app->request->get('id'), // record id
//                    Yii::$app->request->get('page'), // page number
//                    Yii::$app->request->get('sort'), // sort list
//                    Yii::$app->request->get('cache'), // reset page -> setFlash -> getFlash
//                ],
//            ],
//            [
//                'class' => 'yii\filters\PageCache',
//                'only' => ['index','view'],
//                'duration' => 120,
//                    'variations' => [
//                        Yii::$app->request->get('id'), // record id
//                        Yii::$app->request->get('page'), // page number
//                        Yii::$app->request->get('sort'), // sort list
//                        Yii::$app->request->get('cache'), // reset page -> setFlash -> getFlash
//                    ],
////                'dependency' => [
////                    'class' => 'yii\caching\DbDependency',
////                    'sql' => 'SELECT COUNT(*) FROM tbl_game WHERE publish_status=1',
////                ],
//            ],
//            [
//                'class' => 'yii\filters\HttpCache',
//                'only' => ['index'],
//                'lastModified' => function ($action, $params) {
//                        $q = new \yii\db\Query();
//                        return $q->from('post')->max('updated_at');
//                    },
//            ],

//            [
//                'class' => 'yii\filters\HttpCache',
//                'only' => ['view'],
//                'etagSeed' => function ($action, $params) {
//                        $post = $this->findModel(\Yii::$app->request->get('id'));
//                        return serialize([$post->title, $post->content]);
//                    },
//            ],
        ];
    }

    /**
     * Lists all Game models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = new Query();
        $query->select(['img','title','alias','id']);
        $query->from('tbl_game');
        //for guest we show only published pages
        if(Yii::$app->user->isGuest){
            $query->Where(['publish_status'=>Game::STATUS_PUBLISHED]);
        }
        $query->orderBy('updated_at ASC');

        //show all game list
        $gameProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 28,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $gameProvider,
        ]);

    }

    /**
     * Displays a single Game model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($alias)
    {
        //find game by alias
        $model = $this->findModel($alias);

        //find others games from this category(similar-games)

        $query = (new \yii\db\Query())
            ->from('tbl_game')
            ->where(['category_id'=>$model->category_id])
            ->andWhere(['not in', 'id', $model->id]);

        //for guest we show only published pages
        if(Yii::$app->user->isGuest){
            $query->andWhere(['publish_status'=>Game::STATUS_PUBLISHED]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 16,
            ],
        ]);

        //add +1 to counter of game
        //$model->updateCounters(['counter'=>1]);

        return $this->render('view', [
            'model' => $model,
            'similarDataProvider'=>$dataProvider,
        ]);
    }

    /*
     * when user add game to favorite he send request in this action
     */
    public function actionAddfavorite($id){

        $cookies = \Yii::$app->response->cookies;

        if (isset(\Yii::$app->request->cookies['favorite_games'])) {

            $favorite_games = json_decode(\Yii::$app->request->cookies['favorite_games']->value, true);

            if(!in_array($id, $favorite_games)){
                $favorite_games[] = $id;
            }

            // add a new cookie to the response to be sent
            $cookies->add(new \yii\web\Cookie([
                'name' => 'favorite_games',
                'value' => json_encode($favorite_games),
                'expire' => time() + 86400 * 365
            ]));
        }else{
            // add a new cookie to the response to be sent
            $cookies->add(new \yii\web\Cookie([
                'name' => 'favorite_games',
                'value' => json_encode([$id]),
                'expire' => time() + 86400 * 365
            ]));
        }

    }

    /*
     * show favorite games which user add to favorite list
     * $data = [1,2,3,4,5] - list of ID-games
     */
    public function actionMyfavorite(){

        if (isset(\Yii::$app->request->cookies['favorite_games'])) {

            $favorite_games_ids = json_decode(\Yii::$app->request->cookies['favorite_games']->value, true);

            $query = new Query();

            $dataProvider = new ArrayDataProvider([
                'allModels' => (new Query())->select(['id','img','alias','title'])->from('tbl_game')->where(['id'=>$favorite_games_ids])->all(),
                'pagination' => [
                    'pageSize' => 24,
                ],
            ]);
        }else{
            $dataProvider = new ArrayDataProvider();
        }

        //display favorite games of user, data gived from cookies
        return $this->render('my_favorite', ['dataProvider'=>$dataProvider]);

    }

    /*
     * user can delete selected games from favorite list
     */
    public function actionDeletefavoritegame($id){
        //read favorite-list of games user and delete from list $id element
        if (isset(\Yii::$app->request->cookies['favorite_games'])) {

            //get favorite list from cookies
            $favorite_games = json_decode(\Yii::$app->request->cookies['favorite_games']->value, true);

            //delete cheked element from array
            if(($key = array_search($id, $favorite_games)) !== false) {
                unset($favorite_games[$key]);
                //rewrite cookies
                \Yii::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => 'favorite_games',
                    'value' => json_encode($favorite_games),
                    'expire' => time() + 86400 * 365
                ]));
            }
            //if size of list is null - delete cookie
            if(sizeof($favorite_games)==0){
                $cookies = Yii::$app->response->cookies;
                $cookies->remove('favorite_games');
                unset($cookies['favorite_games']);
            }
        }
    }

    /*
     * full screen view game
     */
    public function actionFullscreen($id){

        $model = $this->findModelId($id);

        return $this->renderPartial('fullscreen', [
            'model' => $model,
        ]);
    }



    /**
     * Finds the Game model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Game the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($alias)
    {

        if(Yii::$app->user->isGuest){
            $model = Game::findOne(['alias'=>$alias,'publish_status'=>Game::STATUS_PUBLISHED]);
        }else{
            $model = Game::findOne(['alias'=>$alias]);
        }

        if ($model!== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelId($id)
    {

        if(Yii::$app->user->isGuest){
            $model = Game::findOne(['id'=>$id, 'publish_status'=>Game::STATUS_PUBLISHED]);
        }else{
            $model = Game::findOne(['id'=>$id]);
        }

        if ($model!== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

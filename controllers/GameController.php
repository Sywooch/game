<?php

namespace app\controllers;

use app\models\CategorySearch;
use Yii;
use app\models\Game;
use app\models\GameSearch;
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
                    'delete' => ['post'],
                ],
            ],
//            [
//                'class' => 'yii\filters\PageCache',
//                'only' => ['index'],
//                'duration' => 120,
//                'variations' => [
//                    \Yii::$app->language,
//                ],
////                'dependency' => [
////                    'class' => 'yii\caching\DbDependency',
////                    'sql' => 'SELECT COUNT(*) FROM tbl_game',
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

//        $games = Yii::$app->db->createCommand('SELECT id, title FROM tbl_game')->queryAll();
//
//        if($games){
//            foreach($games as $game){
//
//                $alias = Game::str2url($game['title']);
//
//                $params = [':id'=>$game['id'], ':alias'=>$alias];
//
//                Yii::$app->db->createCommand('UPDATE tbl_game SET alias=:alias WHERE id=:id')->bindValues($params)->execute();
//            }
//        }


        $searchModel = new GameSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /*
     * main page of site
     */
    public function actionMain(){

//        $parser = new \app\models\Parser();
//        $parser->parseGameCategory();

//        //show all category list
//        $queryCategory = \app\models\Category::find();
//        $categoryProvider = new ActiveDataProvider([
//            'query' => $queryCategory,
//            'pagination' => [
//                'pageSize' => 20,
//            ],
//        ]);
//
//        //show all game list
//        $queryGame = \app\models\Game::find();
//        $gameProvider = new ActiveDataProvider([
//            'query' => $queryGame,
//            'pagination' => [
//                'pageSize' => 200,
//            ],
//        ]);
//
//
//        return $this->render('main', [
//            'categoryProvider' => $categoryProvider,
//            'gameProvider'=>$gameProvider,
//        ]);



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
        $searchModel = new GameSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $similar = $searchModel->similarSearch($model->category_id, $model->id);

        return $this->render('view', [
            'model' => $model,
            'similarDataProvider'=>$similar,
        ]);
    }

    /**
     * Creates a new Game model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Game();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Game model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Game model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
        if (($model = Game::findOne(['alias'=>$alias])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

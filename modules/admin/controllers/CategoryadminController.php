<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.03.15
 * Time: 14:59
 */

namespace app\modules\admin\controllers;


use app\models\Category;
use app\models\CategorySearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;


class CategoryadminController extends Controller{

    public $defaultAction = 'index';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['logout'],
                'rules' => [
                    [
                        //'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /*
      * list of all games
      */
    public function actionIndex(){

        $searchModel = new CategorySearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Game model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $dir = Yii::getAlias('@app/web/');

        $model = new Category();

        $model->setScenario('create');

        if (Yii::$app->request->isPost) {

            $model->load(Yii::$app->request->post());

            $model->img = UploadedFile::getInstance($model, 'img');//image of category

            if ($model->validate()) {
                if($model->img){
                    $model->img->saveAs($dir.'/img/' . $model->img->baseName  . '.' . $model->img->extension);
                }

                $model->save();

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }



    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $dir = Yii::getAlias('@app/web/');

        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {

            $img = $model->img;

            $model->load(Yii::$app->request->post());

            $model->img = UploadedFile::getInstance($model, 'img');//image of category

            if ($model->validate()) {
                if($model->img){
                    $model->img->saveAs($dir.'/img/' . $model->img->baseName  . '.' . $model->img->extension);
                }else{
                    $model->img = $img;
                }

                $model->save();

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne(['id'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $category = $this->findModel($id);

        return $this->render('view', [
            'model' => $category,
        ]);
    }
} 
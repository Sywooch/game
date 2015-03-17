<?php

namespace app\controllers;

use app\models\Game;
use Yii;
use app\models\Category;
use app\models\CategorySearch;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\data\ActiveDataProvider;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{

    public $defaultAction = 'index';


    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($alias)
    {
        $category = $this->findModel($alias);

        $query = new Query();
        $query->select(['img','title','alias']);
        $query->from('tbl_game');
        $query->where(['category_id'=>$category->id]);

        //for guest we show only published pages
        if(Yii::$app->user->isGuest){
            $query->andWhere(['publish_status'=>Game::STATUS_PUBLISHED]);
        }


        //show all game list
        $gameProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 28,
            ],
        ]);

        return $this->render('view', [
            'model' => $category,
            'gameProvider'=>$gameProvider,
        ]);
    }


    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($alias)
    {
        if (($model = Category::findOne(['alias'=>$alias])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

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
    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($alias)
    {
        $category = $this->findModel($alias);

        $query = $category
            ->getGames()
            ->andWhere(['publish_status'=>Game::STATUS_PUBLISHED])
            ->andWhere(['<','updated_at', time()])
            ->orderBy('updated_at DESC');


        //show all game list
        $gameProvider = new ActiveDataProvider([
            'query' => $query,
            //'allmodels'=>$category->games,
            'pagination' => [
                'pageSize' => Yii::$app->params['params_category_page']['count_games_on_page'],
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
            throw new NotFoundHttpException('Не удалось найти указанную страницу.');
        }
    }
}

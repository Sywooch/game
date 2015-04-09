<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//use app\models\Game;

/**
 * GameSearch represents the model behind the search form about `app\models\Game`.
 */
class GameSearch extends Game
{

    public $category;
    public $updatedat;//переменная для фильтрации по дате, игр

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category','publish_status','updated_at'], 'integer'],
            [['id','title', 'category','updatedat','updated_at','publish_status','file', 'img','alias','pagetitle'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Game::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith(['gameCategory']);

        $this->load($params);


        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tbl_game.id' => $this->id,
        ]);

        $query->groupBy('tbl_game.id');



        //фильтр по дате поста, т.к. дата у нас в формате "time" в БД, а в форме лишь день-месяц-год, начинаем финтовать
        if(!empty($this->updatedat)){

            $beginOfDay = strtotime("midnight", strtotime($this->updatedat));
            $endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;

            $query->andWhere(['<','tbl_game.updated_at', $endOfDay]);
            $query->andWhere(['>','tbl_game.updated_at', $beginOfDay]);
        }

        $query->andFilterWhere([
            'tbl_game_category.category_id' => $this->category,
        ]);

        $query->andFilterWhere(['like', 'tbl_game.title', $this->title])
            ->andFilterWhere(['like', 'tbl_game.file', $this->file])
            ->andFilterWhere(['like', 'tbl_game.pagetitle', $this->pagetitle])
            ->andFilterWhere(['like', 'tbl_game.alias', $this->alias])
            ->andFilterWhere(['like', 'tbl_game.publish_status', $this->publish_status])
            ->andFilterWhere(['like', 'tbl_game.img', $this->img]);

        $dataProvider->pagination = [
            'defaultPageSize' => Yii::$app->params['admin']['count_game_on_page'],
            //'pageSizeLimit' => [12, 100],
        ];



        return $dataProvider;
    }

    public function similarSearch($category_id, $id){

        $query = (new \yii\db\Query())
            ->from('tbl_game')
            ->where(['category_id'=>$category_id])
             ->andWhere(['not in', 'id', $id]);

        //for guest we show only published pages
        if(Yii::$app->user->isGuest){
            $query->andWhere(['publish_status'=>self::STATUS_PUBLISHED]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
            ],
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $dataProvider->pagination = [
            'defaultPageSize' => 16,
        ];

        return $dataProvider;
    }
}

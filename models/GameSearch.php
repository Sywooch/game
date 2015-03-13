<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Game;

/**
 * GameSearch represents the model behind the search form about `app\models\Game`.
 */
class GameSearch extends Game
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['title', 'file', 'img'], 'safe'],
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
            'pagination' => [
                //'forcePageParam' => false,
                //'pageSizeParam' => false,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'file', $this->file])
            ->andFilterWhere(['like', 'img', $this->img]);

        $dataProvider->pagination = [
            'defaultPageSize' => 28,
            'pageSizeLimit' => [12, 100],
        ];

        return $dataProvider;
    }

    public function similarSearch($category_id, $id){

        //$query = Game::find();


        $query = (new \yii\db\Query())
            ->from('tbl_game')
            ->where(['category_id'=>$category_id])
             ->andWhere(['not in', 'id', $id]);


        //$query->andFilterWhere(['category_id' => $this->category_id]);

        //$query->limit(12);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                //'forcePageParam' => false,
                //'pageSizeParam' => false,
            ],
        ]);




        //$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


//        $query->andFilterWhere(['like', 'title', $this->title])
//            ->andFilterWhere(['like', 'file', $this->file])
//            ->andFilterWhere(['like', 'img', $this->img]);

        $dataProvider->pagination = [
            'defaultPageSize' => 16,
            //'pageSizeLimit' => [12, 100],
        ];

        return $dataProvider;
    }
}

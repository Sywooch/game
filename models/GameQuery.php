<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 29.03.15
 * Time: 14:40
 */

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

class GameQuery extends ActiveQuery
{

    public function selectMain(){
        $this->select(['tbl_game.img','tbl_game.title','tbl_game.alias','tbl_game.id']);
        return $this;
    }

    public function publish($status = Game::STATUS_PUBLISHED)
    {
        $this->andWhere(['tbl_game.publish_status' => $status]);
        return $this;
    }

//    public function category($category = '')
//    {
//        if($category){
//            $this->andWhere(['category_id' => $category]);
//            return $this;
//        }else{
//            return $this;
//        }
//    }

    public function timepublish()
    {
        $this->andWhere(['<','tbl_game.updated_at', time()]);
        return $this;
    }

    public function alias($alias){

        $this->andWhere(['alias' => $alias]);

        return $this;
    }


}
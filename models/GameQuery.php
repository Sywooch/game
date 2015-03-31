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
        $this->select(['img','title','alias','id']);
        return $this;
    }

    public function publish($status = Game::STATUS_PUBLISHED)
    {
        $this->andWhere(['publish_status' => $status]);
        return $this;
    }

    public function category($category = '')
    {
        if($category){
            $this->andWhere(['category_id' => $category]);
            return $this;
        }else{
            return $this;
        }
    }

    public function timepublish()
    {
        $this->andWhere(['<','updated_at', time()]);
        return $this;
    }

    public function alias($alias){

        $this->andWhere(['alias' => $alias]);

        return $this;
    }


}
<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $img
 *
 * @property Game[] $games
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'alias'], 'required'],
            [['title', 'alias'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 5255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название категории',
            'img' => 'Изображение',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGames()
    {
        return $this->hasMany(Game::className(), ['category_id' => 'id']);
    }

    /*
     * get all list category
     */
    static function getListCategory(){
        return Yii::$app->db->createCommand('SELECT title, alias FROM tbl_category')->cache(3600)->queryAll();
    }

    /*
     * dropdown list for menu
     */
    static function dropDownMenu(){

        $category_list = Category::getListCategory();
        $result = array();
        foreach($category_list as $category){
            $result[]=['label' => $category['title'], 'url' =>Url::to(['/category/view','alias'=>$category['alias']])];//
        }
        return $result;
    }

}

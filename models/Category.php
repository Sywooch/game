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
            [['title', 'img','description_meta','keyword_meta'], 'required', 'on'=>'create'],
            [['title', 'alias', 'description_meta','keyword_meta'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 5255],
            ['alias', 'filter', 'filter' => function ($value) {
                    // normalize alias input here
                    return Game::str2url($this->title);
                }],
            [['alias','title'], 'unique'],
            [['img'], 'file', 'skipOnEmpty' => true], // <--- here!
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
            'alias'=>'Урла категории',
            'img' => 'изображение категории',
            'keyword_meta'=>'Ключевые слова(мета)',
            'description_meta'=>'Описание(мета)',
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
        $result[]=['label' => 'Все категории', 'url' =>Url::to(['/categorys'])];//
        foreach($category_list as $category){
            $result[]=['label' => $category['title'], 'url' =>Url::to(['/category/view','alias'=>$category['alias']])];//
        }
        return $result;
    }

}

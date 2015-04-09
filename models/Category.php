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
            [['title', 'img','shot_title'], 'required', 'on'=>'create'],/*,'description_meta','keyword_meta'*/
            [['title', 'alias','shot_title', 'description_meta','keyword_meta'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 5255],
            ['alias', 'filter', 'filter' => function ($value) {
                    // normalize alias input here
                    return Game::str2url($this->title);
                }],
            [['alias','title','shot_title'], 'unique'],
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
            'shot_title'=>'Краткое название категории для списка категорий на всех страницах(меню)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getGameCategorys()
//    {
//        return $this->hasMany(GameCategory::className(), ['category_id' => 'id']);
//    }

    public function getGames(){
        return $this->hasMany(Game::className(), ['id' => 'game_id'])->viaTable(GameCategory::tableName(), ['category_id'=>'id']);
    }


    /*
     * get all list category
     */
    static function getListCategory(){
        return Yii::$app->db->createCommand('SELECT title, alias FROM tbl_category')->cache(3600)->queryAll();
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            foreach($this->getGames()->all() as $game){
                $game->delete();
            }
            return true;
        } else {
            return false;
        }
    }

    /*
     * select all category to show on all pages of site
     */
    static function categoryListMain(){
        return Yii::$app->db->createCommand('SELECT shot_title, alias, img FROM tbl_category ORDER BY shot_title')->queryAll();
    }
}

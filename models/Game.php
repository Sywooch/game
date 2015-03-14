<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "{{%game}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $file
 * @property string $img
 *
 * @property Category $category
 */
class Game extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%game}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'file', 'img','pagetitle','keywords','description','url', 'rules'], 'required'],
            [['category_id','counter'], 'integer'],
            [['title', 'file', 'img','pagetitle','description_meta','url', 'alias'], 'string', 'max' => 255],
            [['description', 'rules'], 'string', 'max' => 6255],
            // normalize "alias" input
            ['alias', 'filter', 'filter' => function ($value) {
                    // normalize alias input here
                    return self::str2url($this->title);
                }],
            [['alias','title'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'title' => 'Заголовок',
            'file' => 'Файл',
            'img' => 'Изображение',
            'counter'=>'Количество просмотров',
            'rules'=>'Как играть',
        ];
    }

    public function behaviors() {
        return [
            [
                'class' => \chiliec\vote\behaviors\RatingBehavior::className(),
                'model_name' => 'Game', // name of this model
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    function rus2translit($string) {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        );
        return strtr($string, $converter);
    }
    static function str2url($str) {
        // переводим в транслит
        $str = Game::rus2translit($str);
        // в нижний регистр
        $str = strtolower($str);
        // заменям все ненужное нам на "-"
        $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
        // удаляем начальные и конечные '-'
        $str = trim($str, "-");
        return $str;
    }

    /*
     * find similar games for current game in current category of game
     */
    public function similarGames($limit = 9){

        $queryGame = \app\models\Game::find();

        $gameProvider = new ActiveDataProvider([
            'query' => $queryGame,
            'pagination' => [
                'pageSize' => 24,
            ],
        ]);
    }
}

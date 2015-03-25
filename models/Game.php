<?php

namespace app\models;

use Yii;
//use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

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

    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%game}}';
    }

    public function behaviors()
    {
        return [
//            [
//                'class' => TimestampBehavior::className(),
//                'createdAtAttribute' => 'created_at',
//                'updatedAtAttribute' => 'updated_at',
//                'value' => time(),
//            ],
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
            ],
            [
                'class' => \chiliec\vote\behaviors\RatingBehavior::className(),
                'model_name' => 'Game', // name of this model
            ],
        ];
    }

    /**
     * @return string status
     */
    public function getStatus()
    {
        $statuses = self::getStatuses();
        return $statuses[$this->publish_status];
    }


    /**
     * @return int last changes timestamp
     */
    public function getLastChangesTimestamp()
    {
        return !empty($this->updated_at) ? date('d.m.Y',$this->updated_at) : date('d.m.Y',$this->created_at);
    }

    /**
     * @return array statuses
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_DRAFT => 'Черновик',
            self::STATUS_PUBLISHED => 'Опубликовано',
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'file', 'img','pagetitle','keywords','description','rules', 'publish_status','description_meta'], 'required','on'=>'create'],

            [['category_id','counter', 'updated_at', 'created_at','publish_status'], 'integer'],
            [['title', 'pagetitle','description_meta','url', 'alias'], 'string', 'max' => 255],
            [['description', 'rules'], 'string', 'max' => 6255],
            // normalize "alias" input
            ['alias', 'filter', 'filter' => function ($value) {
                    // normalize alias input here
                    return self::str2url($this->title);
                }],
            [['alias','title'], 'unique'],

            //validate upload files
            [['file'], 'file', 'skipOnEmpty' => true], // <--- here!
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
            'category_id' => 'Категория',
            'title' => 'Заголовок',
            'file' => 'Файл',
            'img' => 'Изображение',
            'counter'=>'Количество просмотров',
            'rules'=>'Как играть',
            'created_at'=>'Дата создания',
            'updated_at'=>'Дата обновления',
            //'status'=>'Статус',
            'publish_status'=>'Статус публикации',
            'keywords'=>'Ключевые слова',
            'description'=>'Описание',
            'description_meta'=>'Мета-описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    static function rus2translit($string) {
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

    public function getPathImg(){
        return Yii::getAlias('@app/'.Yii::$app->params['upload_image'].$this->img);
    }

    public function getPathFlash(){
        return Yii::getAlias('@app/'.Yii::$app->params['upload_flash'].$this->file);
    }

    public function afterDelete()
    {
        unlink($this->getPathImg());
        unlink($this->getPathFlash());
        parent::afterDelete();
    }
}

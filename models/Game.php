<?php

namespace app\models;

use Yii;
//use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use app\models\GameQuery;
use yii\db\ActiveRecord;
use yii\helpers\BaseArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
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

    //список констант для типов игры, на основании типа игры выводим кнопку для скачивания доп. плагина для игры, чтобы играть
    const TYPE_GAME_FLASH = 1;//тип игры флеши-игра(файл загружаем через форму)
    const TYPE_GAME_UNITY3D = 2;//тип игры unity 3d(файл загружаем через форму)
    const TYPE_GAME_CODE = 3;//типа игры будет не файл, а код вставки, который будет отображать игру на моей странице

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
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                    ActiveRecord::EVENT_BEFORE_INSERT => 'updated_at',
                    //ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
            ],
            [
                'class' => \chiliec\vote\behaviors\RatingBehavior::className(),
                'model_name' => 'Game', // name of this model
            ],
        ];
    }
    /*
     * return type of game
     */
    public function getType(){
        $statuses = self::getTypes();
        return $statuses[$this->type_game];
    }

    /**
     * @return string status
     */
    public function getStatus()
    {
        $statuses = self::getStatuses();
        return $statuses[$this->publish_status];
    }

    public function getUpdatedate(){
        return date('Y-m-d',$this->updated_at);
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

    /*
     * return array types
     */
    public static function getTypes(){
        return [
            self::TYPE_GAME_FLASH =>'Flash игра',
            self::TYPE_GAME_UNITY3D=>'Unity 3D игра',
            self::TYPE_GAME_CODE=>'Код для вставки игры(целиком код). Проставить размеры(width='.Yii::$app->params['width_game'].', height='.Yii::$app->params['height_game'].')',
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['category_id', 'title', 'img','pagetitle','keywords','description','rules', 'publish_status','description_meta','type_game'], 'required','on'=>'create'],

            //если выбрали тип игры-код вставки с др. сайта, то загружать файл игры не надо
            ['file', 'required', 'when' => function($model) {
                if($model->type_game){
                    if($model->type_game == Game::TYPE_GAME_FLASH || $model->type_game == Game::TYPE_GAME_UNITY3D){
                        return true;
                    }
                }
            }],

            ['game_code', 'required','when' => function($model) {
                if($model->type_game) {
                    return $model->type_game == Game::TYPE_GAME_CODE;
                }
            }],

            [['category_id','counter',  'created_at','publish_status','type_game'], 'integer'],

            [['updated_at','created_at'], 'default', 'value' => time()],

            [['file'],'default', 'value'=>''],

            [['title', 'pagetitle','description_meta','url', 'alias','keywords'], 'string', 'max' => 255],
            [['description', 'rules', 'game_code'], 'string', 'max' => 6255],
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
            'type_game'=>'Тип игры(unity 3D, Flash и т.д.)',
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

    private $_url;

    public function getUrl()
    {
        return Url::to(['/game/view','alias'=>$this->alias]);
    }

    /*
     * в зависимости от типа игры формируем ссылку для скачивания нужного плагина для игры
     * $params - доп. параметры при формировании ссылки
     */
    public function getPluginLink($params = []){
        //ссылка на плагин от Unity 3D
        if($this->type_game==self::TYPE_GAME_UNITY3D){
            if($params){
                $params = BaseArrayHelper::merge($params, ['alt'=>'Скачать плагин Unity3D']);
            }
            return Html::a('Скачать Unity3D', '/file/Unity3d.rar', $params);
        }
        //ссылка на плагин для флеша
        if($this->type_game==self::TYPE_GAME_FLASH){
            if($params){
                $params = BaseArrayHelper::merge($params, ['alt'=>'Скачать flash плагин']);
            }
            return Html::a('Скачать Флеш', 'http://get.adobe.com/flashplayer/', $params);
        }

        return '';
    }

    /*
     * в зависимости от типа игрухи формируем код для её вставки на сайт
     * $what_page - для какой страницы получаем код для отображения, для страницы просмотра не большие размеры флеш игр,
     * а для страницы на полный экран - ширина и длина игры должны быть максимальными
     */
    public function getCodegame($what_page = 'view'){

        //определимся с размерами для отображения
        if($what_page=='view'){
            //size game by params
            $width = Yii::$app->params['width_game'];
            $height = Yii::$app->params['height_game'];
        }else{
            //full size of game
            $width = '98%';
            $height = '98%';
        }

        //UNITY 3D  game
        if($this->type_game==self::TYPE_GAME_UNITY3D){
            return
                '<object classid="clsid:444785F1-DE89-4295-863A-D46C3A781394"
                    codebase="http://webplayer.unity3d.com/download_webplayer/UnityWebPlayer.cab#version=2,0,0,0" height="'.$height.'" id="UnityObject" width="'.$width.'">
                    <param name="backgroundcolor" />
                    <param name="bordercolor" value="000000" />
                    <param name="textcolor" value="FFFFFF" />
                    <embed height="'.$height.'" pluginspage="http://www.unity3d.com/unity-web-player-2.x"
                        src="/flash/'.$this->file.'" type="application/vnd.unity" width="'.$width.'">
                    </embed>
                </object>';
        }
        //Flash-game
        if($this->type_game == self::TYPE_GAME_FLASH){
            return
                '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" width="468" height="60" id="mymoviename">
                    <param name="movie" value="http://www.tizag.com/pics/example.swf" />
                    <param name="quality" value="high" />
                    <param name="wmode" value="direct" /
                    <param name="bgcolor" value="#ffffff" />
                    <embed src="/flash/'.$this->file.'" quality="high" bgcolor="#ffffff"
                           width="'.$width.'" height="'.$height.'"  wmode="direct"
                           name="mymoviename" align="" type="application/x-shockwave-flash"
                           pluginspage="http://www.macromedia.com/go/getflashplayer">
                    </embed>
                </object>';
        }

        //код игры с другого сайта, файл не загружали по игре
        if($this->type_game==self::TYPE_GAME_CODE){
            return $this->game_code;
        }
    }

    public static function find()
    {
        return new GameQuery(get_called_class());
    }
}

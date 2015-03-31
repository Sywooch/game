<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 31.03.15
 * Time: 21:35
 */

namespace app\components;

use yii\base\Widget;
use app\models\Category;

class CategoryWidget extends Widget{

    public $div_class;//класс для пунктов меню

    public $img_width;//ширина картинок для меню категорий
    public $img_height;//высота картинок для меню категорий

    public function init()
    {
        parent::init();
        if($this->div_class===null){
            $this->div_class = 'game-desc-pre category-menu';
        }
        if($this->img_height===null){
            $this->img_height = '55px';
        }

        if($this->img_width===null){
            $this->img_width = '46px';
        }

    }

    public function run()
    {
        $rows = Category::categoryListMain();

        return $this->render('_category',['param'=>$this,'data'=>$rows]);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.03.15
 * Time: 15:17
 */

use yii\helpers\Html;
use yii\widgets\ListView;


$this->title = 'Главная страница';
?>


<!--<div class="category-index">-->
<!---->
<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->
<?php
//// echo $this->render('_search', ['model' => $searchModel]);
//// a button group with items configuration
//echo yii\bootstrap\ButtonGroup::widget([
//    'buttons' => [
//        ['label' => 'КАтегория 1'],
//        ['label' => 'КАтегория 2'],
//    ]
//]);
//
//// button group with an item as a string
//echo yii\bootstrap\ButtonGroup::widget([
//    'buttons' => [
//        yii\bootstrap\Button::widget(['label' => 'A2222']),
//        ['label' => 'B3333'],
//    ]
//]);
//?>
<!---->
<!--    <p>Game list</p>-->
<!--    --><?//= ListView::widget([
//        'dataProvider' => $gameProvider,
//        'itemView' => '_game',
//    ]); ?>
<!---->
<!--<!-- http://www.yiiframework.com/doc-2.0/guide-output-data-widgets.html  -->-->
<!---->
<!---->
<!---->
<!---->
<!--<p>Category list:</p>-->
<?//= ListView::widget([
//    'dataProvider' => $categoryProvider,
//    'itemView' => '_category',
//    'options' => ['class' => 'list-view'],
//]); ?>
<!---->
<!--</div>-->

<?/*= Html::ul($categoryProvider, ['item' => function($item, $index) {
        return Html::tag(
            'li',
            $this->render('_category', ['item' => $item,'model'=>$i]),
            ['class' => 'post']
        );
    }])
*/?>
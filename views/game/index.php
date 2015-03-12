<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\ListView;
use yii\bootstrap\Carousel;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Games';
$this->params['breadcrumbs'][] = $this->title;


$this->registerMetaTag([
    'name' => 'description',
    'content' => 'some description'
]);

?>
<div class="game-index">

    <?php

    /*

    echo Carousel::widget([
        'items' => [
            // the item contains only the image
            '<img src="http://onlineguru.ru/i/online/headslider/top.png"/>',
            // equivalent to the above
            ['content' => '<img src="http://onlineguru.ru/f/online/genres/smallpic/softgames.png"/>'],
            // the item contains both the image and the caption
            [
                'content' => '<img src="http://twitter.github.io/bootstrap/assets/img/bootstrap-mdo-sfmoma-03.jpg"/>',
                'caption' => '<h4>This is title</h4><p>This is the caption text</p>',
                //'options' => [...],
        ],
    ]
]);*/

    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_game',

        'pager'        => [

            'firstPageLabel'    => 'Начало',

            'lastPageLabel'     => 'Конец',
//
//            'nextPageLabel'     => Glyph::icon(Glyph::ICON_STEP_FORWARD),
//
//            'prevPageLabel'     => Glyph::icon(Glyph::ICON_STEP_BACKWARD),

        ],
        //'summary'=>'',
        //'layout' => '{summary}\n{items}\n{pager}',
        'layout' => '{pager}<br>{items}',
    ]);
    ?>

</div>
<style>
    div.list-view>div{
        columns: 200px auto;
        display: inline-block;
    }
    div.title-game{
        width: 195px;
    }
</style>


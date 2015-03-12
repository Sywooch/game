<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use kartik\rating\StarRating;

/* @var $this yii\web\View */
/* @var $model app\models\Game */

$this->title = $model->title;



$this->registerMetaTag([
    'name' => 'keywords',
    'content'=>$model->keywords,
]);
$this->registerMetaTag([
    'name' => 'description',
    'content'=>$model->description_meta,
]);

//'description' => $model->description_meta

//$this->params['breadcrumbs'][] = ['label' => 'Игры', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->category->title, 'url' => Url::to(['/category/view','alias'=>$model->category->alias])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="game-desc">
        <?=$model->description;?>
    </div>

    <?php

/*    echo StarRating::widget([
        'name' => 'rating',
        'pluginOptions' => ['size' => 'lg']
    ]);*/


//    echo '<label class="control-label">Rating</label>';
//    echo StarRating::widget(['model' => $model, 'attribute' => 'rating',
//        'pluginOptions' => [
//            'glyphicon' => false
//        ]
//    ]);


    // Usage with ActiveForm and model
//    echo $form->field($model, 'rating')->widget(StarRating::classname(), [
//        'pluginOptions' => ['size'=>'lg']
//    ]);

    ?>

    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" width="468" height="60" id="mymoviename">

        <param name="movie" value="http://www.tizag.com/pics/example.swf" />

        <param name="quality" value="high" />

        <param name="bgcolor" value="#ffffff" />

        <embed src="/flash/<?=$model->file?>" quality="high" bgcolor="#ffffff"

               width="728" height="546"

               name="mymoviename" align="" type="application/x-shockwave-flash"

               pluginspage="http://www.macromedia.com/go/getflashplayer">


        </embed>

    </object>

    <p>
        <?php //echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /*echo Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */?>

    </p>


    <script type="text/javascript">(function() {
            if (window.pluso)if (typeof window.pluso.start == "function") return;
            if (window.ifpluso==undefined) { window.ifpluso = 1;
                var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
                var h=d[g]('body')[0];
                h.appendChild(s);
            }})();</script>
    <div class="pluso" data-background="transparent" data-options="big,square,line,horizontal,nocounter,theme=08" data-services="vkontakte,odnoklassniki,facebook,twitter,google,moimir"></div>


    <?php

/*
    echo \ijackua\sharelinks\ShareLinks::widget(
        [
            'viewName' => '@app/views/game/sharelinks.php'   //custom view file for you links appearance
        ]
    );
*/

    ?>


    <h4>Похожие игры</h4>
    <div class="game-index">
        <?php
            echo ListView::widget([
                'dataProvider' => $similarDataProvider,
                'itemView' => '_similar_game',
                //'summary'=>'',
                //'layout' => '{summary}\n{items}\n{pager}',
                'layout' => '{items}',
            ]);
        ?>
    </div>
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

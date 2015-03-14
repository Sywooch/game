<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\web\View;
use kartik\popover\PopoverX;
use ijackua\kudos\Kudos;
/* @var $this yii\web\View */
/* @var $model app\models\Game */

$this->title = $model->title;

$this->registerJsFile('http://userapi.com/js/api/openapi.js?116',['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerMetaTag([
    'name' => 'keywords',
    'content'=>$model->keywords,
]);
$this->registerMetaTag([
    'name' => 'description',
    'content'=>$model->description_meta,
]);

    //$this->params['breadcrumbs'][] = ['label' => 'Игры', 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->category->title, 'url' => Url::to(['/category/view','alias'=>$model->category->alias])];
    $this->params['breadcrumbs'][] = $this->title;
?>


<div class="game-view" >

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="game-flash">
        <div class="game-flash-file">
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
            <div class="game-flash-buttons">
                <div id="fullscreen">

                    <?=Html::a('Во весь экран',  [Url::to(['/game/fullscreen','id'=>$model->id])], ['class' => 'btn btn-primary flash-buttons', 'target'=>'_blank']);?>

                    <?=Html::a('Скачать плагин Unity3D', '/file/Unity3d.rar', ['class' => 'btn btn-primary  flash-buttons','alt'=>'Скачать плагин Unity3D', 'target'=>'_blank',]);?>

                    <?=Html::a('Не работает ?', ['/answer/'], ['class' => 'btn btn-primary  flash-buttons','target'=>'_blank','alt'=>'Не работает ?']);?>

                    <?php
                    echo Html::a('К моим играм','#', [
                        'class' => 'btn btn-primary  flash-buttons',
                        'onclick'=>"
                             $.ajax({
                                type     :'POST',
                                cache    : false,
                                url  : '".Url::to(['/game/addfavorite','id'=>$model->id])."',
                                success  : function(response) {
                                    alert('done');
                                }
                        });return false;",
                    ]);

                    ?>


                    <?php
                        // info
                        echo PopoverX::widget([
                            'header' => 'Управление игры  ',
                            'type' => PopoverX::TYPE_INFO,
                            'placement' => PopoverX::ALIGN_BOTTOM,
                            'content' => $model->rules,
                            'toggleButton' => ['label'=>'Как играть ?', 'class'=>'btn btn-primary  flash-buttons'],
                        ]);


                    echo \chiliec\vote\Display::widget([
                        'model_name' => 'Game', // name of current model
                        'target_id' => $model->id, // id of current element
                        // optional fields
                        'view_aggregate_rating' => false, // set true to show aggregate_rating
                        'mainDivOptions' => ['class' => 'text-center'], // div options
                        'classLike' => 'glyphicon glyphicon-thumbs-up', // class for like button
                        'classDislike' => 'glyphicon glyphicon-thumbs-down', // class for dislike button
                        'separator' => '&nbsp;', // separator between like and dislike button
                    ]);


//                    echo Kudos::widget(
//                        [
//                            'widgetId' => 'game', // unique id of widget on page, to allow more than one widget on the page
//                            'uid' => $model->id, // uid of Kudoable element, for stat count
//                            'count' => $model->rating, // initial Kudos value, to display
//                            'onAdded' => 'function (event) {
//  // JS callback on Kudo +1 , you can do what ever you want here
//  // for example send AJAX request to track stats
//  var uid = $(this).data("uid");
//  $.post("/kudo/plus/post/" + uid);}',
//                            'onRemoved' => 'function (event) {
//  // JS callback on Kudo -1, send another AJAX request to track stats
//  var uid = $(this).data("uid");
//  $.post("/kudo/minus/post/" + uid);}',
//                        ]);

//                    echo  Kudos::widget(
//                        [
//                            'widgetId' => 'post',
//                            'uid' => $model->id,
//                            'count' => $model->rating,
//                            'defaultClass' => 'glyphicon glyphicon-hand-right',
//                            'onAdded' => 'function (event) {
//        var uid = $(this).data("uid");
//        $(this).find(".icon").removeClass("icon-emo-thumbsup").addClass("icon-emo-beer");
//        $.post("/kudo/plus/post/" + uid);}',
//                            'onRemoved' => 'function (event) {
//        var uid = $(this).data("uid");
//        $(this).find(".icon").removeClass("icon-emo-beer").addClass("icon-emo-thumbsup");
//        $.post("/kudo/minus/post/" + uid);}',
//                        ]);
                    ?>
                </div>
            </div>

        </div>
    </div>

    <div class="social-likes" data-counters="no">
        <div class="facebook" title="Поделиться ссылкой на Фейсбуке">Facebook</div>
        <div class="twitter" title="Поделиться ссылкой в Твиттере">Twitter</div>
        <div class="mailru" title="Поделиться ссылкой в Моём мире">Мой мир</div>
        <div class="vkontakte" title="Поделиться ссылкой во Вконтакте">Вконтакте</div>
        <div class="odnoklassniki" title="Поделиться ссылкой в Одноклассниках">Одноклассники</div>
        <div class="plusone" title="Поделиться ссылкой в Гугл-плюсе">Google+</div>
    </div>


    <div class="game-desc">
        <pre><?=$model->description;?></pre>
    </div>


    <h3>Похожие игры</h3>
    <div class="game-index">
        <?php
            echo ListView::widget([
                'dataProvider' => $similarDataProvider,
                'itemView' => '_similar_game',
                'layout' => '{items}',
            ]);
        ?>
    </div>

    <!-- comments from vk-->
    <div id="vk_comments"></div>

    <?php
        $this->registerJs('VK.init({apiId: 4825408, onlyWidgets: true});',View::POS_END, 'myKey');
        $this->registerJs('VK.Widgets.Comments("vk_comments", {limit: 10, width: "665", attach: "*"});',View::POS_END, 'myKey1');
    ?>

</div>
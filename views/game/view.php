<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\web\View;
use kartik\popover\PopoverX;
use ijackua\kudos\Kudos;
/* @var $this yii\web\View */
/* @var $model app\models\Game */

    //чтобы не писать по всех играхах слово приставку к TITLE, добавим здесь
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

    $this->params['breadcrumbs'][] = ['label' => $model->category->title, 'url' => Url::to(['/category/view','alias'=>$model->category->alias])];
    $this->params['breadcrumbs'][] = $model->title;

    $title = $this->title;
    //заглушка дополнительное слово, посоветовали
    $this->title = 'Игра '.$this->title.' на '.Yii::$app->name;
?>


<div class="game-view" >

    <h1 class="text-warning"><?= Html::encode($title);?></h1>

    <div class="game-flash">

        <div class="game-flash-file">

            <?=$model->getCodegame('view');?>

            <div class="game-flash-buttons">

                <div id="fullscreen">

                    <?=Html::a('Во весь экран',  [Url::to(['/game/fullscreen','id'=>$model->id])], ['class' => 'btn btn-primary flash-buttons', 'target'=>'_blank']);?>

                    <?=$model->getPluginLink(['class' => 'btn btn-primary  flash-buttons', 'target'=>'_blank',]);?>

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
                                        location.reload();
                                    }
                            });return false;",
                        ]);
                    ?>


                    <?php
                        // info
                        echo PopoverX::widget([
                            'header' => 'Управление игры  ',
                            'type' => PopoverX::TYPE_INFO,
                            'placement' => PopoverX::ALIGN_RIGHT_BOTTOM,
                            'content' => $model->rules,
                            'toggleButton' => ['label'=>'Как играть ?', 'class'=>'btn btn-primary  flash-buttons'],
                        ]);

                        echo \chiliec\vote\Display::widget([
                            'model_name' => 'Game', // name of current model
                            'target_id' => $model->id, // id of current element
                            // optional fields
                            'view_aggregate_rating' => true, // set true to show aggregate_rating
                            'mainDivOptions' => ['class' => 'text-center','style'=>'font-size:28px'], // div options
                            'classLike' => 'glyphicon glyphicon-thumbs-up', // class for like button
                            'classDislike' => 'glyphicon glyphicon-thumbs-down', // class for dislike button
                            'separator' => '&nbsp;', // separator between like and dislike button
                        ]);
                    ?>
                </div>
            </div>

        </div>
    </div>

    <div class="social-likes" data-counters="no">

        <span class="text-info">Дата добавления: <?=$model->LastChangesTimestamp;?></span>

        <div class="facebook" title="Поделиться ссылкой на Фейсбуке">Facebook</div>
        <div class="twitter" title="Поделиться ссылкой в Твиттере">Twitter</div>
        <div class="mailru" title="Поделиться ссылкой в Моём мире">Мой мир</div>
        <div class="vkontakte" title="Поделиться ссылкой во Вконтакте">Вконтакте</div>
        <div class="odnoklassniki" title="Поделиться ссылкой в Одноклассниках">Одноклассники</div>
        <div class="plusone" title="Поделиться ссылкой в Гугл-плюсе">Google+</div>
    </div>

    <div class="game-desc">
        <div class="game-desc-pre">
            <?= Html::img('@web/img/'.$model['img'], ['alt' => $model['title'],'class'=>'img-rounded' , 'width'=>Yii::$app->params['width_image'], 'height'=>Yii::$app->params['height_image']]);?>
            <div class="game-desc-pre-text"><?=$model->description;?></div>
        </div>
    </div>

    <h3 class="text-info">Другие игры</h3>
    <div class="game-index">
        <?php
            echo ListView::widget([
                'dataProvider' => $similarDataProvider,
                'itemView' => '_game',
                'id'=>'main_game_list',
                'layout' => '{items}',
            ]);
        ?>

        <!-- comments from vk-->
        <div id="vk_comments"></div>
    </div>

    <?php
        $this->registerJs('VK.init({apiId: 4825408, onlyWidgets: true});',View::POS_END, 'myKey');
        $this->registerJs('VK.Widgets.Comments("vk_comments", {limit: 10, width: "890", attach: "*"});',View::POS_END, 'myKey1');
    ?>
</div>
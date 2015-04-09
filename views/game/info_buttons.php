<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 04.04.15
 * Time: 15:44
 */
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\popover\PopoverX;
?>
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
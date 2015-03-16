<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16.03.15
 * Time: 15:53
 */


use \yii\helpers\Html;
use \yii\helpers\Url;
?>
<div class="category-row">

    <?php


    echo Html::a(
        '<img src="/img/'.$model->img.'" alt="'.$model->title.'" class="img-rounded" width="234px" height="160px">',
        Url::to(['/category/view','alias'=>$model->alias])
    );


    ?>



    <div class="title-game"><?=Html::a($model->title, Url::to(['/category/view','alias'=>$model->alias]));?></div>
</div>

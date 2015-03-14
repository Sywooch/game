<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.03.15
 * Time: 16:50
 */
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="game">


    <?= Html::a(Html::img('@web/img/'.$model['img'], ['alt' => 'My logo','width'=>'234px', 'height'=>'160px']),Url::to(['/game/view', 'alias'=>$model['alias']]), ['style'=>'margin:0 auto;']); ?>

    <div class="title-game"><?= Html::a(Html::encode($model['title']),Url::to(['/game/view', 'alias'=>$model['alias']])); ?></div>

</div>
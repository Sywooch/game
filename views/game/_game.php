<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.03.15
 * Time: 15:52
 */
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="game">

    <?= Html::img('@web/img/'.$model->img, ['alt' => 'My logo']) ?>

    <div class="title-game"><?= Html::a(Html::encode($model->title),Url::to([$model->alias])); ?></div>
</div>


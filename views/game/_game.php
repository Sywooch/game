<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.03.15
 * Time: 15:52
 */
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="post">

    <?= Html::img('@web/images/'.$model->image, ['alt' => 'My logo']) ?>

    <h2><?= Html::encode($model->title) ?></h2>

<!--    --><?//= HtmlPurifier::process($model->text) ?>
</div>


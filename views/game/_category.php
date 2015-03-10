<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.03.15
 * Time: 15:49
 */
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="post">
    <h2><?= Html::encode($model->title) ?></h2>

    <?= HtmlPurifier::process($model->text) ?>
</div>
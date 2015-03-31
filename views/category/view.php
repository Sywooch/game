<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $model->keyword_meta
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => $model->description_meta
]);
?>
<div class="game-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="game-desc">
        <div class="game-desc-pre"><?=$model->description;?></div>
    </div>
    <div class="game-index">
        <?php
            echo ListView::widget([
                'dataProvider' => $gameProvider,
                'itemView' => '_game',
                'id'=>'main_game_list',
                'pager'        => [
                    'firstPageLabel'    => 'Начало',
                    'lastPageLabel'     => 'Конец',
                ],
                'layout' => '{pager}<br>{items}<br>{pager}',
            ]);
        ?>
    </div>
</div>



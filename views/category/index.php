<?php

use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
    $this->registerMetaTag([
        'name' => 'keywords',
        'content' => $searchModel->keyword_meta
    ]);

    $this->registerMetaTag([
        'name' => 'description',
        'content' => $searchModel->description_meta
    ]);
    $this->title = 'Разделы';
    $this->params['breadcrumbs'][] = $this->title;
?>

<div class="game-index">
    <?php
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_category',
            'id'=>'main_game_list',
            'layout' => '{pager}<br>{items}<br>{pager}',
            'pager'        => [
                'firstPageLabel'    => 'Начало',
                'lastPageLabel'     => 'Конец',
            ],
        ]);
    ?>
</div>

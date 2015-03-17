<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Разделы';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="game-index">

    <?php

    echo ListView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'itemView' => '_category',
        'layout' => '{pager}<br>{items}',
        'pager'        => [
            'firstPageLabel'    => 'Начало',
            'lastPageLabel'     => 'Конец',
        ],
    ]);
    ?>
</div>
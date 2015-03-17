<?php

use yii\helpers\Html;
use yii\grid\GridView;
//use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Разделы';
$this->params['breadcrumbs'][] = $this->title;
?>

<p><?= Html::a('Добавить раздел', ['create'], ['class' => 'btn btn-success']) ?></p>

<div class="game-index">

    <?php

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'title',
            'alias',
            ['class' => 'yii\grid\ActionColumn'],
        ]
    ]);
    ?>
</div>

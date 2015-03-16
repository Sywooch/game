<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16.03.15
 * Time: 10:19
 */
use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'Управление играми';
?>
<div class="gameadmin-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Html::a('Добавить игру', ['create'], ['class' => 'btn btn-success']) ?></p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],

        'id',
        'title',
        'pagetitle',
        'alias',
        'status',
        //'img',

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>

</div>
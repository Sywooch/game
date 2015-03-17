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
        //'status',

        [
            'label'=>'Статус',
            'value'=>'status',
            'attribute' => 'publish_status',
            'filter' => Html::activeDropDownList(
                    $searchModel,
                    'publish_status',
                    [\app\models\Game::STATUS_DRAFT=>'Черновик', \app\models\Game::STATUS_PUBLISHED=>'Опубликован'],
                    ['class' => 'form-control','prompt'=>'']
                )
        ],

        [
            'label'=>'Раздел',
            'attribute' => 'category',
            'value' => 'category.title',
            'filter' => Html::activeDropDownList(
                    $searchModel,
                    'category_id',
                    \yii\helpers\ArrayHelper::map(\app\models\Category::find()->all(),'id','title'),
                    ['class' => 'form-control','prompt'=>'']
                )
        ],

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>

</div>
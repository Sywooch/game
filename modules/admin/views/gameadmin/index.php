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
        [
            'label'=>'ID',
            'value'=>'id',
            'attribute'=>'id',
            'contentOptions'=>['style'=>'width:90px']
        ],
        'title',
        'pagetitle',
        'alias',
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
            'format' => 'raw',
            'attribute' => 'categorys',
            'value' => function($data){
                $buttons = [];
                foreach($data->relationCategory as $category){
                    $buttons[] = ['label'=>$category->title,'options'=>['class'=>'btn btn-success']];
                }
                return  \yii\bootstrap\ButtonGroup::widget([
                    'buttons' => $buttons,
                    'options' => ['class' => 'btn-group-xs danger']
                ]);
            },
            'filter' => Html::activeDropDownList(
                $searchModel,
                'category',
                \yii\helpers\ArrayHelper::map(\app\models\Category::find()->all(),'id','title'),
                ['class' => 'form-control','prompt'=>'']
            )
        ],
        [
            'label'=>'Отредактирован',
            'value'=>'updatedate',
            'attribute'=>'updatedat',
            'format' => 'raw',
            'filter' => \yii\jui\DatePicker::widget([
                'model'=>$searchModel,
                'attribute'=>'updatedat',
                'language' => 'ru',
                'dateFormat' => 'yyyy-MM-dd'
            ]),
        ],

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>

</div>
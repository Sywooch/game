<?php
use yii\helpers\Html;
use yii\widgets\ListView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\GameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Флеш игры бесплатно дл всех на '.Yii::$app->name;
//$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'keyword',
    'content' => 'Флеш игры бесплатно для всех'
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Играй бесплатно онлайн в самые популярные флеш игры для всех, которые мы специально выбрали,
    и добавили на сайт!
    Только у нас вы найдете самые интересные и увлекательные игры для всех возрастов, которые не заставят вас скучать.'
]);


?>
<div class="game-index">
    <?php
    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_game',
        'pager'        => [
            'firstPageLabel'    => 'Начало',
            'lastPageLabel'     => 'Конец',
        ],
        'layout' => '{pager}<br>{items}{pager}',
    ]);
    ?>
</div>
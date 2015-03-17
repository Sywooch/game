<?php
use yii\helpers\Html;
use yii\widgets\ListView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\GameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Games';
//$this->params['breadcrumbs'][] = $this->title;


$this->registerMetaTag([
    'name' => 'description',
    'content' => 'some description'
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
        'layout' => '{pager}<br>{items}',
    ]);
    ?>
</div>
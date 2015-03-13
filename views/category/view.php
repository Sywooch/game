<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Разделы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
            //echo  Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary'])
        ?>
        <?php
        /*echo  Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])*/
        ?>
    </p>

</div>


<div class="game-index">

    <?php

    echo ListView::widget([
        'dataProvider' => $gameProvider,
        'itemView' => '_game',
        'pager'        => [

            'firstPageLabel'    => 'Начало',

            'lastPageLabel'     => 'Конец',
//
//            'nextPageLabel'     => Glyph::icon(Glyph::ICON_STEP_FORWARD),
//
//            'prevPageLabel'     => Glyph::icon(Glyph::ICON_STEP_BACKWARD),

        ],
        //'summary'=>'',
        //'layout' => '{summary}\n{items}\n{pager}',
        'layout' => '{pager}<br>{items}',
    ]);
    ?>

</div>
<style>

</style>

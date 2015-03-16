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


    <div class="game-desc">
        <span class="game-desc-pre"><?=$model->description;?></span>
    </div>

</div>


<div class="game-index">

    <?php

    echo ListView::widget([
        'dataProvider' => $gameProvider,
        'itemView' => '_game',
        'pager'        => [
            'firstPageLabel'    => 'Начало',
            'lastPageLabel'     => 'Конец',
        ],
        'layout' => '{pager}<br>{items}',
    ]);
    ?>
</div>
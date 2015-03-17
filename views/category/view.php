<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Разделы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'keyword',
    'content' => $model->keyword_meta
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => $model->description_meta
]);


?>
<div class="category-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="game-desc">
        <div class="game-desc-pre"><?=$model->description;?></div>
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
        'layout' => '{pager}<br>{items}<br>{pager}',
    ]);
    ?>
</div>
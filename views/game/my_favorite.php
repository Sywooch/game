<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.03.15
 * Time: 16:25
 */
use yii\widgets\ListView;

$this->title = 'Games';
$this->params['breadcrumbs'][] = 'Избранные игры';


$this->registerMetaTag([
    'name' => 'description',
    'content' => 'some description'
]);
?>

<h2>Избранные игры</h2>

<div class="game-index">
    <?php
    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_game_array',
        'pager'        => [
            'firstPageLabel'    => 'Начало',
            'lastPageLabel'     => 'Конец',
        ],
        'layout' => '{pager}<br>{items}',
    ]);
    ?>
</div>
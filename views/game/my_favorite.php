<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.03.15
 * Time: 16:25
 */
use yii\widgets\ListView;

$this->title = 'Мои избранные игры на '.strtoupper(Yii::$app->name);

$this->params['breadcrumbs'][] = 'Избранные игры';

$this->registerMetaTag([
    'name' => 'description',
    'content' => Yii::$app->params['params_main_page']['desc']
]);

$this->registerMetaTag([
    'name' => 'keyword',
    'content' => Yii::$app->params['params_main_page']['keywords']
]);
?>

<h2>Избранные игры</h2>

<div class="game-index">
    <?php
    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_game_array',
        'id'=>'main_game_list',
        'pager'        => [
            'firstPageLabel'    => 'Начало',
            'lastPageLabel'     => 'Конец',
        ],
        'layout' => '{pager}<br>{items}<br>{pager}',
    ]);
    ?>
</div>
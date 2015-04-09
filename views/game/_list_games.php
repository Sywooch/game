<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 04.04.15
 * Time: 15:48
 */

use yii\widgets\ListView;

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_game',
    'id'=>'main_game_list',
    'layout' => '{items}',
]);
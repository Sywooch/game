<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.03.15
 * Time: 13:59
 */
use yii\bootstrap\Collapse;

echo Collapse::widget([
    'items' => [
        // equivalent to the above
        [
            'label' => 'Вопрос #1',
            'content' => 'ответ на вопрос...',
            // open its content by default
            'contentOptions' => ['class' => 'in']
        ],
        // another group item
        [
            'label' => 'Вопрос #2',
            'content' => 'Ответ на вопрос №2...',
            //'contentOptions' => [...],
        //'options' => [...],
],
    ]
]);
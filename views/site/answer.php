<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.03.15
 * Time: 13:59
 */
use yii\bootstrap\Collapse;
use yii\helpers\Html;

echo Collapse::widget([
    'items' => [
        // equivalent to the above
        [
            'label' => 'Если вы испытываете какие-либо трудности с отображением или загрузкой игры ?',
            'content' => 'Вам необходимо обновить версию  ' .Html::a('Adobe Flash Player','http://get.adobe.com/flashplayer/', ['target'=>'_blank']).'  на официальном сайте компании Adobe',
            // open its content by default
            'contentOptions' => ['class' => 'in']
        ],
        // another group item
        [
            'label' => 'В случае, если игра долго грузится ?',
            'content' => 'Наберитесь терпения и дождитесь окончания загрузки.',
            //'contentOptions' => [...],
            //'options' => [...],
        ],
        [
            'label' => 'Возникли проблемы с отображением флеш-игры, но при этом у вас выполнены первые 2 пункта ?',
            'content' => 'Попробуйте отключить AdBlock. Либо другие плагины или дополнения в вашем браузере, которые могут блокировать содержимое сайта',
            //'contentOptions' => [...],
            //'options' => [...],
        ],

    ]
]);

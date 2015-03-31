<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.03.15
 * Time: 13:59
 */
use yii\bootstrap\Collapse;
use yii\helpers\Html;

?>
<div class="game-index">

    <?php
    echo Collapse::widget([
        'items' => [
            // equivalent to the above
            [
                'label' => 'Если вы испытываете какие-либо трудности с отображением или загрузкой игры ?',
                'content' => 'Вам необходимо обновить версию  ' .Html::a('Adobe Flash Player','http://get.adobe.com/flashplayer/', ['target'=>'_blank']).'
                на официальном сайте компании Adobe. <br>Также можем вам посоветовать  '.Html::a('Скачать плагин Unity3D', '/file/Unity3d.rar', ['class' => 'btn btn-primary','alt'=>'Скачать плагин Unity3D', 'target'=>'_blank',]),
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
            [
                'label' => 'Хотите хранить список любимых игр без регистрации ?',
                'content' => 'На странице каждой игры есть кнопочка "К моим играм", нажав на неё вы добавите выбранную игру к вашему списку игр.
                Список добавленных вами игр будет отображаться в вверхнем меню сайта.',
                //'contentOptions' => [...],
                //'options' => [...],
            ],


        ]
    ]);
    ?>
</div>
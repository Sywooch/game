<?php

use yii\helpers\Html;
use yii\helpers\Url;

use yii\web\View;

//use ijackua\kudos\Kudos;
/* @var $this yii\web\View */
/* @var $model app\models\Game */

    //чтобы не писать по всех играхах слово приставку к TITLE, добавим здесь
    $this->title = $model->title;

    $this->registerJsFile('http://userapi.com/js/api/openapi.js?116',['depends' => [\yii\web\JqueryAsset::className()]]);

    $this->registerMetaTag([
        'name' => 'keywords',
        'content'=>$model->keywords,
    ]);
    $this->registerMetaTag([
        'name' => 'description',
        'content'=>$model->description_meta,
    ]);

    //если лишь к одной кактегории подвязана игра - выводим в "крошках" название и ссылку на эту категорию
    // если игра подвязана к нескольким категориям, то не выводим категории
    $category_link = $model->getBreakcrumbsLinkCategory();

    if(!empty($category_link)){ $this->params['breadcrumbs'][] = $category_link ;}


    $this->params['breadcrumbs'][] = $model->title;

    $title = $this->title;
    //заглушка дополнительное слово, посоветовали
    $this->title = 'Игра '.$this->title.' на '.Yii::$app->name;
?>


<div class="game-view" >

    <h1 class="text-warning"><?= Html::encode($title);?></h1>

    <div class="game-flash">

        <div class="game-flash-file">

            <?=$model->getCodegame('view');?>

            <div class="game-flash-buttons">
                <?=$this->render('info_buttons', ['model'=>$model])?>
            </div>

        </div>
    </div>

    <div class="social-likes" data-counters="no">

        <span class="text-info">Дата добавления: <?=$model->LastChangesTimestamp;?></span>

        <?php echo $this->render('social_btn');?>
    </div>

    <div class="game-desc">
        <div class="game-desc-pre">
            <?= Html::img('@web/img/'.$model['img'], ['alt' => $model['title'],'class'=>'img-rounded' , 'width'=>Yii::$app->params['width_image'], 'height'=>Yii::$app->params['height_image']]);?>
            <div class="game-desc-pre-text"><?=$model->description;?></div>
        </div>
    </div>

    <h3 class="text-info">Другие игры</h3>
    <div class="game-index">

        <?php echo $this->render('_list_games', ['dataProvider'=>$similarDataProvider]);?>

        <!-- comments from vk-->
        <div id="vk_comments"></div>
    </div>

    <?php
        $this->registerJs('VK.init({apiId: 4825408, onlyWidgets: true});',View::POS_END, 'myKey');
        $this->registerJs('VK.Widgets.Comments("vk_comments", {limit: 10, width: "890", attach: "*"});',View::POS_END, 'myKey1');
    ?>
</div>
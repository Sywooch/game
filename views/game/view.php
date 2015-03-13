<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use kartik\rating\StarRating;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $model app\models\Game */

$this->title = $model->title;

$this->registerJsFile('http://userapi.com/js/api/openapi.js?116',['depends' => [\yii\web\JqueryAsset::className()]]);



// Просто подключаем один файл:

//$this->registerCssFile('@app/assets/css/style.css');
//
//// Фрагмент:
//$this->registerJs('alert("message");', self::POS_READY, 'myKey');
//$this->registerCss('.class{color: red;}');


$this->registerMetaTag([
    'name' => 'keywords',
    'content'=>$model->keywords,
]);
$this->registerMetaTag([
    'name' => 'description',
    'content'=>$model->description_meta,
]);

//'description' => $model->description_meta

//$this->params['breadcrumbs'][] = ['label' => 'Игры', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->category->title, 'url' => Url::to(['/category/view','alias'=>$model->category->alias])];
$this->params['breadcrumbs'][] = $this->title;
?>





<div class="game-view" >

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="game-desc">
        <?=$model->description;?>
    </div>

    <?php




//    echo '<label class="control-label">Rating</label>';
//    echo StarRating::widget(['model' => $model, 'attribute' => 'rating',
//        'pluginOptions' => [
//            'glyphicon' => false
//        ]
//    ]);


    // Usage with ActiveForm and model
//    echo $form->field($model, 'rating')->widget(StarRating::classname(), [
//        'pluginOptions' => ['size'=>'lg']
//    ]);

    ?>

    <div class="game-flash">
        <div class="game-flash-file">
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" width="468" height="60" id="mymoviename">
                <param name="movie" value="http://www.tizag.com/pics/example.swf" />
                <param name="quality" value="high" />
                <param name="bgcolor" value="#ffffff" />
                <embed src="/flash/<?=$model->file?>" quality="high" bgcolor="#ffffff"
                       width="728" height="546"
                       name="mymoviename" align="" type="application/x-shockwave-flash"
                       pluginspage="http://www.macromedia.com/go/getflashplayer">
                </embed>
            </object>
            <div class="game-flash-buttons">
                <div id="fullscreen">
<!--                    <a href="#" onclick="ResizeFlash(546, 728); return false" rel="nofollow">Во весь экран</a>,'style'=>'width:181px;'  -->
                    <?=Html::a('Во весь экран', '#', ['class' => 'btn btn-primary flash-buttons','rel'=>'nofollow']);?>

                    <?=Html::a('Скачать плагин Unity3D', '/file/Unity3d.rar', ['class' => 'btn btn-primary  flash-buttons','alt'=>'Скачать плагин Unity3D', 'target'=>'_blank',]);?>

                    <?=Html::a('Не работает ?', ['/answer/'], ['class' => 'btn btn-primary  flash-buttons','target'=>'_blank','alt'=>'Не работает ?']);?>


                    <?=Html::a('К моим играм', '#', ['class' => 'btn btn-primary  flash-buttons','alt'=>'Добавить в избранное']);?>


                </div>
            </div>

        </div>
    </div>


    <p>
        <?php //echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /*echo Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */?>

    </p>
<?php
/*    echo StarRating::widget([
    'name' => 'rating',
    'pluginOptions' => ['size' => 'lg','disabled'=>true,]
    ]);
*/
?>




    <div class="social-likes" data-counters="no">
        <div class="facebook" title="Поделиться ссылкой на Фейсбуке">Facebook</div>
        <div class="twitter" title="Поделиться ссылкой в Твиттере">Twitter</div>
        <div class="mailru" title="Поделиться ссылкой в Моём мире">Мой мир</div>
        <div class="vkontakte" title="Поделиться ссылкой во Вконтакте">Вконтакте</div>
        <div class="odnoklassniki" title="Поделиться ссылкой в Одноклассниках">Одноклассники</div>
        <div class="plusone" title="Поделиться ссылкой в Гугл-плюсе">Google+</div>
    </div>


    <h4>Похожие игры</h4>
    <div class="game-index">
        <?php
            echo ListView::widget([
                'dataProvider' => $similarDataProvider,
                'itemView' => '_similar_game',
                //'summary'=>'',
                //'layout' => '{summary}\n{items}\n{pager}',
                'layout' => '{items}',
            ]);
        ?>
    </div>



    <!-- блок комментариев  https://vk.com/dev/Comments -->

    <!-- Put this div tag to the place, where the Comments block will be -->
    <div id="vk_comments"></div>

    <?php
        $this->registerJs('VK.init({apiId: 4825408, onlyWidgets: true});',View::POS_END, 'myKey');
        $this->registerJs('VK.Widgets.Comments("vk_comments", {limit: 10, width: "665", attach: "*"});',View::POS_END, 'myKey1');
    ?>

    <script type="text/javascript">



    </script>

</div>


<style>

</style>




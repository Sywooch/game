<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<h1>Бесплатные игры для всех на <?=Yii::$app->name;?></h1>

<div class="game-index">

    <div class="game-desc-pre">
        <?=Yii::$app->params['params_main_page']['text_desc_on_main_page'];?>
    </div>

    <h2>Новые игры</h2>

    <?php echo $this->render('_list_games', ['dataProvider'=>$dataProvider]);?>
</div>
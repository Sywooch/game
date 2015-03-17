<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use \app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Game */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="game-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php
        $category = Category::find()->all();
        $listData=ArrayHelper::map($category,'id','title');
        echo $form->field($model, 'category_id')->dropDownList($listData,['prompt'=>'Select...']);
    ?>

    <?php
    echo $form->field($model, 'publish_status')->dropDownList(\app\models\Game::getStatuses());
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'pagetitle')->textInput(['maxlength' => 255]) ?>


    <?= $form->field($model, 'keywords')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'rules')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'description')->textarea(['cols'=>5, 'rows'=>10]) ?>


    <?= $form->field($model, 'description_meta')->textarea(['cols'=>5, 'rows'=>5]) ?>


    <?= $form->field($model, 'file')->fileInput() ?>

    <?php
    //if exist file show into form
    if(file_exists('flash/'.$model->file)){
        echo Html::a('Ссылка на файл',['/flash/'.$model->file], ['target'=>'_blank']);
    }
    ?>

<br><br>

    <?= $form->field($model, 'img')->fileInput() ?>

    <?php
    //if exist file show into form
    if(file_exists(Yii::getAlias('@app/web/').'img/'.$model->img)){
        echo Html::img('/img/'.$model->img);
    }
    ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

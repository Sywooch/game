<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'shot_title')->textInput(['maxlength' => 40]) ?>



    <?= $form->field($model, 'description_meta')->textarea(['cols' => 5,'rows'=>5]) ?>

    <?= $form->field($model, 'keyword_meta')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'description')->textarea(['cols' => 5,'rows'=>5]) ?>

    <?= $form->field($model, 'img')->fileInput() ?>


    <?php
    //if exist file show into form
    if(file_exists(Yii::getAlias('@app/').Yii::$app->params['upload_image'].$model->img)){
        echo Html::img('/img/'.$model->img);
    }
    ?>
    <br><br>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

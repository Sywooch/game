<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Game */
/* @var $form yii\widgets\ActiveForm */

?>



<div class="game-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'enableClientValidation'=>false, ]); ?>

    <?php

        echo Html::tag('div',

            $form->field($model,'categorys')->checkboxList($listCategory,[

                    'item'=>function($index, $label, $name, $checked, $value){

                        $checkbox = Html::checkbox($name, $checked, ['value'=>$value]);

                        if($checked){ $label_checked = 'active';}else{$label_checked='';}

                        return Html::tag('div', Html::label($checkbox. $label), ['class'=>'btn btn-primary '.$label_checked, 'autocomplete'=>'off']);
                    },
                ]
            ),
            ['class'=>'btn-group', 'data-toggle'=>'buttons']
        );
    ?>

    <?php echo $form->field($model, 'publish_status')->dropDownList(\app\models\Game::getStatuses());?>

    <?= $form->field($model, 'updated_at')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
        'clientOptions' => [
            'defaultDate' =>date('Y-m-d'),
            'changeMonth'=> true,
            'changeYear'=> true,
            'autoSize'=>true,
        ]
    ]) ?>

    <?php echo $form->field($model, 'type_game')->dropDownList(\app\models\Game::getTypes());?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'pagetitle')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'rules')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'description')->textarea(['cols'=>5, 'rows'=>10,'onkeyup'=>'str=this.value;count(str);']) ?>

    <p>без пробелов и переводов строк <b id="b2">0</b></p>

    <?= $form->field($model, 'description_meta')->textarea(['cols'=>5, 'rows'=>5]) ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <?= $form->field($model, 'game_code')->textarea(['cols'=>5, 'rows'=>5]) ?>

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
    if(file_exists(Yii::getAlias('@app/').Yii::$app->params['upload_image'].$model->img)){
        echo Html::img('/img/'.$model->img);
    }
    ?>

    <br><br>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php echo Html::a('Удалить',\yii\helpers\Url::to(['/admin/gameadmin/delete/','id'=>$model->id]), ['class'=>'btn btn-success', 'style'=>'margin-left:30px;']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script language="javascript">
    var str='';
    function count(str)
    {

        document.getElementById('b2').innerHTML=str.replace(/\s/g,'').length;
        var st = str.replace(/\n/g,' ') + ' ';
        st = st.split(/\s* \s*/).length;
        return false;
    }
</script>

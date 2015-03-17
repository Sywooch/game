<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.03.15
 * Time: 15:17
 */
use \yii\widgets\DetailView;

$this->title = 'Разделы';

$this->params['breadcrumbs'][] = ['label' => 'Разделы', 'url' => ['index']];

$this->params['breadcrumbs'][] = $model->title;



echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'title',               // title attribute (in plain text)
        'alias',
        'description:html',    // description attribute in HTML
        'description_meta', // creation date formatted as datetime
        'keyword_meta',
        [
            'attribute'=>'img',
            'value'=>'/img/'.$model->img,
            'format' => ['image',['width'=>'200','height'=>'200']],
        ],
    ],
]);
?>




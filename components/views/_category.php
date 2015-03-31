<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 31.03.15
 * Time: 21:40
 */
use yii\helpers\Html;
use yii\helpers\Url;
?>
<ul id="category_list">
    <?php
    if(isset($data)){
        foreach($data as $row){
            ?>
            <li>
                <div class="<?=$param->div_class;?>">
                    <?=Html::a(Html::img('/img/'.$row['img'],['width'=>$param->img_width, 'height'=>$param->img_height]).'<br>'.$row['shot_title'],Url::to(['/category/view','alias'=>$row['alias']]));?>
                </div>
            </li>
            <?php
        }
    }
    ?>
</ul>
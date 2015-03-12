<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.03.15
 * Time: 14:52
 */
use ijackua\sharelinks\ShareLinks;
use \yii\helpers\Html;
use \yii\helpers\Url;

/**
 * @var yii\base\View $this
 */

?>
asdfasdfsadf
<div class="socialShareBlock">

    <?=
    Html::a('1<i class="icon-facebook-squared"></i>', $this->context->shareUrl(ShareLinks::SOCIAL_FACEBOOK),
        ['title' => 'Share to Facebook']) ?>
    <?=
    Html::a('2<i class="icon-twitter-squared"></i>', $this->context->shareUrl(ShareLinks::SOCIAL_TWITTER),
        ['title' => 'Share to Twitter']) ?>
    <?=
    Html::a('3<i class="icon-linkedin-squared"></i>', $this->context->shareUrl(ShareLinks::SOCIAL_LINKEDIN),
        ['title' => 'Share to LinkedIn']) ?>
    <?=
    Html::a('4<i class="icon-gplus-squared"></i>', $this->context->shareUrl(ShareLinks::SOCIAL_GPLUS),
        ['title' => 'Share to Google Plus']) ?>
    <?=
    Html::a('5<i class="icon-vkontakte"></i>', $this->context->shareUrl(ShareLinks::SOCIAL_VKONTAKTE),
        ['title' => 'Share to Vkontakte']) ?>
    <?=
    Html::a('6<i class="icon-tablet"></i>', $this->context->shareUrl(ShareLinks::SOCIAL_KINDLE),
        ['title' => 'Send to Kindle']) ?>
</div>
<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use raoul2000\widget\scrollup\Scrollup;
use app\components\CategoryWidget;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/img/img_55081e8409007.ico" type="image/vnd.microsoft.icon" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->name,
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-default navbar-fixed-top nav-pills',
                ],
            ]);

?>
        <div class="pull-left animated fadeInDown animation-delay-8" style="padding-top:5px;margin-left: 100px">
            <div class="input-group">
                <div class="ya-site-form ya-site-form_inited_no" onclick="return {'action':'http://game-simple.ru/search','arrow':false,'bg':'transparent','fontsize':12,'fg':'#000000','language':'ru','logo':'rb','publicname':'Поиск','suggest':true,'target':'_blank','tld':'ru','type':2,'usebigdictionary':true,'searchid':2207019,'webopt':false,'websearch':false,'input_fg':'#000000','input_bg':'#ffffff','input_fontStyle':'normal','input_fontWeight':'normal','input_placeholder':'Поиск','input_placeholderColor':'#000000','input_borderColor':'#337ab7'}"><form action="http://yandex.ru/sitesearch" method="get" target="_blank"><input type="hidden" name="searchid" value="2207019"/><input type="hidden" name="l10n" value="ru"/><input type="hidden" name="reqenc" value=""/><input type="search" name="text" value=""/><input type="submit" value="Найти"/></form></div><style type="text/css">.ya-page_js_yes .ya-site-form_inited_no { display: none; }</style><script type="text/javascript">(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0],e=d.documentElement;if((' '+e.className+' ').indexOf(' ya-page_js_yes ')===-1){e.className+=' ya-page_js_yes';}s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Form.init()})})(window,document,'yandex_site_callbacks');</script>
            </div>
        </div>

<?php

            if(Yii::$app->user->isGuest){
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items' => [
                        \app\models\User::getFavoriteGameCount(),
                        ['label' => 'Вопрос/Ответ', 'url' => ['/site/answer']],
                        ['label' => 'Обратная связь', 'url' => ['/site/contact']],
                    ],
                ]);
            }

            //if login user
            if(!Yii::$app->user->isGuest){
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items' => [
                        ['label' => 'Игры', 'url' => ['/admin/gameadmin']],
                        ['label' => 'Категории', 'url' => ['/admin/categoryadmin']],
                        ['label' => 'Выход','url' => ['/site/logout'],'linkOptions' => ['data-method' => 'post']],
                    ],
                ]);
            }

            NavBar::end();
        ?>

        <?php
        echo Scrollup::widget([
            'theme' => Scrollup::THEME_PILLS,
            'pluginOptions' => [
                'scrollText' => "Наверх", // Text for element
                'scrollName'=> 'scrollup', // Element ID
                'topDistance'=> 300, // Distance from top before showing element (px)
                'topSpeed'=> 3000, // Speed back to top (ms)
                'animation' => Scrollup::ANIMATION_SLIDE, // Fade, slide, none
                'animationInSpeed' => 200, // Animation in speed (ms)
                'animationOutSpeed'=> 200, // Animation out speed (ms)
                'activeOverlay' => false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
            ]
        ]);
        ?>


        <div class="container">
            <?php
                echo  Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => '<i class="fa fa-home"></i>' . Yii::t('yii', 'Главная'),
                        'url' => Yii::$app->homeUrl,
                        'encode' => false// Requested feature
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
             ?>

            <?= $content ?>


            <div class="main-list-category">
                <?php
                /*['dependency' => ['class' => 'yii\caching\DbDependency','sql' => 'SELECT MAX(id) FROM tbl_category']]*/
                if ($this->beginCache('category_list', ['duration' => 3600])) {

                    //generate category list
                    echo CategoryWidget::widget();

                    $this->endCache();
                }
                ?>
            </div>

        </div>

    </div>



    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; <?=Yii::$app->name;?> <?= date('Y') ?> | <?php echo Html::a('Карта сайта', ['/sitemap.xml/']); ?></p>

            <p class="pull-right">
                <!--LiveInternet counter--><script type="text/javascript"><!--
                    document.write("<a href='//www.liveinternet.ru/click' "+
                        "target=_blank><img src='//counter.yadro.ru/hit?t26.11;r"+
                        escape(document.referrer)+((typeof(screen)=="undefined")?"":
                        ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
                            screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
                        ";"+Math.random()+
                        "' alt='' title='LiveInternet: показано число посетителей за"+
                        " сегодня' "+
                        "border='0' width='88' height='15'><\/a>")
                    //--></script><!--/LiveInternet-->
            </p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

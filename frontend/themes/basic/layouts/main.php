<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/**
 * @var \yii\web\View $this
 * @var string $content
 */
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
<!--    <meta name="viewport" content="width=device-width, initial-scale=1">-->
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="container">
        <div class="col-lg-12 col-md-12 top-head-block"  style=" padding: 20px 20px 20px 20px; ">
            <?php if (Yii::$app->user->getId())
            { ?>
                <a href="<?=Url::to(['/organization/new'])?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-ok-sign"></span> Добавить организацию</a>
            <?php } ?>
            <a href="<?=Url::to(['/organization/category/index'])?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-list-alt"></span> Рубрикатор</a>
            <a href="<?=Url::to(['/news'])?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-list"></span> Новости компаний</a>

            <?php if (Yii::$app->user->getId())
            { ?>
                <a href="<?=Url::to(['/register'])?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-list"></span> Регистрация </a>
                <a href="<?=Url::to(['/login'])?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-list"></span> Вход </a>
            <?php } else { ?>
                <a href="<?=Url::to(['/logout'])?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-list"></span> Выход </a>
            <?php } ?>
        </div>
    </div>
    <div class="container clearfix">
        <?php
        $form = ActiveForm::begin([
            'action' => ['/search-result'],
            'method' =>'get',
            'options' => [
                'novalidate' => "novalidate",
                'data-validate' => "parsley",

                'class' => 'search-form',

            ]
        ]);
        ?>
        <div class="row">

<!--        <span class="region-list col-md-2" >-->
<!--            <b>Регион</b>-->
<!--            --><?php //echo Html::dropDownList('region', Yii::$app->request->get('region'), \yii\helpers\ArrayHelper::map(\common\modules\locality\models\Region::find()->all(), 'name', 'name'), ['class' => 'col-lg-12', 'style' => 'padding:7px;']); ?>
<!--        </span>-->

            <div class="col-md-12 " >
                <div class="row">
                    <div class="col-lg-11" >
                        <b>Поиск</b>
                        <?php echo Html::textInput('search_value', Yii::$app->request->get('search_value'),['placeholder' => 'Я ищу', 'style' => 'margin-bottom:0; padding:5px 15px 5px 15px; width:100%;']) ?>

                    </div>
                    <div class="col-lg-1" style="padding: 0; margin: 0;">

                        <?php echo Html::submitButton('Найти', ['class' => 'btn btn-default', 'style' => 'margin-top:20px; padding:8px 20px 8px 20px;']); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <?php
       /* NavBar::begin([
            'brandLabel' => 'My Company',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        $menuItems = [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
            $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
        } else {
            $menuItems[] = [
                'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']
            ];
        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
       */
    ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12" style="margin: 10px 0 10px 0;">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </div>
        </div>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>



    <div class="wrap">
        <div class="container align-center">


        </div>
    </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

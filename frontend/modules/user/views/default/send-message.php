<?php
/**
 * Created by PhpStorm.
 * User: Phantom
 * Date: 21.10.2014
 * Time: 16:15
 */

use yii\web\View;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
    ?>
<?php if (Yii::$app->session->hasFlash('user-register-success')) {
?>
    <p><?= Yii::$app->session->getFlash('user-register-success');
        Yii::$app->session->setFlash('user-register-success', null); ?></p>
        <a href="<?=Url::to(['/login'])?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-list"></span> Вход </a>
        <?php
} else {
    if (Yii::$app->session->hasFlash('user-register-error')) { ?>
        <p><?= Yii::$app->session->getFlash('user-register-error');
            Yii::$app->session->setFlash('user-register-error', null); ?></p>
    <?php } else {
        ?>
        <h1><?php echo Html::encode($this->title); ?></h1>
        <p>На Ваш номер телефона отправлено сообщение с кодом активации. </p>
        <?php
    }  ?>
        <?php $form = ActiveForm::begin(array('options' => array('class' => 'form-horizontal', 'id' => 'registration-form'))); ?>
        <?php echo $form->field($model, 'activate')->textInput(); ?>

        <div class="form-actions">
            <?php echo Html::submitButton('Подтвердить', array('class' => 'btn btn-primary')); ?>

        </div>
        <?php  ActiveForm::end();
}
?>
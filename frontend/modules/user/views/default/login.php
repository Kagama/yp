<?php
/**
 * Created by PhpStorm.
 * User: Phantom
 * Date: 18.10.2014
 * Time: 13:47
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;


if (Yii::$app->session->hasFlash('user-login')) {
    ?>
    <p><?php echo Yii::$app->session->getFlash('user-login');
        Yii::$app->session->setFlash('user-login', null); ?></p>
<?php } else {

    ?>
    <h1><?php echo Html::encode($this->title); ?></h1>

    <p class="lead">Вы можете использовать ваш аккаунт в социальных сетях:</p>
    <?php echo nodge\eauth\Widget::widget(array('action' => 'default/login')); ?>
    <hr/>


    <p>Или заполните следующие поля:</p>

    <?php $form = ActiveForm::begin(array('options' => array('class' => 'form-horizontal', 'id' => 'login-form'))); ?>
    <?php echo $form->field($model, 'username')->textInput(); ?>
    <?php echo $form->field($model, 'password')->passwordInput(); ?>
    <?php echo $form->field($model, 'rememberMe')->checkbox(); ?>
    <div class="form-actions">
        <?php echo Html::submitButton('Login', array('class' => 'btn btn-primary')); ?>
    </div>
    <?php ActiveForm::end();
}?>

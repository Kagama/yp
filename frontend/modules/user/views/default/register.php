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

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
    ?>
<?php if (Yii::$app->session->hasFlash('user-register-exist')) {
    ?>
    <p><?= Yii::$app->session->getFlash('user-register-exist');
        Yii::$app->session->setFlash('user-register-exist', null); }?></p>
    <h1><?php echo Html::encode($this->title); ?></h1>
        <p>Заполните следующие поля: </p>

    <?php $form = ActiveForm::begin(array('options' => array('class' => 'form-horizontal', 'id' => 'registration-form'))); ?>
    <div class="row">
        <div class="col-lg-1">+7</div>
        <div class="col-lg-11"><?php echo $form->field($model, 'phone')->textInput(); ?></div>
    </div>

    <?php echo $form->field($model, 'password')->passwordInput(); ?>
        <div class="form-actions">
            <?php echo Html::submitButton('Зарегистрироваться', array('class' => 'btn btn-primary')); ?>

        </div>
    <?php  ActiveForm::end();
//}
?>
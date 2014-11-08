<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\modules\organization\models\Organization $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="organization-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 512]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => 254]) ?>

    <?= $form->field($model, 'category')->textInput() ?>

    <?= $form->field($model, 'longitude')->textInput() ?>

    <?= $form->field($model, 'latitude')->textInput() ?>

    <?= $form->field($model, 'org_type')->textInput() ?>

    <?= $form->field($model, 'locality')->textInput() ?>

    <?= $form->field($model, 'registration_date')->textInput() ?>

    <?= $form->field($model, 'update_date')->textInput() ?>

    <?= $form->field($model, 'user')->textInput() ?>

    <?= $form->field($model, 'locality_id')->textInput() ?>

    <?= $form->field($model, 'approve')->textInput() ?>

    <?= $form->field($model, 'seo_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'simple_name')->textInput(['maxlength' => 254]) ?>

    <?= $form->field($model, 'seo_title')->textInput(['maxlength' => 254]) ?>

    <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => 254]) ?>

    <?= $form->field($model, 'logo_img')->textInput(['maxlength' => 512]) ?>

    <?= $form->field($model, 'top_manager')->textInput(['maxlength' => 512]) ?>

    <?= $form->field($model, 'tags')->textInput(['maxlength' => 1024]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

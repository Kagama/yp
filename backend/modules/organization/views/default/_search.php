<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\modules\organization\search\OrganizationSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="organization-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'simple_name') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'org_type') ?>

    <?= $form->field($model, 'logo_img') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'locality') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'registration_date') ?>

    <?php // echo $form->field($model, 'update_date') ?>

    <?php // echo $form->field($model, 'category') ?>

    <?php // echo $form->field($model, 'user') ?>

    <?php // echo $form->field($model, 'tags') ?>

    <?php // echo $form->field($model, 'longitude') ?>

    <?php // echo $form->field($model, 'latitude') ?>

    <?php // echo $form->field($model, 'seo_title') ?>

    <?php // echo $form->field($model, 'seo_keywords') ?>

    <?php // echo $form->field($model, 'seo_description') ?>

    <?php // echo $form->field($model, 'locality_id') ?>

    <?php // echo $form->field($model, 'approve') ?>

    <?php // echo $form->field($model, 'top_manager') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

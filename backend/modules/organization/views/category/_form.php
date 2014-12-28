<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\modules\organization\models\Category $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
        ]
    ]); ?>
    <?= $form->field($model, 'name')->textInput() ?>
    <?= $form->field($model, 'logo')->fileInput() ?>
    <?php if ($model->logo) {?>
        <img src=<?= $model->logo ?> >
    <?php } ?>

    <?= $form->field($model, 'position')->textInput() ?>
    <?= $form->field($model, 'level')->textInput() ?>
    <fieldset>
        <?= $form->field($model, 'seo_title')->textInput() ?>
        <?= $form->field($model, 'seo_keywords')->textInput() ?>
        <?= $form->field($model, 'seo_description')->textInput() ?>
    </fieldset>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

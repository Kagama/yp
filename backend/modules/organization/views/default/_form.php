<?php

use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\modules\organization\models\Category;
use common\modules\organization\models\OrgType;
use common\models\Tags;

/**
 * @var yii\web\View $this
 * @var common\modules\organization\models\Organization $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="organization-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
        ]

    ]); ?>

    <?= $form->field($model, 'approve')->checkbox() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 512]) ?>

    <?= $form->field($model, 'simple_name')->textInput(['maxlength' => 254]) ?>

    <?= $form->field($model, 'img')->fileInput() ?>
    <?php if ($model->img) {?>
        <img src=<?= $model->img_src.'/'.$model->img ?>>
    <?php } ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'category')->dropDownList(ArrayHelper::map(Category::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'org_type')->dropDownList(ArrayHelper::map(OrgType::find()->all(), 'id', 'name'), ['prompt' => ' ']) ?>

    <?= $form->field($model, 'top_manager')->textInput(['maxlength' => 512]) ?>

    <?= $form->field($model, 'tags')->widget(Select2::className(), [
        'model' => $model,
        'attribute' => 'tags',
        'pluginOptions' => [
        'tags' => Tags::getAllLikeJsList(),
        'maximumInputLength' => 10
        ],
    ]) ?>

    <fieldset>
        <?= $form->field($model, 'seo_description')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'seo_title')->textInput(['maxlength' => 254]) ?>

        <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => 254]) ?>
    </fieldset>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

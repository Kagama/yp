<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->registerAssetBundle('backend\modules\news\assets\NewsModuleAsset', \yii\web\View::POS_HEAD);

/**
 * @var yii\web\View $this
 * @var common\modules\organization\models\Organization $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organization-view padding020 widget">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Список', ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('Создать организацию', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить организацию?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'simple_name',
            'name',
            [
                'label' => 'Статус одобрения',
                'value' => $model->approve == 1 ? 'Одобрено' : 'Не одобрено',
            ],
            [
                'label' => 'Тип организации',
                'value' => $model->orgType['name'],
            ],

            [
                'label' => 'Логотип организации',
                'value' => $model->logo_img ? '<img src="'.$model->logo_img.'" >': '-' ,
            ],

            'description:ntext',
            [
                'label' => 'Контакты',
                'value' => $contacts,
                'format' => 'html'
            ],
            'registration_date',
            'update_date',
            [
                'label' => 'Категория организации',
                'value' => $model->cat['name'],
            ],
            'user',
            'tags',
            'seo_title',
            'seo_keywords',
            'seo_description:ntext',
            'approve',
            'top_manager',
        ],
    ]) ?>

</div>

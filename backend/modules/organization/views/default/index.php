<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->registerAssetBundle('backend\modules\news\assets\NewsModuleAsset', \yii\web\View::POS_HEAD);

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\modules\organization\search\OrganizationSearch $searchModel
 */

$this->title = 'Организации';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organization-index padding020 widget">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать организацию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'logo_img',
            'name',
            [
                'attribute' => 'org_type',
                'value' => function($model, $index) {
                        return $model->orgType->name;
                    },
                'filter' => \yii\helpers\ArrayHelper::map(\common\modules\organization\models\OrgType::find()->all(), 'id', 'name')
            ],
            'registration_date:date',


            // 'description:ntext',
            // 'locality',
            // 'address',
            // 'registration_date',
            // 'update_date',
            // 'category',
            // 'user',
            // 'tags',
            // 'longitude',
            // 'latitude',
            // 'seo_title',
            // 'seo_keywords',
            // 'seo_description:ntext',
            // 'locality_id',
            // 'approve',
            // 'top_manager',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

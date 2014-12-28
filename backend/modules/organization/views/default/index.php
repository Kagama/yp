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
        <?= Html::a('Одобрить все организации', ['approve-all'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'approve',
                'value' => function($model) {
                    return $model->approve == 0 ? 'Не одобрено' : 'Одобрено';
                },
                'filter' => [0 => 'Не одобрено', 1=> 'Одобрено']
            ],
            [
                'attribute' => 'org_type',
                'value' => function($model) {
                        return $model->orgType['name'];
                    },
                'filter' => \yii\helpers\ArrayHelper::map(\common\modules\organization\models\OrgType::find()->all(), 'id', 'name')
            ],
            'registration_date:date',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

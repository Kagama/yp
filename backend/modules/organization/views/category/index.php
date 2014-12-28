<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->registerAssetBundle('backend\modules\news\assets\NewsModuleAsset', \yii\web\View::POS_HEAD);

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\modules\organization\search\CatSearch $searchModel
 */

$this->title = 'Рубрикатор';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index padding020 widget">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать рубрику', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'level',
            'position',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

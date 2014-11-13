<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->registerAssetBundle('backend\modules\news\assets\NewsModuleAsset', \yii\web\View::POS_HEAD);

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\modules\news\models\search\NewsSearch $searchModel
 */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index padding020 widget">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать новость', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => 'table table-striped dataTable', 'aria-describedby' => "datatable-table_info", 'id' => 'datatable-table'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'date:date',
            'title',

//            'alt_title',
//            'small_text:ntext',
//            'text:ntext',

            // 'seo_title',
            // 'seo_keywords',
            // 'seo_description:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

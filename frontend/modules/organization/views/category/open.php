<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 15.09.14
 * Time: 15:16
 */
use yii\widgets\Breadcrumbs;

$this->params['breadcrumbs'] = [
    ['label' => "Рубрикатор", 'url' => ['/organization/category/index']],
    ['label' => $model->name, 'url' => null],
];
?>
<!--<div class="container">-->
<div class="row">
    <div class="col-lg-12">
        <h1>Рубрикатор</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-9">
        <div class="row">
            <?=
            \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'layout' => '<div class="col-lg-12">{items}</div> <div class="clearfix"></div> <div class="col-lg-12">{pager}</div>',
                'itemView' => '_organization_item',
                'emptyText' => '- Нет организаций -',
                'showOnEmpty' => '-',
                'pager' => [
                    'prevPageLabel' => '&nbsp;',
                    'nextPageLabel' => '&nbsp;'
                ]
            ])
            ?>
        </div>
    </div>
    <div class="col-lg-3">
        <?= \frontend\modules\organization\widget\BookmarkWidget::widget() ?>
    </div>
</div>
<!--</div>-->
<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 15.09.14
 * Time: 16:06
 */
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;

$this->params['breadcrumbs'] = [
    ['label' => "Рубрикатор", 'url' => ['/organization/category/index']],
    ['label' => $model->cat->name, 'url' => ['/category/' . $model->cat->alt_name . "_" . $model->cat->id]],
    ['label' => $model->orgType->name . " " . $model->name, 'url' => null],
];
    if ($model->address->latitude && $model->address->longitude) {
        Yii::$app->view->registerJsFile('http://api-maps.yandex.ru/2.0/?load=package.full&mode=debug&lang=ru-RU');
        Yii::$app->view->registerJs("
            var myMap;
            ymaps.ready(function () {
                var startGeoPoint;
                startGeoPoint = [" . $model->address->latitude . ", " . $model->address->longitude . "];


                myMap = new ymaps.Map('yandexMap', {
                        center: startGeoPoint,
                        zoom: 15,
                        //type: 'yandex#satellite',
                        //behaviors: ['default', 'scrollZoom']
                    }
                );
                myMap.controls.add('mapTools').add('zoomControl').add('typeSelector');
                myMap.behaviors.disable('scrollZoom');

//                var searchControl = new ymaps.control.SearchControl({ provider: 'yandex#map', 'noPlacemark': true });
//                myMap.controls.add(searchControl, { left: '100px', top: '5px' });

                var execution_status1 = {
                    'hideIconOnBalloonOpen': true,
                    draggable: false
                };

                myPlacemark = new ymaps.Placemark(startGeoPoint,{hintContent: 'Место расположения организации - " . $model->orgType->name . " " . $model->name . "'}, execution_status1);
                myMap.geoObjects.add(myPlacemark);

//                myMap.events.add('click', function(event) {
//                    var coordinates = event.get('coordPosition');
//                    myPlacemark.geometry.setCoordinates(coordinates);
//                    setCoordinates(coordinates[0], coordinates[1]);
//
//                    event.stopImmediatePropagation();
//                });
//                myPlacemark.events.add('dragend', function(e){
//                    var coordinates = e.get('target').geometry.getCoordinates();
//                    setCoordinates(
//                        coordinates[0],
//                        coordinates[1]
//                    );
//                });
                $('#YMapsID').hover(function(){
                    myMap.behaviors.enable('scrollZoom')
                },function(){
                    myMap.behaviors.disable('scrollZoom');
                });
            });


        ", View::POS_READY, 'add-organization-action');
    }
?>
<div class="row" style="padding: 0; margin: 0;">
    <div class="col-lg-9 show-organization">



        <h1><?= $model->orgType->name . " " . $model->name ?></h1>
        <p class="contact-info"><?= $model->address ?></p>
        <div class="additional-links text-right">

            <a href="<?= Url::to(['/map/', 'id' => $model->id]) ?>"
               class="glyphicon glyphicon-map-marker" title="Показать на карте"></a>
            <a href="<?= Url::to(['/add-bookmark/', 'id' => $model->id]) ?>"
               class="glyphicon glyphicon-bookmark add-bookmark" title="Добавить в закладки"></a>
        </div>
        <div class="col-lg-12" style="padding: 0; margin: 0;">
            <?php
            $groups = $model->contactInfo;
            foreach ($groups as $group) {
                ?>
                <p class="contact-info"><span><?= $group->group->name ?>:</span> <?= $group->value ?></p>
            <?php
            }
            ?>
        </div>

        <div class="description">
            <?= $model->description; ?>
        </div>
<!--        <div class="col-lg-12 tags">-->
<!--            Теги:-->
<!--            --><?php
//            $tags = explode(",", $model->tags);
//            foreach ($tags as $tag) {
//                echo Html::a(trim($tag), ["/organizations-by-tag/", 'tag' => $tag], ['class' => '']);
//            }
//            ?>
<!--        </div>-->



        <div id="yandexMap" class="col-lg-12" style="height: 326px;">

        </div>
    </div>
    <div class="col-lg-3">
        <?=\frontend\modules\organization\widget\BookmarkWidget::widget()?>
    </div>
</div>
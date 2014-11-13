<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21.07.14
 * Time: 0:19
 */
use yii\helpers\Html;
use yii\helpers\Url;


?>
<div class="organization-item">
    <div class="row">
        <div class="col-lg-2">

        </div>
        <div class="col-lg-10">
            <?= Html::a($model->orgType->name . " " . $model->name, ['/show-organization-info/', 'id' => $model->id], ['class' => 'title']) ?>

            <div class="description">
                <?= $model->description; ?>
            </div>
            <p class="contact-info"><span>Адрес:</span> <?= $model->address ?></p>
            <?php
            $groups = $model->contactInfo;
            foreach ($groups as $group) {
                if ($group->group->id != 3 && $group->group->id != 5) {
                    ?>
                    <p class="contact-info"><span><?= $group->group->name ?>:</span> <?= $group->value ?></p>
                <?php
                }
            }
            ?>
            <div class="row" style="padding: 0 15px 0 15px;">
                <div class="col-lg-12 additional-links text-right">
                    <?php
                    $groups = $model->contactInfo;
                    foreach ($groups as $group) {
                        if ($group->group->id == 3) {
                            ?>
                            <a href="mailto:<?= $group->value ?>" class="glyphicon glyphicon-envelope"
                               title="Написать письмо"></a>
                        <?php
                        }
                        if ($group->group->id == 5) {
                            ?>
                            <a href="<?= $group->value ?>" target="_blank" class="glyphicon glyphicon-globe"
                               title="Перейти на сайт"></a>
                        <?php
                        }
                    }
                    ?>
<!--                    <a href="--><?//= Url::to(['/map/', 'id' => $model->id]) ?><!--"-->
<!--                       class="glyphicon glyphicon-map-marker" title="Показать на карте"></a>-->
                    <a href="<?= Url::to(['/add-bookmark/', 'id' => $model->id]) ?>"
                       class="glyphicon glyphicon-bookmark add-bookmark" title="Добавить в закладки"></a>
                </div>
            </div>
        </div>


    </div>

</div>

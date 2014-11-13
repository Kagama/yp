<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 15.09.14
 * Time: 16:41
 */
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="bookmark-block">
    <div class="title">
        <span> <span class="glyphicon glyphicon-bookmark"></span> Закладки</span>
    </div>
    <div class="content">
        <?php
        if ($organizations == null) {
            echo "<i style='padding: 10px 5px 10px 5px; display: block'>Добавьте организацию в закладки.</i>";
        } else {
            foreach ($organizations as $org) {
            ?>
                <div class="row item">
<!--                    <a class="title" href="--><?//=Url::to(['/show-organization-info/', 'id' => $org->id])?><!--">--><?//=$org->orgType->name . " " . $org->name?><!-- </a>-->
                    <div class="col-lg-10" style="padding: 0; ">
                        <?= Html::a($org->orgType->name . " " . $org->name, ['/show-organization-info/', 'id' => $org->id], ['class' => 'title']) ?>
                    </div>
                    <div class="col-lg-2 text-center" style="padding: 0; ">
                        <?= Html::a("", ['/remove-from-bookmarks/', 'id' => $org->id], ['class' => 'glyphicon glyphicon-remove remove-bookmark']) ?>
                    </div>

                </div>
            <?php
            }
        }
        ?>
    </div>
</div>
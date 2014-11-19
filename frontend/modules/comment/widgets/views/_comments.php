<?php
/**
 * Created by PhpStorm.
 * User: Phantom
 * Date: 18.11.2014
 * Time: 0:29
 */

use common\modules\user\models\User;
use \yii\widgets\ActiveForm;
use \yii\helpers\Html;
use \yii\helpers\Url;
use yii\web\View;
?>

<?php
Yii::$app->view->registerJS ('
$(document).ready( function() {
    $("#comment-comment").change(function() {
        $(".add-comment-button").removeAttr("disabled");
    })
})
', View::POS_READY, 'add-comment');

Yii::$app->view->registerJs("
    var offsetComment = 0;
    $('#next').on('click', function(){
        if ($('#next').html() == 'Скрыть') {
            $('#add-here').html('');
            $('#next').html('Показать предыдущие');
            offsetComment = 0;
        } else {
            $.ajax({
                method:'get',
                url:'/comment/default/show.html',
                data: {org_id: " . $model->id . ", offset: offsetComment},
                success: function (msg) {
                        $('#add-here').prepend(msg);
                        if ($('#finish').val() == 1)
                            $('#next').html('Скрыть');
                        offsetComment++;
                }
            });
        }
    });
", View::POS_READY, 'load-comments');
?>

<?php date_default_timezone_set('etc/GMT-3')?>

<div id="comments">
    <?php
    $countComments = count($comments);
    if ($countComments == 0) {
            echo "Нет отзывов";
    }
    else {
        if ($countComments == 4) {
        ?><span id = "next">Показать предыдущие</span>
            <div id="add-here">

            </div>


        <?
            $comment = end($comments);
            $comment = prev($comments);
        } else
            $comment = end($comments);?>
        <?php

        while ($comment != false) { ?>
            <fieldset>
                <legend>
                    <div class="user">
                        <?= 'Пользователь '.User::findOne($comment->user_id)->username.' написал:'?>
                    </div>
                </legend>
                <div class="comment">
                    <?= $comment->comment ?>
                </div>

                <div class="date">
                    <?= 'Дата написания: '. date('d/m/Y H:i', $comment->created_at) ?>
                </div>
            </fieldset>
        <?php
            $comment = prev($comments);
        } ?>
    <?php } ?>
</div>



         <?php if (\Yii::$app->user->isGuest) {
            echo '<p>Для добавления отзыва <a href="'.Url::to(['/login']).'"> Войдите</a> или <a href="'.Url::to(['/register']).'"> Зарегистрируйтесь</a></p>'?>

        <?php } else {
            $form = \yii\widgets\ActiveForm::begin([
                'action' => ['../../../comment/add'],
                'options' => [
                    'novalidate' => "novalidate",
                    'method' => "post",
                    'data-validate' => "parsley"
                ]
            ]); ?>
            <div class="add-comment">
                <!--            --><?//= 'Добавить отзыв: '?>

                <?= $form->field($newComment, 'comment')->textarea(['rows' => 2, 'maxlength' => 128])?>
                <?= $form->field($newComment, 'org_id')->hiddenInput(['value' => $model->id]); ?>
            </div>

            <div class="buttons">
                <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary add-comment-button', 'disabled'=>'disabled']); ?>
            </div>
            <?php ActiveForm::end() ?>
        <?php } ?>

<?php //} ?>
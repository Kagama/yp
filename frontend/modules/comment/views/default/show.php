<?php
/**
 * Created by PhpStorm.
 * User: Phantom
 * Date: 19.11.2014
 * Time: 10:16
 */
use common\modules\user\models\User;
?>

<div class="comments">
    <?php
        if (count($comments) != 11) {
                echo \yii\helpers\Html::hiddenInput('finish', 1, ['id' => 'finish']);
        }
            foreach ($comments as $index => $comment) {
                if ($index == 10)
                    continue; ?>
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
            <?php } ?>

</div>
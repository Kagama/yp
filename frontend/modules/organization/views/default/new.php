<?php
use yii\web\View;
use common\modules\locality\models\Region;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\modules\organization\models\Category;
use common\models\Tags;
use common\modules\organization\models\OrgType;

use frontend\assets\AppAsset;

?>

<?php
if (Yii::$app->session->hasFlash('org_add_success')) {
    ?>
    <p><?php echo Yii::$app->session->getFlash('org_add_success');
        Yii::$app->session->setFlash('org_add_success', null); ?></p>
<?php
} else {
    Yii::$app->view->registerJs('var work_time_index = 0;
        $(document).ready(function () {
            hideShowWorkDayDeleteLink();
            // Добавление Рабочих дней
            $(".add-new-work-day-row").on("click", function () {

                var item = $(".work-days-item").html();

                var html = $(".work-days .work-days-item:first").clone();
//            $(html).find("a").attr("class", "").addClass(".remove-new-work-day-row").text("Удалить");
                $(html).appendTo(".work-days")
                hideShowWorkDayDeleteLink();
                return false;
            });
            $(".remove-new-work-day-row").on("click", function () {
                $(this).parent("div").parent("div").remove();
                return false;
            });

            // Добавление Адреса
            var _index = '.(count($address)).';
            $(".address-set legend .add-address").on("click", function() {

//                var _html_copy = $(".address-set .address-item:first").clone();
//                var _number = $(_item_number_elem).html();

                var _html_copy = "<div class=\"address-item\">";
                _html_copy += "<div class=\"row\">";
                _html_copy += "<div class=\"col-lg-1 address-number\"><span>"+_index+"</span></div>";
                _html_copy += "<div class=\"col-lg-11\"> <div class=\"row\"> <div class=\"col-lg-12\">";
                _html_copy += "<div class=\"form-group field-addressaddform-"+_index+"-address required\">";
                _html_copy += "<label class=\"control-label\" for=\"addressaddform-"+_index+"-address\"></label>";
                _html_copy += "<input id=\"addressaddform-"+_index+"-address\" class=\"form-control\" name=\"AddressAddForm["+_index+"][address]\" value=\"\" maxlength=\"512\" placeholder=\"Адрес\" type=\"text\">";
                _html_copy += "<div class=\"help-block\"></div></div></div></div>";
                _html_copy += "<div class=\"row\"><div class=\"col-lg-3\"><div class=\"form-group field-addressaddform-"+_index+"-point_name\">";
                _html_copy += "<label class=\"control-label\" for=\"addressaddform-"+_index+"-point_name\"></label>";
                _html_copy += "<input id=\"addressaddform-"+_index+"-point_name\" class=\"form-control\" name=\"AddressAddForm["+_index+"][point_name]\" value=\"\" maxlength=\"512\" placeholder=\"Название отделения\" type=\"text\">";
                _html_copy += "<div class=\"help-block\"></div></div></div>";
                _html_copy += "<div class=\"col-lg-5\"><div class=\"form-group field-addressaddform-"+_index+"-phone required\">";
                _html_copy += "<label class=\"control-label\" for=\"addressaddform-"+_index+"-phone\"></label>";
                _html_copy += "<input id=\"addressaddform-"+_index+"-phone\" class=\"form-control\" name=\"AddressAddForm["+_index+"][phone]\" value=\"\" maxlength=\"512\" placeholder=\"Номер телефона\" type=\"text\">";
                _html_copy += "<div class=\"help-block\"></div></div></div>";
                _html_copy += "<div class=\"col-lg-4\"><div class=\"form-group field-addressaddform-"+_index+"-fax\">";
                _html_copy += "<label class=\"control-label\" for=\"addressaddform-"+_index+"-fax\"></label>";
                _html_copy += "<input id=\"addressaddform-"+_index+"-fax\" class=\"form-control\" name=\"AddressAddForm["+_index+"][fax]\" maxlength=\"512\" placeholder=\"Факс\" type=\"text\">";
                _html_copy += "<div class=\"help-block\"></div></div></div>";
                _html_copy += "</div>";
                _html_copy += "<div class=\"row\"><div class=\"col-lg-2 col-lg-offset-10\">";
                _html_copy += "<span class=\"address_del btn btn-danger\">Удалить</span>";
                _html_copy += "</div>";
                _html_copy += "</div>";
                _html_copy += "</div>";
                _html_copy += "</div>";
                _index = _index + 1;

                $(_html_copy).css("display", "none").appendTo(".address-set").slideDown("slow").find(".address-number span").html(_index);
                var _address_input = $(_html_copy).find("#addressaddform-address");
                $(_address_input).attr("id","addressaddform-address"+_index);

            });
            $(document).on("click", ".address-item .address_del", function() {
                $(this).parent("div").parent("div.row").parent("div.row").parent("div.address-item").remove();
                _index = _index - 1;
                $(".address-set .address-item .address-number span").each(function(i){
                    $(this).html("");
                    $(this).html((i+1));
                });
            });


        });
        function hideShowWorkDayDeleteLink() {
            $(".work-days .work-days-item .remove-new-work-day-row").show();
            $(".work-days .work-days-item .add-new-work-day-row").hide();
            $(".work-days .work-days-item:first .remove-new-work-day-row").hide();
            $(".work-days .work-days-item:first .add-new-work-day-row").show();

        }', View::POS_END, 'form-add-organization-work-time');

    $form = ActiveForm::begin([
        'enableClientValidation' => false,
        'options' => [
            'novalidate' => "novalidate",
            'method' => "post",
            'data-validate' => "parsley"
        ]
    ]); ?>
    <!--    <div class="container">-->
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <p class="note">Поля с * не должны быть пустыми.</p>

            <?= $form->field($model, 'name')->textInput(['maxlength' => 512]) ?>





            <?= $form->field($model, 'description')->textarea(['rows' => 6, 'style' => 'width:940px; min-width:940px; max-width:940px; height:150px; min-height:150px; max-height:150px;']) ?>
            <p class="hint" id="chars_counter" style="color: #696969; font-size: 10px;">Осталось <strong
                    style="color: rgba(255, 0, 0, 0.67); font-size: 12px;"><?php echo Yii::$app->params['max_length_text_field']; ?></strong>
                символов.</p>

            <div>
                <?php

                $query = Category::find()->where('owner_id IS NOT NULL');
                $data = ArrayHelper::map($query->all(), 'id', 'name', 'owner_id') // (OrgCategory::model()->with('parent')->findAll($criteria), 'id', 'name', 'parent.name');
                ?>
                <?php echo $form->field($model, 'category')->widget(\kartik\widgets\Select2::className(), [
                    'data' => array_merge(["" => ""], $data),
                    'options' => ['placeholder' => 'Выберите категорю ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>

            </div>
            <?=
            $form->field($model, 'tags')->widget(\kartik\widgets\Select2::className(), [
                'model' => $model,
                'attribute' => 'tags',
                'pluginOptions' => [
                    'tags' => Tags::getAllLikeJsList(),
                    'maximumInputLength' => 10
                ],
            ]) ?>



            <?php
            Yii::$app->view->registerJs("
                    $(function() {
                        $(\"textarea[id='addorgform-description']\").keyup(function (){

                            var maxLength = " . Yii::$app->params['max_length_text_field'] . ";
                            var curLength = $('textarea[id=\"addorgform-description\"]').val().length;
                            $(this).val($(this).val().substr(0, maxLength));
                            var remaning = maxLength - curLength;

                            if (remaning < 0) remaning = 0;
                            $(\"#chars_counter strong\").html(remaning);
                        });
                    });
                ", View::POS_END, 'Org_add_description_chars_counter');
            ?>

            <!--                --><?//=
            //                $form->field($model, 'region')->widget(\kartik\widgets\Select2::className(), [
            //                    'model' => $model,
            //                    'attribute' => 'region',
            //                    'options' => ['placeholder' => 'Выберите регион ...', 'class' => 'form-control'],
            //                    'pluginOptions' => [
            //                        'tags' => Region::getAllLikeJsList(),
            //                        'maximumInputLength' => 10
            //                    ],
            //                ]);
            ?>


            <fieldset class="address-set">
                <legend>Адрес компании <span class="add-address">добавить адрес</span></legend>
                <?php
                foreach ($address as $index => $_address) {
                    $i = ($index + 1);
                ?>
                <div class="address-item">
                    <div class="row">
                        <div class="col-lg-1 address-number">
                            <span><?=$i?></span>
                        </div>
                        <div class="col-lg-11">
                            <div class="row">

                                <div class="col-lg-12">

                                    <?= $form->field($_address, '['.$index.']address')->textInput(['maxlength' => 512, 'placeholder' => 'Адрес'])->label("") ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <?= $form->field($_address, '['.$index.']point_name')->textInput(['maxlength' => 512, 'placeholder' => 'Название отделения'])->label("") ?>
                                </div>
                                <div class="col-lg-5">
                                    <?= $form->field($_address, '['.$index.']phone')->textInput(['maxlength' => 512, 'placeholder' => 'Номер телефона'])->label("") ?>

                                </div>

                                <div class="col-lg-4">
                                    <?= $form->field($_address, '['.$index.']fax')->textInput(['maxlength' => 512, 'placeholder' => 'Факс'])->label("") ?>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-2 col-lg-offset-10">
                                <span class="address_del btn btn-danger">Удалить</span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>


            </fieldset>


            <p><a href="#" onclick="$('#additionnalinfo').toggle('slow'); return false;" class="btn btn-primary" style="margin-top: 20px;">Дополнительно</a></p>

            <div id="additionnalinfo" style="display: none; background-color: rgb(243, 243, 243); padding: 10px;">
                <label>Время работы</label>

                <div class="work-days">
                    <div class="row work-days-item">
                        <div class="col-lg-5">
                            <select name="workdays_from[]">
                                <option value="null"></option>
                                <option value="0">Понедельник</option>
                                <option value="1">Вторник</option>
                                <option value="2">Среда</option>
                                <option value="3">Четверг</option>
                                <option value="4">Пятница</option>
                                <option value="5">Суббота</option>
                                <option value="6">Воскресенье</option>
                            </select> - <select name="workdays_to[]">
                                <option value="null"></option>
                                <option value="0">Понедельник</option>
                                <option value="1">Вторник</option>
                                <option value="2">Среда</option>
                                <option value="3">Четверг</option>
                                <option value="4">Пятница</option>
                                <option value="5">Суббота</option>
                                <option value="6">Воскресенье</option>
                            </select>
                        </div>

                        <div class="col-lg-2">
                            <input type="text" name="workhours_from[]" value="10:00" style="width: 50px;"
                                   maxlength="5"/>
                            - <input type="text" name="workhours_to[]" value="19:00" style="width: 50px;"
                                     maxlength="5"/>
                        </div>
                        <div class="col-lg-3 action">
                            <a href="#" class="add-new-work-day-row"><span
                                    class="glyphicon glyphicon-plus-sign">&nbsp;</span></a>
                            <a href="#" class="remove-new-work-day-row"><span
                                    class="glyphicon glyphicon-minus-sign">&nbsp;</span></a>
                        </div>
                    </div>
                </div>
                <div class="container" style="margin: 0; padding: 0;">
                    <div class="row">
                        <div class="col-lg-3">
                            <?=
                            $form->field($model, 'org_type')->widget(\kartik\widgets\Select2::className(), [
                                'data' => array_merge(["" => ""], ArrayHelper::map(OrgType::find()->all(), 'id', 'name')),
                                'options' => ['placeholder' => 'Выберите тип организации ...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ]
                            ]);
                            ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'top_manager')->textInput() ?>

                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-6">
                        <?= $form->field($model, 'contacts_email')->textInput() ?>
                    </div>
                    <div class="col-lg-6">
                        <?= $form->field($model, 'contacts_site')->textInput() ?>
                    </div>
                </div>
            </div>
            <div class="row buttons" style="padding-top: 20px;">
                <?php echo Html::submitButton('Добавить', ['class' => 'btn btn-primary']); ?>
                <?php echo Html::resetButton('Сброс значений', ['class' => 'btn']); ?>
                <?php echo Html::a('Отмена', ['/'], ['class' => 'btn btn-danger']); ?>
            </div>
            <div class="col-lg-12">
                <input type="hidden" name="address_enter_type" class="address_enter_type" value="0"/>
            </div>
        </div>
        <div class="col-lg-4">

        </div>
    </div>
    <!--    </div>-->
    <?php ActiveForm::end(); ?>
    <style type="text/css">
        .work-days {
            padding-bottom: 20px;
        }

        .work-days-item tr td.day {
            padding-left: 5px;
        }

        .work-days-item tr td.hours {
            padding-left: 5px;
        }

        .work-days-item tr td.action {
            padding-left: 5px;
        }
    </style>
    <script type="text/javascript">

    </script>
<?php
}
?>


<?php
namespace frontend\modules\user\widget;

use yii\base\Widget;
use Yii;

class LoginzaWidget extends Widget {
    //параметры по-умолчанию
    private $params = array(
        'widget_url'=>'https://s3-eu-west-1.amazonaws.com/s1.loginza.ru/js/widget.js',
        'token_url'=>'https://loginza.ru/api/widget?token_url=',
        'return_url'=>'http://ylps.ru/login',
        'link_anchor'=>'Войти с помощью Loginza',
        'logout_url'=>'',
        'css_class'=>'loginza',
        'providers_set'=>array('vkontakte', 'facebook', 'twitter', 'loginza'
        , 'myopenid', 'webmoney', 'rambler', 'flickr', 'lastfm', 'openid'
        , 'mailru', 'verisign', 'aol', 'steam', 'google', 'yandex'
        , 'mailruapi'),
    );

    /**
     * Этот метод подключает JS скрипт и загружает представление
     */
    public function run() {
        //подключаем JS скрипт
        Yii::$app->clientScript->registerScriptFile(
            $this->params['widget_url']
            , CClientScript::POS_END);
        $this->render('loginzaWidget', $this->params);
    }

    /**
     * Установка параметров
     * @param array $params массив с параметрами
     */
    public function setParams($params) {
        $this->params = array_merge($this->params, $params);
    }
}
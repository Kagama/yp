<?php
/**
 * Created by PhpStorm.
 * User: Phantom
 * Date: 21.10.2014
 * Time: 16:19
 */
namespace frontend\modules\user\controllers;

use common\modules\user\models\User;
use common\modules\user\models\RegisterForm;
use common\modules\user\models\LoginForm;
use yii\web\Controller;
use Yii;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Авторизация пользователя
     * @return string|\yii\web\Response
     * @throws \yii\base\ErrorException
     * @throws \yii\base\InvalidConfigException
     */

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $serviceName = Yii::$app->getRequest()->getQueryParam('service');

        if (isset($serviceName)) {
            /** @var $eauth \nodge\eauth\ServiceBase */

            $eauth = Yii::$app->get('eauth')->getIdentity($serviceName);
            $eauth->setRedirectUrl(Yii::$app->getUser()->getReturnUrl());
            $eauth->setCancelUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('user/default/login'));

            try {
                if ($eauth->authenticate()) {
                    $identity = User::findByEAuth($eauth);
                    Yii::$app->getUser()->login($identity);

                    // special redirect with closing popup window
                    $eauth->redirect();
                }
                else {
                    // close popup window and redirect to cancelUrl
                    $eauth->cancel();
                }
            }
            catch (\nodge\eauth\ErrorException $e) {
                // save error to show it later
                Yii::$app->getSession()->setFlash('error', 'EAuthException: '.$e->getMessage());

                // close popup window and redirect to cancelUrl
//				$eauth->cancel();
                $eauth->redirect($eauth->getCancelUrl());
            }
        }


        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            $user = User::findOne(['phone' => $model->username]);
            if (!$user)
                $user = User::findOne(['username' => $model->username]);
            if (!$user->checked)
            {
                $this->redirect(['send-message', 'phone' => $user->phone]);
            } elseif ($model->login())
                return $this->goHome();
        }
            return $this->render('login', [
                'model' => $model,
            ]);
    }

    /**
     * Выход пользователя
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
//        var_dump();var_dump

        Yii::$app->user->logout();
//        var_dump(Yii::$app->user->getReturnUrl());
        return $this->goHome();
    }

    /**
     * Регистрация пользователя
     * @return string|\yii\web\Response
     */
    public function actionRegister(){
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post())) {
            if (User::find()->where(['phone' => $model->phone])->one()) {
                Yii::$app->session->setFlash('user-register-exist', '<p class="alert-danger"> Пользователь с таким номером телефона уже существует.</p>');
            } elseif ($model->validate() && $model->register($model->phone, $model->password)) {
                $this->redirect(['send-message', 'phone' => $model->phone]);
            }
             else
                Yii::$app->session->setFlash('error');
        }
        return $this->render('register', [
            'model' => $model
        ]);
    }

    /**
     * Отправка сообщения с кодом пользователю
     * @param $phone
     * @return string
     */
    public function actionSendMessage($phone)
    {
        $userModel = User::findOne(['phone' => $phone]);
        $model = new User();
       if ($model->load(Yii::$app->request->post())) {
           if ($model->activate == $userModel->activate) {
               $userModel->setCheck();
               Yii::$app->session->setFlash('user-register-success', '<p>Регистрация завершена</p>');
           }
           else {
               var_dump($model->activate);
               Yii::$app->session->setFlash('user-register-error', '<p class="alert-danger">Код активации введен неверно. Попробуйте еще раз.</p>');
           }
       }
        return $this->render('send-message', ['model' => $model]);
    }
}
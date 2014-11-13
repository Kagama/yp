<?php

namespace common\modules\user\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\base\Security;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "t_kg_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $phone
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $approve_newsletter
 */
class RegisterForm extends Model
{
    public $password;
    public $auth_key;
    public $password_hash;
    public $phone;
    public $created_at;
    public $updated_at;
    public $password_repeat;
    public $activate;

    public function rules()
    {
        return [
            [['phone', 'password'], 'required'],
            ['phone', 'integer'],
            [['password_hash'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'activate' => 'Код активации',
            'password' => 'Пароль',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'phone' => 'Номер моб. телефона (без +7, пробелов и скобок)',
            'created_at' => 'Дата регистрации',
            'updated_at' => 'Дата обновления',
            'password_repeat' => 'Повторить пароль',
        ];
    }

    public static function register($phone_number, $password)
    {
        $user = new User();
        $user->phone = $phone_number;
        $user->password = $password;
        $user->activate = $user->generateActivationKey();
        $user->setPassword($password);
        $user->generateAuthKey();
        if ($user->save()) {
//            \Yii::$app->sms->sms_send(preg_replace("/[^0-9]/", '', $phone_number),
//                'Спасибо за регистрацию! Ваш пароль: '.$user->password,
//                'Kvadro');
            return true;
        } else {
            return print_r($user->getErrors());
        }
    }
}
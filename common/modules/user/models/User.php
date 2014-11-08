<?php

namespace common\modules\user\models;

use common\modules\order\models\Order;
use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
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
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 1;
    public $password_repeat;
    public $old_password;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['username', 'password'], 'required'],
            [['role', 'status', 'created_at', 'updated_at', 'approve_newsletter'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'password_repeat', 'old_password'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['phone'], 'string', 'max' => 128],
            [['phone'], 'exist', 'message' => 'Пользователя с таким номером телефона не существует.', 'on' => 'requestPasswordResetToken'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'operator' => '==', 'on' => 'changePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'phone' => 'Моб. номер телефона',
            'role' => 'Роль',
            'status' => 'Активный',
            'created_at' => 'Дата регистрации',
            'updated_at' => 'Дата обновления',
            'approve_newsletter' => 'Подписка на рассылку',
            'password_repeat' => 'Повторить пароль',
            'old_password' => 'Старый пароль'
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['signup'] =  ['phone'];
        $scenarios['requestPasswordResetToken'] =  ['phone'];
        $scenarios['changePassword'] =  ['password', 'password_repeat', 'old_password'];
        return $scenarios;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (($this->isNewRecord || $this->getScenario() === 'resetPassword') && !empty($this->password)) {
                $this->password_hash = Security::generatePasswordHash($this->password);
            }
            if ($this->isNewRecord) {
                $this->auth_key = Security::generateRandomKey();
            }
            return true;
        }
        return false;
    }

    public static function create($attributes)
    {
        /** @var User $user */
        $user = new static();
        $user->setAttributes($attributes);
        $user->setPassword($attributes['password']);
        $user->generateAuthKey();
        if ($user->save()) {
            return $user;
        } else {
            return null;
        }
    }

    public static function registerByPhoneNumber($phone_number, $password = null)
    {
        $user = new static();
        $user->phone = $phone_number;
        $user->password = ($password == null ? static::generatePassword() : $password);
        $user->setPassword($user->password);
        $user->generateAuthKey();
        if ($user->save()) {
            \Yii::$app->sms->sms_send(preg_replace("/[^0-9]/", '', $phone_number),
                'Спасибо за регистрацию! Ваш пароль: '.$user->password,
            'Kvadro');
            return $user;
        } else {
            return null;
        }
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param  string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => 1]);
    }

    /**
     *  Ищем пользователя по заданым свойствам
     *
     * @param  array $propertiesArr
     * @return static|null
     */
    public static function findByProperties($propertiesArr)
    {
        return static::findOne($propertiesArr);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => 1,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Security::validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Security::generatePasswordHash($password);
    }


    public static function generatePassword()
    {
        $length = 5;
        $APHA_BIG = range('A', 'Z');
        $ExeptCharsIndex = array_search('I', $APHA_BIG);
        unset($APHA_BIG[$ExeptCharsIndex]);
        $chars = array_merge(range(0, 9), range('a', 'z'), $APHA_BIG);
        shuffle($chars);
        return implode(array_slice($chars, 0, $length)); // Случайный набор 5 символов : пароль
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Security::generateRandomKey();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Security::generateRandomKey() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


    public static function getUserName()
    {
        $user = static::findIdentity(Yii::$app->user->getId());
        return ($user->username == "" ? $user->phone : $user->username);
    }

    public function getUserRole()
    {
        return $this->hasOne(UserRole::className(), ['id' => 'role']);
    }

    public function ordersCount()
    {
        return Order::find()->where('user_id = :id', [':id' => $this->getId()])->count();
    }

    public function totalOrdersPrice()
    {
        $order = new Order();
        return $order->totalPriceByUser($this->getId());
    }

}

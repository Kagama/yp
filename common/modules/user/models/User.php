<?php

namespace common\modules\user\models;

//use common\modules\order\models\Order;
use Yii;
use \yii\base\ErrorException;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\base\Security;
use yii\web\IdentityInterface;
use yii\filters\AccessControl;

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
 * @property integer $activate
 * @property integer $checked
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $approve_newsletter
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @var array EAuth attributes
     */
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
            [['phone', 'password'], 'required'],
//            [['role', 'status', 'created_at', 'updated_at', 'approve_newsletter'], 'integer'],
//            [['username', 'password_hash', 'password_reset_token', 'email', 'password_repeat', 'old_password'], 'string', 'max' => 255],
//            [['auth_key'], 'string', 'max' => 32],
            [['phone', 'activate'], 'string', 'max' => 128],
            ['password', 'validatePassword'],
            [['phone'], 'exist', 'message' => 'Пользователя с таким номером телефона не существует.', 'on' => 'requestPasswordResetToken'],
//            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'operator' => '==', 'on' => 'changePassword'],
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
            'old_password' => 'Старый пароль',
            'activate' => 'Код активации',
            'checked' => 'Проверка'
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
            'access' => array(
                'class' => AccessControl::className(),
                'only' => array('login'),
                'rules' => array(
                    array(
                        'allow' => true,
//						'roles' => array('?'),
                    ),
                    array(
                        'allow' => false,
                        'denyCallback' => array($this, 'goHome'),
                    ),
                ),
            ),
            'eauth' => array(
                // required to disable csrf validation on OpenID requests
                'class' => \nodge\eauth\openid\ControllerBehavior::className(),
                'only' => array('login'),
            ),
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
        $security = new Security();
        if (parent::beforeSave($insert)) {
            if (($this->isNewRecord || $this->getScenario() === 'resetPassword') && !empty($this->password)) {
                $this->password_hash = $security->generatePasswordHash($this->password);
            }
            if ($this->isNewRecord) {
                $this->auth_key = $security->generateRandomKey();
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
        if (Yii::$app->getSession()->has('user-'.$id)) {
            return new self(Yii::$app->getSession()->get('user-'.$id));
        }
        else {
            return static::findOne($id);
//            return isset(self::$users[$id]) ? new self(self::$users[$id]) : null;
        }
//
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
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
        return static::find()->orWhere(['username' => $username])->orWhere(['phone' => $username])->one();
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
        $validPass = new Security();
        return $validPass->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $hash = new Security();
        $this->password_hash = $hash->generatePasswordHash($password);
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
        $auth = new Security();
        $this->auth_key = $auth->generateRandomKey();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $rand = new Security();
        $this->password_reset_token = $rand->generateRandomKey() . '_' . time();
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

    public function findByPhone($phone)
    {
        return static::findOne(['phone' => $phone, 'status' => 1]);
    }

    public function generateActivationKey()
    {
        $activate = new Security();
        return strtr($activate->generateRandomString(6),'_-', 'bB');
    }

    public function setCheck()
    {
        $this->checked = true;
        $this->save();
    }


    /**
     * @param \nodge\eauth\ServiceBase $service
     * @return User
     * @throws ErrorException
     */
    public static function findByEAuth($service) {
        if (!$service->getIsAuthenticated()) {
            throw new ErrorException('EAuth user should be authenticated before creating identity.');
        }

        $id = $service->getServiceName().'-'.$service->getId();
        $attributes = array(
            'id' => $id,
            'username' => $service->getAttribute('name'),
            'email' => $service->getAttribute('email'),
        );
        echo 'helllo';
//        $attributes['phone']['service'] = $service->getServiceName();
        Yii::$app->getSession()->set('user-'.$id, $attributes);
        return new self($attributes);
    }
}

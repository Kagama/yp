<?php

namespace common\modules\organization\models;

use common\modules\comments\models\Comments;
use common\modules\locality\models\Region;
use Yii;
use yii\web\Cookie;

/**
 * This is the model class for table "ka_organization".
 *
 * @property integer $id
 * @property string $simple_name
 * @property string $name
 * @property integer $org_type
 * @property string $logo_img
 * @property string $description
 * @property integer $locality
 * @property string $address
 * @property integer $registration_date
 * @property integer $update_date
 * @property integer $category
 * @property integer $user
 * @property string $tags
 * @property double $longitude
 * @property double $latitude
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property integer $locality_id
 * @property integer $approve
 * @property string $top_manager
 */
class Organization extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ka_organization';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'category'], 'required'],
            [['org_type', 'locality', 'registration_date', 'update_date', 'category', 'user', 'locality_id', 'approve'], 'integer'],
            [['description', 'seo_description'], 'string'],
//            [['longitude', 'latitude'], 'number'],
            [['simple_name', 'seo_title', 'seo_keywords'], 'string', 'max' => 254],
            [['name', 'logo_img', 'top_manager'], 'string', 'max' => 512],
            [['tags'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'simple_name' => 'Короткое название',
            'name' => 'Полное название',
            'org_type' => 'Тип организации',
            'logo_img' => 'Фото лого',
            'description' => 'Описание',
            'locality' => 'Раселенный пункт',
//            'address' => 'Адрес',
            'registration_date' => 'Дата регистрации',
            'update_date' => 'Дата обновления',
            'category' => 'Категория',
            'user' => 'Пользователь',
            'tags' => 'Тэги',
//            'longitude' => 'Долгота',
//            'latitude' => 'Широта',
            'seo_title' => 'SEO Заголовок',
            'seo_keywords' => 'SEO Ключевые слова',
            'seo_description' => 'SEO Описание',
            'locality_id' => 'Населенный пукнит',
            'approve' => 'Статус ободрения',
            'top_manager' => 'Top Manager',
            'views_count' => 'Счетчик'
        ];
    }

    public function afterSave($insert, $attributes)
    {

        parent::afterSave($insert, $attributes);
    }

    public function getCat()
    {
        return $this->hasOne(Category::className(), ['id' => 'category']);
    }

    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'locality_id']);
    }

    public function getOrgType()
    {
        return $this->hasOne(OrgType::className(), ['id' => 'org_type']);
    }

    public function getContactInfo()
    {
        return $this->hasMany(ContactInfo::className(), ['organization_id' => 'id']);
    }

    public function getAddress()
    {
        return $this->hasMany(Address::className(), ['org_id' => 'id']);
    }

    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['org_id' => 'id']);
    }

    public  function setCookie() {
        if (Yii::$app->request->cookies->has('viewed_org')) {
            $cookie = Yii::$app->request->cookies->get('viewed_org');

            $value = unserialize($cookie->value);
            if (!in_array($this->id, $value)) {
                $this->views_count += 1;
                $this->save();

                $value[] = $this->id;
                $cookie->value = serialize($value);
                $cookie->expire = time() + 86400; // 1 день хранить cookie о просмотре организации
                Yii::$app->response->cookies->add($cookie);
            }

        } else {
            $this->views_count += 1;
            $this->save();

            $cookie = new Cookie();
            $cookie->name = 'viewed_org';
            $cookie->value = serialize([$this->id]);
            $cookie->expire = time() + 86400; // 1 день хранить cookie о просмотре организации
            Yii::$app->response->cookies->add($cookie);
        }
    }

}

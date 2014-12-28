<?php

namespace common\modules\organization\models;

use common\helpers\CDirectory;
use common\helpers\CString;
use common\modules\locality\models\Region;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Cookie;
use common\modules\organization\models\ElasticKeyValue;
use yii\web\UploadedFile;


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
 * @property string $img
 * @property string $img_src
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
            [['simple_name', 'seo_title', 'seo_keywords'], 'string', 'max' => 254],
            [['name', 'logo_img', 'top_manager', 'img'], 'string', 'max' => 512],
            [['tags', 'img_src'], 'string', 'max' => 1024]
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
            'name' => 'Название',
            'org_type' => 'Тип организации',
            'logo_img' => 'Логотип организации',
            'description' => 'Описание',
            'registration_date' => 'Дата регистрации',
            'update_date' => 'Дата обновления',
            'category' => 'Категория',
            'user' => 'Пользователь',
            'tags' => 'Тэги',
            'seo_title' => 'SEO Заголовок',
            'seo_keywords' => 'SEO Ключевые слова',
            'seo_description' => 'SEO Описание',
            'approve' => 'Статус одобрения',
            'top_manager' => 'Топ-менеджер',
            'views_count' => 'Счетчик',
            'img' => 'Фотография',
            'img_src' => 'Путь к фотографии',
        ];
    }

    public function afterSave($insert, $attributes)
    {
        $file = UploadedFile::getInstance($this, 'img');

        if ($file instanceof UploadedFile) {
            $path = "/images/organization/".date("Y/m/d", time())."/".$this->getPrimaryKey();;
            CDirectory::createDir($path);
            $dir = Yii::$app->basePath . '/../' . $path;
            $imageName = CString::translitTo($this->name) . '.' . $file->getExtension();

            $file->saveAs($dir . '/' . $imageName);
            static::updateAll(['img' => $imageName, 'img_src' => $path], ['id' => $this->getPrimaryKey()]);

        }

        $elastic = new ElasticKeyValue();
        if ($this->approve == 1) {
            $elastic->saveValue($this);
        } else {
            $elastic->deleteValue($this);
        }

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

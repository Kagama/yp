<?php

namespace common\modules\organization\models;

use common\helpers\CDirectory;
use common\helpers\CString;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "ka_org_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $alt_name
 * @property integer $owner_id
 * @property integer $position
 * @property integer $level
 * @property string $logo
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ka_org_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alt_name', 'seo_title', 'seo_keywords', 'seo_description'], 'required'],
            [['owner_id', 'position', 'level'], 'integer'],
            [['seo_description'], 'string'],
            [['name', 'alt_name', 'seo_title', 'seo_keywords'], 'string', 'max' => 254],
            ['logo', 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'alt_name' => 'Альтернативное название',
            'owner_id' => 'Владелец',
            'position' => 'Позиция',
            'level' => 'Уроверь',
            'logo' => 'Лого',
            'seo_title' => 'Seo Title',
            'seo_keywords' => 'Seo Keywords',
            'seo_description' => 'Seo Description',
        ];
    }

    public function afterSave($insert, $attributes)
    {
        $file = UploadedFile::getInstance($this, 'logo');

        if ($file instanceof UploadedFile) {
            $path = "/images/category/".date("Y/m/d", time())."/".$this->getPrimaryKey();
            CDirectory::createDir($path);
            $dir = Yii::$app->basePath . '/../' . $path;
            $imageName = CString::translitTo($this->name) . '.' . $file->getExtension();

            $file->saveAs($dir . '/' . $imageName);
            static::updateAll(['logo' => $path.'/'.$imageName], ['id' => $this->getPrimaryKey()]);

        }

//        var_dump($this->img);
//        var_dump($this->img_src);
//        if ($this->ap prove == 1)
//        {}

        parent::afterSave($insert, $attributes);
    }

    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'owner_id']);
    }

    public function getChild()
    {
        return $this->hasMany(Category::className(), ['owner_id' => 'id']);
    }

    public function getOrganizations()
    {
        return $this->hasMany(Organization::className(), ['category' => 'id'])->andFilterWhere(['approve' => 1]);
    }

}

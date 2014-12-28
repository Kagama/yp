<?php

namespace common\modules\locality\models;

use Yii;

/**
 * This is the model class for table "ka_locality".
 *
 * @property integer $id
 * @property string $name
 * @property string $alt_name
 * @property integer $region_id
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property integer $locality_type
 */
class Locality extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ka_locality';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alt_name', 'region_id', 'seo_title', 'seo_keywords', 'seo_description', 'locality_type'], 'required'],
            [['region_id', 'locality_type'], 'integer'],
            [['seo_description'], 'string'],
            [['name', 'alt_name', 'seo_title', 'seo_keywords'], 'string', 'max' => 254]
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
            'alt_name' => 'Alt название',
            'region_id' => 'Регион',
            'seo_title' => 'Seo Title',
            'seo_keywords' => 'Seo Keywords',
            'seo_description' => 'Seo Description',
            'locality_type' => 'Тип населнного пункта',
        ];
    }
}

<?php

namespace common\modules\locality\models;

use Yii;

/**
 * This is the model class for table "ka_country".
 *
 * @property integer $id
 * @property string $name
 * @property string $alt_name
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ka_country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alt_name', 'seo_title', 'seo_keywords', 'seo_description'], 'required'],
            [['seo_description'], 'string'],
            [['name', 'alt_name'], 'string', 'max' => 64],
            [['seo_title', 'seo_keywords'], 'string', 'max' => 254]
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
            'seo_title' => 'Seo Title',
            'seo_keywords' => 'Seo Keywords',
            'seo_description' => 'Seo Description',
        ];
    }
}

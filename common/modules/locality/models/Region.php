<?php

namespace common\modules\locality\models;

use Yii;

/**
 * This is the model class for table "ka_region".
 *
 * @property integer $id
 * @property string $name
 * @property string $alt_name
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property integer $country_id
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ka_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alt_name', 'seo_title', 'seo_keywords', 'seo_description', 'country_id'], 'required'],
            [['seo_description'], 'string'],
            [['country_id'], 'integer'],
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
            'seo_title' => 'Seo Title',
            'seo_keywords' => 'Seo Keywords',
            'seo_description' => 'Seo Description',
            'country_id' => 'Страна',
        ];
    }

    public static function getAllLikeJsList () {
        $temp_js_list = "";
        $tags = Region::find()->orderBy('name ASC')->all();
        foreach ($tags as $tag) {
            $temp_js_list .= (empty($temp_js_list) ? "" : ", ")." ".$tag->name." ";
        }
        $temp_js_list = explode(",", $temp_js_list);
        return $temp_js_list;
    }
}

<?php

namespace common\modules\organization\models;

use Yii;

/**
 * This is the model class for table "{{%address}}".
 *
 * @property integer $id
 * @property integer $org_id
 * @property string $address
 * @property string $point_name
 * @property string $phone
 * @property string $fax
 * @property double $longitude
 * @property integer $latitude
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%address}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['org_id', 'address', 'phone'], 'required'],
            [['org_id', 'latitude'], 'integer'],
            [['longitude'], 'number'],
            [['address', 'phone', 'fax', 'point_name'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'org_id' => 'Организация',
            'address' => 'Адрес',
            'phone' => 'Телефон',
            'fax' => 'Факс',
            'point_name' => 'Название отделения',
            'longitude' => 'Долгота',
            'latitude' => 'Широта',
        ];
    }


}

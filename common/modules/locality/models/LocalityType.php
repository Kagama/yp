<?php

namespace common\modules\locality\models;

use Yii;

/**
 * This is the model class for table "ka_locality_type".
 *
 * @property integer $id
 * @property string $type_name
 * @property string $alt_type_name
 */
class LocalityType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ka_locality_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_name', 'alt_type_name'], 'required'],
            [['type_name', 'alt_type_name'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_name' => 'Type Name',
            'alt_type_name' => 'Alt Type Name',
        ];
    }
}

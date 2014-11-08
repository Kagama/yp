<?php

namespace common\modules\organization\models;

use Yii;

/**
 * This is the model class for table "ka_org_contact_info".
 *
 * @property integer $id
 * @property integer $group_id
 * @property string $value
 * @property integer $organization_id
 */
class ContactInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ka_org_contact_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'value', 'organization_id'], 'required'],
            [['group_id', 'organization_id'], 'integer'],
            [['value'], 'string', 'max' => 254]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Group ID',
            'value' => 'Value',
            'organization_id' => 'Organization ID',
        ];
    }

    public function getGroup()
    {
        return $this->hasOne(ContactGroup::className(), ['id' => 'group_id']);
    }
}

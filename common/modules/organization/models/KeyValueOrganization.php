<?php

namespace common\modules\organization\models;

use Yii;

/**
 * This is the model class for table "t_key_value_organization".
 *
 * @property integer $id
 * @property string $value
 */
class KeyValueOrganization extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_key_value_organization';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'value'], 'required'],
            [['id'], 'integer'],
            [['value'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Key',
            'value' => 'Value',
        ];
    }

    public function saveValue(Organization $model)
    {
        if ($model->approve == 1) {
            $value = "";
            foreach ($model->getAttributes() as $index => $attr) {

                if ($index == 'category') {
                    $value .= ($value == "" ? "" : " ") . $model->cat->name;
                } else if ($index == 'id' ||
                    $index == 'org_type' ||
                    $index == 'locality' ||
                    $index == 'registration_date' ||
                    $index == 'update_date' ||
                    $index == 'user' ||
                    $index == 'locality_id' ||
                    $index == 'registration_date') {

                } else {
                    $value .= ($value == "" ? "" : " ") . $attr;
                }
            }

            if (!empty($this->address)) {
                foreach ($this->address as $_add) {
                    $value .= " ".$_add->point_name." ".$_add->address." ".$_add->phone." ".$_add->fax;
                }
            }
            $self = KeyValueOrganization::find()->where('id = :id', [':id' => $model->getPrimaryKey()])->one();
            if ($self == null) {
                $self = new KeyValueOrganization();
                $self->id = $model->getPrimaryKey();
                $self->value = $value;
                $self->save();
            } else {
                $self->updateAll(['value' => $value], 'id = :id', [':id' => $model->getPrimaryKey()]);
            }
        }

    }

    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['id' => 'id'])->andFilterWhere(['approve' => 1]);
    }

    public function getAddress()
    {
        return $this->hasMany(Address::className(), ['id' => 'org_id']);
    }
}

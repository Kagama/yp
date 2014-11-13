<?php
/**
 * Created by PhpStorm.
 * User: Phantom
 * Date: 06.10.2014
 * Time: 15:55
 */
namespace common\modules\organization\models;

use Yii;

use yii\elasticsearch\ActiveRecord;

class ElasticKeyValue extends ActiveRecord
{
    public $_id;

    public function attributes()
    {
        return [
            "id",
            "value"
        ];
    }

    public function saveValue(Organization $model)
    {
        $value = "";
        foreach ($model->getAttributes() as $index => $attr) {
            switch ($index) {
                case 'category':
                    $value .= " " . $model->cat->name;          //alt_name?
                    break;
                case 'locality_id':
                    $value .= " " . $model->region->name;      //alt_name?
                    break;
                case 'id':
                    break;
                case 'approve':
                    break;
                default:
                    $value .= " " . $attr;
            }
        }

        if (!empty($this->address)) {
            foreach ($this->address as $_add) {
                $value .= " ".$_add->point_name." ".$_add->address." ".$_add->phone." ".$_add->fax;
            }
        }

        $self = ElasticKeyValue::findOne($model->getPrimaryKey());
        if ($self == null) {
            $self = new ElasticKeyValue();
            $self->id = $self->primaryKey = $model->getPrimaryKey();
            $self->value = $value;
            $self->save();
        } else {
            $self->value = $value;
            $self->update();
        }
    }

    public function getOrg()
    {
        return $this->hasOne(Organization::className(), ['id' => 'id']);
    }
}
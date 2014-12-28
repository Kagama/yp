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
            "category",
            'simple_name',
            'name',
            'org_type',
            'logo_img',
            'description',
            'registration_date',
            'update_date',
            'category',
            'user',
            'tags',
            'seo_title',
            'seo_keywords',
            'seo_description',
            'approve',
            'top_manager',
            'views_count',
            'img',
            'img_src',
        ];
    }

    public function saveValue(Organization $model)
    {
//        $value = "";
//        foreach ($model->getAttributes() as $index => $attr) {
//            switch ($index) {
//                case 'category':
//                    $value .= " " . $model->cat->name;          //alt_name?
//                    break;
//                case 'locality_id':
//                    $value .= " " . $model->region->name;      //alt_name?
//                    break;
//                case 'id':
//                    break;
//                case 'approve':
//                    break;
//                default:
//                    $value .= " " . $attr;
//            }
//        }
//
//        if (!empty($this->address)) {
//            foreach ($this->address as $_add) {
//                $value .= " ".$_add->point_name." ".$_add->address." ".$_add->phone." ".$_add->fax;
//            }
//        }

        $self = ElasticKeyValue::findOne($model->getPrimaryKey());
        if ($self == null) {
            // Add new organization to ES
            $self = new ElasticKeyValue();
            $self->id = $self->primaryKey = $model->getPrimaryKey();
            $self->name = $model->name;
            $self->category = $model->cat['name'];
            $self->description = $model->description;
            $self->save();
        } else {
            // Update organization
            $self->name = $model->name;
            $self->category = $model->cat['name'];
            $self->description = $model->description;
            $self->update();
        }
    }

    public function deleteValue(Organization $model)
    {
        if ($self = ElasticKeyValue::findOne($model->getPrimaryKey()))
            $self->delete();
    }

    public function getOrg()
    {
        return $this->hasOne(Organization::className(), ['id' => 'id']);
    }
}
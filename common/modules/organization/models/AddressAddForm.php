<?php
/**
 * Created by PhpStorm.
 * User: pashaevs
 * Date: 11.10.14
 * Time: 15:16
 */

namespace common\modules\organization\models;

use yii\base\Model;

class AddressAddForm extends Model
{
    public $point_name;
    public $address;
    public $phone;
    public $fax;


    public function rules()
    {
        return [
            // username and password are both required
            [['address', 'phone'], 'required'],
            [['point_name'], 'string', 'max' => 1024],
            [['fax'], 'string', 'max' => 512],
        ];
    }

    public function attributeLabels()
    {
        return [
            'address' => 'Адрес',
            'point_name' => 'Условное обозначение',
            'phone' => 'Номер тел.',
            'fax' => 'Факс'

        ];
    }
}
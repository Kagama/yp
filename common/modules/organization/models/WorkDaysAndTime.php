<?php

namespace common\modules\organization\models;

use Yii;

/**
 * This is the model class for table "ka_org_work_days_and_time".
 *
 * @property integer $id
 * @property integer $organization
 * @property string $work_day_from
 * @property string $work_day_to
 * @property string $work_hours_from
 * @property string $work_hours_to
 * @property string $break_time_from
 * @property string $break_time_to
 */
class WorkDaysAndTime extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ka_org_work_days_and_time';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization', 'work_day_from', 'work_day_to', 'work_hours_from', 'work_hours_to'], 'required'],
            [['organization'], 'integer'],
            [['work_day_from', 'work_day_to'], 'string', 'max' => 64],
            [['work_hours_from', 'work_hours_to', 'break_time_from', 'break_time_to'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'organization' => 'организация',
            'work_day_from' => 'Рабочий день ',
            'work_day_to' => 'Work Day To',
            'work_hours_from' => 'Рабочие часы с',
            'work_hours_to' => 'Рабочие часы по',
            'break_time_from' => 'Перерыв с ',
            'break_time_to' => 'Перерыв до',
        ];
    }
}

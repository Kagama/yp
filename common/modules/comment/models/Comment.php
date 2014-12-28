<?php
/**
 * Created by PhpStorm.
 * User: Phantom
 * Date: 17.11.2014
 * Time: 22:16
 */
namespace common\modules\comment\models;

use yii\db\ActiveRecord;

class Comment extends ActiveRecord {
    public $org;
    /*
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comments}}';
    }

    /*
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['comment', 'string'],
            ['org_id', 'integer']
        ];
    }

    /*
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'org_id' => '',
            'user_id' => 'ID пользователя',
            'comment' => 'Добавить отзыв',
        ];
    }

    /*
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ]
            ]
        ];
    }
}
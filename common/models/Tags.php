<?php

namespace common\models;

use common\helpers\CString;
use Yii;

/**
 * This is the model class for table "ka_tags".
 *
 * @property integer $id
 * @property string $name
 * @property string $alt_name
 * @property integer $frequency
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ka_tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alt_name', 'frequency'], 'required'],
            [['frequency'], 'integer'],
            [['name', 'alt_name'], 'string', 'max' => 254]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'alt_name' => 'Alt Name',
            'frequency' => 'Frequency',
        ];
    }

    public function add($tags)
    {
        $tags = explode(",", $tags);
        $count = count($tags);
        for ($i = 0; $i < $count; $i++) {
            $tag = trim($tags[$i]);
            $row = Tags::find()->where('name = :name', [':name' => $tag])->one();
            if (empty($row)) {
                $newTag = new Tags;
                $newTag->name = $tag;
                $newTag->alt_name = CString::translitTo($tag);
                $newTag->frequency = 1;
                $newTag->save();
                unset($newTag);
            } else {
                $_tag = Tags::findOne($row->id);
                $_tag->frequency = ($row->frequency + 1);
                $_tag->save();
            }
        }
    }

    public static function getAllLikeJsList()
    {
        $temp_js_list = '';
        $tags = Tags::find()->orderBy('name ASC')->all();
        foreach ($tags as $tag) {
            $temp_js_list .= (empty($temp_js_list) ? "" : ", ") . " " . $tag->name . " ";
        }
        $temp_js_list = explode(",", $temp_js_list);;
        return $temp_js_list;
    }
}

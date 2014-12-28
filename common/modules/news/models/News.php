<?php

namespace common\modules\news\models;

use common\helpers\CString;
use Yii;

/**
 * This is the model class for table "t_kg_news".
 *
 * @property integer $id
 * @property string $title
 * @property string $alt_title
 * @property string $small_text
 * @property string $text
 * @property integer $date
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text', 'date'], 'required'],
            [['small_text', 'text', 'seo_description'], 'string'],
//            [['date'], 'integer'],
            [['title', 'alt_title', 'seo_title', 'seo_keywords'], 'string', 'max' => 512],
        ];

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'alt_title' => 'Альт заголовок',
            'small_text' => 'краткое описание',
            'text' => 'плоный текст',
            'date' => 'Дата',
            'seo_title' => 'Seo Title',
            'seo_keywords' => 'Seo Keywords',
            'seo_description' => 'Seo Description',
        ];
    }

    public function beforeValidate() {
        if (parent::beforeValidate()) {
            $this->alt_title = CString::translitTo($this->title);
            $this->date = strtotime($this->date);
            return true;
        }
        return false;
    }

    public function afterFind() {
        $this->date = date("d-m-Y", $this->date);
    }
}

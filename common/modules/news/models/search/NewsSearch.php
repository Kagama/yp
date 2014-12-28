<?php

namespace common\modules\news\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\news\models\News;

/**
 * NewsSearch represents the model behind the search form about `common\modules\news\models\News`.
 */
class NewsSearch extends News
{
    public function rules()
    {
        return [
            [['id', 'date'], 'integer'],
            [['title', 'alt_title', 'small_text', 'text', 'seo_title', 'seo_keywords', 'seo_description'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = News::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'alt_title', $this->alt_title])
            ->andFilterWhere(['like', 'small_text', $this->small_text])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'seo_keywords', $this->seo_keywords])
            ->andFilterWhere(['like', 'seo_description', $this->seo_description]);

        return $dataProvider;
    }
}

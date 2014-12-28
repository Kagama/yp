<?php

namespace common\modules\organization\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\organization\models\Organization;

/**
 * OrganizationSearch represents the model behind the search form about `common\modules\organization\models\Organization`.
 */
class OrganizationSearch extends Organization
{
    public function rules()
    {
        return [
            [['id', 'org_type', 'locality', 'registration_date', 'update_date', 'category', 'user', 'locality_id', 'approve'], 'integer'],
            [['simple_name', 'name', 'logo_img', 'description', 'address', 'tags', 'seo_title', 'seo_keywords', 'seo_description', 'top_manager'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Organization::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'org_type' => $this->org_type,
            'locality' => $this->locality,
            'registration_date' => $this->registration_date,
            'update_date' => $this->update_date,
            'category' => $this->category,
            'user' => $this->user,
            'locality_id' => $this->locality_id,
            'approve' => $this->approve,
        ]);

        $query->andFilterWhere(['like', 'simple_name', $this->simple_name])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'logo_img', $this->logo_img])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'tags', $this->tags])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'seo_keywords', $this->seo_keywords])
            ->andFilterWhere(['like', 'seo_description', $this->seo_description])
            ->andFilterWhere(['like', 'top_manager', $this->top_manager]);

        return $dataProvider;
    }
}

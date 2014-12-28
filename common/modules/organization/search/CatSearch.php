<?php
/**
 * Created by PhpStorm.
 * User: Phantom
 * Date: 12.12.2014
 * Time: 16:10
 */
namespace common\modules\organization\search;

use Yii;
use common\modules\organization\models\Category;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CatSearch extends Category
{
    public function rules()
    {
        return [
            [['id', 'level', 'position'], 'integer'],
            ['name', 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Category::find();

        $dataProvider = new ActiveDataProvider ([
            'query' => $query,
        ]);

        if(!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
           'id' => $this->id,
            'name' => $this->name,
            'position' => $this->position,
            'level' => $this->level,
        ]);

        return $dataProvider;
    }


}
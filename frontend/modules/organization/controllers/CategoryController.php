<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 15.09.14
 * Time: 2:23
 */

namespace frontend\modules\organization\controllers;

use common\modules\organization\models\Category;
use common\modules\organization\models\Organization;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CategoryController extends Controller
{
    public function actionIndex()
    {
        $categories = Category::find()->where(' owner_id IS NULL ')->all();
        return $this->render('index', [
            'categories' => $categories
        ]);
    }

    public function actionOpen($alt_name_id)
    {
        $vars = explode("_", $alt_name_id);
        $id = $vars[count($vars)-1];

        $model = Category::findOne($id);
        if (empty($model))
            throw new NotFoundHttpException('Рубрика не найдена');

        $query = Organization::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        $dataProvider->query->andFilterWhere(['approve' => 1, 'category' => $model->id]);
        $dataProvider->pagination->pageSize = 20;

        return $this->render('open', [
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }
}
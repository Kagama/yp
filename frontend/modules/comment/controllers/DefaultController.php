<?php
/**
 * Created by PhpStorm.
 * User: Phantom
 * Date: 17.11.2014
 * Time: 23:26
 */
namespace frontend\modules\comment\controllers;

use common\modules\comment\models\Comment;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use Yii;

class DefaultController extends Controller {

    public function actionAdd()
    {
        $newComment = new Comment();
        if ($newComment->load(\Yii::$app->request->post()) && $newComment->validate())
        {
            $newComment->user_id = \Yii::$app->user->id;
            if ($newComment->save())
                $this->redirect(['../../show-organization-info', 'id' => $newComment->org_id]);
        }
    }

    public function actionShow($org_id, $offset)
    {
        $comments = Comment::find()->where(['like', 'org_id', $org_id])->orderBy(['created_at' => SORT_DESC])->limit(11)->offset($offset * 10 + 3)->all();
        return $this->renderPartial('show', [
            'comments' => $comments,
        ]);
    }
}
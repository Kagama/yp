<?php
/**
 * Created by PhpStorm.
 * User: Phantom
 * Date: 17.11.2014
 * Time: 23:33
 */
namespace frontend\modules\comment\widgets;

use yii\base\Widget;
use common\modules\comment\models\Comment;
use yii\data\ActiveDataProvider;
use yii\db\Query;

class Comments extends Widget {

    public $model;

    public function init()
    {
        $newComment = new Comment();
        $comments = Comment::find()->where(['like', 'org_id', $this->model->id])->orderBy(['created_at' => SORT_DESC])->limit(4)->all();

        echo $this->render('_comments', [
            'comments' => $comments,
            'model' => $this->model,
            'newComment' => $newComment,
        ]);
    }
}
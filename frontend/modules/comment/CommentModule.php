<?php
/**
 * Created by PhpStorm.
 * User: Phantom
 * Date: 17.11.2014
 * Time: 23:21
 */
namespace frontend\modules\comment;

use yii\debug\Module;

class CommentModule extends Module {
    public $controllerNamespace = 'frontend\modules\comment\controllers';

    public function init()
    {
        parent::init();
    }
}
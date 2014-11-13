<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 16.05.14
 * Time: 11:53
 */
namespace backend\modules\news;

class NewsModule extends \common\modules\news\NewsModule
{
    public $controllerNamespace = 'backend\modules\news\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}

<?php

namespace backend\modules\user;

class UserModule extends \common\modules\user\UserModule
{
    public $controllerNamespace = 'backend\modules\user\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}

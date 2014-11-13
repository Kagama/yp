<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 15.09.14
 * Time: 16:39
 */

namespace frontend\modules\organization\widget;

use common\modules\organization\models\Organization;
use yii\base\Widget;
use Yii;


class BookmarkWidget extends Widget
{

    public function run() {

        $bookmarks = "";
        $organizations = null;
        if (($bookmarks = Yii::$app->session->get('bookmarks')) != "") {
            $bookmarks = unserialize($bookmarks);
            foreach ($bookmarks as $bookmark) {
                $organizations[] = Organization::findOne((int) $bookmark);
            }

        }

        return $this->render('_bookmark', [
            'organizations' => $organizations
        ]);
    }
}
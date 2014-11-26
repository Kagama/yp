<?php

use yii\db\Schema;
use yii\db\Migration;

class m141126_130851_change_table extends Migration
{
    public function up()
    {
        $this->addColumn('ka_organization', 'img', 'varchar(512)'.NULL);
        $this->addColumn('ka_organization', 'img_src', 'varchar(1024)'.NULL);
    }

    public function down()
    {
        $this->dropColumn('ka_organization', 'img');
        $this->dropColumn('ka_organization', 'img_src');
    }
}

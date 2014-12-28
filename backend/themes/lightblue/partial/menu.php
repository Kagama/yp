<?php
use yii\helpers\Url;

//$route = Yii::$app->controller->getRoute();
$route = Yii::$app->controller->getUniqueId();
?>
<nav id="sidebar" class="sidebar nav-collapse collapse">
    <ul id="side-nav" class="side-nav">
        <li class="<?= ($route == 'admin/default') ? "active": "panel"; ?>">
            <a href="<?= Url::toRoute('/admin/default/index'); ?>"><i class="fa fa-home"></i> <span class="name">Приборная панель</span></a>
        </li>
        <li class="<?= ($route == 'organization/default') ? "active": "panel"; ?>">
            <a class="accordion-toggle collapsed" data-toggle="collapse"
               data-parent="#side-nav" href="#organization-collapse"><i class="fa fa-list-alt"></i> <span
                    class="name">Управление организациями</span></a>
                        <ul id="organization-collapse" class="panel-collapse collapse">
                            <li><a href="<?= Url::toRoute('/organization/default/index') ?>"><i class="fa fa-list-alt"></i> <span class="name" >Организации</span></a></li>
                            <li><a href="<?= Url::toRoute('/organization/category/index') ?>"><i class="fa fa-list"></i> <span class="name" >Рубрикатор</span></a></li>
                        </ul>
        </li>
        <li class="<?= ($route == 'pages/default') ? "active": "panel"; ?>">
            <a class="accordion-toggle collapsed"
               href="<?= Url::toRoute('/pages/default/index') ?>"><i class="fa fa-edit"></i> <span
                    class="name">Страницы</span></a>
        </li>
        <li class="<?= ($route == 'news/default') ? "active": "panel"; ?>">
            <a class="accordion-toggle collapsed" href="<?= Url::toRoute('/news/default/index') ?>"><i class="fa fa-bars"></i> <span class="name">Новости</span></a>
        </li>




        <li class="<?= ($route == 'user/default' ||
                        $route == 'mailing/default' ||
                        $route == 'user/role') ? "active": "panel"; ?>">
            <a class="accordion-toggle collapsed" data-toggle="collapse"
               data-parent="#side-nav" href="#special-collapse"><i class="fa fa-users"></i> <span
                    class="name">Управление пользователями</span></a>
            <ul id="special-collapse" class="panel-collapse collapse">
                <li><a href="<?= Url::toRoute('/user/default/index') ?>"><i class="fa fa-user"></i> <span class="name" >Пользователи</span></a></li>
                <li><a href="<?= Url::toRoute('/user/role/index') ?>"><i class="fa fa-user"></i> <span class="name" >Роль</span></a></li>
                <li><a href="<?= Url::toRoute('/mailing/default/index') ?>"><i class="fa fa-comment"></i> <span class="name" >Управление рассылкой</span></a></li>
            </ul>
        </li>
        <li class="visible-xs">
            <a href="<?= Url::toRoute('/admin/default/logout') ?>"><i class="fa fa-sign-out"></i> <span class="name">Выход</span></a>
        </li>
    </ul>
    <div id="sidebar-settings" class="settings">
        <button type="button"
                data-value="icons"
                class="btn-icons btn btn-transparent btn-sm">Иконки
        </button>
        <button type="button"
                data-value="auto"
                class="btn-auto btn btn-transparent btn-sm">Авто
        </button>
    </div>
</nav>

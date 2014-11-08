<?php
use backend\modules\admin\assets\AdminModuleAsset;
use yii\helpers\Url;

AdminModuleAsset::register($this);
// page specific js
//Yii::$app->view->registerAssetBundle('backend\modules\admin\assets\AdminModuleAsset', \yii\web\View::POS_END);
//$publish = Yii::$app->assetManager->publish(
//    Yii::getAlias('@app/web/js/lightblue')
//);
//print_r($publish);
//Yii::$app->view->jsFiles['backend\modules\admin\assets\AdminModuleAsset'] = 'js/lightblue/index.js';
//$this->registerJsFile($publish[1].'/index.js');
//$this->registerJsFile($publish[1].'/chat.js');
?>



<div class="content container">
<div class="row">
    <div class="col-md-12">
        <h2 class="page-title">Dashboard
            <small>Statistics and more</small>
        </h2>
    </div>
</div>
<div class="row">
<div class="col-md-8">
<section class="widget">
    <header>
        <h4>
            <i class="fa fa-group"></i>
            Visits
            <small>
                Based on a three months data
            </small>
        </h4>
    </header>
    <div class="body no-margin">
        <div id="visits-chart" class="chart visits-chart">
            <svg></svg>
        </div>
        <div class="visits-info well well-sm">
            <div class="row">
                <div class="col-sm-3 col-xs-6">
                    <div class="key"><i class="eicon-users"></i> Total Traffic</div>
                    <div class="value">24 541 <i class="fa fa-caret-up color-green"></i></div>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <div class="key"><i class="eicon-user"></i> Unique Visits</div>
                    <div class="value">14 778 <i class="fa fa-caret-down color-red"></i></div>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <div class="key"><i class="fa fa-plus-square"></i> Revenue</div>
                    <div class="value">$3 583.18 <i class="fa fa-caret-up color-green"></i></div>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <div class="key"><i class="fa fa-user"></i> Total Sales</div>
                    <div class="value">$59 871.12 <i class="fa fa-caret-down color-red"></i></div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="widget">
    <header>
        <h4>
            <i class="fa fa-shopping-cart"></i>
            Traffic Sources
            <small>
                One month tracking
            </small>
        </h4>
    </header>
    <div class="body">
        <table class="table table-striped no-margin sources-table">
            <thead>
            <tr>
                <th class="source-col-header">Source</th>
                <th>Amount</th>
                <th>Change</th>
                <th class="hidden-xs">Percent.,%</th>
                <th>Target</th>
                <th class="chart-col-header hidden-xs">Trend</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><span class="label label-important">Direct</span></td>
                <td>713</td>
                <td><strong class="color-green">+53</strong></td>
                <td class="hidden-xs">+12</td>
                <td>900</td>
                <td class="chart-cell hidden-xs">
                    <div id="direct-trend"></div>
                </td>
            </tr>
            <tr>
                <td><span class="label label-warning">Refer</span></td>
                <td>562</td>
                <td><strong>+84</strong></td>
                <td class="hidden-xs">+64</td>
                <td>500</td>
                <td class="chart-cell hidden-xs">
                    <div id="refer-trend"></div>
                </td>
            </tr>
            <tr>
                <td><span class="label label-success">Social</span></td>
                <td>148</td>
                <td><strong class="color-red">-12</strong></td>
                <td class="hidden-xs">+3</td>
                <td>180</td>
                <td class="chart-cell hidden-xs">
                    <div id="social-trend"></div>
                </td>
            </tr>
            <tr>
                <td><span class="label label-info">Search</span></td>
                <td>653</td>
                <td><strong class="color-green">+23</strong></td>
                <td class="hidden-xs">+43</td>
                <td>876</td>
                <td class="chart-cell hidden-xs">
                    <div id="search-trend"></div>
                </td>
            </tr>
            <tr>
                <td><span class="label label-inverse">Internal</span></td>
                <td>976</td>
                <td><strong>+101</strong></td>
                <td class="hidden-xs">-7</td>
                <td>844</td>
                <td class="chart-cell hidden-xs">
                    <div id="internal-trend"></div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</section>
<section class="widget large">
    <header>
        <h4>
            <i class="eicon-chat"></i>
            Chat
        </h4>
    </header>
    <div class="body">
        <div id="chat" class="chat">
            <div id="chat-messages" class="chat-messages">
                <div class="chat-message">
                    <div class="sender pull-left">
                        <div class="icon">
                            <img src="/cp/img/lightblue/2.jpg" class="img-circle" alt="">
                        </div>
                        <div class="time">
                            4 min
                        </div>
                    </div>
                    <div class="chat-message-body">
                        <span class="arrow"></span>

                        <div class="sender"><a href="index.html#">Tikhon Laninga</a></div>
                        <div class="text">
                            Hey Sam, how is it going? But I must explain to you how all this mistaken
                            idea of denouncing of a pleasure and praising pain was born
                        </div>
                    </div>
                </div>
                <div class="chat-message">
                    <div class="sender pull-right">
                        <div class="icon">
                            <img src="/cp/img/lightblue/1.jpg" class="img-circle" alt="">
                        </div>
                        <div class="time">
                            3 min
                        </div>
                    </div>
                    <div class="chat-message-body on-left">
                        <span class="arrow"></span>

                        <div class="sender"><a href="index.html#">Cenhelm Houston</a></div>
                        <div class="text">
                            Pretty good. Doing my homework.. No one rejects, dislikes, or avoids
                            pleasure itself, because it is pleasure, but because
                        </div>
                    </div>
                </div>
                <div class="chat-message">
                    <div class="sender pull-left">
                        <div class="icon">
                            <img src="/cp/img/lightblue/2.jpg" class="img-circle" alt="">
                        </div>
                        <div class="time">
                            2 min
                        </div>
                    </div>
                    <div class="chat-message-body">
                        <span class="arrow"></span>

                        <div class="sender"><a href="index.html#">Tikhon Laninga</a></div>
                        <div class="text">
                            Any chance to go out? To take a trivial example, which of us ever undertakes
                            laborious physical exercise, except to obtain some advantage
                        </div>
                    </div>
                </div>
                <div class="chat-message">
                    <div class="sender pull-right">
                        <div class="icon">
                            <img src="/cp/img/lightblue/1.jpg" class="img-circle" alt="">
                        </div>
                        <div class="time">
                            2 min
                        </div>
                    </div>
                    <div class="chat-message-body on-left">
                        <span class="arrow"></span>

                        <div class="sender"><a href="index.html#">Cenhelm Houston</a></div>
                        <div class="text">
                            .. Maybe 40-50 mins. I don't know exactly. On the other hand, we denounce
                            with righteous indignation and dislike men who are so beguiled
                        </div>
                    </div>
                </div>
                <div class="chat-message">
                    <div class="sender pull-left">
                        <div class="icon">
                            <img src="/cp/img/lightblue/2.jpg" class="img-circle" alt="">
                        </div>
                        <div class="time">
                            1 min
                        </div>
                    </div>
                    <div class="chat-message-body">
                        <span class="arrow"></span>

                        <div class="sender"><a href="index.html#">Tikhon Laninga</a></div>
                        <div class="text">
                            Anyway sounds great! These cases are perfectly simple and easy to
                            distinguish.
                        </div>
                    </div>
                </div>
            </div>
            <footer class="chat-footer row">
                <div class="col-xs-9">
                    <input id="new-message" type="text" class="form-control input-transparent"
                           placeholder="Enter your message..">
                </div>
                <div class="col-xs-3">
                    <button type="button" id="new-message-btn" class="btn btn-transparent btn-block">Send</button>
                </div>
            </footer>
        </div>
    </div>
</section>
</div>
<div class="col-md-4">
<section class="widget large">
    <header>
        <h4>
            <i class="eicon-share"></i>
            Feed
        </h4>

        <div class="actions">
            <button class="btn btn-transparent btn-xs">Show All <i class="fa fa-arrow-down"></i></button>
        </div>
    </header>
    <div class="body">
        <div id="feed" class="feed">
            <div class="wrapper">
                <div class="vertical-line"></div>
                <section class="feed-item">
                    <div class="icon pull-left">
                        <i class="fa fa-comment"></i>
                    </div>
                    <div class="feed-item-body">
                        <div class="text">
                            <a href="index.html#">John Doe</a> commented on <a href="index.html#">What Makes Good Code
                                Good</a>.
                        </div>
                        <div class="time pull-left">
                            3 h
                        </div>
                    </div>
                </section>
                <section class="feed-item">
                    <div class="icon pull-left">
                        <i class="fa fa-check color-green"></i>
                    </div>
                    <div class="feed-item-body">
                        <div class="text">
                            <a href="index.html#">Merge request #42</a> has been approved by <a href="index.html#">Jessica
                                Lori</a>.
                        </div>
                        <div class="time pull-left">
                            10 h
                        </div>
                    </div>
                </section>
                <section class="feed-item">
                    <div class="icon pull-left">
                        <img src="/cp/img/lightblue/14.jpg" class="img-circle" alt="">
                    </div>
                    <div class="feed-item-body">
                        <div class="text">
                            New user <a href="index.html#">Greg Wilson</a> registered.
                        </div>
                        <div class="time pull-left">
                            Today
                        </div>
                    </div>
                </section>
                <section class="feed-item">
                    <div class="icon pull-left">
                        <i class="fa fa-bolt color-orange"></i>
                    </div>
                    <div class="feed-item-body">
                        <div class="text">
                            Server fail level raises above normal. <a href="index.html#">See logs</a> for details.
                        </div>
                        <div class="time pull-left">
                            Yesterday
                        </div>
                    </div>
                </section>
                <section class="feed-item">
                    <div class="icon pull-left">
                        <i class="eicon-database"></i>
                    </div>
                    <div class="feed-item-body">
                        <div class="text">
                            <a href="index.html#">Database usage report</a> is ready.
                        </div>
                        <div class="time pull-left">
                            Yesterday
                        </div>
                    </div>
                </section>
                <section class="feed-item">
                    <div class="icon pull-left">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="feed-item-body">
                        <div class="text">
                            <a href="index.html#">Order #233985</a> needs additional processing.
                        </div>
                        <div class="time pull-left">
                            Wednesday
                        </div>
                    </div>
                </section>
                <section class="feed-item">
                    <div class="icon pull-left">
                        <i class="fa fa-arrow-down"></i>
                    </div>
                    <div class="feed-item-body">
                        <div class="text">
                            <a href="index.html#">Load more...</a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
<section class="widget widget-tabs">
<header>
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="index.html#stats" data-toggle="tab">Users</a>
        </li>
        <li>
            <a href="index.html#report" data-toggle="tab">Favorites</a>
        </li>
        <li>
            <a href="index.html#dropdown1" data-toggle="tab">Commenters</a>
        </li>
    </ul>
</header>
<div class="body tab-content">
    <div id="stats" class="tab-pane active clearfix">
        <h5 class="tab-header"><i class="fa fa-group"></i> Last logged-in users</h5>
        <ul class="news-list">
            <li>
                <img src="/cp/img/lightblue/1.jpg" alt="" class="pull-left img-circle"/>

                <div class="news-item-info">
                    <div class="name"><a href="index.html#">Finees Lund</a></div>
                    <div class="position">Product Designer</div>
                    <div class="time">Last logged-in: Mar 20, 18:46</div>
                </div>
            </li>
            <li>
                <img src="/cp/img/lightblue/3.jpg" alt="" class="pull-left img-circle"/>

                <div class="news-item-info">
                    <div class="name"><a href="index.html#">Erebus Novak</a></div>
                    <div class="position">Software Engineer</div>
                    <div class="time">Last logged-in: Mar 23, 9:02</div>
                </div>
            </li>
            <li>
                <img src="/cp/img/lightblue/2.jpg" alt="" class="pull-left img-circle"/>

                <div class="news-item-info">
                    <div class="name"><a href="index.html#">Leopoldo Reier</a></div>
                    <div class="position">Chief Officer</div>
                    <div class="time">Last logged-in: Jun 6, 15:34</div>
                </div>
            </li>
            <li>
                <img src="/cp/img/lightblue/13.jpg" alt="" class="pull-left img-circle"/>

                <div class="news-item-info">
                    <div class="name"><a href="index.html#">Frans Garey</a></div>
                    <div class="position">Financial Assistant</div>
                    <div class="time">Last logged-in: Jun 8, 17:20</div>
                </div>
            </li>
            <li>
                <img src="/cp/img/lightblue/14.jpg" alt="" class="pull-left img-circle"/>

                <div class="news-item-info">
                    <div class="name"><a href="index.html#">Jessica Johnsson</a></div>
                    <div class="position">Sales Manager</div>
                    <div class="time">Last logged-in: Jun 8, 9:13</div>
                </div>
            </li>
        </ul>
    </div>
    <div id="report" class="tab-pane">
        <h5 class="tab-header"><i class="fa fa-star"></i> Popular contacts</h5>
        <ul class="news-list news-list-no-hover">
            <li>
                <img src="/cp/img/lightblue/14.jpg" alt="" class="pull-left img-circle"/>

                <div class="news-item-info">
                    <div class="name"><a href="index.html#">Jessica Johnsson</a></div>
                    <div class="options">
                        <button class="btn btn-xs btn-success">
                            <i class="fa fa-phone"></i>
                            Call
                        </button>
                        <button class="btn btn-xs btn-warning">
                            <i class="fa fa-envelope-o"></i>
                            Message
                        </button>
                    </div>
                </div>
            </li>
            <li>
                <img src="/cp/img/lightblue/13.jpg" alt="" class="pull-left img-circle"/>

                <div class="news-item-info">
                    <div class="name"><a href="index.html#">Frans Garey</a></div>
                    <div class="options">
                        <button class="btn btn-xs btn-success">
                            <i class="fa fa-phone"></i>
                            Call
                        </button>
                        <button class="btn btn-xs btn-warning">
                            <i class="fa fa-envelope-o"></i>
                            Message
                        </button>
                    </div>
                </div>
            </li>
            <li>
                <img src="/cp/img/lightblue/3.jpg" alt="" class="pull-left img-circle"/>

                <div class="news-item-info">
                    <div class="name"><a href="index.html#">Erebus Novak</a></div>
                    <div class="options">
                        <button class="btn btn-xs btn-success">
                            <i class="fa fa-phone"></i>
                            Call
                        </button>
                        <button class="btn btn-xs btn-warning">
                            <i class="fa fa-envelope-o"></i>
                            Message
                        </button>
                    </div>
                </div>
            </li>
            <li>
                <img src="/cp/img/lightblue/2.jpg" alt="" class="pull-left img-circle"/>

                <div class="news-item-info">
                    <div class="name"><a href="index.html#">Leopoldo Reier</a></div>
                    <div class="options">
                        <button class="btn btn-xs btn-success">
                            <i class="fa fa-phone"></i>
                            Call
                        </button>
                        <button class="btn btn-xs btn-warning">
                            <i class="fa fa-envelope-o"></i>
                            Message
                        </button>
                    </div>
                </div>
            </li>
            <li>
                <img src="/cp/img/lightblue/1.jpg" alt="" class="pull-left img-circle"/>

                <div class="news-item-info">
                    <div class="name"><a href="index.html#">Finees Lund</a></div>
                    <div class="options">
                        <button class="btn btn-xs btn-success">
                            <i class="fa fa-phone"></i>
                            Call
                        </button>
                        <button class="btn btn-xs btn-warning">
                            <i class="fa fa-envelope-o"></i>
                            Message
                        </button>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div id="dropdown1" class="tab-pane">
        <h5 class="tab-header"><i class="fa fa-comments"></i> Top Commenters</h5>
        <ul class="news-list">
            <li>
                <img src="/cp/img/lightblue/13.jpg" alt="" class="pull-left img-circle"/>

                <div class="news-item-info">
                    <div class="name"><a href="index.html#">Frans Garey</a></div>
                    <div class="comment">
                        Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit,
                        sed quia
                    </div>
                </div>
            </li>
            <li>
                <img src="/cp/img/lightblue/1.jpg" alt="" class="pull-left img-circle"/>

                <div class="news-item-info">
                    <div class="name"><a href="index.html#">Finees Lund</a></div>
                    <div class="comment">
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore
                        eu fugiat.
                    </div>
                </div>
            </li>
            <li>
                <img src="/cp/img/lightblue/14.jpg" alt="" class="pull-left img-circle"/>

                <div class="news-item-info">
                    <div class="name"><a href="index.html#">Jessica Johnsson</a></div>
                    <div class="comment">
                        Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                        deserunt.
                    </div>
                </div>
            </li>
            <li>
                <img src="/cp/img/lightblue/3.jpg" alt="" class="pull-left img-circle"/>

                <div class="news-item-info">
                    <div class="name"><a href="index.html#">Erebus Novak</a></div>
                    <div class="comment">
                        Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium
                        doloremque.
                    </div>
                </div>
            </li>
            <li>
                <img src="/cp/img/lightblue/2.jpg" alt="" class="pull-left img-circle"/>

                <div class="news-item-info">
                    <div class="name"><a href="index.html#">Leopoldo Reier</a></div>
                    <div class="comment">
                        Laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis
                        et quasi.
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
</section>
<section class="widget">
    <header>
        <h4>
            <i class="fa fa-magnet"></i>
            Server Overview
        </h4>
    </header>
    <div class="body">
        <ul class="server-stats">
            <li>
                <div class="key pull-right">CPU</div>
                <div class="stat">
                    <div class="info">60% / 37&deg;C / 3.3 Ghz</div>
                    <div class="progress progress-small">
                        <div class="progress-bar progress-bar-danger" style="width: 70%;"></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="key pull-right">Mem</div>
                <div class="stat">
                    <div class="info">29% / 4GB (16 GB)</div>
                    <div class="progress progress-small">
                        <div class="progress-bar" style="width: 29%;"></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="key pull-right">LAN</div>
                <div class="stat">
                    <div class="info">6 Mb/s <i class="fa fa-caret-down"></i> &nbsp; 3 Mb/s <i
                            class="fa fa-caret-up"></i></div>
                    <div class="progress progress-small">
                        <div class="progress-bar progress-bar-inverse" style="width: 48%;"></div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</section>
</div>
</div>
</div>

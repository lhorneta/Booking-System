<div id="wrapper">
     <!-- Navigation -->
        <nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/cp"> </a>
            </div>
            <!-- /.navbar-header -->
            <?php 
            if(App::gi()->user){
                if(App::gi()->user->id_role == User::ADMIN){ ?>
                <ul class="nav navbar-nav navbar-right">
                    <li> 
                        <a href="/cp/login/logout"><i class="fa fa-power-off"></i></a>
                    </li>
                </ul>
                <?php } ?>
            <?php } ?>
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="/cp" class="<?= App::gi()->uri->route == '' ? 'active' : ''; ?> lnk-1"><i class="fa fa-dashboard fa-fw nav_icon"></i>Главная</a>
                        </li>
                        <li>
                            <a href="/cp/admin" class="<?= App::gi()->uri->route == 'admin' ? 'active' : ''; ?> lnk-2"><i class="fa fa-laptop nav_icon"></i>Администраторы</a>
                        </li>
                        <li>
                            <a href="/cp/user"  class="<?= App::gi()->uri->route == 'user' ? 'active' : ''; ?> lnk-3"><i class="fa fa-user nav_icon"></i>Пользователи</a>
                        </li>
                        <li>
                            <a href="/cp/reviews/users"  class="<?= App::gi()->uri->route == 'reviews' ? 'active' : ''; ?> lnk-7"><i class="fa fa-comments nav_icon"></i>Отзывы на пользователей</a>
                        </li>
                        <li>
                            <a href="/cp/category" class="<?= App::gi()->uri->route == 'category' ? 'active' : ''; ?> lnk-4"><i class="fa fa-bars nav_icon"></i>Категории</a>
                        </li>
                        <li>
                            <a href="/cp/attribute/selectcategory" class="<?= App::gi()->uri->route == 'attribute' ? 'active' : ''; ?> lnk-5"><i class="fa fa-list-ul nav_icon"></i>Атрибуты</a>
                        </li>
                        <li>
                            <a href="/cp/lot" class="<?= App::gi()->uri->route == 'lot' ? 'active' : ''; ?> lnk-6"><i class="fa fa-star-o nav_icon"></i>Лоты</a>
                        </li>
                        <li>
                            <a href="/cp/reviews/lots"  class="<?= App::gi()->uri->route == 'reviews' ? 'active' : ''; ?> lnk-7"><i class="fa fa-comments nav_icon"></i>Отзывы на лоты</a>
                        </li>
                        <li>
                            <a href="/cp/blog"  class="<?= App::gi()->uri->route == 'blog' ? 'active' : ''; ?> lnk-7"><i class="fa fa-sitemap nav_icon"></i>Блог</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
            <div id="content" class="clearfix">
                <div class="content_bottom">
                    <div class="content clearfix"><?= $content; ?></div>     
                    <div class="clearfix"> </div>
                </div>
            </div>
       </div>
      <!-- /#page-wrapper -->
   </div>
    <!-- /#wrapper -->
     
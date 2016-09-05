<!--FaceBook like box
<div
  class="fb-like"
  data-share="true"
  data-width="450"
  data-show-faces="true">
</div>-->
  
<div id="content">
    <?php
    $page = App::gi()->uri->route;
    switch($page){
        case 'ua':
        case '': ?>
    <header id="header">
            <div class="top-line-holder">
                    <div class="top-line clearfix">
                            <div class="social-block">
                                <a href="<?=Socials::LINK_FACEBOOK_GROUP; ?>" target="_blank" class="fb"><i></i></a>
                                <a href="<?=Socials::LINK_VK_GROUP; ?>" target="_blank" class="vk"><i></i></a>
                                <a href="<?=Socials::LINK_GOOGLE_GROUP; ?>" target="_blank" class="gl"><i></i></a>
                            </div>
                            <ul class="top-nav">
                                <?php if ($user = App::gi()->user){
                                $avatar = $user->avatar;
                                $uname = ($user->id_role==2)?$user->name:$user->company_name;
                                ?>
                                    <li class="reg">
                                        <div class="btn-group">
                                            <a href="#" class="pr-offise dropdown-toggle" data-toggle="dropdown" onclick="return false">
                                                <span class="foto-holder" style="background-image: url(<?=$user->avatar ? $avatar : '/assets/images/user.png'; ?>)"></span>
                                                <?=lang('my_profile'); ?>
                                                <span style="display: inline-block; color: #000; font-size: 12px; font-weight: bold; margin-left: 10px;"><?=$uname?></span>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="<?=$this->link('/page/publicprofile/'.$user->id); ?>">Мой профиль </a></li>
                                                <li><a href="<?=$this->link('/myprofile'); ?>">Заказы</a></li>
                                                <li><a href="<?=$this->link('/myprofile?tab2'); ?>">Объявления</a></li>
                                                <li><a href="<?=$this->link('/myprofile?tab3'); ?>">Сообщения</a></li>
                                                <li><a href="<?=$this->link('/myprofile?tab4'); ?>" class="po-settings">Настройки</a></li>
                                                <li class="divider"></li>
                                                <li><a href="<?=$this->link('/login/logout'); ?>">Выйти</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                <?php }else{ ?>
                                    <li class="reg"><a href="#" data-toggle="modal" data-target="#createAdmin">Вход / Регистрация</a></li>
                                <?php } ?>
                                    <li class="servis-help"><a href="/info/index">Помощь по сервису</a></li>
                                    <li class="faq"><a href="/info/index?tab4">FAQ</a></li>
                                    <li class="lenguage">
                                        <select class="selectpicker">
                                            <option>Укр</option>
                                            <option>Рус</option>
                                        </select>
                                    </li>
                            </ul>
                        <div class="modal fade" id="createAdmin" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
                            <div class="modal-dialog create-admin" role="document">
                                <div class="modal-content">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <div class="modal-body">
                                        <div class="enter-registration">
                                            <form action="<?=$this->link('login'); ?>" method="POST" class="form-horizontal">
                                               <h5>Вход на stuffe<i>x</i>.ua</h5>
                                               <input name="form[email]" type="email" placeholder="Ваш E-mail" required>
                                                <input name="form[password]" id="pass" class="st-input" type="password" alt="" placeholder="Пароль" required>
                                                <label class="checkbox">
                                                    <input onchange="if ($('#pass').get(0).type=='password') $('#pass').get(0).type='text'; else $('#pass').get(0).type='password';" name="fff" type="checkbox" value="false">
                                                    <span class="lbl padding-8">Показать пароль</span>
                                                </label>
                                                <label class="checkbox">
                                                    <input type="checkbox">
                                                    <span class="lbl padding-8">Запомнить меня</span>
                                                </label>
                                                <a href="#" class="could-not-enter" data-dismiss="modal" aria-label="Close" data-toggle="modal" data-target="#notEnter">Не удалось войти</a>
                                                <button type="submit" class="btn">Войти</button>
                                            </form>
                                            <div class="registration-box">
                                                <h5>Создать учетную запись</h5>
                                                <p>Пароль нужен для входа в раздел <i>Мои объявления</i>, где вы сможете работать с объявлениями:</p>
                                                <ul>
                                                    <li>редактировать, удалять и обновлять</li>
                                                    <li>просматривать сообщения</li>
                                                    <li>просматривать избранные объявления</li>
                                                </ul>
                                                <a href="#" onclick="return false" class="btn reg-btn" data-toggle="modal" data-target="#registrationWindow" data-dismiss="modal" aria-label="Close">Регистрация</a>
                                            </div>
                                        </div>
                                        <div class="other-enter">
                                            <p>или войдите с помощью</p>
                                            <div class="facebook-holder">
                                                <a href="<?=Socials::linkFacebook(); ?>" class="facebook"><i class="fa fa-facebook"></i>Войти через Facebook</a>
                                            </div>
                                            <div class="gplus-holder">
                                                <a href="<?=Socials::linkGoogle(); ?>" class="gplus"><i class="fa fa-google-plus"></i>Войти через Google</a>
                                            </div>
                                        </div>
                                        <div class="registration-box registration-box-640px">
                                            <h5>Создать учетную запись</h5>
                                            <a href="#" onclick="return false" class="btn reg-btn" data-toggle="modal" data-target="#registrationWindow" data-dismiss="modal" aria-label="Close">Регистрация</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="notEnter" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
                            <div class="modal-dialog create-admin" role="document">
                                <div class="modal-content">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <div class="modal-body">
                                        <h5>Изменить пароль</h5>
                                        <div class="forgot">
                                            <form action="/login/forgot" method="POST" class="form-half">
                                                <label>
                                                    <span>Введите ваш email:</span>
                                                    <input type="email" name="femail" class="form-control" placeholder="Ваш email" required>
                                                </label>
                                                <input type="submit" value="Отправить запрос" class="btn main-btn">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="registrationWindow" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
                            <div class="modal-dialog create-admin" role="document">
                                <div class="modal-content">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <div class="modal-body">
                                        <div class="registration-form">
                                            <h5>Создание  учетной записи</h5>
                                            <form action="/register" method="POST" class="form-horizontal" id="regform">
                                                <label>
                                                    <span>Ваш E-mail <i>*</i></span>
                                                    <input name="form[email]" type="email" class="form-control" required id="emailr">
                                                </label>
                                                <label>
                                                    <span>Пароль <i>*</i></span>
                                                    <input name="form[password]" type="password" class="form-control" required id="passr">
                                                </label>
                                                <label>
                                                    <span>Повторите пароль <i>*</i></span>
                                                    <input name="form[passcheck]" type="password" class="form-control" required id="passcheckr">
                                                </label>
                                                <div class="agrees-holder">
                                                    <label class="checkbox">
                                                        <input type="checkbox" required id="termsr">
                                                        <span class="lbl padding-8"></span>
                                                    </label>
                                                    <strong><i>*</i> Я соглашаюсь с <a href="#">правилами использования сервиса</a>, а также с передачей и обработкой моих данных в staffex.ua. Я подтверждаю своё совершеннолетие и ответственность за размещение объявления</strong>
                                                </div>
                                                <input type="submit" value="Зарегестрироваться" class="btn main-btn" id="regbutton">
                                                <div class="error_reg"></div>
                                            </form>
                                        </div>
                                        <div class="other-enter">
                                            <p>или</p>
                                            <div class="facebook-holder">
                                                <a href="<?=Socials::linkFacebook(); ?>" class="facebook"><i class="fa fa-facebook"></i>Войти через Facebook</a>
                                            </div>
                                            <div class="gplus-holder">
                                                <a href="<?=Socials::linkGoogle(); ?>" class="gplus"><i class="fa fa-google-plus"></i>Войти через Google</a>
                                            </div>
                                            <span>Вы уже на stuffex? <a href="#" onclick="return false" data-toggle="modal" data-target="#createAdmin" data-dismiss="modal" aria-label="Close" >Войти</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="search-section-holder">
                    <div class="search-section">
                            <div class="logo">
                                    <a href="<?=$this->link(''); ?>"><img src="/assets/images/logo.png" alt="Логотип"></a>
                            </div>
                            <a href="/lot/add/" class="btn post-button">Подать объявление</a>
                            <div class="search"> 
                                <form class="filter_form" action="<?=$this->link('search'); ?>" method="GET" role="search">
                                	<div class="top-section clearfix">
                        			<div class="find-section regions_section">
                                	
                                    <div class="form-group">
                                        <label class="search-input-holder">
                                            <input type="text" name="q" class="search-input-main-page search-input form-control" placeholder="<?=Lot::countRowWhere('post_type = 0',array());?> объявлений рядом">
                                            <span class="clear-input">&times;</span>
                                        </label>
                                        
                                        <div id="select_region">
			                            	<input type="text" id="selecter" placeholder="Выберите город" />
			                            	<span class="caret"></span>
			                            	<input type="hidden" name="region" id="reg" />
			                            	<input type="hidden" name="city" id="city" />
			                            </div>
                                        
                                    </div>
                                    <?php 
                                        $regionObjects = getRegionOjects();
                                        $regions = array();
                                        $cities = array();
                                        $regions = Region::models();
                                        if ($regionObjects['region']) {
                                            $cities = City::modelsWhere('id_region = ?', array($regionObjects['region']->id));
                                        }
                                    ?>
                                    
                                    <div class="regions">
		                            	<div class="loads"><div></div></div>
		                            	<div class="all_regions">
		                            		<a href="#" class="all_u"><?=lang('all_regions')?></a>
		                            		<a href="#" class="another_c"><span class="glyphicon glyphicon-chevron-left"></span> Изменить область</a>
		                            		<a href="#" class="all_c">Искать по всей области »</a>
		                            	</div>
		                            	<div class="reg_list clearfix">
		                            		<ul class="column">
		                            		<?php $t=''; foreach ($regions as $k => $region) {
		                            		$title = $region->outputTitle();
											$tt=mb_substr($title, 0,1);
											if ($tt!=$t) { $titl = "<b>".$tt."</b>".mb_substr($title, 1); } else { $titl = $title; }
											$t=$tt;
		                            		?>
				                            	<li><a href="#" class="city_id" rel="<?=$region->id?>"><?=$titl?> <span class="glyphicon glyphicon-chevron-right pull-right"></span></a></li>
				                            	<?php if (($k+1)%7==0) { ?>
				                            	</ul><ul class="column">
				                            	<?php } ?>
				                            <?php } ?>
		                            		</ul>
		                            	</div>
		                            	<div class="cities_list"></div>
		                            </div>                                   
                                    
                                    <button type="submit" class="btn btn-default"><span>Найти</span><i class="fa fa-search"></i></button>
                                    
                                    </div>
                                    </div>
                                </form>
                            </div>

                    </div>
            </div>
        <?php
            if(in_array(App::gi()->uri->route, self::MAIN_PAGE)){//array('ru','ua','en', '')
                $parents = Category::modelsWhere('id_parent = ?', array(Category::PARENT));
        ?>
            <div class="header-nav-holder">
                <div id="header-nav" class="navbar navbar-default">
                    <ul id="nav" class="nav navbar-nav">
                        <?php
                        $image = 1;
                        foreach($parents as $parent){ $parent->takeChilds(); ?>
                        <li>
                            <?php if(count($parent->firstChilds)){ ?>
                            <button type="button" class="to-back">Назад</button>
                            <a href='#' class="lnk-categ lnk-<?=$image++; ?>" onclick="return false"><i><?=$parent->title; ?></i></a>
                            <div class="open-category-list">
                                <ul class="catagory-list">
                                <?php foreach($parent->firstChilds as $child){ ?>
                                    <li>
                                        <a href="/category/<?=$child->url; ?>"><?=$child->title; ?></a>
                                    </li>
                                <?php } ?>
                                    <li>
                                        <a href="/category/<?=$parent->url; ?>">Все товары из категории <?=  mb_convert_case($parent->title, MB_CASE_LOWER); ?></a>
                                    </li>
                                </ul>
                            </div>
                            <?php }else{ ?>
                                <a href='/category/<?=$parent->url; ?>' class="lnk-categ lnk-<?=$image++; ?>"><i><?=$parent->title; ?></i></a>
                            <?php } ?>
                        </li>
                        <?php } ?>
                    </ul>
                </div> 
            </div>
            <?php } ?>
    </header>
        <?php break; 
        default: ?>
    <header id="header" class="header-catalog">
                <div class="top-line-holder">
                    <div class="top-line clearfix">
                        <div class="social-block">
                                <a href="<?=Socials::LINK_FACEBOOK_GROUP; ?>" target="_blank" class="fb"><i></i></a>
                                <a href="<?=Socials::LINK_VK_GROUP; ?>" target="_blank" class="vk"><i></i></a>
                                <a href="<?=Socials::LINK_GOOGLE_GROUP; ?>" target="_blank" class="gl"><i></i></a>
                        </div>
                        <ul class="top-nav">
                            <?php if ($user = App::gi()->user){
                            $avatar = $user->avatar;
							$uname = ($user->id_role==2)?$user->name:$user->company_name;
                            ?>
                                                        <li class="reg">
                                                            <div class="btn-group">
                                                                <a href="#" class="pr-offise dropdown-toggle" data-toggle="dropdown" onclick="return false">
                                                                    <span class="foto-holder" style="background-image: url(<?=$user->avatar ? $avatar : '/assets/images/user.png'; ?>)"></span>
                                                                    <?=lang('my_profile'); ?>
                                                                    <span style="display: inline-block; color: #000; font-size: 12px; font-weight: bold; margin-left: 10px;"><?=$uname?></span>
                                                                </a>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <li><a href="<?=$this->link('/page/publicprofile/'.$user->id); ?>">Мой профиль</a></li>
                                                                    <li><a href="<?=$this->link('/myprofile'); ?>">Заказы</a></li>
                                                                    <li><a href="<?=$this->link('/myprofile?tab2'); ?>">Объявления</a></li>
                                                                    <li><a href="<?=$this->link('/myprofile?tab3'); ?>">Сообщения</a></li>
                                                                    <li><a href="<?=$this->link('/myprofile?tab4'); ?>" class="po-settings">Настройки</a></li>
                                                                    <li class="divider"></li>
                                                                    <li><a href="<?=$this->link('/login/logout'); ?>">Выйти</a></li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    <?php }else{ ?>
                                                        <li class="reg"><a href="#" data-toggle="modal" data-target="#createAdmin">Вход / Регистрация</a></li>
                                                    <?php } ?>
                            <li class="servis-help"><a href="/info/index">Помощь по сервису</a></li>
                            <li class="faq"><a href="/info/index?tab4">FAQ</a></li>
                            <li class="lenguage">
                                <select class="selectpicker">
                                    <option>Укр</option>
                                    <option>Рус</option>
                                </select>
                            </li>
                        </ul>
                        <div class="modal fade" id="createAdmin" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
                                                <div class="modal-dialog create-admin" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="enter-registration">
                                                                <form action="<?=$this->link('/login'); ?>" method="POST" class="form-horizontal">
                                                                   <h5>Вход на stuffe<i>x</i>.ua</h5>
                                                                    <input name="form[email]" type="email" placeholder="Ваш E-mail" required>
                                                                    <input name="form[password]" id="pass4" class="st-input" type="password" alt="" placeholder="Пароль" required>
                                                                    <label class="checkbox">
                                                                        <input onchange="if ($('#pass4').get(0).type=='password') $('#pass4').get(0).type='text'; else $('#pass4').get(0).type='password';" name="fff" type="checkbox" value="false">
                                                                        <span class="lbl padding-8">Показать пароль</span>
                                                                    </label>
                                                                    <label class="checkbox">
                                                                        <input type="checkbox">
                                                                        <span class="lbl padding-8">Запомнить меня</span>
                                                                    </label>
                                                                    <a href="#" class="could-not-enter" data-dismiss="modal" aria-label="Close" data-toggle="modal" data-target="#notEnter">Не удалось войти</a>
                                                                    <button type="submit" class="btn">Войти</button>
                                                                </form>
                                                                <div class="registration-box">
                                                                    <h5>Создать учетную запись</h5>
                                                                    <p>Пароль нужен для входа в раздел <i>Мои объявления</i>, где вы сможете работать с объявлениями:</p>
                                                                    <ul>
                                                                        <li>редактировать, удалять и обновлять</li>
                                                                        <li>просматривать сообщения</li>
                                                                        <li>просматривать избранные объявления</li>
                                                                    </ul>
                                                                    <a href="#" onclick="return false" class="btn reg-btn" data-toggle="modal" data-target="#registrationWindow" data-dismiss="modal" aria-label="Close">Регистрация</a>
                                                                </div>
                                                            </div>
                                                            <div class="other-enter">
                                                                <p>или войдите с помощью</p>
                                                                <div class="facebook-holder">
                                                                    <a href="<?=Socials::linkFacebook(); ?>" class="facebook"><i class="fa fa-facebook"></i>Войти через Facebook</a>
                                                                </div>
                                                                <div class="gplus-holder">
                                                                    <a href="<?=Socials::linkGoogle(); ?>" class="gplus"><i class="fa fa-google-plus"></i>Войти через Google</a>
                                                                </div>
                                                            </div>
                                                            <div class="registration-box registration-box-640px">
                                                                <h5>Создать учетную запись</h5>
                                                                <a href="#" onclick="return false" class="btn reg-btn" data-toggle="modal" data-target="#registrationWindow" data-dismiss="modal" aria-label="Close">Регистрация</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="notEnter" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
                                                <div class="modal-dialog create-admin" role="document">
                                                    <div class="modal-content">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                        <div class="modal-body">
                                                            <h5>Изменить пароль</h5>
                                                            <div class="forgot">
                                                                <form action="/login/forgot" method="POST" class="form-half">
                                                                    <label>
                                                                        <span>Введите ваш email:</span>
                                                                        <input type="email" name="femail" class="form-control" placeholder="Ваш email" required>
                                                                    </label>
                                                                    <input type="submit" value="Отправить запрос" class="btn main-btn">
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="registrationWindow" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
                                                <div class="modal-dialog create-admin" role="document">
                                                    <div class="modal-content">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                        <div class="modal-body">
                                                            <div class="registration-form">
                                                                <h5>Создание учетной записи</h5>
                                                                <form action="/register" method="POST" class="form-horizontal" id="regform">
                                                                    <label>
                                                                        <span>Ваш E-mail <i>*</i></span>
                                                                        <input name="form[email]" type="email" class="form-control" required id="emailr">
                                                                    </label>
                                                                    <label>
                                                                        <span>Пароль <i>*</i></span>
                                                                        <input name="form[password]" type="password" class="form-control" required id="passr">
                                                                    </label>
                                                                    <label>
                                                                        <span>Повторите пароль <i>*</i></span>
                                                                        <input name="form[passcheck]" type="password" class="form-control" required id="passcheckr">
                                                                    </label>
                                                                    <div class="agrees-holder">
                                                                        <label class="checkbox">
                                                                            <input type="checkbox" required id="termsr">
                                                                            <span class="lbl padding-8"></span>
                                                                        </label>
                                                                        <strong><i>*</i> Я соглашаюсь с <a href="#">правилами использования сервиса</a>, а также с передачей и обработкой моих данных в staffex.ua. Я подтверждаю своё совершеннолетие и ответственность за размещение объявления</strong>
                                                                    </div>
                                                                    <input type="submit" value="Зарегестрироваться" class="btn main-btn" id="regbutton">
                                                                    <div class="error_reg"></div>
                                                                </form>
                                                            </div>
                                                            <div class="other-enter">
                                                                <p>или</p>
                                                                <div class="facebook-holder">
                                                                    <a href="<?=Socials::linkFacebook(); ?>" class="facebook"><i class="fa fa-facebook"></i>Войти через Facebook</a>
                                                                </div>
                                                                <div class="gplus-holder">
                                                                    <a href="<?=Socials::linkGoogle(); ?>" class="gplus"><i class="fa fa-google-plus"></i>Войти через Google</a>
                                                                </div>
                                                                <span>Вы уже на stuffex? <a href="#" onclick="return false" data-toggle="modal" data-target="#createAdmin" data-dismiss="modal" aria-label="Close" >Войти</a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                    </div>
                </div>
                <div class="search-section-holder">
                    <div class="search-section">
                        <div class="logo">
                            <a href="/"><img src="/assets/images/logo.png" alt="Логотип"></a>
                        </div>

                        <a href="/lot/add/" class="btn post-button">Подать объявление</a>
                    </div>
                </div>
            </header>
    <?php break; 
    } ?>
        <?php
            if(in_array(App::gi()->uri->route, self::MAIN_PAGE)){//array('ru','ua','en', ''))){
        ?>
    <div class="slogan-section-holder">
        <div class="slogan-section">
                    <div class="text-box">
                            <h2>Делитесь Вашими товарами с соседями и друзьями</h2>
                            <p>Сэкономить свои деньги и ресурсы, делясь своими вещами с друзьями и соседями. Регистрация бесплатная.</p>
                            <a href="https://www.youtube.com/watch?v=hES4www1WT4" class="btn how-it-works" target="_blank">Как это работает</a>
                    </div>
            </div>
    </div>
        <?php } ?>
    <?=$content; ?>
</div>

<footer id="footer">
    <div class="footer-content clearfix">
        <div class="holder-box">
            
                <div class="info-text">
                    <p>Stuffex.com.ua первое сообщество совместного потребления Украины.<br>
                    Здесь вы сможете создать доверительные группы друзей, соседей, коллег и обмениваться между собой вещами. С помощью Stuffex вам не нужно будет тратить деньги на, то что вам пригодится всего пару раз. А ваши малоиспользуемые вещи принесут вам дополнительный доход. Возьмите в аренду на Stuffex то, что редко используете. Или заработайте на вещах, которые пылятся у вас в шкафу.</p>
                </div>
                <div id="navigation">
                    <h5>Пользователям</h5>
                    <ul class="box-1">
                        <li><a href="/info/index?tab4">FAQ</a></li>
                        <li><a href="/info/index?tab5">Условия использования</a></li>
                        <li><a href="/info/index?tab6">Как это работает</a></li>
                    </ul>
                    <ul class="box-2">
                        <li><a href="/info/index?tab1">Блог</a></li>
                        <li><a href="/info/index?tab2">Контакты</a></li>
                        <li><a href="/info/index?tab3">О нас</a></li>
                    </ul>
                </div>
        
            <div class="fb-block">
                <h6>Сообщества Stuffex в социальных сетях</h6>
                <div class="social-box">
                    <a href="#" class="fb">!</a>
                    <a href="#" class="vk">!</a>
                    <a href="#" class="gl">!</a>
                </div>
                <div class="fb-like" data-href="<?=Socials::LINK_FACEBOOK_GROUP?>" data-width="80px" data-layout="box_count" data-action="like" data-show-faces="true" data-share="false"></div>
            </div>
            <div class="info-text info-text-2">
                <p>Stuffex.com.ua первое сообщество совместного потребления Украины.<br>
                    Здесь вы сможете создать доверительные группы друзей, соседей, коллег и обмениваться между собой вещами. С помощью Stuffex вам не нужно будет тратить деньги на, то что вам пригодится всего пару раз. А ваши малоиспользуемые вещи принесут вам дополнительный доход. Возьмите в аренду на Stuffex то, что редко используете. Или заработайте на вещах, которые пылятся у вас в шкафу.</p>
            </div>
        </div>
        
        <div class="number-ads">
            <span><?=Lot::countRowWhere('post_type = 0',array());?> предложений<br>
от <?=User::countRowWhere('id',array());?> пользователей.</span>
        </div>
        <div id="copy">
            <a href="/info/index?tab2" class="advertising">Реклама на сайте</a>
        </div>
    </div>
</footer>
<script type="text/javascript">

	
	
    //Show category list in the header nav
    $('#nav .lnk-categ').click( function () {
        $('#nav > li').not( $(this).parent() ).removeClass('opened');
        $(this).parent().toggleClass('opened');
        $(this).parent('li').find('.open-category-list').css({'width': $('body').width(), 'left': ($(this).offset().left) * (-1)});        
    });
    $('.catagory-list .closer, .search-section-holder, .top-line-holder, .slogan-section-holder, #main, #nav .to-back').bind('click', function () {
        $('#nav > li').removeClass('opened');
    });
    
    // Appending copyright text with dinamic current year
    ;(function() {
        var copy = document.getElementById('copy'),
            year = new Date().getFullYear(),
            copyText = '<div class="copy-text">&copy; 2015-' + year + ' OOO &laquo;Stuffex&raquo;</div>';
        copy.insertAdjacentHTML('beforeEnd', copyText);
    }());
    
</script>
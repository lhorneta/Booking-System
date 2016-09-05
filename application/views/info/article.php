
<meta property="og:type" content="article">
<meta property="og:url" content="http://<?=$_SERVER['SERVER_NAME']?>/info/article/<?=$article->url?>">
<meta property="og:title" content="<?=$article->title?>">
<meta property="og:description" content="<?=$article->meta_d?>">
<meta property="og:image" content="<?=($article->img)?'http://'.$_SERVER['SERVER_NAME'].'/uploads/blog/'.$article->url.'/'.$article->img:''?>">

<div id="main-info-page">
    <div class="top-line"></div>
    <div class="private-office-content info-container">
        <div class="tabbable"> <!-- Only required for left/right tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Блог</a></li>
                <li><a href="#tab2" data-toggle="tab">Контакты</a></li>
                <li><a href="#tab3" data-toggle="tab">О нас</a></li>
                <li><a href="#tab4" data-toggle="tab">FAQ</a></li>
                <li><a href="#tab5" data-toggle="tab">Условия использования</a></li>
                <li><a href="#tab6" data-toggle="tab">Как это работает</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane blogindex clearfix active" id="tab1">
                    <div id="blog" class="clearfix art">
                        <div class="blog-content-holder">
                            <div class="blog-content">
                            	
                                <?php if ($article) { ?>
                                <div class="back-nav">
						            <a href="/info/index?tab1" class="back">назад</a>
						        </div>
                                <article>
						            <div class="date"><?=date('d.m.Y в H:i', strtotime($article->date_add));?></div>
						            <h2><?=$article->title?></h2>
						            <div class="text">
						                <p><?=$article->description?></p>
						            </div>
						            <?php if ($article->img) { ?>
                                    <div class="img-holder" style="background-image: url('/uploads/blog/<?=$article->url?>/<?=$article->img?>')"></div>
                                    <?php } ?>
						            <div class="social-likes">
                                        <div class="facebook" title="Поделиться ссылкой на Facebook" <?=($article->img)?'data-media="http://'.$_SERVER['SERVER_NAME'].'/uploads/blog/'.$article->url.'/'.$article->img.'"':''?> data-title="<?=$article->title?>" data-url="http://<?=$_SERVER['SERVER_NAME']?>/info/article/<?=$article->url?>"></div>
                                        <div class="vkontakte" title="Поделиться ссылкой во Вконтакте" <?=($article->img)?'data-media="http://'.$_SERVER['SERVER_NAME'].'/uploads/blog/'.$article->url.'/'.$article->img.'"':''?> data-title="<?=$article->title?>" data-url="http://<?=$_SERVER['SERVER_NAME']?>/info/article/<?=$article->url?>"></div>
                                        <div class="plusone" title="Поделиться ссылкой в Google+" <?=($article->img)?'data-media="http://'.$_SERVER['SERVER_NAME'].'/uploads/blog/'.$article->url.'/'.$article->img.'"':''?> data-title="<?=$article->title?>" data-url="http://<?=$_SERVER['SERVER_NAME']?>/info/article/<?=$article->url?>"></div>
                                    </div>
						        </article>
                                <?php } ?>
                                
                            </div>
                            <div class="reviews">
				            <!-- <h4>Комментарии <a href="#" class="add-review-lnk <?=(App::gi()->user)?'actrew':''?>" style="display:inline-block; float: right" <?=(App::gi()->user)?'':'data-target="#createAdmin" data-toggle="modal"'?>>Добавить комментарий</a></h4> -->
				            <h4>Комментарии <a href="#" class="add-review-lnk actrew" style="display:inline-block; float: right">Добавить комментарий</a></h4>
				            <div class="reviews">
				            	<?php if ($reviews) { ?>
				            	<?php foreach ($reviews as $k => $r) {
				            	$user = User::modelWhere('id=?', array($r->id_user));
								$rating = getUserRating($user->id);
				            	?>
								<div class="review" id="rev_<?=$r->id?>">
					                <div class="user">
					                    <div class="foto" style="<?=($user->avatar)?'background-image: url('.$user->avatar.')':'background-image: url(/assets/images/photo.jpg)'?>"></div>
					                    <span class="name"><?=$user->name?></span>
					                </div>
					                <div class="evaluation">
					                    <div class="rateit" data-rateit-starwidth="12" data-rateit-starheight="13" data-rateit-value="<?=$rating?>"></div>
					                    <span><?=echoRussianDate(strtotime($r->dateadd))?></span>
					                </div>
					                <!-- <div class="title">Отличный автомобиль</div> -->
					                <div class="review-text">
					                    <p><?=$r->text?></p>
					                </div>
					                
					                <?php
					                $revs = Comment::modelsWhere('id_blog=? AND parent=? AND status=1', array($article->id, $r->id));
									if ($revs) {
					                ?>
					                <div class="answers">
					                    <a class="openanswers" rel="<?=$r->id?>" href="#">+ Ответы на комментарий</a>
					                    <!-- <span>28 Ноября, 2015</span> -->
					                    <div class="ansrews openaningswers" id="rev_<?=$r->id?>">
					                    <?php foreach ($revs as $ks => $rs) {
					                    $u = User::modelWhere('id=?', array($rs->id_user));
										$rat = getUserRating($u->id);
					                    ?>
					                    
					                    <div class="review" >
								            <div class="user">
								                <div class="foto" style="<?=($u->avatar)?'background-image: url(/uploads/user/'.$u->id.'/'.$u->avatar.')':'background-image: url(/assets/images/photo.jpg)'?>"></div>
								                <span class="name"><?=$u->name?></span>
								            </div>
								            <div class="evaluation">
								                <div class="rateit" data-rateit-starwidth="12" data-rateit-starheight="13" data-rateit-value="<?=$rat?>"></div>
								                <span><?=echoRussianDate(strtotime($rs->dateadd))?></span>
								            </div>
								            <!-- <div class="title">Отличный автомобиль</div> -->
								            <div class="review-text">
								                <p><?=$rs->text?></p>
								            </div>
							            
							            </div>
					                    
					                    <?php } ?>
					                    </div>
					                </div>
					                <?php } ?>
					                
					                <button type="button" class="answer-bnt revansw" rel="<?=$r->id?>">Ответить</button>
					                <!-- <button type="button" class="like-bnt"><i></i></button> -->
					            </div>
								<?php } ?>
				            	<?php } else { ?>
				            	<div class="noreviews">Здесь будут комментарии</div>
				            	<?php } ?>
				            	
				            </div>
				            <div class="successrev">Спасибо, Ваш комментарий сохранен и будет опубликован после проверки модератором</div>
				            <div id="blog_review_form" class="comments_with_answers">
				            	
				            	<div class="add-review user_review">
						            <h4>Добавление комментария <span class="pull-right ansname"></span></h4>
						            <form action="#" method="post" id="commentblogform">
						                	<div class="savehide">
							                	<input type="hidden" name="review[id_blog]" value="<?=$article->id?>">
							                	<input type="hidden" name="review[parent]" class="parentrev" value="0">
							                    <textarea name="review[text]" placeholder="Ваш комментарий *" id="textcomment" required=""></textarea>
						                    </div>
						                    <input type="submit" value="Комментировать" class="btn <?=(App::gi()->user)?'actrew':''?>" id="commentblog" <?=(App::gi()->user)?'':'data-target="#createAdmin" data-toggle="modal"'?>>
						            </form>
						        </div>
				            	
				            </div>
				            
				        </div>
                            
                            
                        </div>
                        <div class="blog-navigation">
                        	<?php if ($rubrics) { ?>
                            <div class="rubrics-links">
                                <h5>Рубрики</h5>
                                <ul>
                                	<?php foreach ($rubrics as $kr => $rubric) { ?>
                                		<?php //debug($rubric); ?>
                                    <li><a class="rubriclink" href="/info/rubric/<?=$rubric->url?>?tab1"><?=$rubric->title?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <?php } ?>
                            <?php if ($popular) { ?>
                            <div class="most-popular">
                                <h5>Самое читаемое</h5>
                                <ul>
                                	<?php foreach ($popular as $kp => $p) {
                                	$coments = Comment::modelsWhere('id_blog=?', array($p->id));
                                	?>
                                	<li>
                                        <a class="rubriclink" href="/info/article/<?=$p->url?>"><?=$p->title?></a>
                                        <p><?=$p->views?> просмотров, <?=count($coments)?> комментариев</p>
                                    </li>
                                    <?php } ?>
                                    
                                </ul>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane clearfix" id="tab2">
                    <div id="contacts" class="clearfix">
                        <div class="rigth-part">
                            <div class="write-to-us">
                                <div class="icon-holder"></div>
                                <p>Написать нам</p>
                                <a href="mailto:info@staffex.ua" >info@staffex.ua</a>
                            </div>  
                            <div class="call-to-us">
                                <div class="icon-holder"></div>
                                <p>Позвонить нам</p>
                                <a href="tel:+380991234567" class="phone" onclick="yaCounter33331293.reachGoal('tel380991234567up'); return true;">
                                    +380 99 123-45-67
                                </a>
                            </div>                                     
                        </div>
                        <div class="left-part">
                            <div class="preview-text">
                                <h2>Обратная связь</h2>
                                <p>Если у вас возникли вопросы по работе сервиса, команда OLX всегда рядом! Чтобы помочь вам максимально оперативно, нам важны все детали. Опишите суть проблемы, укажите номер объявления и добавьте скриншоты. Загляните в раздел Помощь	- там есть ответы на наиболее распространенные вопросы. Удачных сделок! :)</p>
                            </div>
                            <div class="feedback-form-box">
                                <form action="#" method="post" id="cbf">
                                    <fieldset>
                                        <section class="field">
                                            <strong>Выберите тему <i>*</i></strong>
                                            <select class="selectpicker" required>
                                                <option>Платные услуги</option>
                                                <option>Бесплатные услуги</option>
                                                <option>Все услуги</option>
                                            </select>
                                        </section>
                                        <section class="field">
                                            <strong>Текст сообщения <i>*</i></strong>
                                            <textarea class="form-control" required></textarea>
                                        </section>
                                        <section class="field">
                                            <strong>Номер объявления</strong>
                                            <input type="number" class="form-control">
                                        </section>
                                        <section class="field">
                                            <strong>Email-адрес <i>*</i></strong>
                                            <input type="email" class="form-control" required>
                                        </section>
                                        <!-- <section class="field send-holder">
                                            <div class="add-file">
                                                <div class="input-holder">
                                                    <input type="file">
                                                    <p>Прикрепить файл</p>
                                                </div>
                                                <p>Типы файлов, которые принимаются: jpg, jpeg, png, doc, pdf, gif, zip, rar, tar, html, swf, txt, xls, docx, xlsx, odt</p>                                  
                                            </div>
                                        </section> -->
                                        <input type="submit" value="Отправить сообщение" class="btn main-btn" id="sendfeedback">
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>                
                </div>
                <div class="tab-pane clearfix" id="tab3">
                    <div id="about-us">
                        <div class="logo-row">
                            <a href="#" class="logo"><img src="/assets/images/logo.png" alt="Логотип"></a>
                        </div>
                        <div class="text-container">
                            <p>Staffex — сервис объявлений №1 в Украине. Украинская база площадки насчитывает более 9 млн. объявлений и ежемесячно пополняется более чем на 3 млн. новых предложений. В среднем новое объявление публикуется каждую секунду. Сайт входит в топ-10 самых популярных ресурсов среди украинцев по данным компании Gemius (Fusion панель, апрель 2015). Каждый четвертый интернет-пользователь из Украины посещает сайт минимум один раз в месяц.</p>
                            <p>На OLX вы сможете разместить или найти объявление из первых рук. Наши пользователи — это люди, которые умеют экономить и стремятся рационально использовать свой бюджет, не любят переплачивать и хотят избавиться от ненужных вещей с выгодой для себя. На OLX есть товары любой ценовой категории – от «народных» до брендовых, при этом они будут стоить в несколько раз дешевле, чем в любом магазине. Даже человек, которому впервые подключили интернет, без каких-либо сложностей сможет найти или разместить объявление в считанные минуты!</p>
                            <p>Первое объявление появилось на Slando 3 марта 2006 года. Этот день мы считаем нашим днем рождения и гордимся своей маленькой историей. С сентября 2015 года украинский сервис является частью международной сети площадок частных объявлений OLX, которыми пользуются в более 40 странах мира!</p>
                            <p>Запросы от журналистов мы принимаем на почту press_ua@olx.com. По вопросам рекламы и сотрудничества пишите на marketing_ua@olx.com.</p>
                            <p>По иным вопросам обращайтесь, пожалуйста, в Службу поддержки.</p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane clearfix" id="tab4">
                    <div id="faq">
                        <div class="text">
                            <div class="title">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium, nemo.</div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor, doloribus, deserunt? Perspiciatis et, dignissimos repellat, qui aut id culpa. Fugiat veritatis sunt quam excepturi consequuntur voluptate fuga soluta beatae, asperiores architecto? Hic dicta ullam eligendi aperiam officia, aspernatur eum, possimus alias corporis, quibusdam tempore commodi cupiditate laboriosam! Maiores atque earum repellendus fugit quod, soluta nisi libero natus possimus voluptatum sequi facilis ab amet, expedita labore inventore rem, nostrum porro. Voluptas quos debitis dolores quod asperiores quis, est soluta, possimus quia officia sunt iste iure quaerat facere! Eligendi similique aperiam fugiat! Ut error, nisi sapiente tempore ab odit quae at illo.</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae id nobis, quibusdam inventore repellendus accusantium ullam, dolores ab ratione! Quibusdam repudiandae ullam aliquam, dolor minus unde illum earum sunt veniam obcaecati expedita quae deserunt quis eveniet, omnis commodi iure voluptates facere fugiat nemo ipsum doloremque velit dicta temporibus at. Animi tempore nulla excepturi soluta ea odio veritatis minus aliquam sequi odit ad perspiciatis libero officia cumque, magni est, commodi impedit aspernatur id itaque nemo adipisci debitis molestiae. Autem asperiores ut expedita consequatur eveniet, repudiandae, cum quasi reiciendis quis omnis amet, nostrum adipisci ullam nesciunt praesentium eius. Nam ipsa modi maxime! Assumenda a aspernatur consequatur numquam nam eaque, voluptatem debitis magnam asperiores placeat ipsa expedita dolor fugit aut, beatae distinctio explicabo, minima eius possimus, laboriosam architecto dolores maxime nostrum doloremque. Odio molestiae, sint error temporibus quis quod nam provident ut sunt maiores dolorem perspiciatis, delectus neque. Qui ut nostrum nisi explicabo.</p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane clearfix" id="tab5">
                    <div id="conditions-of-use">
                        <div class="content-block">
                            <div class="general-provisions">
                                <h2>1. ОБЩИЕ ПОЛОЖЕНИЯ</h2>
                                <ol>
                                    <li>ООО «ЕМАРКЕТ УКРАИНА», (далее Исполнитель и/или Компания) публикует данный Публичный договор (Соглашение и/или Оферта) об оказании услуг на интернет-сайтах</li>
                                    <li>В соответствии со статьей 633 Гражданского Кодекса Украины (ГК Украины) данное Соглашение является публичным договором, и в случае принятия (акцепта) изложенных ниже условий любое дееспособное физическое или юридическое лицо (далее Пользователь) обязуется выполнять условия этого Соглашения.</li>
                                    <li>
                                        <p>В настоящей оферте, если контекст не требует иного, нижеприведенные термины имеют следующие значения:</p>
                                        <ul>
                                            <li>Оферта – публичное предложение Исполнителя, адресованное любому физическому и/или юридическому лицу, заключить с ним Публичный договор об оказании услуг на условиях, содержащихся в данном Соглашении, включая все его приложения;</li>
                                            <li>Акцепт – полное принятие Пользователем условий Соглашения;
                                            </li>
                                            <li>Исполнитель - ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ «ЕМАРКЕТ УКРАИНА», юридический адрес: ул. г. Киев, ул. Владимирская, 77А;</li>
                                            <li>Сайты – http://olx.ua/, http://olx.by/, http://olx.kz/ – интернет-сайты, администрируемые Компанией и представляющий собой коммуникационную платформу для размещения временных классифицируемых объявлений (далее по тексту – Сайт и/или Сайты);</li>
                                            <li>Пользователь – любое дееспособное физическое или юридическое лицо, принявшее условия данного Соглашения и пользующееся услугами Компании;</li>
                                            <li>Товар - любой материальный и нематериальный объект;</li>
                                            <li>Услуга – любая операция, не являющаяся поставкой товаров, связанная с предоставлением сервиса, который потребляется в процессе совершения определенного действия или осуществления определенной деятельности, для удовлетворения личных потребностей заказчика;</li>
                                            <li>Услуги/сервис OLX.ua – любые платные и бесплатные сервисы, оказываемые Исполнителем при помощи Сайтов (например, в том числе, но не исключительно, всех его возможностей, текста, данных, информации, программного обеспечения, графиков или фотографий, рисунков и т.д. и т.п.), а также любых других услуг, предоставляемых Компанией с помощью сервисов Сайтов.</li>
                                            <li>Учетная запись/аккаунт – электронный кабинет Пользователя в функциональной системе Сайтов, с помощью которого он может управлять своими объявлениями на Сайтах;</li>
                                            <li>Регистрация – принятие Пользователем оферты на заключение данного Соглашения и процедура, в ходе которой Пользователь посредством заполнения соответствующих форм Сайта предоставляет необходимую информацию для использования сервисов Сайта. Регистрация считается завершенной только в случае успешного прохождения всех ее этапов в соответствии с опубликованными на Сайте инструкциями.</li>
                                            <li>Персональные данные - это сведения или совокупность сведений о физическом лице, которое при их помощи идентифицировано или может быть конкретно идентифицировано.</li>
                                        </ul>
                                    </li>
                                </ol>
                                <p>Если Пользователь не согласен с настоящими условиями полностью или частично, Исполнитель просит его покинуть данный сайт. Настоящие условия регулируют использование Пользователем Сайтов и услуг OLX.ua. Использование Услуг slando означает, что Пользователь ознакомлен с настоящим Соглашением, понимает и принимает его условия.
                                    Начиная использовать какой-либо сервис OLX.ua, либо пройдя процедуру регистрации, Пользователь считается принявшим условия Соглашения в полном объеме, без всяких оговорок и исключений. В случае несогласия Пользователя с какими-либо из положений настоящего Cоглашения, Пользователь не в праве использовать сервисы OLX.ua.
                                    Настоящим Компания предлагает Пользователям сети Интернет использовать свои сервисы на условиях, изложенных в настоящем Соглашении.</p>
                                <p>Компания предлагает Пользователю услуги по использованию Сайтов olx.ua, olx.by, olx.kz для размещения информации о товарах (услугах) c целью, в том числе, но не исключительно, последующей покупки или продажи различных товаров и услуг другими Пользователями.</p>
                                <p>Все сделки заключаются между Пользователями напрямую. Таким образом, Компания не является участником сделок Пользователей, а лишь предоставляет коммуникационную торговую платформу для размещения объявлений.</p>
                            </div>
                            <div class="ad-placement">
                                <h2>2. РАЗМЕЩЕНИЕ ОБЪЯВЛЕНИЙ</h2>
                                <ol>
                                    <li>Пользователь получает право размещать объявления на Сайтах после заполнения специальной формы с указанием параметров предлагаемых товаров или услуг.</li>
                                    <li>Пользователь также имеет право зарегистрироваться на Сайтах с целью получения дополнительных сервисов, заполнив формуляр с указанием действительного электронного адреса, к которому имеет доступ только Пользователь, выбранного пароля, а также других данных, необходимых для регистрации. После этого Пользователь получает электронное письмо с подтверждением регистрации, содержащее ссылку, переход по которой необходим для завершения регистрации.</li>
                                    <li>Использование возможностей и сервисов Сайтов, как зарегистрированными так и незарегистрированными Пользователями означает принятие обязательств следовать правилам и инструкциям по пользованию услугами OLX.ua.</li>
                                    <li>Пользователь несет ответственность за все действия с использованием его электронного адреса и пароля для входа на Сайты. Пользователь имеет право пользоваться сервисами Сайтов только при помощи собственного электронного адреса и пароля.</li>
                                    <li>Пользователь обязуется сохранять конфиденциальность переданного ему пароля и не раскрывать его третьим лицам.</li>
                                    <li>Пользователь обязан немедленно изменить данные для входа на Сайты, если у него есть причины подозревать, что его 
                                        электронный адреса и пароль, используемые для входа на Сайты, были раскрыты или могут быть использованы третьими лицами.</li>
                                    <li>Пользователь, размещающий объявления о продаже товаров или услуг на Сайте, обязуется разместить информацию о них в соответствии настоящим Соглашением и инструкциями, представленными на Сайте, и предоставить точную и полную информацию о товаре или услугах и условиях их продажи. Размещая информацию о товаре или услуге, Пользователь подтверждает, что он имеет право продавать этот товар или оказывать данную услугу в соответствии с требованиями законодательства стран, в которых они реализуются.</li>
                                    <li>Пользователь гарантирует, что предлагаемые им товары/услуги соответствуют нормам качества, установленным законодательством стран, для которых они реализуются и свободны от притязаний третьих лиц.</li>
                                    <li>Пользователь гарантирует, что предлагаемые им услуги, в случае если оказание их требует специального разрешения, будут осуществлены в соответствии с требованиями законодательства стран, специальные органы которых будут уполномочены осуществлять надзор за такой деятельностью пользователя.</li>
                                    <li>Пользователь обязан тщательно проверить всю информацию о товарах и услугах, размещенных им на Сайтах, и, в случае обнаружения неверной информации, добавить необходимые сведения в описание товара или услуги. Если это невозможно, исправить неверную информацию, аннулировав объявление и повторно разместив информацию о товаре или услуге.</li>
                                    <li>Условия доставки должны включаться в описание товара, а условия оказания услуг в описание услуги. Условия продажи товара и оказания услуг, составленные Пользователем, не должны противоречить настоящему Соглашению и действующему законодательству стран, для которых они реализуются.</li>
                                    <li>
                                        <p>Пользователь обязуется не оказывать активную поддержку и не распространять информацию об услугах, предоставляемых конкурентами Исполнителя, как-то, но не исключительно:</p>
                                        <ul>
                                            <li>Информацию о других досках объявлений, торговых площадках, интернет-аукционах и/или интернет-магазинах;</li>
                                            <li>Интернет-ресурсах, предлагающих товары и услуги, запрещенные к продаже на Сайтах.</li>
                                        </ul>
                                    </li>
                                    <li>Компания имеет право переместить, завершить или продлить срок демонстрации товара или услуги Пользователя по техническим причинам, находящимся под контролем или вне контроля Компании. Сайт имеет право прекратить демонстрацию объявления, если Пользователь зарегистрировал товар или услугу, с нарушением условий настоящего Соглашения или действующего правоприменительного законодательства.</li>
                                    <li>
                                        <p>Пользователю запрещено:</p>
                                        <ol>
                                            <li>Публиковать одинаковые объявления с одного и того же адреса электронной почты;</li>
                                            <li>Публиковать схожие по содержанию объявления, где очевидно, что речь идет об одном и том же предложении;</li>
                                            <li>Дублировать одинаковые объявления с разных адресов электронной почты;</li>
                                            <li>Публиковать объявления в рубрике, которая не соответствует содержанию объявления;</li>
                                            <li>Публиковать объявления, в заголовке которых содержатся повторяющиеся знаки пунктуации и/или небуквенные символы;</li>
                                            <li>Публиковать объявления, описание и/или заголовок/фотографии которых являются несвязанными, нечитаемыми;</li>
                                            <li>Публиковать объявления с предложением нескольких товаров и услуг одновременно;</li>
                                            <li>Вставлять в объявлении ссылки на ресурсы, которые содержат вредоносные элементы либо ссылки на главную страницу сайта;</li>
                                            <li>Размещать объявление о товаре или услуге, если такое размещение может привести к нарушению правоприменительного законодательства;</li>
                                            <li>Объявления должны соответствовать географической области и городу, выбранной в соответствующих функциональных настройках Сайтов.</li>
                                            <li>Разрешается разместить одно объявление касательно одного конкретного предмета, объекта имущества, вакансии, услуги.</li>
                                            <li>Объявления могут проходить выборочную пост или премодерацию представителями Компании.
                                            </li>
                                            <li>Запрещается размещать объявления, рекламирующие продажу:</li>
                                        </ol>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane clearfix" id="tab6">
                    <div id="faq">
                        <div class="text">
                            <div class="title">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium, nemo.</div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor, doloribus, deserunt? Perspiciatis et, dignissimos repellat, qui aut id culpa. Fugiat veritatis sunt quam excepturi consequuntur voluptate fuga soluta beatae, asperiores architecto? Hic dicta ullam eligendi aperiam officia, aspernatur eum, possimus alias corporis, quibusdam tempore commodi cupiditate laboriosam! Maiores atque earum repellendus fugit quod, soluta nisi libero natus possimus voluptatum sequi facilis ab amet, expedita labore inventore rem</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae id nobis, quibusdam inventore repellendus accusantium ullam, dolores ab ratione! Quibusdam repudiandae ullam aliquam, dolor minus unde illum earum sunt veniam obcaecati expedita quae deserunt quis eveniet, omnis commodi iure voluptates facere fugiat nemo ipsum doloremque velit dicta temporibus at. Animi tempore nulla excepturi soluta ea odio veritatis minus aliquam sequi odit ad perspiciatis libero officia cumque, magni est, commodi impedit aspernatur id itaque nemo adipisci debitis molestiae. Autem asperiores ut expedita consequatur eveniet, repudiandae, cum quasi reiciendis quis omnis amet, nostrum adipisci ullam nesciunt praesentium eius. Nam ipsa modi maxime! Assumenda a aspernatur consequatur numquam nam eaque, voluptatem debitis magnam asperiores placeat ipsa expedita dolor fugit aut, beatae distinctio explicabo, minima eius possimus, laboriosam architecto dolores maxime nostrum doloremque. Odio molestiae, sint error temporibus quis quod nam provident ut sunt maiores dolorem perspiciatis, delectus neque. Qui ut nostrum nisi explicabo.</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim provident veritatis iste culpa voluptate. Similique sit sunt quam pariatur laborum nihil soluta, itaque magni tenetur. Nulla reiciendis labore, provident! Non dolore, fugiat! Ratione aliquam id aperiam tempore fugiat temporibus, distinctio fuga! Quod praesentium sequi laudantium quos, a dolores dignissimos dolor sit fuga aliquam impedit veritatis repellat voluptate esse natus at repellendus id, voluptatem eum, reiciendis. Odit non, fuga aut animi harum modi cumque voluptates earum natus culpa, quos expedita repudiandae obcaecati aspernatur distinctio nostrum suscipit adipisci, molestias nesciunt veniam perspiciatis consequatur accusantium reprehenderit. Neque assumenda molestias, rem obcaecati consequuntur quia illum recusandae mollitia, cupiditate a, voluptate nihil, rerum cum maiores est iusto voluptas. Provident iste, maxime distinctio eveniet dignissimos saepe hic molestias magni incidunt aut. Asperiores odio excepturi laudantium placeat libero distinctio fuga eum vel sed nobis aperiam repellendus sapiente, doloribus, iusto officiis! Iste, eligendi accusantium, obcaecati provident veniam corporis, sed consequuntur deleniti eos incidunt quibusdam ut error. Eaque obcaecati quaerat atque harum vel dolorum alias cumque, commodi facere! Delectus voluptate id quaerat vero nisi! Voluptatem dolor debitis odio tempore ipsam nesciunt. Magni saepe libero in soluta incidunt minus voluptas deleniti maiores, non unde, quasi. Veniam cupiditate voluptate facilis non.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $revs = (isset($_GET['reviews']))?1:0; ?>
<?php if ($revs) { ?>
<script type="text/javascript">
	$(function(){
		$("html, body").animate({ scrollTop: $('#reviews').offset().top }, 1000);
	});
</script>
<?php } ?>
<?php $u = App::gi()->user; $uid = $user->id; ?>
<div class="main-user-profile-holder">
    <div id="main-user-profile" class="clearfix">
    <div class="author-ad">
        <div class="author-info">
            <div class="foto" style="background-image: url(<?=($user->avatar)?$user->avatar:'/assets/images/photo.jpg'?>)"></div>
            <div class="holder">
                <div class="name"><?=$user->name?> <?=$user->surname?></div>
                <div class="evaluation">
                    <div class="rateit" data-rateit-value="<?=$lot->rating;?>" data-rateit-starwidth="12" data-rateit-starheight="13"></div>
                    <a href="#" onclick="$('html, body').animate({ scrollTop: $('#reviews').offset().top }, 1000);">(<?=Review::countRowWhere('id_user=?', array($user->id))?> отзывов)</a>
                </div>
                <span>на stuffe<i>x</i> c сентрября 2012</span>
            </div>
        </div>
        <div class="link-holder">
            <a href="tel:<?=$user->phone0?>" class="phone"><?=$user->phone0?></a>
           <?php if ($u) {
           if ($user->id!=$u->id) { ?> 
            <a href="mailto:<?=$user->email?>" class="write-to-author" data-toggle="modal" data-target="#writeToAuthor">Написать автору</a> 
           <? }} ?>
        </div>
        <?php $date = date("F Y", $user->register_time); ?>
        <span>на stuffe<i>x</i> c <?=$date?></span>
        <div class="modal fade" id="writeToAuthor" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
            <div class="modal-dialog create-admin" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="/lot/leavemessage" data-form="">
                            <textarea name="message[text]" required></textarea>
                            <input type="hidden" name="message[id_to]" value="<?= $user->id; ?>">
                            <input type="submit" value="Отправить сообщение владельцу" class="btn"/>
                        </form>                            
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="info-text-section">
    	<?php if($user->id_role==2){?>
        	<div class="name"><?=$user->name?> <?=$user->surname?></div>
        <? }else if($user->id_role==3) {?>
        	<div class="name"><?=$user->company_name?></div>
        <? } ?>
        <div class="evaluation">
            <div class="rateit" data-rateit-value="<?=$lot->rating;?>" data-rateit-starwidth="12" data-rateit-starheight="13"></div>
            <a href="#" onclick="$('html, body').animate({ scrollTop: $('#reviews').offset().top }, 1000);">(<?=Review::countRowWhere('id_user=?', array($user->id))?> отзывов)</a>
        </div>
<!--
        <div class="show-link-holder link-user-map-holder">
            <a href="#" onclick="return false" class="show-link show-user-map" data-toggle="modal" data-target="#modalmapUserProf">
                <span class="img-holder btn"><i></i></span>
                <strong>Показать объявление на карте</strong>
            </a>
        </div>
-->
        <?php if($user->id_role==2){?>
        	<p><?=$user->description?></p>
        <? }else if($user->id_role==3) {?>
        	<p><?=$user->description_comp?></p>
        <? } ?>
        
        <?php if (isset($map->address)) { ?>
        <a href="#" class="address address-480px"><?=$map->address?></a>
		<?php } ?>

<!--
        <div class="modal fade" id="modalmapUserProf" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <div class="modal-body">
                        <div id="mapUserProf"></div>



                    </div>
                </div>
            </div>
        </div>
-->
    </div>
    
    <div class="map-reviews-container">
    	<?php if ($map) { ?>
        <div class="map-container">
            <div id="map"></div>
            <script>
                // This example creates circles on the map, representing populations in North
                // America.

                // First, create an object containing LatLng and population for each city.
                var citymap = {
                    kiev: {
                        center: {lat: <?=$map->latitude?>, lng: <?=$map->longitude?> },
                        population: 100
                    }
                };

                function initMap() {
                    // Create the map.
                    var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 11,
                        scrollwheel: false,
                        center: {lat: <?=$map->latitude?>, lng: <?=$map->longitude?> },
                        mapTypeId: google.maps.MapTypeId.TERRAIN
                    });

                    // Construct the circle for each value in citymap.
                    // Note: We scale the area of the circle based on the population.
                    for (var city in citymap) {
                        // Add the circle for this city to the map.
                        var cityCircle = new google.maps.Circle({
                            strokeColor: '#FF0000',
                            strokeOpacity: 0.8,
                            strokeWeight: 2,
                            fillColor: '#FF0000',
                            fillOpacity: 0.35,
                            map: map,
                            center: citymap[city].center,
                            radius: Math.sqrt(citymap[city].population) * 100
                        });
                    }
                }
            </script>

            <script async defer
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpONh6QjiiZyV7Emi4nsSB7KJFApSbkzM&signed_in=true&callback=initMap">
            </script>
        </div>
        <?php } ?>
        
        <div class="reviews-goods-container">
            <div class="buttons-row">
                <button type="button" class="btn orders-btn <?=(!$revs)?'active':''?>">Объявления</button>
                <button type="button" id="reviews" class="btn reviews-btn <?=($revs)?'active':''?>">Отзывы</button>
            </div>
            <div class="goods-container" <?=($revs)?'style="display:none"':''?>>
                <h4>Мои объявления</h4>
                <div class="result-nav">
                    <div class="switches">
                        <span>Вид списка:</span>
                        <button type="button" class="colums"></button>
                        <button type="button" class="rows active"></button>
                    </div>
                </div>
                <div class="products-holder">
                	<?php if ($lots) {
                	foreach ($lots as $k => $lot) {
                	$lot->takeImages();
                    $lot->countReviews();
                	$cat = Category::modelWhere('id = ?', array($lot->id_category));
					if ($cat) { $cat->checkOnParentsAndTakeIt(); }
                	?>
						
                    <div class="product">
                    	
                    	<?php if(count($lot->images)){ ?>
                        <div class="img-holder" style="background-image: url(<?=Lot::UPLOAD_DIR.$lot->url.'/'.$lot->images[0]; ?>)"><a href="/lot/view/<?=$lot->url; ?>"></a></div>
                        <?php }else{ ?>
                        <div class="img-holder" style="background-image: url(/assets/images/no-img.png)"><a href="/lot/view/<?=$lot->url; ?>"></a></div>
                        <?php } ?>
                    	
                        <div class="evaluation-col-view">
                            <div class="rateit" data-rateit-value="<?=$lot->rating;?>" data-rateit-starwidth="12" data-rateit-starheight="13"></div>
                        </div>
                        
                        
                        
                        <div class="description">
                            <div class="title">
                                <a href="/lot/view/<?=$lot->url?>"><?=$lot->title?></a>
                                <?php if ($cat) { ?>
                                <ul class="category">
                                    <?php if (isset($cat->parent->parent)) { ?>
                                    <li><a href="/category/<?=$cat->parent->parent->url?>"><?=$cat->parent->parent->title?></a><i>&raquo;</i></li>
                                    <?php } ?>
                                    <?php if (isset($cat->parent)) { ?>
                                    <li><a href="/category/<?=$cat->parent->url?>"><?=$cat->parent->title?></a><i>&raquo;</i></li>
                                    <?php } ?>
                                    <li><a href="/category/<?=$cat->url?>"><?=$cat->title?></a><i>&raquo;</i></li>
                                </ul>
                                <?php } ?>
                            </div>
                            
                            <?php
                            $loc = 'Город не указан';
	                        $reg = Region::modelWhere('id=?', array($lot->id_region));
							$city = City::modelWhere('id=?', array($lot->id_city));
							if ($reg) {
								$loc = $reg->title_ru;
							}
							if ($city) {
								$loc .= ', '.$city->title_ru;
							}
	                        if ($loc=='Город не указан'&&$lot->address) {
	                           	$loc = $lot->address;
	                        }
                            ?>
                            
                            <div class="place-time">
                                <?php if($lot->show_address && $lot->show_address==1){ ?>
	                                <div class="place"><?=$loc?></div>
			                    <?php	} ?>
                                <div class="time"><?=date("d F H:i", $lot->time)?></div>
                            </div>
                            <div class="price-box-col-view">от <span><?=$lot->day_payment?></span> грн./ сутки</div>
                        </div>
                        <?php $count = Review::countRowWhere('id_lot=?', array($lot->id)); ?>
                        <div class="price-holder">
                            <div class="evaluation">
                                <div class="rateit" data-rateit-value="<?=$lot->rating;?>" data-rateit-starwidth="12" data-rateit-starheight="13"></div>
                                <a href="/lot/view/<?=$lot->url?>#reviews">(<?=$count?> отзывов)</a>
                            </div>
                            <div class="price">
                                <strong><?=$lot->day_payment?> грн.</strong>
                                <span>Цена за сутки</span>
                                <?php if ($lot->day_payment) { ?>
                                    <div class="other-price">
                                    	<?php if ($lot->week_payment && $lot->week_payment>0) { ?>
                                        <span><?= $lot->week_payment; ?> / <i>Цена за неделю</i></span>
                                        <?php } else { ?>
                                        <span><?=($lot->day_payment*7)?> / <i>Цена за неделю</i></span>
                                        <?php } ?>
                                        <?php if ($lot->month_payment && $lot->month_payment>0) { ?>
                                        <span><?= $lot->month_payment; ?> / <i>Цена за месяц</i></span>
                                        <?php } else {?>
                                        	<?php if ($lot->day_payment && $lot->day_payment>0) { ?>
                                        		<span><?=($lot->day_payment*30)?> / <i>Цена за месяц</i></span>
                                        	<?php } ?>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } else { ?>
                 	
                 	<?php if ($u&&$user->id!=$u->id) { ?>
                    <div class="no_reviews">Здесь будут все активные лоты пользователя</div>
                    <?php } else { ?>
                    <div class="no_reviews">Здесь будут все Ваши активные лоты</div>
                    <?php } ?>
                    
                    <?php } ?>
                    
                    
                </div>
            </div>
            
            <?php $alreadyrev=0; foreach ($reviews as $kr => $review) {
            	if ($u&&$review->id_reviewer==$u->id) {
            		$alreadyrev = 1;
            	}
            }?>
            <div class="reviews-container"  <?=($revs)?'style="display:block"':''?>>
                <div class="reviews">
                    <h4>Отзывы<?php if (!$alreadyrev) { ?><a href="#" class="revansw pull-right">Оставить отзыв</a><?php } ?></h4>
                    <?php $myrev = 0; if ($reviews) { ?>
                    <?php foreach ($reviews as $kr => $review) {
                    $user = User::modelWhere('id=?', array($review->id_reviewer));
					//debug($user);
                    ?>
                    <div class="review" id="rev_<?=$review->id?>">
                        <div class="user">
                            <div class="foto" style="background-image: url('<?=(isset($user->avatar))?$user->avatar:'/assets/images/photo.jpg'?>')"></div>
                            <span class="name"><?=($user)?$user->name:''?></span>
                        </div>
                        <div class="evaluation">
                        	
                        	<?php $rat = getUserRating($review->id_reviewer); ?>
                            <div class="rateit" data-rateit-starwidth="12" data-rateit-starheight="13" data-rateit-value="<?=$rat?>"></div>
                            <span><?=date("d F, Y", $review->time)?></span>
                        </div>
                        <div class="title"><?=($review->title)?$review->title:"Заголовок не указан"?></div>
                        <div class="review-text">
                            <p><?=$review->text?></p>
                        </div>
                        
                        <?php 
					    $revs = Review::modelsWhere('id_user=? AND parent=? AND reposted=0', array($uid, $review->id));
						//debug($revs);
						if ($revs) {
						    ?>
						    <div class="answers">
						        <a class="openanswers" rel="<?=$review->id?>" href="#">+ Ответы на комментарий</a>
						        <div class="ansrews openaningswers" id="rev_<?=$review->id?>">
						        <?php foreach ($revs as $ks => $rs) {
						        
						        $us = User::modelWhere('id=?', array($rs->id_reviewer));
								$rat = getUserRating($us->id);
								if ($u&&$rs->id_reviewer==$u->id) {$myrev=1;}
						        ?>
						        
						        <div class="review" >
						        <div class="user">
						            <div class="foto" style="<?=($us->avatar)?'background-image: url('.$us->avatar.')':'background-image: url(/assets/images/photo.jpg)'?>"></div>
						            <span class="name"><?=$us->name?></span>
						        </div>
						        <div class="evaluation">
						            <div class="rateit" data-rateit-starwidth="12" data-rateit-starheight="13" data-rateit-value="<?=$rat?>"></div>
						            <span><?=echoRussianDate(strtotime($rs->time))?></span>
						        </div>
						        <div class="review-text">
						            <p><?=$rs->text?></p>
						        </div>
						    
						    </div>
						        
						        <?php } ?>
						        </div>
						    </div>
					    <?php } ?>
                        
                        <?php if ($u) {
                        	
							if ((!$myrev||count($revs)<1)&&$uid==$u->id) { ?>
		                        <button type="button" class="answer-bnt revansw" rel="<?=$review->id?>">Ответить</button>
		               <?php }
							
						} else { ?>
                        <button type="button" class="answer-bnt" data-toggle="modal" data-target="#createAdmin">Ответить</button>
                        <?php }
		                    $votes = votes($review->id);
		                    $myvote = myvote($review->id);
                    	?>
                    <button type="button" class="like-bnt like_review <?=($myvote==1||!App::gi()->user)?'active':''?>" rel="<?=$review->id?>" <?=(App::gi()->user)?'':'data-target="#createAdmin" data-toggle="modal"'?>><i rel="<?=$review->id?>"></i></button>
                    <!-- <div class="stat" rel="<?=$review->id?>">
                    	<span class="plus" style="width:<?=$votes->percent[1]?>%"><?=$votes->percent[1]?>%</span>
                    	<span class="minus"style="width:<?=$votes->percent[2]?>%"><?=$votes->percent[2]?>%</span>
                    </div>
                    <button type="button" class="unlike-bnt unlike_review <?=($myvote==2||!App::gi()->user)?'active':''?>" rel="<?=$review->id?>" <?=(App::gi()->user)?'':'data-target="#createAdmin" data-toggle="modal"'?>><i rel="<?=$review->id?>"></i></button> -->
                        
                    </div>
                    <?php } ?>
                    <?php } else { ?>
	                    <?php if ($u) { ?>
		                    <?php if ($user->id!=$u->id) { ?>
		                    <div class="no_reviews">Здесь будут отзывы о пользователе</div>
		                    <?php } else { ?>
		                    <div class="no_reviews">Здесь будут отзывы о Вас</div>
		                    <?php } ?>
		                <?php } ?>   
                    <?php } ?>
                    
                    <?php if ($u) {
                    	if ((App::gi()->user)) {
                    		$bookings = Booking::modelWhere('id_from=? AND id_to=? AND confirmed=1', array($u->id, $uid));
							if ($bookings) {
								if ($myrev) {
									$rev = 'id="" data-target="#alreadyrev" data-toggle="modal"';
								} else {
									$rev = 'id="userreview"';
								}
							} else {
								$rev = 'id="" data-target="#notbuyed" data-toggle="modal"';
							}
                    	} else {
                    		$rev = 'id="userreviewlog" data-toggle="modal" data-target="#createAdmin"';
                    	}
                    	
                    ?>
                    	<div class="successrev">Спасибо, Ваш комментарий отправлен</div>
                    	<?php if($user){?>
                    		<div id="user_review_form" <?=($user->id==$u->id)?'class="comments_with_answers"':''?>>
                    	<? } ?>
	                    <div class="add-review user_review">
				            <h4>Добавить отзыв <span class="pull-right ansname"></span></h4>
				            <div class="rateit" data-rateit-value="" data-rateit-starwidth="26" data-rateit-starheight="25"></div>
				            <span class="not_voted">Вы не поставили оченку</span>
				            <form action="#" action="/lot/addreview" method="post" id="userreviewform">
				                	<div class="savehide">
					                	<input type="hidden" name="review[vote]" id="review_vote" value="0">
					                	<input type="hidden" name="review[id_user]" value="<?=$uid?>">
					                    <input type="text" name="review[title]" placeholder="Заголовок отзыва *" required>
					                    <input type="hidden" name="review[parent]" class="parentrev" value="0">
					                    <span>Пример: Надежный пользователь</span>
					                    <textarea name="review[text]" placeholder="Ваш отзыв *" id="textcomment" required></textarea>
				                    </div>
				                    <input type="submit" value="Добавить отзыв" class="btn" <?=$rev?>>
				            </form>
				        </div>
				        </div>
	                <?php } ?>
                    
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="notbuyed" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
            <div class="modal-dialog create-admin" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h2>Вы не можете оставить отзыв на этого пользователя, т.к. Вы ни разу не арендовали его лоты!</h2>  
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="alreadyrev" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
            <div class="modal-dialog create-admin" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h2>Вы уже оставляли отзыв этому пользователю!</h2>  
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>



</div>
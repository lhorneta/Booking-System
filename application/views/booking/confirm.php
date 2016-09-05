<div class="confirmation-order-holder">
   <div id="confirmation-order" class="clearfix">
    <div class="left-block">
        <div class="order-info clearfix">
        	<? $filename = Lot::UPLOAD_DIR.$lot->url."/".$lot->img0;?>
        	<? if($lot->img0){ ?>
        		<div class="order-foto" style="background-image: url('<?=$filename;?>')"></div>
        	<?}else{?>
        		<div class="order-foto" style="background-image: url('/assets/images/no-img.png')"></div>
        	<? }?>
            
            <div class="order-content clearfix">
                <div class="name">Подтверждение заказа:</div>
                <? //debug($lot);?>
                <? //debug($user);?>
                <p><?=$lot->title;?></p>
                <span>Номер объявления: <?=$lot->id;?></span>
                <div class="evaluation">
                    <div class="rateit" data-rateit-value="<?=$lot->rating;?>" data-rateit-starwidth="12" data-rateit-starheight="13"></div>
                    <a href="#">(<?=$lot->reviews;?> отзывов)</a>
                </div>

            </div>
        </div>
        <div class="block-in-total">
            <div class="list-in-total">
                <p>Итого</p>
            </div>
            <div class="list-in-total">
                <p>Период с:</p>
                <span><?=echoRussianDate(strtotime($calendar->start));?> <?=($calendar->start_rent)? 'с '.$calendar->start_rent:''?></span>
            </div>
            <div class="list-in-total">
                <p>Перириод до:</p>
                <span><?=echoRussianDate(strtotime($calendar->end));?> <?=($calendar->end_rent)? 'до '.$calendar->end_rent:''?></span>
            </div>
            <div class="list-in-total clearfix">
                <span>Период</span>
                <span><?=$days;?> день/дней</span>
            </div>
            <div class="list-in-total clearfix">
                <span>Цена</span>
                <span><?=$price;?> грн.</span>
            </div>
        </div>
		<div class="characteristics">
                <table class="table table1">
                    <tbody>
                        <tr>
                            <td><strong>Объявление от:</strong></td>
                            <td><span><?=$user->role; ?></span></td>
                        </tr>
                        <?php if(count($lot->staticValues)){
                            foreach($lot->staticValues as $group=>$value){ ?>
                                <tr>
                                    <td><strong><?=$group; ?>:</strong></td>
                                    <td><span><?=$value; ?></span></td>
                                </tr>
                            <?php }
                        } ?>
                        <?php if(count($lot->dynamicValues)){
                            foreach($lot->dynamicValues as $group=>$value){ ?>
                                <tr>
                                    <td><strong><?=$group; ?>:</strong></td>
                                    <td><span><?=$value; ?></span></td>
                                </tr>
                            <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
            <div class="requirements">
                <div class="description rules">
                	<strong>Описание</strong>
                    <p><?=$lot->description; ?></p>
                </div>
                <?php if($lot->rental_terms != null){ ?>
                <div class="rules">
                    <strong>Условия проката</strong>
                    <p><?=$lot->rental_terms; ?></p>
                </div>
                <?php } 
                if($lot->special_provisio != null){ ?>
                   <div class="age">
                        <strong>Особые условия:</strong>
                        <p><?=$lot->special_provisio; ?></p>
                    </div>
                <?php } ?>
            </div>

        
    </div>
    <div class="right-block">
        <div class="block-in-total">
            <div class="list-in-total">
                <p>Итого</p>
            </div>
            <div class="list-in-total">
                <p>Период с:</p>
                <span><?=echoRussianDate(strtotime($calendar->start));?> <?=($calendar->start_rent)? 'с '.$calendar->start_rent:''?></span>
            </div>
            <div class="list-in-total">
                <p>Перириод до:</p>
                <span><?=echoRussianDate(strtotime($calendar->end));?> <?=($calendar->end_rent)? 'до '.$calendar->end_rent:''?></span>
            </div>
            <div class="list-in-total clearfix">
                <span>Период</span>
                <span><?=$days;?> день/дней</span>
            </div>
            <div class="list-in-total clearfix">
                <span>Цена</span>
                <span><?=$price;?> грн.</span>
            </div>
        </div>
        <div class="map-section">
            <?php if ($lot->address) { 
                $userAuth = App::gi()->user;
            ?>
                    <div id="map"></div>
                    <script>                                
                            var citymap = {
                                kiev: {
                                    center: {lat: <?=$lot->latitude;?>, lng: <?=$lot->longitude;?> },
                                    population: 100
                                }
                            };

                            function initMap() {
                            	
                            	// Create the map.											
                                var map = new google.maps.Map(document.getElementById('map'), {
                                    zoom: 14,
                                    scrollwheel: false,
                                    center: {lat: <?=$lot->latitude;?>, lng: <?=$lot->longitude;?> },
                                    mapTypeId: google.maps.MapTypeId.TERRAIN
                                });

                                <?php  if($userAuth){ ?>

                                     var marker = new google.maps.Marker({
                                        position: {lat: <?=$lot->latitude;?>, lng: <?=$lot->longitude;?> },
                                        map: map,
                                    });

                                <?php }else{ ?>

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
                                            radius: Math.sqrt(citymap[city].population) * 10
                                        });
                                        map.setCenter(cityCircle.center);
                                    }

                                <?php } ?>
                            }
                    </script>

                    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpONh6QjiiZyV7Emi4nsSB7KJFApSbkzM&signed_in=true&callback=initMap">
                    </script>
                <?php }else{
                    echo "Адрес не указан";
                } ?>
        </div>
        <div class="author-ad">
            <div class="author-info clearfix">
            	
            	<?php if($owner->avatar){?>
                	<div class="author-foto" style="background-image: url(<?=$owner->avatar;?>)"></div>
                <?php }else{?>
                	<div class="author-foto" style="background-image: url(/assets/images/photo.jpg)"></div>
                <? } ?>
                
                <div class="author-content">
                    <div class="name"><?=$owner->name;?></div>
                    <div class="evaluation">
                        <div class="rateit" data-rateit-value="<?=$lot->user_rating;?>" data-rateit-starwidth="12" data-rateit-starheight="13"></div>
                        <a href="#">(<?=$lot->reviewsCount ;?> отзывов)</a>
                    </div>
                    <span>на stuffe<i>x</i> c <?=echoRussianDate(strtotime($owner->register_time));?></span>

                </div>
            </div>
            <div class="link-holder">
                <a href="tel:+38<?=$owner->phone0;?>" class="phone">
                    <span>+<?=$owner->phone0;?></span>
                </a>
                <a href="#" class="write-to-author" data-toggle="modal" data-target="#writeToAuthor">
                    <span>Написать автору</span>
                </a>
            </div>

            <div class="modal fade" id="writeToAuthor" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
                <div class="modal-dialog create-admin" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form method="POST" action="/lot/leavemessage/<?=$lot->url;?>" data-form="<?= $lot->url; ?>">
                                <textarea name="message[text]" required></textarea>
                                <input type="hidden" name="message[id_to]" value="<?= $owner->id; ?>">
                                <input type="submit" value="Отправить сообщение владельцу" class="btn"/>
                            </form>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="message">
        <span>Сообщение владельцу</span>
        <div class="client-logo clearfix">
            <?php if($owner->avatar){?>
            	<div class="author-foto" style="background-image: url(<?=$owner->avatar;?>)"></div>
            <?php }else{?>
            	<div class="author-foto" style="background-image: url(/assets/images/photo.jpg)"></div>
            <? } ?>
            <span><?=$owner->name;?></span>
        </div>
        
        <form method="POST" class="booking_form">
        	<input type='hidden' name="calendar[id_lot]" value="<?=$calendar->id_lot;?>">
        	<input type='hidden' name="calendar[order_arr]" value='<?=$order_arr;?>'>
        	<input type='hidden' name="calendar[id_to]" value="<?=$calendar->id_to;?>">
        	<input type='hidden' name="calendar[id_from]" value="<?=$calendar->id_from;?>">
        	<input type='hidden' name="calendar[start]" value="<?=$calendar->start;?>">
        	<input type='hidden' name="calendar[end]" value="<?=$calendar->end;?>">
        	<input type='hidden' name="calendar[start_rent]" value="<?=$calendar->start_rent;?>">
        	<input type='hidden' name="calendar[end_rent]" value="<?=$calendar->end_rent;?>">
        	
            <textarea name="message[text]" class="message_text" placeholder="Ваше сообщение" required></textarea>
	        <p>Расскажите как и где Вы будете использовать лот</p>
	        <button type="submit" class="btn send-order booking_save" data-toggle="modal" data-target="#confirmOrder">Отправить запрос</button>
	    </form>

        <div class="modal fade" id="confirmOrder" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <img src="/assets/images/ico-59.png" alr="Icon">   
                        <p>Спасибо, Ваша заявка принята! <?=$owner->name;?> свяжется с Вами в ближайшее время</p>                      
                    </div>
                </div>
            </div>
        </div>
        
        <script>
	    	
	    $('#confirmOrder').on('hidden.bs.modal', function () {
		  	window.location.href = '/lot/view/<?=$lot->url;?>';
		});
	    </script>
    </div>
</div>
</div>
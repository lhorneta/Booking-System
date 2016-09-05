<?php //debug($parents); ?>
<div class="header-lot">
    <div class="breadcrumbs-holder">
        <div class="breadcrumbs-block">
            <a href="javascript:history.go(-1)" class="back">назад</a>
            <ul class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <?php if (isset($category->parent->parent)) { ?>
                <li><a href="/category/<?=$category->parent->parent->url?>"><?=$category->parent->parent->title?></a></li>
                <?php } ?>
                <?php if (isset($category->parent)) { ?>
                <li><a href="/category/<?=$category->parent->url?>"><?=$category->parent->title?></a></li>
                <?php } ?>
                <?php if (isset($category->title)) { ?>
                <li class="active"><?=$category->title?></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<div class="main-lot-holder">
   <div id="main-lot" class="clearfix">
    <h3><?=$lot->title; ?></h3>
    <div class="top-section">
        <span class="number">Номер объявления: <i><?=$lot->id;?></i></span>
        <div class="evaluation">
            <div class="rateit" data-rateit-value="4" data-rateit-starwidth="12" data-rateit-starheight="13"></div>
            <a href="#" onclick="$('html, body').animate({ scrollTop: $('#reviews').offset().top }, 1000); return false;"><?=$lot->reviewsCount ;?> отзыв(ов)</a>
        </div>
    </div>

    <div class="blocks-holder clearfix">
        <div class="left-block">
        <?php if(count($lot->images)){ ?>
            <div class="carousel">
                <div id="sync1" class="owl-carousel">
                   <? if($lot->img0){?><div class="item"><div style="background-image: url(<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img0; ?>)">
                       <a class="fancybox" rel="group" href="<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img0; ?>"></a>
                   </div></div><?  } ?>
                   <? if($lot->img1){?><div class="item"><div style="background-image: url(<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img1; ?>)">
                       <a class="fancybox" rel="group" href="<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img1; ?>"></a>
                   </div></div><?  } ?>
                   <? if($lot->img2){?><div class="item"><div style="background-image: url(<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img2; ?>)">
                       <a class="fancybox" rel="group" href="<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img2; ?>"></a>
                   </div></div><?  } ?>
                   <? if($lot->img3){?><div class="item"><div style="background-image: url(<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img3; ?>)">
                       <a class="fancybox" rel="group" href="<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img3; ?>"></a>
                   </div></div><?  } ?>
                   <? if($lot->img4){?><div class="item"><div style="background-image: url(<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img4; ?>)">
                       <a class="fancybox" rel="group" href="<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img4; ?>"></a>
                   </div></div><?  } ?>
                   <? if($lot->img5){?><div class="item"><div style="background-image: url(<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img5; ?>)">
                       <a class="fancybox" rel="group" href="<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img5; ?>"></a>
                   </div></div><?  } ?>
                   <? if($lot->img6){?><div class="item"><div style="background-image: url(<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img6; ?>)">
                       <a class="fancybox" rel="group" href="<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img6; ?>"></a>
                   </div></div><?  } ?>
                   <? if($lot->img7){?><div class="item"><div style="background-image: url(<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img7; ?>)">
                       <a class="fancybox" rel="group" href="<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img7; ?>"></a>
                   </div></div><?  } ?>
                </div>
                <div id="sync2" class="owl-carousel">
                   <? if($lot->img0){?><div class="item"><div style="background-image: url(<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img0; ?>)"></div></div><?  } ?>
                   <? if($lot->img1){?><div class="item"><div style="background-image: url(<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img1; ?>)"></div></div><?  } ?>
                   <? if($lot->img2){?><div class="item"><div style="background-image: url(<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img2; ?>)"></div></div><?  } ?>
                   <? if($lot->img3){?><div class="item"><div style="background-image: url(<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img3; ?>)"></div></div><?  } ?>
                   <? if($lot->img4){?><div class="item"><div style="background-image: url(<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img4; ?>)"></div></div><?  } ?>
                   <? if($lot->img5){?><div class="item"><div style="background-image: url(<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img5; ?>)"></div></div><?  } ?>
                   <? if($lot->img6){?><div class="item"><div style="background-image: url(<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img6; ?>)"></div></div><?  } ?>
                   <? if($lot->img7){?><div class="item"><div style="background-image: url(<?=Lot::UPLOAD_DIR.$lot->url; ?>/<?=$lot->img7; ?>)"></div></div><?  } ?>
                </div>
            </div>
        <?php }else{ ?>
        <div class="carousel">
            <div id="sync1" class="owl-carousel">
                <div class="item"><div style="background-image: url(/assets/images/no-img.png)"></div></div>
            </div>
            <div id="sync2" class="owl-carousel">
<!--                <div class="item"><div style="background-image: url(/assets/images/lot.jpg)"></div></div>-->
            </div>
        </div>
        <?php } ?>
            <div class="block-order" data-day-payment="<?=$lot->day_payment?>" data-week-payment="<?=$lot->week_payment?>" data-month-payment="<?=$lot->month_payment?>">
                <div class="price-holder">
                    <div class="price pr_v"><?=$lot->day_payment?> грн.</div>
                    <select class="selectpicker pr_picker">
                        <option value="<?=$lot->day_payment?>">сутки</option>
                        <?php if ($lot->week_payment) { ?>
                        <option value="<?=$lot->week_payment?>">неделя</option>
                        <?php } ?>
                        <?php if ($lot->month_payment) { ?>
                        <option value="<?=$lot->month_payment?>">месяц</option>
                        <?php } ?>
                    </select>
                </div>
                <form action="/booking/newbooking" method="POST" class="booking_calendar">
                    <div class="period">
                        <div class="part part1">
                            <p>Период с</p>
                            <input name="calendar[start]" data-defaults = "<?=date('Y-m-d', strtotime( '+1 days' ))?>" placeholder="<?=date('Y-m-d', strtotime( '+1 days' ))?>" type="text" id="datepicker3">
<!--
                            <select class="selectpicker start_rent">
                                <option>00:00</option>
                                <option>01:00</option>
                                <option>02:00</option>
                                <option>03:00</option>
                                <option>04:00</option>
                                <option>05:00</option>
                                <option>06:00</option>
                                <option>07:00</option>
                                <option>08:00</option>
                                <option>09:00</option>
                                <option>10:00</option>
                                <option>11:00</option>
                                <option selected="selected">12:00</option>
                                <option>13:00</option>
                                <option>14:00</option>
                                <option>15:00</option>
                                <option>16:00</option>
                                <option>17:00</option>
                                <option>18:00</option>
                                <option>19:00</option>
                                <option>20:00</option>
                                <option>21:00</option>
                                <option>22:00</option>
                                <option>23:00</option>
                            </select>
-->
                        </div>
                        <div class="part">
                            <p>До</p>
                            <input name="calendar[end]" data-defaultf = "<?=date('Y-m-d', strtotime( '+2 days' ))?>" placeholder="<?=date('Y-m-d', strtotime( '+2 days' ))?>" type="text" id="datepicker4">
<!--
                            <select class="selectpicker end_rent">
                                <option>00:00</option>
                                <option>01:00</option>
                                <option>02:00</option>
                                <option>03:00</option>
                                <option>04:00</option>
                                <option>05:00</option>
                                <option>06:00</option>
                                <option>07:00</option>
                                <option>08:00</option>
                                <option>09:00</option>
                                <option>10:00</option>
                                <option>11:00</option>
                                <option>12:00</option>
                                <option>13:00</option>
                                <option>14:00</option> 
                                <option>15:00</option>
                                <option>16:00</option>
                                <option>17:00</option>
                                <option selected="selected">18:00</option>
                                <option>19:00</option>
                                <option>20:00</option>
                                <option>21:00</option>
                                <option>22:00</option>
                                <option>23:00</option>
                            </select>
-->
                        </div>
                        <!--<div class="clear_field"><span class="glyphicon glyphicon-remove"></span></div>-->
                        <div class="message_field">Некоректно задан диапозон</div>
                    </div>
                    <div class="total clearfix">
                        <span>Итого</span>
                        <div data-attr="<?=$lot->day_payment?>" class="total-price">
                            <span class='custom-sum'><?=$lot->day_payment?> грн.</span>
                            <div class="btn-group">
                                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                    Узнать цену подробнее
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-prices-calendar">
                                    <li class="more-about-price"><span>1 суток Х <?=$lot->day_payment?> грн.</span> <span><?=$lot->day_payment?> грн.</span></li>
                                </ul>
                            </div>
                        </div>
                        <input name="calendar[total_sum]" type="hidden" value="" class="total_sum">
                        <input name="calendar[order_arr]" type='hidden' class='order_arr'>
                    	<input name="calendar[count_days]" type="hidden" value="" class="count_days">
                        <input name="calendar[id_to]" type="hidden" value="<?=$user->id; ?>" class="time">
                        <input name="calendar[id_lot]" type="hidden" value="<?=$lot->id; ?>" class="time">
                        <input name="calendar[start_rent]" class="inp_start_rent" type="hidden" >
                        <input name="calendar[end_rent]" class="inp_end_rent" type="hidden" >
                        <input type="submit" value="Отправить заявку" class="btn sent">
                    </div>
                    
                </form>
                <?php if ($lot->deposit) { ?>
                <div class="note"><span>Аренда предпологает залог: <?=($lot->deposit == 'document')? 'Документ':$lot->deposit;?></span></div>
                <?php } ?>
            </div>
            <div class="characteristics">
                <table class="table table1">
                    <tbody>
 	
                        <tr>
                            <td><strong>Объявление от:</strong></td>
                            <td><span><?=$user->role; ?></span></td>
                        </tr>
                    	
                        <tr>
                            <td><strong>Состояние:</strong></td>
                            <td><span><?=($lot->condition_title)? $lot->condition_title: '';?></span></td>
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
<!--                <table class="table table2">
                    <tbody>
                        <tr>
                            <td><strong>Марка:</strong></td>
                            <td><span>Smart</span></td>
                        </tr>
                        <tr>
                            <td><strong>Тип кузова:</strong></td>
                            <td><span>Седан</span></td>
                        </tr>
                        <tr>
                            <td><strong>Коробка передач:</strong></td>
                            <td><span>Автомат</span></td>
                        </tr>
                        <tr>
                            <td><strong>Вид топлива:</strong></td>
                            <td><span>Бензин</span></td>
                        </tr>
                        <tr>
                            <td><strong>Дополнительные опции:</strong></td>
                            <td><span>Кондиционер</span></td>
                        </tr>
                    </tbody>
                </table>-->
            </div>
            <div class="requirements">
                <div class="description">
                    <p><?=$lot->description; ?></p>
                </div>
                <?php if($lot->rental_terms != null){ ?>
                <div class="rules">
                    <strong>Условия проката</strong>
                    <p><?=$lot->rental_terms; ?></p>
<!--                    <div class="age">
                        <strong>Возраст:</strong>
                        <p>От 21 года для автомобилей Эконом и Среднего классов (группы A – H)</p>
                        <p>От 25 лет для автомобилей Бизнес, Премиум и 4х4 (группы I – M)</p>
                        <p>Смотри «Наш автопарк»</p>
                    </div>
                    <div class="experience">
                        <strong>Водительские права:</strong>
                        <p>Водительский стаж арендатора должен быть не менее 2 лет для всех групп авто.<br>
                            Имя и фамилия на правах должны быть написаны латиницей. В ином случае потребуется международное водительское удостоверение</p>
                    </div>
                    <div class="payment">
                        <strong>Формы оплаты:</strong>
                        <p>Банковские карты: American Express, Visa, Mastercard.</p>
                        <p>Наличные (только на станция в Киеве, Борисполе).</p>
                        <p>Ваучеры с оплаченным прокатом</p>
                    </div>-->
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
        <div class="top-section">
            <span class="number">Номер объявления: <i><?=$lot->id;?></i></span>
            <div class="evaluation">
                <div class="rateit" data-rateit-value="<?=$lot->rating;?>" data-rateit-starwidth="12" data-rateit-starheight="13"></div>
                <a href="#" onclick="$('html, body').animate({ scrollTop: $('#reviews').offset().top }, 1000); return false;"><?=$lot->reviewsCount ;?> отзыв(ов)</a>
            </div>
        </div>
        <div class="block-order" data-day-payment="<?=$lot->day_payment?>" data-week-payment="<?=$lot->week_payment?>" data-month-payment="<?=$lot->month_payment?>">
            <div class="price-holder">
                <div class="price pr_v"><?=$lot->day_payment?> грн.</div>
                <select class="selectpicker pr_picker">
                    <option value="<?=$lot->day_payment?>">сутки</option>
                    <?php if ($lot->week_payment) { ?>
                    <option value="<?=$lot->week_payment?>">неделя</option>
                    <?php } ?>
                    <?php if ($lot->month_payment) { ?>
                    <option value="<?=$lot->month_payment?>">месяц</option>
                    <?php } ?>
                </select>
            </div>
            <form action="/booking/newbooking" method="POST" class="booking_calendar">
                <div class="period">
                    <div class="part part1">
                        <p>Период с</p>
                        <input name="calendar[start]" data-defaults = "<?=date('Y-m-d', strtotime( '+1 days' ))?>" placeholder="<?=date('Y-m-d', strtotime( '+1 days' ))?>" type="text" id="datepicker">
<!--
                        <select class="selectpicker start_rent stcst">
                            <option>00:00</option>
                            <option>01:00</option>
                            <option>02:00</option>
                            <option>03:00</option>
                            <option>04:00</option>
                            <option>05:00</option>
                            <option>06:00</option>
                            <option>07:00</option>
                            <option>08:00</option>
                            <option>09:00</option>
                            <option>10:00</option>
                            <option>11:00</option>
                            <option selected="selected">12:00</option>
                            <option>13:00</option>
                            <option>14:00</option>
                            <option>15:00</option>
                            <option>16:00</option>
                            <option>17:00</option>
                            <option>18:00</option>
                            <option>19:00</option>
                            <option>20:00</option>
                            <option>21:00</option>
                            <option>22:00</option>
                            <option>23:00</option>
                        </select>
-->
                    </div>
                    <div class="part">
                        <p>До</p>
                        <input name="calendar[end]" data-defaultf = "<?=date('Y-m-d', strtotime( '+2 days' ))?>" placeholder="<?=date('Y-m-d', strtotime( '+2 days' ))?>" type="text" id="datepicker2">
<!--
                        <select class="selectpicker end_rent fncst">
                            <option>00:00</option>
                            <option>01:00</option>
                            <option>02:00</option>
                            <option>03:00</option>
                            <option>04:00</option>
                            <option>05:00</option>
                            <option>06:00</option>
                            <option>07:00</option>
                            <option>08:00</option>
                            <option>09:00</option>
                            <option>10:00</option>
                            <option>11:00</option>
                            <option>12:00</option>
                            <option>13:00</option>
                            <option>14:00</option>
                            <option>15:00</option>
                            <option>16:00</option>
                            <option>17:00</option>
                            <option selected="selected">18:00</option>
                            <option>19:00</option>
                            <option>20:00</option>
                            <option>21:00</option>
                            <option>22:00</option>
                            <option>23:00</option>
                        </select>
-->
                    </div>
					<!--<div class="clear_field"><span class="glyphicon glyphicon-remove"></span></div>-->
					<div class="message_field">Некоректно задан диапозон</div>
                </div>
                <div class="total clearfix">
                    <span>Итого</span>
                    <div class="total-price">
                        <span class='custom-sum'><?=$lot->day_payment?> грн.</span>
                        <div class="btn-group">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                Узнать цену подробнее
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-prices-calendar">
                                <li class="more-about-price"><span>1 суток Х <?=$lot->day_payment?> грн.</span> <span><?=$lot->day_payment?> грн.</span></li>
                            </ul>
                        </div>
                    </div>
                    <input name="calendar[total_sum]" type="hidden" value="" class="total_sum">
                    <input name="calendar[order_arr]" type='hidden' class='order_arr'>
                    <input name="calendar[count_days]" type="hidden" value="" class="count_days">
                    <input name="calendar[id_to]" type="hidden" value="<?=$user->id; ?>" class="time">
                    <input name="calendar[id_lot]" type="hidden" value="<?=$lot->id; ?>" class="time">
                    <input name="calendar[start_rent]" class="inp_start_rent" type="hidden" >
                    <input name="calendar[end_rent]" class="inp_end_rent" type="hidden" >
                    <input type="submit" value="Отправить заявку" class="btn sent">
                </div>
            </form>
            <?php if ($lot->deposit) { ?>
             <div class="note"><span>Аренда предпологает залог: <?=($lot->deposit == 'document')? 'Документ':$lot->deposit;?></span></div>
            <?php } ?>
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
                                    zoom: 13,
                                    scrollwheel: false,
                                    center: {lat: <?=$lot->latitude;?>, lng: <?=$lot->longitude;?> },
                                    mapTypeId: google.maps.MapTypeId.TERRAIN
                                });

                                <?php 
                                if($userAuth){
                                	////////////////// BISSENESS /////////////
                                		if($userAuth->id_role==3){//bisseness
                                			if($lot->show_address ==1){
                                				 	
	                                		 if(count($booking_lots) >= 1 || $userAuth->id==$user->id){?>
	                                			
	                                			var marker = new google.maps.Marker({
			                                        position: {lat: <?=$lot->latitude;?>, lng: <?=$lot->longitude;?> },
			                                        map: map,
			                                    });
			                                                                      
											<?php }else{?>
												
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
			                                        map.setCenter(cityCircle.center);
			                                    }
			                                    
											<?php }?>
										
			                                <?php }else{?>
			                                	
				                                     var marker = new google.maps.Marker({
				                                        position: {lat: <?=$lot->latitude;?>, lng: <?=$lot->longitude;?> },
				                                        map: map,
				                                    });
					                                    
			                                <?php	}
                                			
                                		////////////////////// PRIVATE //////////////////	
                                		}else if($userAuth->id_role==2){//private profile
                                			if($lot->show_address ==1){
                                				 	
	                                		 if(count($booking_lots) >= 1 || $userAuth->id==$user->id){?>
	                                			
	                                			var marker = new google.maps.Marker({
			                                        position: {lat: <?=$lot->latitude;?>, lng: <?=$lot->longitude;?> },
			                                        map: map,
			                                    });
			                                                                      
											<?php }else{?>
												
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
			                                        map.setCenter(cityCircle.center);
			                                    }
			                                    
											<?php }?>
										
			                                <?php }else{?>
			                                	
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
				                                        map.setCenter(cityCircle.center);
				                                    }
					                                    
			                                <?php	} /////////////////// DEFAULT ////////////////
                                		}else{?>
                                			
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
		                                        map.setCenter(cityCircle.center);
		                                    }
		                                    
		                                <? }
		                                } ?>									
                            }
                    </script>

                    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpONh6QjiiZyV7Emi4nsSB7KJFApSbkzM&signed_in=true&callback=initMap">
                    </script>
                <?php }else{
                    echo "Адрес не указан";
                } ?>
        </div>
        <div class="author-ad">
            <div class="author-info">
            	<?php $uname = ($user->id_role==2)?$user->name:$user->company_name; ?>
                <div class="name"><a href="<?=$this->link('/page/publicprofile/'.$user->id); ?>"><?=$uname?></a></div>
                <?php if($user->avatar != ''){ ?>
                    <div class="foto" style="background-image: url(<?=$user->avatar?>)"><a href="<?=$this->link('/page/publicprofile/'.$user->id); ?>"></a></div>
                <?php }else{ ?>
                    <div class="foto" style="background-image: url(/assets/images/photo.jpg)"><a href="<?=$this->link('/page/publicprofile/'.$user->id); ?>"></a></div>
                <?php } ?>
                <div class="evaluation">
                    <div class="rateit" data-rateit-value="<?=$lot->user_rating;?>" data-rateit-starwidth="12" data-rateit-starheight="13"></div>
                    <a href="/page/publicprofile/<?=$user->id?>?reviews"><?=$user->reviewsCount; ?> отзыв(ов)</a>
                </div>
                <span>на stuffe<i>x</i> c <?= echoRussianDate($user->register_time); ?></span>
            </div>
            <div class="link-holder">
                <?php for($i = 0; $i<5; $i++){
                    $phone = 'phone'.$i;
                    if($user->$phone != null){ ?>
                        <a href="tel:+38<?=$user->$phone; ?>" class="phone">+38<?=$user->$phone; ?></a>
                    <?php }
                }?>
                 <a href="javascript:void(0)" class="write-to-author" data-toggle="modal" data-target="#writeToAuthor">Написать автору</a> 
            </div>
            <div class="modal fade" id="writeToAuthor" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
                <div class="modal-dialog create-admin" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form method="POST" action="/lot/leavemessage/<?= $lot->url; ?>" data-form="<?= $lot->url; ?>">
                                <textarea name="message[text]" required></textarea>
                                <input type="hidden" name="message[id_to]" value="<?= $user->id; ?>">
                                <input type="submit" value="Отправить сообщение владельцу" class="btn"/>
                            </form>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="reviews-holder clearfix">
        
        <div class="reviews" id="reviews">
        	<?php $myrev=0; if(count($lot->reviews)){ ?>
                <h4>Отзывы</h4>
                <?php foreach($lot->reviews as $review){
                    $reviewer = User::model($review->id_reviewer); 
                    if($reviewer){?>
                <div class="review" id="r_<?=$review->id?>">
                    <div class="user">
                        <div class="foto" style="background-image: url(<?=($avatar != '') ? User::UPLOAD_DIR.$avatar : '/assets/images/photo.jpg'; ?>)"></div>
                        <span class="name"><?=$reviewer->name?></span>
                    </div>
                    <div class="evaluation">
                    	
                    	<?php $rat = getUserRating($review->id_reviewer); ?>
                        <div class="rateit" data-rateit-starwidth="12" data-rateit-starheight="13" data-rateit-value="<?=$rat?>"></div>
                        
                        <span><?=echoRussianDate($review->time); ?></span>
                    </div>
                    <div class="title"><?=($review->title)?$review->title:'Заголовок не указан'; ?></div>
                    <div class="review-text"><p><?=$review->text; ?></p></div>
                    
                    <?php
                    	$usr = App::gi()->user;
                    	$mr = 0;
					    $revs = Review::modelsWhere('id_lot=? AND parent=? AND reposted=0', array($lot->id, $review->id));
                        if($usr){
						  if ($review->id_reviewer==$usr->id ) {$myrev=1;}
                        }
						//debug($revs);
						if ($revs) {
						    ?>
						    <div class="answers">
						        <a class="openanswers" rel="<?=$review->id?>" href="#">+ Ответы на комментарий</a>
						        <!-- <span>28 Ноября, 2015</span> -->
						        <div class="ansrews openaningswers" id="rev_<?=$review->id?>">
						        <?php foreach ($revs as $ks => $rs) {
						        $us = User::modelWhere('id=?', array($rs->id_reviewer));
								
								if($usr){
									if ($rs->id_reviewer==$usr->id) {$mr++;}
								}
								$rat = getUserRating(isset($us)?$us->id:'');
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
						        <!-- <div class="title">Отличный автомобиль</div> -->
						        <div class="review-text">
						            <p><?=$rs->text?></p>
						        </div>
						    
						    </div>
						        
						        <?php } ?>
						        </div>
						    </div>
					    <?php } ?>
                    
                    
                    <!-- <div class="answers">
                        <a href="#">+ Ответы на комментарий</a>
                        <span>28 Ноября, 2015</span>
                    </div> -->
                    
                    <?php
                    $votes = $lot->votes($review->id);
                    $myvote = $lot->myvote($review->id);
                    ?>
                     <?php if ($usr) { ?>
                        <?php if ($mr==0&&$lot->id_user==$usr->id) { ?>
                        <button type="button" class="answer-bnt revanswlot" rel="<?=$review->id?>" <?=(App::gi()->user)?'':'data-target="#createAdmin" data-toggle="modal"'?>>Ответить</button>
                        <?php } ?>
                    <?php } ?>
                    
                    <button type="button" class="like-bnt like_review <?=($myvote==1||!App::gi()->user)?'active':''?>" rel="<?=$review->id?>" <?=(App::gi()->user)?'':'data-target="#createAdmin" data-toggle="modal"'?>><i rel="<?=$review->id?>"></i></button>
                    <!-- <div class="stat" rel="<?=$review->id?>">
                    	<span class="plus" style="width:<?=$votes->percent[1]?>%"><?=$votes->percent[1]?>%</span>
                    	<span class="minus"style="width:<?=$votes->percent[2]?>%"><?=$votes->percent[2]?>%</span>
                    </div>
                    <button type="button" class="unlike-bnt unlike_review <?=($myvote==2||!App::gi()->user)?'active':''?>" rel="<?=$review->id?>" <?=(App::gi()->user)?'':'data-target="#createAdmin" data-toggle="modal"'?>><i rel="<?=$review->id?>"></i></button> -->
                </div>
                <?php }} ?>
                <!-- <div class="pagination-holder">
                    <ul class="pagination">
                        <li><a href="#" class="prev"></a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#" class="active">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">6</a></li>
                        <li><a href="#">7</a></li>
                        <li><a href="#">8</a></li>
                        <li><a href="#" class="next"></a></li>
                    </ul>
                </div> -->
            <?php } ?>
        </div>
        
        <?php
        $notbuyed = 0;
        if (App::gi()->user) {
        	$us = App::gi()->user;
			if ((int)$us->id==(int)$lot->id_user) {
				$rev = 'id="addreviewlog" data-target="#self_review" data-toggle="modal"';
			} else {
				$bookings = Booking::modelWhere('id_from=? AND id_lot=? AND confirmed=1', array($us->id, $lot->id));
				
				if ($bookings) {
					if ($myrev) {
						$rev = 'id="" data-target="#alreadyrev" data-toggle="modal"';
					} else {
						$rev = 'id="addreview"';
					}
				} else {
					$notbuyed = 1;
					$rev = 'id="addreviewlog" data-target="#notbuyed" data-toggle="modal"';
				}
				
				
			}
        } else {
        	$rev = 'id="addreviewlog" data-target="#createAdmin" data-toggle="modal"';
        }
        ?>
        
        <?php if ($notbuyed!=1) { ?>
        <div class="add-review">
            <h4>Добавить отзыв <span class="pull-right ansname"></span></h4>
            <div class="rateit" data-rateit-value="" data-rateit-starwidth="26" data-rateit-starheight="25"></div>
            <span class="not_voted">Вы не поставили оченку</span>
            <form action="#" id="addreviewform" action="/lot/addreview">
                <fieldset>
                	<div class="savehide">
	                	<input type="hidden" name="review[vote]" id="votelotvalue" value="0">
	                	<!-- <input type="hidden" name="review[id_user]" value="<?=$user->id?>"> -->
	                	<input type="hidden" name="review[id_lot]" value="<?=$lot->id?>">
	                    <input type="text" name="review[title]" placeholder="Заголовок отзыва *" required>
	                    <input type="hidden" name="review[parent]" class="parentrev" value="0">
	                    <span>Пример: Этот продукт имеет большие возможности</span>
	                    <textarea name="review[text]" placeholder="Ваш отзыв *" id="textcomment" required></textarea>
                    </div>
                    
                    
                    
                    <input type="submit" value="Добавить отзыв" class="btn" <?=$rev?>>

                </fieldset>
            </form>
        </div>
        <?php } ?>
        
        
        <div class="modal fade" id="notbuyed" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
            <div class="modal-dialog create-admin" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h2>Вы не можете оставить отзыв на этот лот, т.к. Вы ни разу не арендовали его!</h2>  
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="self_review" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
            <div class="modal-dialog create-admin" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h2>Вы не можете оставить отзыв самому себе!</h2>  
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="alreadyrev" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
            <div class="modal-dialog create-admin" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h2>Вы уже оставили отзыв на этот лот!</h2>  
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
</div>

<script>
    
	/* booking calendar select, отправка времени бронирования*/
	$('.start_rent').change(function(){
		var val = $(this).val();
		$('input.inp_start_rent').attr('value',val);
	});
	
	$('.end_rent').change(function(){
		var val = $(this).val();
		$('input.inp_end_rent').attr('value',val);
	});
	
	
	/*datepickers*/
	$(document).ready(function(){

		var dates = <?=$booking;?>
		
		var startDate='', endDate='',flag = 0,flag2 = 0;
		
		console.log('dates',dates);

		var disableDates = function(dt) {
			countDays(startDate, endDate, day_payment,week_payment, month_payment);
			if(dates.length > 1 ){
				
				var result = dates.reduce(function(prev, item, index, arr) {

					var inside = dates.reduce(function(prev, cur) {
	                 return prev || (cur.from && cur.to && dt <= (new Date(cur.to).setHours(0)) && dt >= (new Date(cur.from).setHours(0)));
	            	}, false);
					
					//return [!inside && (!startDate || +dt >= (new Date(startDate)).setHours(0)) && (!endDate || +dt <= (new Date(endDate)).setHours(0))];
					return [!inside];
				
				});
				
				if(result[0] ===false){
					return [result,'datepicker_event'];
				}
				return result;
			}else{
				var result=null;
				if(dates.length === 1){
					var start = dates[0].from,
					end = dates[0].to;

					//var res = (!start || dt >= new Date(start).setHours(0)) && (!end || dt <= new Date(end).setHours(0));
					var res = (!start || dt >= new Date(start).setHours(0)) && (!end || dt <= new Date(end).setHours(0));

					if(res ===false){res =true;}else{res =false;}

					//result=[(!startDate || dt >= new Date(startDate).setHours(0)) && (!endDate || dt <= new Date(endDate).setHours(0)) && res];
					result=[res];
					//if(flag === 0 && flag2 === 0){
						if(result[0] ===false){
							return [result,'datepicker_event'];
						}
					//}

					return result;
					
				}else{
					//return [(!startDate || dt >= new Date(startDate).setHours(0)) && (!endDate || dt <= new Date(endDate).setHours(0))];
					return [true];
				}
				
			}
		}

		function checkRange (dt){
			countDays(startDate, endDate, day_payment,week_payment, month_payment);
			if(dates.length > 0){
				
				var result = dates.reduce(function(prev, item, index, arr) {
					
					var inside = dates.reduce(function(prev, cur) {
	                 return prev || (cur.from && cur.to && (new Date(startDate).setHours(0)) <= (new Date(cur.to).setHours(0)) && (new Date(endDate).setHours(0)) >= (new Date(cur.from).setHours(0)));
	            	}, false);
	
					if(inside === true){
						clear();
						function f(){$('.message_field').show();}
						setTimeout( function() { f() } , 300);
					}else{$('.message_field').hide();}
					
				});
				
			}else{
				return [(!startDate || dt >= new Date(startDate).setHours(0)) && (!endDate || dt <= new Date(endDate).setHours(0))];
			}
			
		}
		
		function checkOneDate (startDateField, endDateField){
			var res = '';
			if(dates.length > 1){
				var result = dates.reduce(function(prev, item, index, arr) {
					var inside = dates.reduce(function(prev, cur) {
	                 return prev || (cur.from && cur.to && (new Date(startDateField).setHours(0)) <= (new Date(cur.to).setHours(0)) && (new Date(endDateField).setHours(0)) >= (new Date(cur.from).setHours(0)));
	            	}, false);
					
					if(inside === true){
						clear();
						function f(){$('.message_field').show();}
						setTimeout( function() { f() } , 300);
						res = 0;
					}else{$('.message_field').hide();res = 1;}
					
				});
			}else{
				return res = 1;
			}
			return res;
		}
		
		 var 
		 	day_payment = parseInt($('.block-order').attr('data-day-payment')),
		 	week_payment = parseInt($('.block-order').attr('data-week-payment')),
		 	month_payment = parseInt($('.block-order').attr('data-month-payment'));
		 		
		//Вычисление цены для диапозана брониварония лота
		function countDays(data1='',data2='',day=0,week=0,month=0){
			
			//Инициализация переменных
			var result = {},consist = {},arr = [],prices = {},days = '',sum= 0,monthes = '', weeks = '',str='';
			
			
			if(data1 !=='' && data2 !==''){
			
				//Определение количества дней в заданном диапазоне
				days = new Date(new Date(data1).setHours(0) - new Date(data2).setHours(0))/(1000*60*60*24);
				days = (Math.abs(Math.round(days))+1);
				
				
				//Создание массива цен из входных параметров
				prices = {days : day,weeks : week,monthes : month};
				
				//Определение количества месяцев и недель в заданном диапазоне
				weeks = Math.floor(days/7);
				monthes = Math.floor(days/30);
				
				//Формирование массива с датами с разбивкой по месяцам, неделям и дням
				if(day !==0 && week !==0 && month !==0){
					//console.log(1);
					if(monthes >= 1){
						var a = (days-(monthes*30)), b = Math.floor(a/7), c=0;
						if(b > 0){
							c = (a-(b*7));
							consist = {days : c,weeks : b,monthes : monthes};
						}else{c=a;}
						if(c>=1){consist = {days : c,weeks : b,monthes : monthes};}else{consist = {weeks : b,monthes : monthes};}
					}else{
						if(weeks >= 1){
							var  a = (days-(weeks*7));
							if(a>0){consist = {	days : a,weeks : weeks};}else{consist = {weeks : weeks};}
						}else{consist = {days : days};}
					}
				}
				if(day ===0 && week ===0 && month ===0){
					//console.log(2);
					consist = {};	
				}
				if(day !==0 && week ===0 && month !==0){
					//console.log(3);
					var a = (days-(monthes*30));
					consist = {days : a, monthes : monthes};
				}
				if(day !==0 && week !==0 && month ===0){
					//console.log(4);
					if(weeks >= 1){
						var  a = (days-(weeks*7));
						if(a>0){consist = {	days : a,weeks : weeks};}else{consist = {weeks : weeks};}
					}else{consist = {days : days};}
				}
				if(day ===0 && week !==0 && month !==0){
					//console.log(5);
					var a = (days-(monthes*30)), b = Math.floor(a/7), c=0;
					consist = {weeks : b,monthes : monthes};
				}
				if(day ===0 && week ===0 && month !==0){
					//console.log(6);
					consist = {monthes : monthes};
				}
				if(day ===0 && week !==0 && month ===0){
					//console.log(7);
					consist = {weeks : weeks};
				}
				if(day !==0 && week ===0 && month ===0){
					//console.log(8);
					consist = {days : days};
				}
	
				//Создание массива с количеством дней, недель и месяцев в заданном диапазоне
				result = { days : days,	weeks : weeks,monthes : monthes};
				//Создание массива с текстовками для вывода списка
				names = {days : 'суток',	weeks : 'недель',monthes : 'месяцев'};
				
				//Подсчет общей суммы лота
			  	if(month !==0 && consist.monthes){	sum += (+consist.monthes*month);}//monthes
				if(week !==0 && consist.weeks){sum += (+consist.weeks*week);}//weeks
				if(day !==0 && consist.days){sum +=  (+consist.days*day);}//days
	
				//Исходящий массив
				arr = [consist,result,prices,names,sum];

				//Функция оторисовки списка из исходящего массива
				$('.order_arr').val(JSON.stringify(arr));
				renderPriceIntoLot(arr);
				return arr;
			}
		}
		
		function renderPriceIntoLot(arr){
			$('.total_sum').val(arr[4]);$('.count_days').val(arr[1].days);
			$('.total-price span.custom-sum').html(arr[4]+' грн.');
			var html = '';
			$.each(arr[0], function(key, value){
				  html += '<li class="more-about-price"><span>' + value + ' '+arr[3][key]+' Х ' + arr[2][key] + ' грн.</span> <span>' + value*arr[2][key]+' грн.</span></li>';
			});
			if(arr[4] ===0){html='<li class="more-about-price"><span>Бесплатно</span></li>';}
			$('.dropdown-prices-calendar').html(html);
		}
		
		
		function clear(){
			function f(){$('.message_field').hide();}
			setTimeout( function() { f() } , 2500);
			$("#datepicker,#datepicker2").val('');
			startDate='', endDate='';
		}
		
		$("#datepicker").datepicker({
		    dateFormat : 'yy-mm-dd',
		    altField: "#actualDate",
            minDate: "#actualDate",
            firstDay: 1,
		    beforeShowDay: disableDates,
		    onSelect: function (date) {
		    //	flag = 1;
		    	startDate = date;
		        checkRange(startDate);
		    }
		});
		
		$('#datepicker2').datepicker({
		    dateFormat : 'yy-mm-dd',
		    altField: "#actualDate",
            minDate: "#actualDate",
            firstDay: 1,
		    beforeShowDay: disableDates,
		    onSelect: function (date) {
		    //	flag2 = 1;
		    	endDate = date;
		        checkRange(endDate);
		    }
		});
		
		$('.clear_field').click(function(){clear();});
		
		function showError(){
			$('.message_field').text('Выберите, пожалуйста, другой диапазон бронирования').show();
			function f(){$('.message_field').hide();}
			setTimeout( function() { f() } , 2500);
		}
		
		var 
			defaults = $("#datepicker").attr('data-defaults'),
			defaultf = $("#datepicker2").attr('data-defaultf');

		countDays(defaults, defaultf, day_payment,week_payment, month_payment);

		//valid calendar date
		$('.booking_calendar').submit(function(e){
			//e.preventDefault();
			var 
				$d1 = $("#datepicker"),
				$d2 = $("#datepicker2"),
				field1 = $d1.val(),
				field2 = $d2.val(),
				start_rent = $('.stcst').val(),
				end_rent = $('.fncst').val(),
				defaults = $("#datepicker").attr('data-defaults'),
				defaultf = $("#datepicker2").attr('data-defaultf');
		
			$('.inp_start_rent').val(start_rent);
			$('.inp_end_rent').val(end_rent);
			
			if(field1 !=='' && field2 !==''){
				if( (new Date(field1).setHours(0)) < (new Date(field2).setHours(0)) ||
				(new Date(field1).setHours(0)) === (new Date(field2).setHours(0)) ){
					if(checkOneDate(field1, field2) === 1){
						countDays(field1, field2, day_payment,week_payment, month_payment);
						return true;
					}else{
						showError();
						return false;
					}
				}else{
					console.log(222);
					showError();
					return false;
				}
			}
			
			if(field1 ==='' && field2 ===''){

				if(checkOneDate(defaults, defaultf) === 1 && (new Date(defaults).setHours(0)) < (new Date(defaultf).setHours(0)) ){
					countDays(defaults, defaultf, day_payment,week_payment, month_payment);
					$d1.val(defaults); 
					$d2.val(defaultf);
					countDays(defaults, defaultf,day_payment,week_payment, month_payment);
					return true;
				}else{
					showError();
					return false;
				}
				
			}else if(field1 ==='' || field2 ===''){

				if(field1 !==''){
					
					if(checkOneDate(field1, field1) === 1 ){
						countDays(defaults, defaultf, day_payment,week_payment, month_payment);
						$d1.val(field1); 
						$d2.val(field1);
						countDays(field1,field1,day_payment,week_payment, month_payment);
						return true;
					}else{
						showError();
						return false;
					}

				}
				
				if(field2 !==''){
					
					if(checkOneDate(field2, field2) === 1){
						countDays(defaults, defaultf, day_payment,week_payment, month_payment);
						$d1.val(field2); 
						$d2.val(field2);
						countDays(field2,field2,day_payment,week_payment, month_payment);
						return true;
					}else{
						showError();
						return false;
					}
					
					$d1.val(field2); 
					$d2.val(field2);
					countDays(field2, field2,day_payment,week_payment, month_payment);
					return true;
				}
				
			} else{
				return true;
			}
			
		});
		
	});
</script>
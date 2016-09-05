<div id="view-order">
    <div class="back-nav-holder">
        <div class="back-nav">
            <a href="javascript: history.go(-1)" class="back">назад</a>
        </div>
    </div>
    <div class="view-order-block" id="openOrderWindow">
        <div class="title-row clearfix">
            <a href="#" class="little-logo"><img src="/assets/images/little-logo.png" alt="Логотип"></a>
            <span>Распечатайте это подтверждение и принисите во время получения заказа</span>
        </div>
        <div class="order-content">
            <div class="title-order">
                <? $filename = Lot::UPLOAD_DIR.$booking->lot->url."/".$booking->lot->img0;?>
	        	<? if($booking->lot->img0){ ?>
	        		<div class="order-foto" style="background-image: url('<?=$filename;?>')"></div>
	        	<?}else{?>
	        		<div class="order-foto" style="background-image: url('/assets/images/no-img.png')"></div>
	        	<? }?>
                <div class="description">
                    <p>Ваш заказ:</p>
                    <strong class="title"><?=$booking->lot->title; ?></strong>
                    <p>Номер объявления:</p>
                    <strong><?=$booking->id; ?></strong>
                </div>
                <a href="#" class="btn print-btn">Печать</a>
            </div>
            <div class="information-text">
                <div class="row-items">
                    <section class="contact-person">
                        <p>Контактное лицо:</p>
                        <strong><?=$booking->owner->name.' '.$booking->owner->surname; ?></strong>
                    </section>
                    <section class="contact">
                        <p>Контакты:</p>
                        <?php for($i=0;$i<5;$i++){
                            $phone = 'phone'.$i;
                            if($booking->owner->$phone){ ?>
                                <strong>+38 <?=$booking->owner->$phone; ?></strong>
                            <?php }
                        } ?>
                    </section>
                    <section class="period">
                        <p>Период:</p>
                        <?php $period = ($booking->endTime - $booking->startTime) / (24*3600); ; ?>
                        <strong><?=$period; ?> суток(и)</strong>
                    </section>
                    <section class="payment-type">
                        <p>Вид оплаты:</p>
                        <strong>При получении</strong>
                    </section>
                    <section class="period-from">
                        <p>Период с:</p>
                        <strong><?=echoRussianDate($booking->startTime); ?></strong>
                        <strong><?=($booking->start_rent>=10)? $booking->start_rent: '0'.$booking->start_rent; ?>:00</strong>
                    </section>
                    <section class="period-to">
                        <p>Период до:</p>
                        <strong><?=echoRussianDate($booking->endTime); ?></strong>
                        <strong><?=($booking->end_rent>=10)? $booking->end_rent: '0'.$booking->end_rent; ?>:00</strong>
                    </section>
                    <section class="address">
                        <p>Адрес:</p>
                        <?php
							if($booking->lot->show_address ==1){ 	
	                                if(count($booking_lots) >= 1){?>
	                                	<strong><?=$booking->lot->address; ?></strong>
	                                <?php }else{?>
	                                	<strong>Адрес уточните у владельца лота</strong>
	                                <?php }
							 }else{?>
                            		<strong><?=$booking->lot->address; ?></strong>
                            <?php } ?>
                    </section>
                </div>
            </div>
            <div class="prices-map-holder clearfix">
                <div class="map-box">
                    <div id="map"></div>
                    <script>                                
                            var citymap = {
                                kiev: {
                                    center: {lat: <?=$booking->lot->latitude;?>, lng: <?=$booking->lot->longitude;?> },
                                    population: 100
                                }
                            };

							 function initMap() {
                            	
                            	// Create the map.											
                                var map = new google.maps.Map(document.getElementById('map'), {
                                    zoom: 13,
                                    scrollwheel: false,
                                    center: {lat: <?=$booking->lot->latitude;?>, lng: <?=$booking->lot->longitude;?> },
                                    mapTypeId: google.maps.MapTypeId.TERRAIN
                                });

                                <?php 
                                	////////////////// BISSENESS /////////////
                                		if($booking->owner->id_role==3){//bisseness
                                			if($booking->lot->show_address ==1){
                                				 	
	                                		 if(count($booking_lots) >= 1){?>
	                                			
	                                			 var map = new google.maps.Map(document.getElementById('map'), {
				                                    zoom: 14,
				                                    scrollwheel: false,
				                                    center: {lat: <?=$booking->lot->latitude;?>, lng: <?=$booking->lot->longitude;?> },
				                                    mapTypeId: google.maps.MapTypeId.TERRAIN
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
			                                	
				                                   var map = new google.maps.Map(document.getElementById('map'), {
					                                    zoom: 14,
					                                    scrollwheel: false,
					                                    center: {lat: <?=$booking->lot->latitude;?>, lng: <?=$booking->lot->longitude;?> },
					                                    mapTypeId: google.maps.MapTypeId.TERRAIN
					                                });
					                                    
			                                <?php	}
                                			
                                		////////////////////// PRIVATE //////////////////	
                                		}else if($booking->owner->id_role==2){//private profile
                                			if($booking->lot->show_address ==1){
                                				 	
	                                		 if(count($booking_lots) >= 1){?>
	                                			
	                                			 var map = new google.maps.Map(document.getElementById('map'), {
				                                    zoom: 14,
				                                    scrollwheel: false,
				                                    center: {lat: <?=$booking->lot->latitude;?>, lng: <?=$booking->lot->longitude;?> },
				                                    mapTypeId: google.maps.MapTypeId.TERRAIN
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
		                                    
		                                <? } ?>									
                            }
                    </script>

                    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpONh6QjiiZyV7Emi4nsSB7KJFApSbkzM&signed_in=true&callback=initMap"></script>
                </div>
                <div class="prices-section">
                	<? if($booking->lot->deposit =='document'){?>
                    	<div class="note"><span>Аренда предпологает залог в виде документа</span></div>
                    <?}else{?>
                    	<div class="note"><span>Аренда предпологает залог в размере <?=$booking->lot->deposit?></span></div>
                    <?}?>
                    <div class="rules-use">
                        <span>Правила пользования: <a href="#" data-toggle="modal" data-target="#rulesUse">Читать правила</a></span>
                        <div class="modal fade" id="rulesUse" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Правила пользования</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="requirements">
                                            <div class="rules">
                                                <strong>Условия проката</strong>
                                                <p><?=$booking->lot->rental_terms; ?></p>
                                                <?php if($booking->lot->special_provisio != ''){ ?>
                                                <div class="age">
                                                    <strong>Особые условия:</strong>
                                                    <p><?=$booking->lot->special_provisio; ?></p>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-holder">
                        <h2>Стоимость аренды:</h2>
                        <table class="table">
                            <tbody>
                            <?php 
                            	$order_arr = json_decode($booking->order_arr);
							?>
								<?php if(isset($order_arr[0]->monthes)){?>
	                                <tr>
	                                    <td><strong><?=$order_arr[2]->monthes; ?> <?=$booking->lot->currency?> Х <?=$order_arr[0]->monthes; ?> месяц(а)</strong></td>
	                                    <td><?=$order_arr[2]->monthes*$order_arr[0]->monthes;?> <?=$booking->lot->currency?></td>
	                                </tr>
                                <?}?>
                                <?php if(isset($order_arr[0]->weeks)){?>
	                                <tr>
	                                    <td><strong><?=$order_arr[2]->weeks; ?> <?=$booking->lot->currency?> Х <?=$order_arr[0]->weeks; ?> недель(я)</strong></td>
	                                    <td><?=$order_arr[2]->weeks*$order_arr[0]->weeks;?> <?=$booking->lot->currency?></td>
	                                </tr>
                                <?}?>
                                <?php if(isset($order_arr[0]->days)){?>
	                                <tr>
	                                    <td><strong><?=$order_arr[2]->days; ?> <?=$booking->lot->currency?> Х <?=$order_arr[0]->days; ?> дней(ь)</strong></td>
	                                    <td><?=$order_arr[2]->days*$order_arr[0]->days;?> <?=$booking->lot->currency?></td>
	                                </tr>
                                <?}?>
                                <?php if($booking->lot->deposit != 'document'){ ?>
                                <tr>
                                    <td><strong>Залог</strong></td>
                                    <td><?=$booking->lot->deposit; ?></td>
                                    <?php 
                                    	$sum = explode(' ',$booking->lot->deposit);
										if(isset($sum[1])){
											if($booking->lot->currency==$sum[1]){
	                                    		$order_arr[4] += $sum[0];
											}
										}
									?>
                                </tr>
                                <?php }elseif($booking->lot->deposit == 'document'){ ?>
                                <tr>
                                    <td><strong>Залог</strong></td>
                                    <td>Документ</td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td><strong>Итого</strong></td>
                                    <? 
                                    $sum = explode(' ',$booking->lot->deposit);
									if(isset($sum[1])){
	                                    if($booking->lot->currency!=$sum[1]){?>
	                                    	<td><?=$order_arr[4]; ?> <?=$booking->lot->currency?> 
	                                    	<p>+ Залог <?=$booking->lot->deposit; ?></p>
	                                    	</td>
	                                    <? }else{ ?>
	                                    	<td><?=$order_arr[4]; ?> <?=$booking->lot->currency?></td>
	                                    <? } 
                                    }else{?>
                                    	<td><?=$order_arr[4]; ?> <?=$booking->lot->currency?></td>
                                    <?php } ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

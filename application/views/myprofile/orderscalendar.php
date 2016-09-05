<div id="main-orders-calendar" class="clearfix">
    <div class="back-nav-holder">
        <div class="back-nav">
            <a href="/myprofile?tab2" class="back">назад</a>
        </div>
    </div>
    <div class="calendar-tables-holder clearfix">
        <div class="calendar-holder">
            <div class="calendar" data-loturl="<?=$lot->url;?>">
                <div class="title-order">
                    <h4><?=$lot->title;?></h4>
                    <span>Номер объявления:<i><?=$lot->id;?></i></span>
                </div>
                <div id="datepicker"></div>

                <div class="note">
                    <span>Аренда недоступна</span>
                </div>
            </div>
            <div class="block-order">
                <form action="#" class="booking_date">
                    <div class="period">
                        <div class="part part1">
                            <p>Период с</p>
                            <input type="text" id="datepicker5">
                        </div>
                        <div class="part">
                            <p>До</p>
                            <input type="text" id="datepicker6">
                        </div>
                    </div>
                    <input type="submit" value="Отметить как забронированные" class="btn sent">
                </form>
                <div class="holder-order" data-count="<?=(isset($authorBooking))?count($authorBooking):0;?>">
                <?php if (isset($authorBooking)) { ?>
                    <?php
                        if(count($authorBooking)){
                            foreach($authorBooking as $key=>$item){
                                $key++;?>
                                <section>
                                    <strong><?=$key?>. Забронирован в период с <?=$item->start?> по <?=$item->end?></strong>
                                    <div data-booking-id="<?=$item->id?>" class="delete_boooking"><span class="glyphicon glyphicon-remove"></span></div>
                                </section>
                            <?php	}
                        }
                    ?>
                <?php } ?>
                </div>
            </div>
<!--            <div class="clear_field"><span class="glyphicon glyphicon-remove"></span></div>-->
            <div class="message_field">Некоректно задан диапозон</div>
        </div>
        <div class="orders-tables-container">
            <div class="future-orders">
                <div class="table-header">Будующие заказы</div>
                
                <table class="table table-future-orders">
                    <thead>
                        <tr>
                            <th class="status">
                                <div class="btn-group">
                                    <button class="status-btn dropdown-toggle" data-toggle="dropdown">
                                        Статус <!--<span class="caret"></span>-->
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" class="all-orders" onclick="return false">Все заказы</a></li>
                                        <li><a href="#" class="confirmed-orders" onclick="return false">Подтвержденные</a></li>
                                        <li><a href="#" class="canceled-orders" onclick="return false">Отмененные</a></li>
                                        <li><a href="#" class="for-confirmation" onclick="return false">На подтверждении</a></li>
                                    </ul>
                                </div>
                            </th>

                            <th class="owner">Арендатор</th>
                            <th class="period">Период <!--<a href="#" onclick="return false"></a>--></th>
                            <th class="options">Опции</th>
                        </tr>
                    </thead>
                    <tbody>

	               		<?php
					//	debug($bookedFuture);
	               		if($flag ==true && count($bookedFuture)){
		               		
	                            foreach(array_reverse($bookedFuture) as $key=>$bookinF){ ?>
	 
		                        	<?php if($bookinF->class =='wait'){ ?>
		                        		
		                        		<tr id="booking_<?=$bookinF->id?>" class="<?=$bookinF->class; ?>" cellpadding="4" cellspacing="0">
				                            <td colspan="4">
				                                <table>
				                                    <tr>
				                                        <td class="status">
								                            <span class="<?=$bookinF->class; ?>"><?=$bookinF->classText; ?></span>
								                        </td>

								                        <td class="owner"><span><a href="/page/publicprofile/<?=$bookinF->id_from; ?>"><?=$bookinF->username?></a></span></td>

								                        <td class="period">
								                            <span>с <?=$bookinF->start; ?></span>
								                            <span>по <?=$bookinF->end; ?></span>
								                        </td>
								                        <td class="options">
								                            <a href="/myprofile?tab3" class="message">Сообщения</a>
								                        </td>
				                                    </tr>
				                                    <tr class="buttons-row" data-start="<?=$bookinF->start?>" data-end="<?=$bookinF->end?>">
				                                        <td colspan="4">
				                                        	
				                                            <a href="#" data-booking-id="<?=$bookinF->id?>" class="btn main-btn resolve_booking">Подтвердить</a>
				                                            
				                                            <a href="#" data-booking-id="<?=$bookinF->id?>" class="btn reject reject_booking">Отклонить</a>
				                                        </td>
				                                    </tr>
				                                </table>
				                            </td>
				                        </tr>
	
				                    <?php }else{ ?>
				                    	
				                    	 <tr id="booking_<?=$bookinF->id?>" class="<?=$bookinF->class; ?>">
					                        <td class="status">
					                            <span class="<?=$bookinF->class; ?>"><?=$bookinF->classText; ?></span>
					                        </td>
					                        <td class="owner"><span><a href="/page/publicprofile/<?=$bookinF->id_from; ?>"><?=$bookinF->username?></a></span></td>

					                        <td class="period">
					                            <span>с <?=$bookinF->start; ?></span>
					                            <span>по <?=$bookinF->end; ?></span>
					                        </td>
					                        <td class="options">
					                            <a href="/myprofile?tab3" class="message">Сообщения</a>
					                        </td>
					                    </tr>
				                    <?php } ?>
			                    
	                    <?php } }else{ ?>
	                    	<tr cellpadding="4" cellspacing="0">
				                            <td colspan="4">Нет записей</td>
				            </tr>
	                    <?php } ?>
                    </tbody>
               </table>

            </div>
            
            <div class="past-orders">
                <div class="table-header">Прошедшие заказы</div>
                <table class="table table-past-orders">
                    <thead>
                        <tr>
                            <th class="status">
                                <div class="btn-group">
                                    <button class="status-btn dropdown-toggle" data-toggle="dropdown">
                                        Статус <!--<span class="caret"></span>-->
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" class="all-orders" onclick="return false">Все заказы</a></li>
                                        <li><a href="#" class="confirmed-orders" onclick="return false">Подтвержденные</a></li>
                                        <li><a href="#" class="canceled-orders" onclick="return false">Отмененные</a></li>
                                    </ul>
                                </div>
                            </th>

                            <th class="owner">Арендатор</th>
                            <th class="period">Период <!--<a href="#" onclick="return false"></a>--></th>
                            <th class="options">Опции</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        if($flag ==true && count($bookedPast)){
	               		 
	                        foreach(array_reverse($bookedPast) as $bookinP){
	                        	if($bookinP->class =='wait'){$bookinP->class='cancel';$bookinP->classText='Отменено';}
	                        	?>
	                        	
	                        	     <tr class="<?=$bookinP->class; ?>">
				                        <td class="status">
				                            <span class="<?=$bookinP->class; ?>"><?=$bookinP->classText; ?></span>
				                        </td>
				                        <td class="owner"><span><a href="/page/publicprofile/<?=$bookinP->id_from?>"><?=$bookinP->username?></a></span></td>

				                        <td class="period">
				                            <span>с <?=$bookinP->start; ?></span>
				                            <span>по <?=$bookinP->end; ?></span>
				                        </td>
				                        <td class="options">
				                            <a href="/myprofile?tab3" class="message">Сообщения</a>
				                        </td>
				                    </tr>
	                    <?php 
							}
	                   
						 }else{ ?>
	                    	<tr cellpadding="4" cellspacing="0">
				                            <td colspan="4">Нет записей</td>
				            </tr> 
	                   
	                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
	/*datepicker*/
	$(document).ready(function(){

		var dates = <?=$booking;?>
		
		var startDate='', endDate='';
		console.log('dates',dates);

		var disableDates = function(dt) {

			if(dates.length > 1 ){
						
				var result = dates.reduce(function(prev, item, index, arr) {

					var inside = dates.reduce(function(prev, cur) {
	                 return prev || (cur.from && cur.to && dt <= (new Date(cur.to).setHours(0)) && dt >= (new Date(cur.from).setHours(0)));
	            	}, false);

					return [!inside && (!startDate || +dt >= (new Date(startDate)).setHours(0)) && (!endDate || +dt <= (new Date(endDate)).setHours(0))];
				});
				
				if(result[0] ===false){
					return [result,'datepicker_event'];
				}
				return result;
			}else{
				var result=null;
				if(dates.length === 1){
					startDate = dates[0].from;
					endDate = dates[0].to;
					result = (!startDate || +dt >= (new Date(startDate).setHours(0))) && (!endDate || +dt <= (new Date(endDate)).setHours(0));
					if(result === true){result = false;return [result,'datepicker_event'];}else if(result === false){result = true;return [result];}
				}else{
					result = true;return [result];
				}
				
			}
		}

		$("#datepicker").datepicker({
		    dateFormat : 'yy-mm-dd',
		    altField: "#actualDate",
		    firstDay: 1,
            minDate: "#actualDate",
		    beforeShowDay: disableDates
		});
	});

</script>
<script>
	//Бронирование дат автором лота
	/*datepickers*/
	$(document).ready(function(){

		var dates = <?=$booking;?>
		
		var startDate='', endDate='',flag = 0,flag2 = 0;
		
		console.log('datesnew',dates);

		var disableDates = function(dt) {
			if(dates.length > 1 ){
				
				var result = dates.reduce(function(prev, item, index, arr) {

					var inside = dates.reduce(function(prev, cur) {
	                 return prev || (cur.from && cur.to && dt <= (new Date(cur.to).setHours(0)) && dt >= (new Date(cur.from).setHours(0)));
	            	}, false);
					
					return [!inside && (!startDate || +dt >= (new Date(startDate)).setHours(0)) && (!endDate || +dt <= (new Date(endDate)).setHours(0))];
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

					var res = (!start || dt >= new Date(start).setHours(0)) && (!end || dt <= new Date(end).setHours(0));
					
					if(res ===false){res =true;}else{res =false;}

					result=[(!startDate || dt >= new Date(startDate).setHours(0)) && (!endDate || dt <= new Date(endDate).setHours(0)) && res];
					
					if(flag === 0 && flag2 === 0){
						if(result[0] ===false){
							return [result,'datepicker_event'];
						}
					}

					return result;
					
				}else{
					return [(!startDate || dt >= new Date(startDate).setHours(0)) && (!endDate || dt <= new Date(endDate).setHours(0))];
				}
				
			}
		}

		function checkRange (dt){
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
			if(dates.length > 0){
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
		
		function clear(){
			function f(){$('.message_field').hide();}
			setTimeout( function() { f() } , 2500);
			$("#datepicker,#datepicker2").val('');
			startDate='', endDate='';
		}
		
		$("#datepicker5").datepicker({
		    dateFormat : 'yy-mm-dd',
		    altField: "#actualDate",
            minDate: "#actualDate",
            firstDay: 1,
		    beforeShowDay: disableDates,
		    onSelect: function (date) {
		    	flag = 1;
		    	startDate = date;
		        checkRange(startDate);
		    }
		});
		
		$('#datepicker6').datepicker({
		    dateFormat : 'yy-mm-dd',
		    altField: "#actualDate",
            minDate: "#actualDate",
            firstDay: 1,
		    beforeShowDay: disableDates,
		    onSelect: function (date) {
		    	flag2 = 1;
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
			defaults = $("#datepicker5").attr('data-defaults'),
			defaultf = $("#datepicker6").attr('data-defaultf');

		function ajaxSend(arrDates=''){
			var 
				url = '/booking/saveautorbooking/',
				counter = $(' .holder-order').attr('data-count');
				
			console.log('ajaxSend',arrDates);
			
			if(arrDates.start !=='' && arrDates.end !=='' && arrDates.id_lot !==''){
				$.ajax({
		            url: url,
		            data:{booking:arrDates},
		            method: "POST",
		           	success:function(data){
		            	//$('.calendar-tables-holder').load(document.location+' .calendar-tables-holder > *');
		            	$('.holder-order').append('<section><strong>'+(+counter+1)+'. '+'Забронирован в период с '+arrDates.start+' по '+arrDates.end+'</strong><div data-booking-id="'+data+'" class="delete_boooking"><span class="glyphicon glyphicon-remove"></span></div></section>');
		            },
		            error:function(xhr, ajaxOptions, thrownError){
		            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		            }
	            });
	          }
			
		}

		//valid calendar date
		$('.booking_date').submit(function(e){
			e.preventDefault();
			var 
				$d1 = $("#datepicker5"),
				$d2 = $("#datepicker6"),
				field1 = $d1.val(),
				field2 = $d2.val(),
				id_lot = <?=$lot->id;?>,
				arrDates = {},
				defaults = $("#datepicker5").attr('data-defaults'),
				defaultf = $("#datepicker6").attr('data-defaultf');
		
			
			if(field1 ==='' && field2 ===''){

				if(checkOneDate(defaults, defaultf) === 1){
					$d1.val(defaults); 
					$d2.val(defaultf);
					arrDates = {start : defaults, end : defaultf,id_lot:id_lot};
					//return true;
				}else{
					showError();
					return false;
				}
				
			}else if(field1 ==='' || field2 ===''){

				if(field1 !==''){
					
					if(checkOneDate(field1, field1) === 1){
						$d1.val(field1); 
						$d2.val(field1);
						//return true;
						arrDates = {start : field1, end : field1,id_lot:id_lot};
					}else{
						showError();
						return false;
					}

				}
				
				if(field2 !==''){
					
					if(checkOneDate(field2, field2) === 1){
						$d1.val(field2); 
						$d2.val(field2);
						//return true;
						arrDates = {start : field2, end : field2,id_lot:id_lot};
					}else{
						showError();
						return false;
					}
					
					$d1.val(field2); 
					$d2.val(field2);
					arrDates = {start : field2, end : field2,id_lot:id_lot};
					//return true;
				}
				
			} else{
				arrDates = {start : field1, end : field2,id_lot:id_lot};
				//return true;
			}
			ajaxSend(arrDates);
		});
		
	});
</script>
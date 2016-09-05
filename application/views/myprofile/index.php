<div id="main-private-office"> 
        <div class="top-line"></div>
        <div class="private-office-content">
            <div class="tabbable"> <!-- Only required for left/right tabs -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab" class="lnk1">Мои заказы</a></li>
                    <li><a href="#tab2" data-toggle="tab" class="lnk2">Мои объявления</a></li>
                    <li><a href="#tab3" data-toggle="tab" class="lnk3">Сообщения</a></li>
                    <li><a href="#tab4" data-toggle="tab" class="lnk4">Настройки</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane clearfix active" id="tab1">
                        <div class="buttons-holder">
                            <a href="#" class="btn new-order active" onclick="return false">Новые заказы</a>
                            <a href="#" class="btn last-order" onclick="return false">Прошедшие заказы</a>
                        </div>
                        <div class="table-my-orders">
                            <div class="sorting-orders">
                                <select class="selectpicker">
                                    <option value="new">Новые заказы</option>
                                    <option value="last">Прошедшие заказы</option>
                                </select>
                            </div>
                            
                            <table class="table table-last-orders">
                                <thead>
                                    <tr>
                                        <th class="status">
                                            <div class="btn-group">
                                                <button class="status-btn dropdown-toggle" data-toggle="dropdown">
                                                    Статус <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#" class="all-orders" onclick="return false">Все заказы</a></li>
                                                    <li><a href="#" class="confirmed-orders" onclick="return false">Подтвержденные</a></li>
                                                    <li><a href="#" class="canceled-orders" onclick="return false">Отмененные</a></li>
                                                    <li><a href="#" class="for-confirmation" onclick="return false">На подтверждении</a></li>
                                                </ul>
                                            </div>
                                        </th>
                                        <th class="order">Заказ</th>
                                        <th class="lot">Лот</th>
                                        <th class="owner">Владелец</th>
                                        <th class="period">Период <!--<a href="#" onclick="return false"></a>--></th>
                                        <th class="options">Опции</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $counterP = 0;
                                    if(count($bookedPast->send)){
                                        foreach($bookedPast->send as $bookinP){
                                        	$counterP++;
                                       if ($bookinP->lot && $bookinP->id_from!=$bookinP->id_to) {
                                    ?>
                                    <tr class="<?=$bookinP->class; ?>">
                                        <td class="status">
                                            <span class="<?=$bookinP->class; ?>"><?=$bookinP->classText; ?></span>
                                        </td>
                                        <td class="order">
                                        	<?php if($bookinP->class=='confirm'){?>
	                                            <a href="/page/orderview/<?=$bookinP->id; ?>" class="show-order">Показать заказ</a>
	                                            <a href="/page/orderview/<?=$bookinP->id; ?>" class="print">Печатать заказ</a>
                                            <? } ?>
                                        </td>
                                        <td class="lot">
                                        	<?php
                                        	//debug($bookinP);
                                        	$title = explode(" ", $bookinP->lot->title);
											if (count($title)>6) {
												$tt = array();
												foreach ($title as $k => $t) {
													if ($k<6) {
														$tt[] = $t;
													}
												}
												$title = implode(" ", $tt)."...";
											} else {
												$title = $bookinP->lot->title;
											}
                                        	?>
                                        	<a href="/lot/view/<?=$bookinP->lot->url; ?>"><span><?=$title?></span></a>
                                      	</td>
                                        <td class="owner"><span><? if($bookinP->user){ echo $bookinP->user->name; }?></span></td>
                                        <td class="period">
                                            <span>с <?=$bookinP->start; ?></span>
                                            <span>по <?=$bookinP->end; ?></span>
                                        </td>
                                        <td class="options">
                                            <a href="/myprofile?tab3" class="message">Сообщения</a>
                                            <a href="/page/publicprofile/<? if($bookinP->user){ echo  $bookinP->user->id;} ?>" class="estimate">Оценить арендодателя</a>
                                            <a href="/lot/view/<?=$bookinP->lot->url; ?>" class="estimate2">Оценка лота</a>
                                        </td>
                                    </tr>
                                    <?php } }
                                    } ?>
                                    
                                    <?php if ($counterP==0){?>
                                    	<tr><td colspan="6">У вас пока нет заказов.</td></tr>
                                    <? } ?>

                                </tbody>
                            </table>
                            <table class="table table-new-orders">
                                <thead>
                                    <tr>
                                        <th class="status">
                                            <div class="btn-group">
                                                <button class="status-btn dropdown-toggle" data-toggle="dropdown">
                                                    Статус <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#" class="all-orders" onclick="return false">Все заказы</a></li>
                                                    <li><a href="#" class="confirmed-orders" onclick="return false">Подтвержденные</a></li>
                                                    <li><a href="#" class="canceled-orders" onclick="return false">Отмененные</a></li>
                                                    <li><a href="#" class="for-confirmation" onclick="return false">На подтверждение</a></li>
                                                </ul>
                                            </div>
                                        </th>
                                        <th class="order">Заказ</th>
                                        <th class="lot">Лот</th>
                                        <th class="owner">Владелец</th>
                                        <th class="period">Период</th>
                                        <th class="options">Опции</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counterF=0;
									
                                    if(count($bookedFuture->send)){
                                        foreach($bookedFuture->send as $bookinF){
                                        	
                                        	if ($bookinF->user && $bookinF->lot && $bookinF->id_from!=$bookinF->id_to) {
                                        		
                                        		$counterF++; ?>
	                                    		<tr class="<?=$bookinF->class; ?>">
			                                        <td class="status">
			                                            <span class="<?=$bookinF->class; ?>"><?=$bookinF->classText; ?></span>
			                                        </td>
			                                        <td class="order">
														<?php if($bookinF->class=='confirm'){?>
			                                            	<a href="/page/orderview/<?=$bookinF->id?>" class="show-order">Показать заказ</a>
			                                            	<a href="/page/orderview/<?=$bookinF->id; ?>" class="print">Печатать заказ</a>
			                                        	<? } ?>
			                                        </td>
			                                        <td class="lot"><a href="/lot/view/<?=$bookinF->lot->url; ?>"><span><?=$bookinF->lot->title; ?></span></a></td>
			                                        <td class="owner"><span><?=$bookinF->user->name; ?></span></td>
			                                        <td class="period">
			                                            <span>с <?=$bookinF->start; ?></span>
			                                            <span>по <?=$bookinF->end; ?></span>
			                                        </td>
			                                        <td class="options">
			                                            <a href="/myprofile?tab3" class="message">Сообщения</a>
			                                            <a href="/page/publicprofile/<?=$bookinF->user->id; ?>" class="estimate">Оценить арендодателя</a>
			                                            <a href="/lot/view/<?=$bookinF->lot->url; ?>" class="estimate2">Оценка лота</a>
			                                        </td>
			                                    </tr>
                                    <?php }
                                    } } ?>
                                                                        
                                    <?php if ($counterF==0){?>
                                    	<tr><td colspan="6">У вас пока нет заказов.</td></tr>
                                    <? } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="my-orders-640px">
                            <div class="sorting-orders">
                                <select class="selectpicker">
                                    <option value="new">Новые заказы</option>
                                    <option value="last">Прошедшие заказы</option>
                                </select>
                            </div>   
                            <div class="new-orders active">
                                <?php $counterF=0;
									
                                    if(count($bookedFuture->send)){
                                        foreach($bookedFuture->send as $bookinF){
                                        	
                                        	if ($bookinF->user && $bookinF->lot && $bookinF->id_from!=$bookinF->id_to) {
                                        		
                                        		$counterF++; ?>
		                                <div class="<?=$bookinF->class; ?>">
		                                     <div class="order-block">
		                                        <div class="status">
		                                            <span class="<?=$bookinF->class; ?>"><?=$bookinF->classText; ?></span>
		                                        </div>
		                                        <div class="name"><? if($bookinF->user){ echo $bookinF->user->name;} ?></div>
		                                        <p>Сообщения</p>
		                                        <div class="text"><a href="/lot/view/<?=$bookinF->lot->url; ?>"><span><?=$bookinF->lot->title; ?></span></a></div>
		                                        <div class="date">
		                                            <span>с <?=$bookinF->start; ?></span>
                                                    <span>по <?=$bookinF->end; ?></span>
		                                        </div>
		                                        <div class="links-holder">
		                                            <?php if($bookinF->class=='confirm'){?>
                                                        <a href="/page/orderview/<?=$bookinF->id?>" class="show-order">Показать заказ</a>
                                                        <a href="/page/orderview/<?=$bookinF->id; ?>" class="print">Печатать заказ</a>
                                                    <? } ?>
		                                        </div>
		                                     </div>
		                                </div>
                                   <?php }
                                    } } ?>
                                                                        
                                    <?php if ($counterF==0){?>
                                    	<p>У вас пока нет заказов.</p>
                                    <? } ?>
                             </div>
                            <div class="last-orders">
                                <?php 
                                $counterP = 0;
                                if(count($bookedPast->send)){
                                    foreach($bookedPast->send as $bookinP){
                                        $counterP++;
                                   if ($bookinP->lot && $bookinP->id_from!=$bookinP->id_to) {
                                ?>
                                <div class="<?=$bookinP->class; ?>">
                                     <div class="order-block">
                                        <div class="status">
                                            <span class="<?=$bookinP->class; ?>"><?=$bookinP->classText; ?></span>
                                        </div>
                                        <div class="name"><? if($bookinP->user){ echo $bookinP->user->name; }?></div>
                                        <p>Сообщения</p>
                                        <div class="text">
                                            <?php
                                            //debug($bookinP);
                                            $title = explode(" ", $bookinP->lot->title);
                                            if (count($title)>6) {
                                                $tt = array();
                                                foreach ($title as $k => $t) {
                                                    if ($k<6) {
                                                        $tt[] = $t;
                                                    }
                                                }
                                                $title = implode(" ", $tt)."...";
                                            } else {
                                                $title = $bookinP->lot->title;
                                            }
                                            ?>
                                            <a href="/lot/view/<?=$bookinP->lot->url; ?>"><span><?=$title?></span></a>
                                        </div>
                                        <div class="date">
                                            <span>с <?=$bookinP->start; ?></span>
                                            <span>по <?=$bookinP->end; ?></span>
                                        </div>
                                        <div class="links-holder">
                                            <a href="/page/orderview/<?=$bookinP->id; ?>" class="show-order">Показать заказ</a>
                                            <a href="/page/orderview/<?=$bookinP->id; ?>" class="print">Печатать заказ</a>
                                        </div>
                                    </div>
                                </div>
                                 <?php } }
                                } ?>

                                <?php if ($counterP==0){?>
                                    <p>У вас пока нет заказов.</p>
                                <? } ?>
                             </div>
                        </div>
                    </div>
                    <div class="tab-pane clearfix" id="tab2">
                        <div class="my-ads-holdere">
                            <div class="show-deactivated">
                                <label class="checkbox">
                                    <input class="deactivated-controll" type="checkbox">
                                    <span class="lbl padding-8"></span>
                                </label>
                                <span>Показать деактивированные</span>
                            </div>
                            <table class="table table-my-ads">
                                <thead>
                                    <tr>
                                        <th class="title">Заголовок</th>
                                        <th class="calendar">Календарь</th>
                                        <th class="price">Цена</th>
                                        <th class="message">Сообщение</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(count($user->lots)){ ?>
                                    <?php foreach($user->lots as $lot){  ?>
                                    <tr class="lot-hide-<?=$lot->post_type; ?>">
                                        <td class="title">
                                            <div class="ordered-product">
                                                <div class="img-holder" style="background-image: url(<?=!empty($lot->mainImage) ? Lot::UPLOAD_DIR.$lot->url.'/'.$lot->mainImage : '/assets/images/no-img.png'; ?>)"><a href="/lot/view/<?=$lot->url; ?>"></a></div>
                                                <div class="description" id="lot_<?=$lot->id?>">
                                                	<?php
		                                        	$title = explode(" ", $lot->title);
													if (count($title)>6) {
														$tt = array();
														foreach ($title as $k => $t) {
															if ($k<6) {
																$tt[] = $t;
															}
														}
														$title = implode(" ", $tt)."...";
													} else {
														$title = $lot->title;
													}
		                                        	?>
                                                    <a href="/lot/view/<?=$lot->url; ?>"><strong><?=$title?></strong></a>
                                                    <a href="/lot/view/<?=$lot->url; ?>" class="showing">Просмотр</a>
                                                    <a href="/lot/edit/<?=$lot->url; ?>" class="edit">Редактировать</a>
                                                    <a href="/lot/posttype/<?=$lot->id?>" class="<?=$lot->post_type ? 'activate' : 'deactivate'; ?>"><?=$lot->post_type ? '<i class="fa fa-check"></i> Активировать' : 'Деактивировать'; ?></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="calendar"><a href="/myprofile/orderscalendar/<?=$lot->url; ?>"></a></td>
                                        <td class="price"><?=$lot->day_payment; ?> <?=($lot->currency)?$lot->currency:'грн.'; ?></td>
                                        <td class="message">
                                        	<?php $newmess = $countNew = Message::countRowWhere('id_lot = ? AND new = ? AND booked !=0', array($lot->id, Message::FRESH)); ?>
                                        	<a class="<?php if($newmess > 0){?>have-messages<? } ?> link_to_mess" href="#tab3" data-toggle="tab" class="lnk3">
                                            	<span><?=$newmess?></span>
                                            </a>
                                        </td>
                                    </tr>
                                        <?php 
                                    } 
                                }else{ ?>
                                    <tr>
                                        Нет лотов
                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>
                        </div>
                        <div class="my-ads-640px">
                            <div class="show-deactivated">
                                <label class="checkbox">
                                    <input type="checkbox">
                                    <span class="lbl padding-8"></span>
                                    <span>Показать деактивированные</span>
                                </label>
                            </div>
                            <?php
                                if(count($user->lots)){ ?>
                                    <?php foreach($user->lots as $lot){  ?>
                                        <div class="ad-block">
                                            <div class="img-holder" style="background-image: url(<?=!empty($lot->mainImage) ? Lot::UPLOAD_DIR.$lot->url.'/'.$lot->mainImage : '/assets/images/no-img.png'; ?>)"><a href="/lot/view/<?=$lot->url; ?>"></a></div>
                                            <div class="description" id="lot_<?=$lot->id?>">
                                               <?php
                                                $title = explode(" ", $lot->title);
                                                if (count($title)>6) {
                                                    $tt = array();
                                                    foreach ($title as $k => $t) {
                                                        if ($k<6) {
                                                            $tt[] = $t;
                                                        }
                                                    }
                                                    $title = implode(" ", $tt)."...";
                                                } else {
                                                    $title = $lot->title;
                                                }
                                                ?>
                                                <a href="/lot/view/<?=$lot->url; ?>"><strong><?=$title?></strong></a>
                                                <div class="price-and-calendar">
                                                    <span><?=$lot->day_payment; ?> currency</span>
                                                    <div class="box">
                                                        <a href="/myprofile/orderscalendar/<?=$lot->url; ?>" class="calendar"></a>
                                                        <?php $newmess = $countNew = Message::countRowWhere('id_lot = ? AND new = ? AND booked !=0', array($lot->id, Message::FRESH)); ?>
                                                        <a class="messages <?php if($newmess > 0){?>have-messages<? } ?> link_to_mess" href="#tab3" data-toggle="tab" class="lnk3">
                                                            <span><?=$newmess?></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="links-holder">
                                                <a href="/lot/view/<?=$lot->url; ?>" class="showing">Просмотр</a>
                                                <a href="/lot/edit/<?=$lot->url; ?>" class="edit">Редактировать</a>
                                                <a href="/lot/posttype/<?=$lot->id?>" class="<?=$lot->post_type ? 'activate' : 'deactivate'; ?>"><?=$lot->post_type ? '<i class="fa fa-check"></i> Активировать' : 'Деактивировать'; ?></a>
                                            </div>
                                        </div>
                                    <?php 
                                    } 
                                }else{ ?>
                                    <div class="ad-block">
                                        Нет лотов
                                    </div>
                                <?php } ?>
                            
                        </div>
                    </div>
                    <div class="tab-pane clearfix" id="tab3">
                        <div class="messages-holder clearfix">
                            <div class="buttons-holder">
                                <a href="#" class="btn inbox active" onclick="return false">Входящие</a>
                                <a href="#" class="btn outbox" onclick="return false">Исходящие</a>
                                <a href="#" class="btn archive" onclick="return false">Архив</a>
                            </div>
                            <div class="table-my-messages">
                                <div class="table-section">
                                    <div class="sorting-for-messages"><br />
                                    	
                                        <span>Показать входящие сообщения для:</span>
                                        <select class="selectpicker messages-type">
                                            <option value="0">Входящие</option>
                                            <option value="1">Исходящие</option>
                                            <option value="2">Архив</option>
                                        </select>
                                        <select name="lots_select" class="selectpicker lots_select">
                                             <option class="lotshowerAll" value="0">Все входящие сообщения</option>
                                             <?php 
                                             	$shr = array();
		                                    	if(count($messagesArray)){
			                                        foreach($messagesArray as $recive) {
		                                                 if($recive->from instanceof User){ 
		                                                 	if($recive->lot){
		                                                     	if(!in_array($recive->from->name.','.$recive->lot->title, $shr)){ ?>
				                                                   	<option class="lotshower" data-id="<?=$recive->lot->id; ?>" value="<?=$recive->lot->id; ?>"><?=$recive->lot->title; ?></option>
			                                                     	<?php $shr[] = $recive->from->name.','.$recive->lot->title;                
		                                                     	} 
		                                                 	}
			                                             }
			                                     	}
												}
		                                     ?>
                                         </select>
                                    </div>
                                     <table class="table table-incoming-messages _active">
                                         <thead>
                                             <tr>
                                                 <th class="check">
                                                     <label class="checkbox">
                                                         <input type="checkbox">
                                                         <span class="lbl padding-8"></span>
                                                     </label>
                                                 </th>
                                                 <th class="del"><a class="checked_mess_to_archive" href="#" title="Удалить все сообщения"></a></th>
                                                 <th class="user">Пользователь</th>
                                                 <th class="order">Объявление</th>
                                                 <th class="date">Дата<a href="#" class="sort_messages" data-hold="<?=$hold;?>" onclick="return false"></a></th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                         <?php
                                         if(count($messagesArray)){
                                         	
                                             foreach($messagesArray as $key => $recive) { 
                                                 if($recive->from instanceof User){
                                                 	
                                                 	if($recive->lot){
                                                     if(!in_array($recive->from->name.','.$recive->lot->title, $showedr)){ ?>
	                                                    <tr class="lotrow <?if($recive->new == 1 && count($recive->new) > 0){?>newmessages<?php } ?>" id="<?=$recive->lot->id; ?>">
	                                                        <td class="check">
	                                                            <label class="checkbox checkbox-del-message"> 
	                                                                <input type="checkbox">
	                                                                <span class="lbl padding-8"></span>
	                                                            </label>
	                                                        </td>
	                                                        <td class="del lot_to_archive"><a data-id="<?=$recive->id;?>" data-json="<?=$recive->from->id; ?>|<?=$recive->lot->id; ?>" href="/myprofile/toarchive/<?=$recive->lot->id; ?>/<?=$recive->from->id; ?>"></a></td>
	                                                        <td class="user"><a href="/page/publicprofile/<?=$recive->from->id; ?>" <?php if($user->id != $recive->from->id){ ?>class="arrow"<?php } ?>><?=$recive->from->name; ?></a></td>
	                                                        <td class="order">
	                                                            <div class="message">
	                                                                <a href="#" class="to-open-dialog" onclick="return false" data-user="<?=$recive->from->id; ?>" data-lot="<?=$recive->lot->id; ?>"><strong><?=$recive->lot->title; ?></strong></a>
	                                                                <p><?=$recive->text; ?></p>
	                                                            </div>
	                                                        </td>
	                                                        <td class="date"><span><?=echoRussianDate($recive->time); ?></span></td>
	                                                    </tr>
                                                     <?php $showedr[] = $recive->from->name.','.$recive->lot->title;                
                                                     } 
                                                 	}else{ ?>
                                                 		<tr class="lotrow <?if($recive->new == 1 && count($recive->new) > 0){?>newmessages<?php } ?>">
	                                                        <td class="check">
	                                                            <label class="checkbox checkbox-del-message"> 
	                                                                <input type="checkbox">
	                                                                <span class="lbl padding-8"></span>
	                                                            </label>
	                                                        </td>
	                                                        <td class="del user_to_archive"><a data-id="<?=$recive->id;?>" data-json="<?=$recive->from->id; ?>|0" href="/myprofile/toarchiveauthor/<?=$recive->from->id; ?>"></a></td>
	                                                        <td class="user"><a href="/page/publicprofile/<?=$recive->from->id; ?>"><?=$recive->from->name; ?></a></td>
	                                                        <td class="order">
	                                                            <div class="message">
	                                                                <a href="#" class="to-open-dialog-toauthor" onclick="return false" data-user="<?=$recive->from->id; ?>" <?php if($user->id != $recive->from->id){ ?>class="arrow"<?php } ?>><strong>Сообщение автору</strong></a>
	                                                                <p><?=$recive->text; ?></p>
	                                                            </div>
	                                                        </td>
	                                                        <td class="date"><span><?=echoRussianDate($recive->time); ?></span></td>
	                                                    </tr>
                                               <? }}
                                             }
                                         }else{ ?>
                                             <tr>
                                                 <td>Сообщения отсутствуют</td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                             </tr>
                                         <?php } ?>
                                         </tbody>
                                     </table>
                                     <table class="table table-outgoing-messages">
                                         <thead>
                                             <tr>
                                                 <th class="check">
                                                     <label class="checkbox">
                                                         <input type="checkbox">
                                                         <span class="lbl padding-8"></span>
                                                     </label>
                                                 </th>
                                                 <th class="del"><a class="checked_outmess_to_archive" href="#" title="Удалить все сообщения"></a></th>
                                                 <th class="user">Пользователь</th>
                                                 <th class="order">Объявление</th>
                                                 <th class="date">Дата<a href="#" class="sort_messages" data-hold="<?=$hold;?>" onclick="return false"></a></th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             <?php
                                             if(count($user->sendMessages)){
                                                 foreach(array_reverse($user->sendMessages) as $send) { 
                                                     if($send->to instanceof User){
                                                     	if($send->lot){
                                                         if(!in_array($send->to->name.','.$send->lot->title, $showeds)){ ?>
                                                             <tr class="lotrow" id="<?=$send->lot->id; ?>">
                                                                 <td class="check">
                                                                     <label class="checkbox checkbox-del-outmessage">
                                                                         <input type="checkbox">
                                                                         <span class="lbl padding-8"></span>
                                                                     </label>
                                                                 </td>
                                                                 <td class="del lot_to_archive_out"><a data-id="<?=$send->id;?>" data-json="<?=$send->to->id; ?>" href="/myprofile/toarchiveoutcoming/<?=$send->id;?>"></a></td>
	                                                             <td class="user"><a href="/page/publicprofile/<?=$send->to->id; ?>"><?=$send->to->name; ?></a></td>
                                                                 <td class="order">
                                                                     <div class="message">
                                                                         <a href="#" class="to-open-dialog" onclick="return false" data-user="<?=$send->to->id; ?>" data-lot="<?=$send->lot->id; ?>"><strong><?=$send->lot->title; ?></strong></a>
                                                                         <p><?=$send->text; ?></p>
                                                                     </div>
                                                                 </td>
                                                                 <td class="date"><span><?=echoRussianDate($send->time); ?></span></td>
                                                             </tr>
                                                         <?php $showeds[] = $send->to->name.','.$send->lot->title;        
                                                         } 
                                                     }else{?>
                                                     	<tr class="lotrow">
                                                                 <td class="check">
                                                                     <label class="checkbox checkbox-del-outmessage">
                                                                         <input type="checkbox">
                                                                         <span class="lbl padding-8"></span>
                                                                     </label>
                                                                 </td>
                                                                 <td class="del lot_to_archive_out"><a data-id="<?=$send->id;?>" data-json="<?=$send->to->id; ?>" href="/myprofile/toarchiveoutcoming/<?=$send->id;?>"></a></td>
	                                                             <td class="user"><a href="/page/publicprofile/<?=$send->to->id; ?>"><?=$send->to->name; ?></a></td>
                                                                 <td class="order">
                                                                     <div class="message">
                                                                         <a href="#" class="to-open-dialog-toauthor" onclick="return false" data-user="<?=$send->to->id; ?>"><strong>Сообщение автору</strong></a>
                                                                         <p><?=$send->text; ?></p>
                                                                     </div>
                                                                 </td>
                                                                 <td class="date"><span><?=echoRussianDate($send->time); ?></span></td>
                                                             </tr>
                                                    <? }
													}
                                                 }
                                             }else{ ?>
                                                 <tr>
                                                     <td>Сообщения отсутствуют</td>
                                                 </tr>
                                         <?php } ?>
                                         </tbody>
                                     </table>
                                     <table class="table table-archive-messages">
                                         <thead>
                                             <tr>
                                                 <th class="check">
                                                     <label class="checkbox">
                                                         <input type="checkbox">
                                                         <span class="lbl padding-8"></span>
                                                     </label>
                                                 </th>
                                                 <th class="del"><a href="#" class="del_checked_messages" title="Удалить все сообщения"></a></th>
                                                 <th class="user">Пользователь</th>
                                                 <th class="order">Объявление</th>
                                                 <th class="date">Дата<a href="#" data-hold="<?=$hold;?>" class="sort_messages" onclick="return false"></a></th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                              <?php $showeds = array();
                                             if(count($user->archiveMessages)){
                                                 foreach(array_reverse($user->archiveMessages) as $key=>$archive) {
                   									
                                                 	if($archive->lot){
                                                 	//	$sh = (isset($archive->to->name)&&isset($archive->from->name)&&isset($archive->lot->title))?$archive->to->name.','.$archive->from->name.','.$archive->lot->title:'';
                                                     
	                                                     if(!in_array($archive->to->name.','.$archive->lot->title, $showeds) && $archive->lot->title){ ?>
	                                                         <tr class="lotrow" id="<?=$archive->lot->id; ?>">
	                                                             <td class="check">
	                                                                 <label class="checkbox del_archive_checkbox">
	                                                                     <input type="checkbox">
	                                                                     <span class="lbl padding-8"></span>
	                                                                 </label>
	                                                             </td>
	                                                             <td class="del del_archive"><a data-id="<?=$archive->id; ?>" href="/myprofile/deletearchiveid/<?=$archive->id; ?>"></a></td>
	                                                             <td class="user"><?=$archive->to->name; ?>, <?=is_object($archive->from)?$archive->from->name:''; ?></td>
	                                                             <td class="order">
	                                                                 <div class="message">
	                                                                     <a href="#" onclick="return false" class="to-open-dialog" data-user="<?=is_object($archive->from)?$archive->from->id:''; ?>" data-lot="<?=$archive->lot->id; ?>" /><strong><?=$archive->lot->title; ?></strong></a>
	                                                                     <p><?=$archive->text; ?></p>
	                                                                 </div>
	                                                             </td>
	                                                             <td class="date"><span><?=echoRussianDate($archive->time); ?></span></td>
	                                                         </tr>
	                                                         <?php 
	                                                         	$showeds[] = $archive->to->name.','.$archive->lot->title;     
															 
	                                                     }
													}else{?>
														<tr class="lotrow">
                                                             <td class="check">
                                                                 <label class="checkbox del_archive_checkbox">
                                                                     <input type="checkbox">
                                                                     <span class="lbl padding-8"></span>
                                                                 </label>
                                                             </td>
                                                             <td class="del del_archive"><a data-id="<?=$archive->id; ?>" href="/myprofile/deletearchiveid/<?=$archive->id; ?>"></a></td>
                                                             <td class="user"><?=$archive->to->name; ?>, <?=is_object($archive->from)?$archive->from->name:''; ?></td>
                                                             <td class="order">
                                                                 <div class="message">
                                                                     <a href="#" onclick="return false" class="to-open-dialog" data-user="<?=is_object($archive->from)?$archive->from->id:''; ?>"><strong>Сообщение автору</strong></a>
                                                                     <p><?=$archive->text; ?></p>
                                                                 </div>
                                                             </td>
                                                             <td class="date"><span><?=echoRussianDate($archive->time); ?></span></td>
                                                         </tr>
													<?}
                                                 }
                                             }else{ ?>
                                                 <tr>
                                                     <td></td>
                                                     <td></td>
                                                     <td>Сообщения отсутствуют</td>
                                                     <td></td>
                                                     <td></td>
                                                 </tr>
                                         <?php } ?>
                                         </tbody>
                                     </table>
                                </div>

                                <div id="dialog-holder">
                                    <!--Html code will be here after ajax inquiry!-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane clearfix" id="tab4">
                        <div class="settings-holder <?=($user->id_role == User::BUSINESS) ? 'business' : ''; ?>">
                            
                            <div class="content-holder">
                                <form method="POST" action="/myprofile/editinfo" enctype="multipart/form-data" onkeypress="if(event.keyCode == 13) return false;">
                                	
                                	<div class="top-section">
		                                <span>Кто вы?</span>
		                                <select name="form[id_role]" class="selectpicker select-privat-business">
		                                    <option <?=($user->id_role == User::USER) ? 'selected' : ''; ?> value="2">Частное лицо</option>
		                                    <option <?=($user->id_role == User::BUSINESS) ? 'selected' : ''; ?> value="3">Бизнес</option>
		                                </select>
		                            </div>
                                    <div class="personal-information-holder">
                                        <div class="personal-information">

                                            <h6>Личная информация</h6>
                                            <div class="avatar">
                                                <span>Аватар</span>
                                                <div class="add-image">
                                                    <div class="img-holder img_avatar" style="background-image: url(<?=($user->avatar)?$user->avatar:'/assets/images/photo.jpg'; ?>); background-size: cover;"> 
                                                        <input name="form[avatar]" class="inp_avatar" type="hidden" value="<?=($user->avatar)?$user->avatar:''; ?>">
                                                    </div>
                                                    <div class="descript">
                                                        <div class="input-holder">
                                                            <button type="button" class="download">Выберите или перетащите сюда</button>   
                                                            <button type="button" class="download download-640px">Загрузить</button>
                                                        </div>
                                                        <a href="javascript: void(0)" class="del del-avatar"></a>
                                                        <p>Формат: jpg, gif, png. Максимальный размер файла: 5 МБ.</p>
                                                    </div>

                                                    <input name="userfile" type="file" id="avatar">

                                                    <div class="modal-del-holder delete-avatar">
                                                        <div class="modal-del">
                                                            <button type="button" class="closer">×</button>
                                                            <div class="question">

                                                                <p><i class="fa fa-trash-o"></i> Удалить текущий аватар?</p>
                                                                <a href="/myprofile/deleteavatar" class="delete ok">ОК</a>

                                                                <a href="#" onclick="return false" class="cancel">ОТМЕНА</a>
                                                            </div>
                                                        </div>
                                                        <div class="overlay"></div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="main-info">
                                                <label class="user">
                                                    <strong>Имя</strong>
                                                    <input name="form[name]" type="text" value="<?=($user->name) ? $user->name : ''; ?>" required class="form-control" placeholder="Ваше имя">
                                                    <b></b>
                                                </label>
                                                <label class="user">
                                                    <strong>Фамилия</strong>
                                                    <input name="form[surname]" type="text" value="<?=($user->surname) ? $user->surname : ''; ?>" required class="form-control" placeholder="Ваша фамилия">
                                                    <b></b>
                                                </label> 
                                                <label class="user">
                                                    <strong>E-mail</strong>
                                                    <input name="form[email]" type="email" value="<?=($user->email); ?>" required class="form-control" placeholder="Ваш e-mail">
                                                    <b></b>
                                                </label>
                                                <label class="business">
                                                    <strong>Название компании</strong>
                                                    <input name="form[company_name]" type="text" value="<?=($user->company_name) ? $user->company_name : ''; ?>" required class="form-control" placeholder="Введите название">
                                                    <b></b>
                                                </label>
                                                <label class="business">
                                                    <strong>E-mail</strong>
                                                    <input name="form[company_email]" type="email" value="<?=($user->company_email) ? $user->company_email : ''; ?>" required class="form-control" placeholder="Ваш e-mail">
                                                    <b></b>
                                                </label>
                                                <div class="pol user">
                                                    <strong>Пол</strong>
                                                    <label class="checkbox male">
                                                        <input name="form[male]" <?=($user->gender == 'male') ? 'checked' : ''; ?> type="checkbox">
                                                        <span class="lbl padding-8"></span>
                                                        <i>Мужской</i>
                                                    </label>
                                                    <label class="checkbox female">
                                                        <input name="form[female]" <?=($user->gender == 'female') ? 'checked' : ''; ?> type="checkbox">
                                                        <span class="lbl padding-8"></span>
                                                        <i>Женский</i>
                                                    </label>
                                                </div>
                                                <div class="date-birth user">
                                                    <strong>День рождения</strong>
                                                    <?php if(count($birthday)){ ?>
                                                        <select name="form[day]" class="selectpicker">
                                                        <?php for($day = 1; $day<32; $day++){ ?>
                                                            <option <?=$birthday['day'] == $day ? 'selected' : ''; ?>><?=$day; ?></option>
                                                        <?php } ?>
                                                        </select>
                                                        <select name="form[month]" class="selectpicker">
                                                            <?php for($month = 1; $month<13; $month++){ ?>
                                                                <option <?=$birthday['month'] == $month ? 'selected' : ''; ?>><?=$month; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <select name="form[year]" class="selectpicker">
                                                        <?php for($year = 1930; $year<2007; $year++){ ?>
                                                            <option <?=$birthday['year'] == $year ? 'selected' : ''; ?>><?=$year; ?></option>
                                                        <?php } 

                                                    }else{ ?>

                                                        <select name="form[day]" class="selectpicker">
                                                        <?php for($day = 1; $day<32; $day++){ ?>
                                                            <option><?=$day; ?></option>
                                                        <?php } ?>
                                                        </select>
                                                        <select name="form[month]" class="selectpicker">
                                                            <?php for($month = 1; $month<13; $month++){ ?>
                                                                <option><?=$month; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <select name="form[year]" class="selectpicker">
                                                        <?php for($year = 1930; $year<2011; $year++){ ?>
                                                            <option><?=$year; ?></option>
                                                        <?php } 
                                                    } ?>
                                                    </select>
                                                </div>
                                                <div class="phone-numbers">
                                                    <strong>Номе телефона</strong>
                                                    <div class="inputs-holder">
                                                        <div class="marker">Этот номер мы покажем как основной</div>
                                                        <?php $check = 0; for($phone=0; $phone<5; $phone++){ 
                                                            $telephone = 'phone'.$phone;
                                                            if($user->$telephone){ $check++; ?>
                                                                <div class="item main-number">
                                                                    <i>+38</i><input type="text" value="<?=$user->$telephone; ?>" name="form[<?=$telephone; ?>]" class="form-control additional-number">
                                                                </div>
                                                            <?php }
                                                        } 
                                                        if($check<1){ ?>
                                                        <div class="item main-number">
                                                            <i>+38</i><input type="text" name="form[phone<?=$check; ?>]" class="form-control additional-number" required>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="lnk-holder">
                                                        <a href="#" class="add-number-field" onclick="return false">Добавить еще номер телефона</a>
                                                    </div>      
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="your-contacts-holder">
                                        <div class="your-contacts">
                                        <h6>Ваши контактные данные</h6>
                                           <div class="location-holder">
                                            <div class="location">
                                                <span>Помогите клиентам найти Вас:</span>
                                                
                                                <a href="#" id="viewasuser" onclick="return false" class="show-location" data-lat="<?=($user->position)?$user->position->latitude:''?>" data-long="<?=($user->position)?$user->position->longitude:''?>" data-toggle="modal" data-target="#showMap">Посмотреть что будут видеть другие пользователи.</a>
                                                <div class="map-holder">
                                                    <div class="marker">Мы будем скрывать Ваш точный адрес</div>
                                                    <input id="pac-input" name="map[title]" value="<?=($user->position)?$user->position->address:'Харьков, Харьковская область, Украина'?>" class="controls" type="text" placeholder="Ваше местоположение">
                                                    
                                                    <input name="map[lat]" value="<?=($user->position)?$user->position->latitude:'49.9935'?>" class="mlat" type="hidden">
                                                    <input name="map[long]" value="<?=($user->position)?$user->position->longitude:'36.230383'?>" class="mlong" type="hidden">
                                                    
                                                    <div id="map"></div>

                                                    <div class="marker marker2">Мы будем скрывать Ваш точный адрес</div>
                                                    
                                                    <script> 
                                                    
                                                    function initAutocomplete() {
                                                    	
                                                    	var map = new google.maps.Map(document.getElementById('map'),
                                                    {
                                                    	center: {lat: <?=($user->position)?$user->position->latitude:'49.9935'?>,
                                                    	lng: <?=($user->position)?$user->position->longitude:'36.230383'?>},
                                                    	zoom: 11,
                                                    	disableDefaultUI: true,
                                                    	scrolwheel: false,
                                                    	mapTypeId: google.maps.MapTypeId.ROADMAP
                                                    });
                                                    
                                                    var marker = new google.maps.Marker({
				                                        position: {lat: <?=($user->position)?$user->position->latitude:'49.9935'?>,
                                                    	lng: <?=($user->position)?$user->position->longitude:'36.230383'?>},
				                                        map: map,
				                                    });
				                                    google.maps.event.trigger(map, "resize");
                                                    var input = document.getElementById('pac-input');
                                                    var searchBox = new google.maps.places.SearchBox(input);
                                                    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                                                    map.addListener('bounds_changed', function() {searchBox.setBounds(map.getBounds());});
                                                    var markers = [];
                                                    searchBox.addListener('places_changed', function() {
                                                    	var places = searchBox.getPlaces();
                                                    	if (places.length == 0) {return;}
                                                    	markers.forEach(function(marker) {marker.setMap(null);});
                                                    	markers = [];
                                                    	var bounds = new google.maps.LatLngBounds();
                                                    	places.forEach(function(place) {
                                                    		var icon = {
                                                    			url: place.icon,
                                                    			size: new google.maps.Size(71, 71),
                                                    			origin: new google.maps.Point(0, 0),
                                                    			anchor: new google.maps.Point(17, 34),
                                                    			scaledSize: new google.maps.Size(25, 25)
                                                    		};
                                                    		markers.push(new google.maps.Marker({
                                                    			map: map,
                                                    			icon: icon,
                                                    			title: place.name,
                                                    			position: place.geometry.location
                                                    		}));
                                                    		$('.mlat').val(markers[0].position.lat());
                                                    		$('.mlong').val(markers[0].position.lng());
                                                    		$('#viewasuser').attr('data-lat', markers[0].position.lat());
                                                    		$('#viewasuser').attr('data-long', markers[0].position.lng());
                                                    		console.log(markers[0].position.lat());
                                                    		console.log(markers[0].position.lng());
                                                    		if (place.geometry.viewport) {
                                                    			bounds.union(place.geometry.viewport);
                                                    		} else {
                                                    			bounds.extend(place.geometry.location);
                                                    		}
                                                    	});
                                                    	map.fitBounds(bounds);
                                                    	
                                                    });
                                                    
                                             		}
                                             		</script>      
                                                    <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCpz0h1gSI6h2qsxrq6wsgVgDcemQzyEWU&libraries=places&signed_in=true&callback=initAutocomplete' async defer></script>
                                                </div>
                                                <label class="checkbox">
                                                	<input name="form[show_all_adresses]" <?=($user->show_all_adresses == 1) ? 'checked' : ''; ?> type="checkbox" class="show_all_adresses">
                                                    
                                                    <span class="lbl padding-8"></span>
                                                    <i>Показывать точный адрес для подтвержденных заказов</i>
                                                </label>
                                            </div>
                                            <div class="modal fade" id="showMap" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
                                                 <div class="modal-dialog" role="document">
                                                     <div class="modal-content">
                                                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                         <div class="modal-body">
                                                            <div id="map2"></div>

                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                        </div>  

                                        <div class="about-yourself-holder">
                                            <span>Опишите себя</span>
                                            <span class="business">Описание компании</span>
                                            <div class="about-yourself">
                                                <textarea id="textField" name="form[description]" class="form-control"><?=($user->description) ? $user->description : ''; ?></textarea>
                                                <i id="count">500</i><span> символов осталось</span><br>
                                                <input type="submit" class="btn main-btn save_info" value="Сохранить"><br>
                                                <span class="success-change">Изменения сохранены!</span>
                                                <span class="error-change">ОШИБКА: изменения не сохранены!</span>
                                            </div>
                                            <div class="about-yourself business">
                                                <textarea id="textFieldt_bus" name="form[description_comp]" class="form-control"><?=($user->description_comp) ? $user->description_comp : ''; ?></textarea>
                                                <i id="count_bus">500</i><span> символов осталось</span><br>
                                                <input type="submit" class="btn main-btn save_info" value="Сохранить"><br>
                                                <span class="success-change">Изменения сохранены!</span>
                                                <span class="error-change">ОШИБКА: изменения не сохранены!</span>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </form>
                                <?php if($user->password != ''){ ?>
                                <div class="change-email-holder">
                                    <div class="change-email">
                                        <h6>Изменить E-mail</h6>
                                        <form action="/myprofile/changeemail" id="changemail" method="post">
                                            <label>
                                                <strong>Ваш пароль</strong>
                                                <input name="password" type="password" required class="form-control">
                                                <b></b>
                                            </label>
                                            <label>
                                                <strong>Новый E-mail</strong>
                                                <input name="email" type="email" required class="form-control">
                                                <b></b>
                                            </label>
                                            <input type="submit" class="btn main-btn changeemail" value="Изменить E-mail">
                                            <span class="success-change">Изменения сохранены!</span>
                                            <span class="error-change">ОШИБКА: изменения не сохранены!</span>
                                        </form>
                                    </div>
                                </div>

                                <div class="change-password-holder change-email-holder">
                                    <div class="change-password change-email">
                                        <h6>Изменить пароль</h6>
                                        <form action="/myprofile/changepassword" id="changepassform" method="post">
                                            <label>
                                                <strong>Новый пароль</strong>
                                                <input name="pass" type="password" required class="form-control">
                                                <b></b>
                                            </label>
                                            <label>
                                                <strong>Повторите новый пароль</strong>
                                                <input name="passcheck" type="password" required class="form-control">
                                                <b></b>
                                            </label>
                                            <input type="submit" class="btn main-btn changepass" value="Изменить пароль">
                                            
                                            <span class="success-change">Изменения сохранены!</span>
                                            <span class="error-change">ОШИБКА: изменения не сохранены!</span>
                                        </form>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    
    //Вставка карты на событие shown.bs.tab
    // $('a[href="#tab4"]').on('shown.bs.tab', function (e) {
    	// console.log(e);
        // if($(this).data('loaded') !== 'true'){
// //                var lat = $(this).data('lat');
// //                var long = $(this).data('long');
            // $('.location .map-holder').append("<script> function initAutocomplete() {var map = new google.maps.Map(document.getElementById('map'), {center: {lat: 49.994507, lng: 36.1457423}, zoom: 11, scrolwheel: false, mapTypeId: google.maps.MapTypeId.ROADMAP}); var input = document.getElementById('pac-input'); var searchBox = new google.maps.places.SearchBox(input); map.controls[google.maps.ControlPosition.TOP_LEFT].push(input); map.addListener('bounds_changed', function() {searchBox.setBounds(map.getBounds());}); var markers = []; searchBox.addListener('places_changed', function() {var places = searchBox.getPlaces(); if (places.length == 0) {return;} markers.forEach(function(marker) {marker.setMap(null);}); markers = []; var bounds = new google.maps.LatLngBounds(); places.forEach(function(place) {var icon = {url: place.icon, size: new google.maps.Size(71, 71), origin: new google.maps.Point(0, 0), anchor: new google.maps.Point(17, 34), scaledSize: new google.maps.Size(25, 25)}; markers.push(new google.maps.Marker({map: map, icon: icon, title: place.name, position: place.geometry.location})); $('.mlat').val(map.center.lat()); $('.mlong').val(map.center.lng()); $('#viewasuser').attr('data-lat', map.center.lat()); $('#viewasuser').attr('data-long', map.center.lng()); console.log(map.center.lat(), map.center.lng()); if (place.geometry.viewport) {bounds.union(place.geometry.viewport);} else {bounds.extend(place.geometry.location);}}); map.fitBounds(bounds);});} <\/script>      <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCpz0h1gSI6h2qsxrq6wsgVgDcemQzyEWU&libraries=places&callback=initAutocomplete' async defer><\/script>");
        // }
        // $(this).data('loaded', 'true');
	// });
	
//    $('.ordered-product .deactivate').click( function () {
//        $(this).css('display', 'none');
//        $('.ordered-product .activate').css('display', 'inline-block');
//    }); 
//    $('.ordered-product .activate').click( function () {
//        $(this).css('display', 'none');
//        $('.ordered-product .deactivate').css('display', 'inline-block');
//    });
    
</script>


<!-- <a href="/myprofile/favorite">Избранное</a><br>
<a href="/lot/selectcategory">Подать объявление</a><br>
<a href="/myprofile/messages">Сообщения (<?=$new; ?>)</a><br>


<?php
if(count($user->reviewsToUser)){ ?>
    <p>Все отзывы на данного пользователя</p>
    <?php foreach($user->reviewsToUser as $review){ ?>
    Дата отзыва: <p><?=date('Y/m/d H:i:s',$review->time); ?></p>
    Текс отзыва: <p><?=$review->text; ?></p>
    <p><?=$review->id_lot ? "Отзыв на лот: ".Lot::outputTitle($review->id_lot) : "Отзыв от пользователя: ".User::outputEmail($review->id_reviewer); ?></p>  
    <hr>
    <?php
    }
}

if(count($user->reviews)){ ?>
    <p>Все отзывы от данного пользователя</p>
    <?php foreach($user->reviews as $rev){ ?>
    Дата отзыва: <p><?=date('Y/m/d H:i:s',$rev->time); ?></p>
    Текс отзыва: <p><?=$rev->text; ?></p>
    <p><?=$rev->id_lot ? "Отзыв на лот: ".Lot::outputTitle($rev->id_lot) : "Отзыв на пользователя: ".User::outputEmail($rev->id_user); ?></p>  
    <hr>
    <?php
    }
} ?> -->
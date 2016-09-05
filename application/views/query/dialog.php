<div id="dialog-open"><?php $from = App::gi()->user; //debug($lot->messages);?>
    <script>

        // Hide dialog
        $(document).on('click', '.back-to-messages', function(){
        	
        	$.ajax({
                url: '/myprofile/refreshmessages/',
                dataType: "html",
                success: function (data) {
	              $('#main-private-office').html(data);
            	  $('.selectpicker').selectpicker();
            	  $('.lnk3').click();
                } 
           });
            
        /*   $('#dialog-open').hide();
           $('.table-my-messages .table-section').show();*/
        });

    </script>

    <div class="dialog-content">
        <div class="header-row">
            <a href="#" class="back-to-messages">Назад к сообщениям</a>
            <?php if(!isset($messagesToAuthor)){ ?>
            <span>Поместить в архив <a href="/myprofile/toarchive/<?= $lot->id; ?>/<?= $lot->user->id; ?>" class="del"></a></span>
            <?php } ?>
        </div>
        <div class="body-dialog clearfix">
        	<?php if(isset($messagesToAuthor)){ ?>
        		<div class="row-holder clearfix">
	                
		                <?php 
			                if (count($messagesToAuthor)) {
								
			                    foreach ($messagesToAuthor as $key=>$message) {
			                    	if($message){ $id_from = $message->id_from;?>
							            <div class="message-row <?= ($from->id == $id_from) ? 'author' : 'user'; ?>-message <?= $message->booked != Message::NOT_BOOKED ? 'request' : ''; ?>">
		
					                        <div class="message-row ">
					                        	
					                            <div class="name-and-date clearfix">
					                            	<div class="author-name"><?= ($owner->id == $id_from) ? $ownername : $username; ?></div>
					                                <div class="date"><?= echoRussianDate($message->time); ?></div>
					                            </div>
					
				                                <div class="text-block clearfix">
				                                    <div class="request-text">
				                                        <span><?= $message->text; ?></span>
				                                        <?php //debug($message); ?>
				                                        <?php if($message->file){?>
				                                        	<span><a target="_blank" href="<?= '/uploads/messages/' .$id_from. '/'.$message->file; ?>">Скачать</a></span>
				                                        <?php } ?>
				                                    </div>
				                                </div>
					                            
					                        </div>
				                        </div>
			                      <?php }
			                   } ?>
									
							<?php } ?>
            	</div>
            	<div class="write-answer">
	                <form action="/myprofile/dialogmessageanswer" method="POST" class="send_to_user" enctype="myltipart/form-data">
	                    <textarea class="form-control" name="dialog[text]" placeholder="Ваше сообщение"></textarea>
	                    <div class="send-holder">
	                        <div class="add-file">
	                            <div class="input-holder">
	                                <input name="userfile" type="file">
	                                <p data-name=''>Прикрепить файл</p>
	                            </div>
	                            <p>Типы файлов, которые принимаются: jpg, jpeg, png, doc, pdf, gif, zip, rar, tar, html, swf, txt, xls, `docx, xlsx, odt</p>
	                        </div>
                        	<input type="hidden" name="dialog[filename]" class="filename" value="" />
	                        <input type="hidden" name="dialog[user]" class="user_id" value="<?=$user->id;?>" />
	                        <input type="submit" value="Отправить сообщение" class="btn main-btn ">
	                    </div>
	                </form>
	            </div>
        	<?php }else{?>
        	 <div class="row-holder clearfix">
                <div class="message-row title-message <?=($from->id==$lot->id_user)?'author':'user'?>-message">
                    <div class="name-and-date clearfix">
                        <div class="author-name"><?= $lot->owner->name . ' ' . $lot->owner->surname; ?></div>
                        <div class="date"><?= echoRussianDate($lot->time); ?></div>
                    </div>
                    <div class="text-block">
                        <div class="img-holder" style="background-image: url(<?= $lot->mainImage ? Lot::UPLOAD_DIR . $lot->url . '/' . $lot->mainImage : '/assets/images/no-img.png'; ?>)"></div>
                        <div class="description">
                            <strong><?= $lot->title; ?></strong>
	                        <a href="/lot/view/<?= $lot->url; ?>" class="showing">Просмотр</a>
	                        
	                        <?php if ($from->id==$lot->id_user) { ?>
	                        <?php if(isset($lot->messages[0])){?>
	                            <a href="/lot/edit/<?= $lot->url; ?>" class="edit">Редактировать</a>
                            <?php } ?>
                            <?php } ?>
                            <span>Номер объявления: <i><?= $lot->id; ?></i></span>
                        </div>
                        <?php if(isset($lot->messages[0])&&$from->id==$lot->id_user){?>
                        <a href="/myprofile/orderscalendar/<?=$lot->url; ?>" class="calendar"></a>
                        <?php } ?>
                    </div>
                    <span class="viewed">Прочитано</span>
                </div>
                
                <?php 
                if (count($lot->messages)) {

                	$counter = 0;
                    foreach ($lot->messages as $key=>$message) { ?>
                        <div class="message-row <?=($from->id==$message->id_from)?'author':'user'?>-message <?= $message->booked != Message::NOT_BOOKED ? 'request' : ''; ?>">
                            <div class="name-and-date clearfix">
                            	<?php //$name = (!$lot->owner->name)?
                            	
                            	?>
                                <div class="author-name"><?=$lot->owner->id == $message->id_from ? $lot->owner->name . ' ' . $lot->owner->surname : $lot->username; ?><!--<?= $lot->owner->id == $message->id_from ? $lot->owner->name . ' ' . $lot->owner->surname : $lot->user->name . ' ' . $lot->user->surname; ?>--></div>
                                <div class="date"><?= echoRussianDate($message->time); ?></div>
                            </div>

                            <?php
							 if ($message->booked != Message::NOT_BOOKED) { ?>
                                <div class="text-block clearfix">
                                    <div class="request-text">
                                        <span><?= $message->text; ?></span>
                                        <?php if($message->file){?>
	                                    	<span><a target="_blank" href="/uploads/messages/<?=$lot->user->id.'/'.$message->file?>">Скачать</a></span>
	                                    <?php } ?>
                                        <p><?=$lot->owner->id != $message->id_from ? $text[$counter++]->text:''; ?></p>

                                    </div>
                                    <?php if ($from->id != $message->id_from) { ?>
                                    <div class="buttons-box">
                                        <?php if ($message->bookingConfirmed == Constants::WAIT_STATUS) { ?>
                                            <a href="/query/bookingconfirm/<?= $message->booked; ?>"  data-user="<?=$message->id_from; ?>" data-lot="<?=$lot->id; ?>" data-booking-id="<?= $message->booked; ?>" class="btn main-btn resolve_message">Подтвердить</a>
                                            <?php
                                        }
                                        if ($message->bookingConfirmed == Constants::CONFIRMED_STATUS or $message->bookingConfirmed == Constants::WAIT_STATUS) {
                                            ?>
                                            <a href="/query/bookingdenied/<?= $message->booked; ?>"  data-user="<?=$message->id_from; ?>" data-lot="<?=$lot->id; ?>" data-booking-id="<?= $message->booked; ?>" class="btn reject reject_message">Отклонить</a>
                                            <?php
                                        }
                                        if ($message->bookingConfirmed == Constants::DENIED_STATUS) {
                                            ?>
                                            <a href="#" class="btn reject">Отклонено</a>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                </div>
                            <?php } else { ?>
                                <div class="text-block">
                                    <span><?= $message->text; ?></span>
                                    
                                    <?php if($message->file){?>
                                    	<span><a target="_blank" href="/uploads/messages/<?=$lot->user->id.'/'.$message->file; ?>">Скачать</a></span>
                                    <?php } ?>
                                    <?php if ($from->id != $message->id_from) { ?>
                                        <a href="/query/complain/<?= $message->id_from; ?>" class="block-up">Заблокировать</a>
                                    <?php } ?>
                                </div>
                                <?php
                            }
                            ?>  
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            
            <div class="write-answer">
                <form action="/myprofile/dialogmessage" method="POST"  class="send_to_lot" enctype="myltipart/form-data">
                    <textarea class="form-control" name="dialog[text]" placeholder="Ваше сообщение"></textarea>
                    <div class="send-holder">
                        <div class="add-file">
                            <div class="input-holder">
                                <input name="userfile" type="file">
                                <p data-name=''>Прикрепить файл</p>
                            </div>
                            <p>Типы файлов, которые принимаются: jpg, jpeg, png, doc, pdf, gif, zip, rar, tar, html, swf, txt, xls, `docx, xlsx, odt</p>
                        </div>
   
                        <input type="hidden" name="dialog[filename]" class="filename" value="" />
                        <input type="hidden" name="dialog[user]" class="user_id" value="<?= $user_id; ?>" />
                        <input type="hidden" name="dialog[lot]" class="lot_id" value="<?= $lot->id; ?>" />
                        <input type="submit" value="Отправить сообщение" class="btn main-btn">
                    </div>
                </form>
            </div>
            <?php } ?>
        </div>
    </div>
</div>


Полученные сообщения:<br>
<?php
if(count($user->reciveMessages)){
    foreach($user->reciveMessages as $recive) {
        if(!in_array($recive->from.','.$recive->lot->title, $showedr)){ ?>
            Пользователь: <p><?=$recive->from; ?></p><br>
            Лот: <a href="/myprofile/messagestolot/<?=$recive->lot->url; ?>"><p><?=$recive->lot->title; ?></p></a><br>
            Дата: <p><?=echoRussianDate($recive->time); ?></p><br>
            <p><?=$recive->text; ?></p><br>
            
        <?php $showedr[] = $recive->from.','.$recive->lot->title;                
        } ?>
<?php }
}else{ echo 'Empty <br>'; } ?>
Отправленные сообщения:<br>
<?php
if(count($user->sentMessages)){
    foreach($user->sentMessages as $sent) { 
        if(!in_array($sent->to.','.$sent->lot->title, $showeds)){ ?>
            Пользователь: <p><?=$sent->to; ?></p><br>
            Лот: <a href="/myprofile/messagestolot/<?=$sent->lot->url; ?>"><p><?=$sent->lot->title; ?></p></a><br>
            Дата: <p><?=echoRussianDate($sent->time); ?></p><br>
            <p><?=$sent->text; ?></p><br>
        <?php $showeds[] = $sent->to.','.$sent->lot->title;        
        } ?>
<?php }
}else{ echo 'Сообщения отсутствуют <br>'; } ?>
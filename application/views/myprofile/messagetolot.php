<?=$user->name; ?><br>
<?=$lot->title; ?><br>
<?php
foreach($lot->messages as $message){ ?>
    <?=$message[0] == $user->name ? 'Ваше сообщение' : $message[0]; ?><br>
    <?=$message[1]->text; ?><br>
<?php 
} ?>
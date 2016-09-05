<?php
if(count($blog->comments)){ 
    foreach($blog->comments as $comment){ ?>
        <p><?=date('d M Y', $comment->time); ?></p>
        <p><?=$comment->text; ?></p>
        <a href="/cp/comment/status/<?=$comment->id; ?>">Опубликовать</a><br>
<?php }
}
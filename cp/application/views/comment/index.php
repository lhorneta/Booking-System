<?php
if(count($blog)){
    foreach($blog as $comment){ ?>
        <a href="/cp/comment/blog/<?=$comment->id; ?>"><?=$comment->title; ?></a><br>
<?php }
} ?>

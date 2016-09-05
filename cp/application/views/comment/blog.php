<div id="comments-blog">
    <?php
    if(count($blog)){ 
        foreach($blog as $key=>$comment){
            if(count($comment)){ ?>
                <div class="parent">
                    <div class="date"><?=$comment->dateadd; ?></div>
                    <div class="text"><?=$comment->text; ?></div>
                    <? if($comment->status == 0){?>
                        <a href="/cp/comment/status/<?=$comment->id; ?>" class="publish">Опубликовать</a>
                    <?}else{?>
                        <a href="/cp/comment/status/<?=$comment->id; ?>" class="block">Заблокировать</a>
                    <?}?>	
                </div>		
            <?php } ?>
            <?php 
            if(count($comment->parent) > 0 && is_array($comment->parent)){ 
                 foreach($comment->parent as $k=>$child){?>
                        <div class="child">
                            <div class="date"><?=$child->dateadd; ?></div>
                            <div class="text"><?=$child->text; ?></div>
                            <? if($child->status == 0){?>
                                <a href="/cp/comment/status/<?=$child->id; ?>" class="publish">Опубликовать</a>
                            <?}else{?>
                                <a href="/cp/comment/status/<?=$child->id; ?>" class="block">Заблокировать</a>
                            <?}?>	
                        </div>				
                    <?php 
                 }
            }
        }
    } ?>
</div>
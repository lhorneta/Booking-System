<script>
(function ($) {
$('div.rateit, span.rateit').rateit();
})(jQuery);
</script>
<?php if(count($lots)){ 
    foreach($lots as $lot){?>
	    <li>
	        <a href="/lot/view/<?=$lot->url; ?>">
	            <?php if(count($lot->images)){ ?>
	                <div class="lot-foto" style="background-image: url('<?=Lot::UPLOAD_DIR.$lot->url.'/'.$lot->images[0]; ?>')"></div>
	            <?php }else{ ?>
	                <div class="lot-foto" style="background-image: url('/assets/images/no-img.png')"></div>
	            <?php } if($lot->mark != 0){ ?>
	                <div class="evaluation">
	                    <div class="rateit" data-rateit-value="<?=$lot->rating;?>" data-rateit-starwidth="12" data-rateit-starheight="13"></div>
	                </div>
	                <?php }else{ ?>
	
	                    <div class="evaluation">
	                        <div class="rateit" data-rateit-value="<?=$lot->rating;?>" data-rateit-starwidth="12" data-rateit-starheight="13"></div>
	                    </div>
	                <?php } if($user = App::gi()->user){ ?>
	                    <!-- <span class="title"><?=($user->id == $lot->id_user) ? 'Your lot' : 'Not your\'s'; ?></span> -->
	                <?php } ?>
	                <span class="title"><?=$lot->title; ?></span>
	                <span class="descript"><?=$lot->description; ?>...</span>
	                <span class="price"><?=$lot->day_payment; ?> грн.</span>
	        </a>
	    </li>
    <?php 
    }
} ?>
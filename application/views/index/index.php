<?php
categoryOffCookie();
$region = getCookieLocation();

$selected_city = null;
$selected_region = null;

$regions = Region::models();
$cities = null;

if ($region) {
    if ($selected_city = City::model((int) $region['id_city'])) {
        $cities = City::modelsWhere('id_region = ?', array($selected_city->id_region));
        $selected_region = Region::modelWhere('id = ?', array($selected_city->id_region));
    } elseif ($selected_region = Region::model((int) $region['id_region'])) {
        $cities = City::modelsWhere('id_region = ?', array($selected_region->id));
    }
    //echo count($lots); 
}
?>  
<div class="main-page-holder">
    <div id="main">
        <h4>Последние обновления</h4>
        <ul class="goods-list">
            <?php if(count($lots)){
            	
                foreach($lots as $lot){
          ?>
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
<!--                                <span class="popular-row">
                                    Нет рейтинга
                                </span> -->
                                <div class="evaluation">
                                    <div class="rateit" data-rateit-value="<?=$lot->rating;?>" data-rateit-starwidth="12" data-rateit-starheight="13"></div>
                                </div>
                            <?php } if($user = App::gi()->user){ ?>
                                <!-- <span class="title"><?=($user->id == $lot->id_user) ? 'Your lot' : 'Not your\'s'; ?></span> -->
                            <?php } ?>
                            <span class="title"><?=$lot->title; ?></span>
                            <span class="descript"><?=$lot->description; ?>...</span>
                            <span class="price"><?=$lot->day_payment; ?> <?=$lot->currency; ?></span>
                    </a>
                </li>
                <?php 
                }
            } ?>
        </ul>
    <?php if($all > count($lots)){ ?>
        <a href="#" data-all='<?=$all?>' data-start='15' data-step='<?=Constants::INDEX_SHOW_LOTS_STEP;?>' class="show-all">Посмотреть все</a>
    <?php } ?>
</div>
</div>
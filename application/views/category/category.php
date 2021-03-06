<?php //debug($category->parent); ?>
    <div id="main-catalog">
        <div class="search-filter-holder">
            <div class="search-filter clearfix">
                <form class="filter_form" action="<?= $this->link('/category/'.$category->url); ?>" method="get" role="search" onkeypress="if(event.keyCode == 13) return false;">
                    <div class="top-section clearfix">
                        <div class="find-section regions_section">
                            <?php
                            $regionObjects = getRegionOjects();
                            $regions = array();
                            $cities = array();
                            $regions = Region::models();
                            if ($regionObjects['region']) {
                                $cities = City::modelsWhere('id_region = ?', array($regionObjects['region']->id));
                            }
                            ?>  
                            <label class="search-input-holder">
                                <input type="text" class="search-input form-control" name="q" value="<?=(isset($_REQUEST['q']))?$_REQUEST['q']:''?>">
                                <span class="clear-input">×</span>
                            </label>
                            <?php
                            $region = (isset($_GET['region']))?$_GET['region']:0;
                            $city = (isset($_GET['city']))?$_GET['city']:0;
							$city_name = byIds($region,$city);
                            ?>
                            <div id="select_region" class="btn-group bootstrap-select">
                            	<input type="text" class="btn dropdown-toggle btn-default" name="location" id="selecter" placeholder="Выберите город" value="<?=$city_name?>" />
                            	<input type="hidden" name="region" id="reg" value="<?=$region?>" />
                            	<input type="hidden" name="city" id="city" value="<?=$city?>" />
                            </div>
                            
                            <div class="regions">
                            	<div class="loads"><div></div></div>
                            	<div class="all_regions">
                            		<a href="#" class="all_u"><?=lang('all_regions')?></a>
                            		<a href="#" class="another_c"><span class="glyphicon glyphicon-chevron-left"></span> Изменить область</a>
                            		<a href="#" class="all_c">Искать по всей области »</a>
                            	</div>
                            	<div class="reg_list">
                            		<ul class="column">
                            		<?php $t=''; foreach ($regions as $k => $region) {
                            		$title = $region->outputTitle();
									$tt=mb_substr($title, 0,1);
									if ($tt!=$t) { $titl = "<b>".$tt."</b>".mb_substr($title, 1); } else { $titl = $title; }
									$t=$tt;
                            		?>
		                            	<li><a href="#" class="city_id" rel="<?=$region->id?>"><?=$titl?> <span class="glyphicon glyphicon-chevron-right pull-right"></span></a></li>
		                            	<?php if (($k+1)%7==0) { ?>
		                            	</ul><ul class="column">
		                            	<?php } ?>
		                            <?php } ?>
                            		</ul>
                            	</div>
                            	<div class="cities_list"></div>
                            </div>
                            
                            <!-- <select class="selectpicker" name="region" id="region" onchange="loadCities(this, 'select[name=city]')" onload="test()">
                                <option value="0"><?= lang('all_regions'); ?></option>
                                <?php foreach ($regions as $region) { ?>
                                    <option value="<?= $region->id; ?>"><?= $region->outputTitle(); ?></option>
                                <?php } ?>
                            </select>
                            <select name="city" id="city" class="" style="display:none">
                                <option value="0"><?= lang('all_cities'); ?></option>
                                <?php if (count($cities)): ?>
                                    <?php foreach ($cities as $city) : ?>
                                        <option <?= $regionObjects['city'] && $regionObjects['city']->id == $city->id ? 'selected' : ''; ?> value="<?= $city->id; ?>"><?= $city->outputTitle(); ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select> -->
                            <label class="checkbox in-title">
                                <input type="checkbox" name="title_desc" value="1" <?=(isset($_REQUEST['title_desc']))?'checked':''?>>
                                <span class="lbl padding-8"></span>
                                <i>Искать в заголовке и описании</i>
                            </label>
                            <label class="checkbox">
                                <input type="checkbox" name="photo" value="1" <?=(isset($_GET['photo'])&&$_GET['photo']=='1')?'checked="checked"':''?>>
                                <span class="lbl padding-8"></span>
                                <i>Только с фото</i>
                            </label>                            
                        </div>
                        
                        <div class="main-rubric">
                            <select class="selectpicker" onchange="loadCategory(this)">
                                <option value="0">Выберите рубрику</option>
                                <?php foreach ($copy->mainParents as $mainParent) { $s='';
                                if ($mainParent->selected) {
                                	$s = 'selected';
									$cat = $mainParent->url;
                                }
                                ?>
                                <option value="<?= $mainParent->url; ?>" <?= ($mainParent->selected) ? 'selected' : ''; ?>><?= $mainParent->title; ?></option>
                                <?php } ?>                                    
                            </select>
                        </div>
                        <label class="checkbox in-title checkbox_sm">
                            <input type="checkbox" name="title_desc" value="1" <?=(isset($_REQUEST['title_desc']))?'checked':''?>>
                            <span class="lbl padding-8"></span>
                            <i>Искать в заголовке и описании</i>
                        </label>
                        <label class="checkbox checkbox_sm">
                            <input type="checkbox" name="photo" value="1" <?=(isset($_GET['photo'])&&$_GET['photo']=='1')?'checked="checked"':''?>>
                            <span class="lbl padding-8"></span>
                            <i>Только с фото</i>
                        </label>
                    </div>
                    
                    <?php
                    if (count($copy->childs)) {
                    	$parent = $copy->parents[0]->id_parent;
						$sel = $copy->parents[0]->id;
						$copy->parents = Category::modelsWhere('id_parent = ?', array($copy->parents[0]->id_parent));
						foreach ($copy->parents as $key => $p) {
							if ($p->id==$sel) {
		                    	$copy->parents[$key]->selected = 1;
		                	}
						}
                    }
                    
                    ?>
                    
                    <div class="middle-section">
                        <div class="row1 clearfix">
                            <div class="item subcategorys">
                                <div class="first-subcategory">
                                    <span>Выберите рубрику</span>
                                    <select class="selectpicker" onchange="loadCategory(this)">
                                        <option value="<?=$cat?>">Выберите рубрику</option>
                                        <?php foreach ($copy->parents as $parent) { $s='';
                                        if ($parent->selected) {
		                                	$s = 'selected';
											$cat = $parent->url;
		                                }
                                        ?>
                                            <option value="<?= $parent->url; ?>" <?= ($parent->selected) ? 'selected' : ''; ?>><?= $parent->title; ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                                <div class="second-subcategory">
                                    <?php if (count($copy->childs)) { ?>
                                        <select class="selectpicker" onchange="loadCategory(this)">
                                            <option value="<?=$cat?>">Выберите рубрику</option>
                                            <?php foreach ($copy->childs as $child) { ?>
                                                <option value="<?= $child->url; ?>" <?= ($child->selected) ? 'selected' : ''; ?>><?= $child->title; ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>
                                </div>
                            </div> 
                            <div class="item price-filters">
                                <div data-filtertype="price">
                                	<label class="search-input-holder">
                                        <input type="number" name="from"  class="search-input form-control from" placeholder="Цена от грн./сутки" value="<?=(isset($_REQUEST['from']))?$_REQUEST['from']:''?>"> 
                                        <span class="clear-input">×</span>
                                    </label>
                                    <label class="search-input-holder">
                                        <input type="number" name="to" class="search-input form-control to" placeholder="Цена до грн./сутки" value="<?=(isset($_REQUEST['to']))?$_REQUEST['to']:''?>">
                                        <span class="clear-input">×</span>
                                    </label> 
                                </div>
                                <!-- <div data-filtertype="square" style="margin-top: 5px;">
                                	<label class="search-input-holder">
                                    <input type="text" name="from" class="search-input form-control from" placeholder="Площадь от грн./сутки" value="<?=(isset($_REQUEST['q']))?$_REQUEST['q']:''?>"> 
                                    <input type="text" name="to" class="search-input form-control to" placeholder="Площадь до грн./сутки" value="<?=(isset($_REQUEST['q']))?$_REQUEST['q']:''?>">
                                    </label> 
                                </div> -->
                                <input type="hidden" name="price-period" value="day">
                            </div>
                            <?php $type = (isset($_REQUEST['type']))?$_REQUEST['type']:0; ?>
                            <div class="item buttons-holder lot_type">
                                <a class="<?=($type==0)?'act':''?>" href="#" rel="0">Все</a>
                                <a class="<?=($type==1)?'act':''?>" href="#" rel="1">Частные</a>
                                <a class="<?=($type==2)?'act':''?>" href="#" rel="2">Бизнес</a>
                                <input type="hidden" name="type" value="<?=$type?>">
                            </div>
                        </div>
                        <div class="row2 clearfix">
                            <div class="buttons-box">
                                <a href="#" class="clean" id="cleanBtn">Очистить</a>
                                <button type="submit" class="find" id="filter_submit">Найти</button>
                            </div>
                            <?php if (isset($category->staticAttributeGroup)) {
                                if (count($category->staticAttributeGroup)) {
                                    ?>
                                    <button type="button" class="btn add-filters">Дополнительные фильтры</button>
                                    
                                    <div class="buttons-box selected_filters">
                                    <?php foreach ($category->staticAttributeGroup as $group) { ?>
                                    <?php foreach ($group->staticValues as $staticValue) { ?>
                                    <?=(isset($_GET[$group->url])&&$_GET[$group->url]==$staticValue->url)?'<button type="button" title="'.$group->title.'" class="btn reset" id="reset-select_'.$group->id.'">'.$staticValue->value.'<span class="clear-filter " title="Удалить">×</span></button>':''?>
                                    <?php } ?>
                                    <?php } ?>
                                    </div> 
                                    
                                <?php }
                            }
                            ?>
                        </div>
                    </div>
                    
            </div>
            
            
        </div>
        
        
        	<div class="add-filters-section-holder">
	            <div class="add-filters-section">
	                <?php foreach ($category->staticAttributeGroup as $group) { ?>
	                    <div class="filter">
	                        <select name="<?=$group->url; ?>" class="selectpicker reset-select_<?=$group->id?>">
	                            <option disabled <?=(!isset($_GET[$group->url]))?'selected':''?>><?=$group->title; ?></option>
	                            <?php foreach ($group->staticValues as $staticValue) { ?>
	                                <option <?=(isset($_GET[$group->url])&&$_GET[$group->url]==$staticValue->url)?'selected':''?> value="<?=$staticValue->url; ?>"><?= $staticValue->value; ?></option>
	                            <?php } ?>
	                        </select>
	                    </div>
	                <?php } ?>
	            </div>
	        </div>
	        </form><!-- </form> -->
                <div class="breadcrumbs-holder">
                    <div class="breadcrumbs-block">
                        <ul class="breadcrumb">
                            <?php if (isset($category->parent->parent)) { ?>
                            <li><a href="/category/<?=$category->parent->parent->url?>"><?=$category->parent->parent->title?></a></li>
                            <?php } ?>
                            <?php if (isset($category->parent)) { ?>
                            <li><a href="/category/<?=$category->parent->url?>"><?=$category->parent->title?></a></li>
                            <?php } ?>
                            <li class="active"><?=$category->title?></li>
                        </ul>
                    </div>
                </div>

                <?php if(count($category->lots)){ ?>

                <div class="search-results">	

                    <div class="top-section clearfix">
                        <h4>Результат поиска</h4>
                        <div class="result-nav">
                            <div class="switches">
                                <span>Вид списка:</span>
                                <button type="button" class="colums"></button>
                                <button type="button" class="rows active"></button>
                            </div>
                            <select class="selectpicker bs-select-hidden search-select" required="">
		                        <option <?=((isset($_GET['sort']) && $_GET['sort'] =='new_search') || !isset($_GET['sort']))?'selected="selected"':'';?> value="new_search">Самые новые</option>
		                        <option <?=(isset($_GET['sort']) && $_GET['sort'] =='expensive_search')?'selected="selected"':'';?> value="expensive_search">Самые дорогие</option>
		                        <!-- <option value="another_search">Еще какие-то</option> -->
		                    </select>
                        </div>
                    </div>
                    <?php foreach($category->lots as $categoryTitle=>$categoryLots){ ?>
                        <!-- <div class="info-title">Все лоты в категории <?=$categoryTitle; ?></div>  -->   
                        <div class="products-holder">
                        <?php 
                        if(count($categoryLots)){
                //            debug($lot); die();
                            foreach($categoryLots as $lot){
                            	$lot->takeImages();
                            	$lot->countReviews();
								$cat = Category::modelWhere('id = ?', array($lot->id_category));
                            	$cat->checkOnParentsAndTakeIt(); ?>
                                    <div class="product">
                                        <?php if(count($lot->images)){ ?>
                                            <div class="img-holder" style="background-image: url(<?=Lot::UPLOAD_DIR.$lot->url.'/'.$lot->images[0]; ?>)"><a href="/lot/view/<?=$lot->url; ?>"></a></div>
                                        <?php }else{ ?>
                                            <div class="img-holder" style="background-image: url(/assets/images/no-img.png)"><a href="/lot/view/<?=$lot->url; ?>"></a></div>
                                        <?php } ?>
                                        <div class="evaluation-col-view">
                                        	
                                            <?php if($lot->rating != 0){ ?>
                                                Рейтинг
                                                <div class="rateit" data-rateit-value="<?=$lot->rating; ?>" data-rateit-starwidth="12" data-rateit-starheight="13"></div>                                        
                                                <?php }else{ ?>
                                                    <span class="popular-row"> 
                                                        <div class="rateit" data-rateit-value="0" data-rateit-starwidth="12" data-rateit-starheight="13"></div>
                                                    </span>                                    
                                                <?php } ?>
                                        </div>
                                        <div class="description">
                                            <div class="title">
                                                <a href="/lot/view/<?=$lot->url; ?>"><?=$lot->title; ?></a>
                                                <ul class="category">
                                                	<?php if (isset($cat->parent->parent)) { ?>
                                                    <li><a href="<?=$cat->parent->parent->url?>"><?=$cat->parent->parent->title?></a><i>&raquo;</i></li>
                                                    <?php } ?>
                                                    <?php if (isset($cat->parent)) { ?>
                                                    <li><a href="<?=$cat->parent->url?>"><?=$cat->parent->title?></a><i>&raquo;</i></li>
                                                    <?php } ?>
                                                    <li><a href="<?=$cat->url?>"><?=$cat->title?></a><i>&raquo;</i></li>
                                                    
                                                    
                                                    
                                                    
                                                </ul>
                                            </div>
                                            
                                            <?php
                                            $loc = 'Город не указан';
	                                        $reg = Region::modelWhere('id=?', array($lot->id_region));
											$city = City::modelWhere('id=?', array($lot->id_city));
											if ($reg) {
												$loc = $reg->title_ru;
											}
											if ($city) {
												$loc .= ', '.$city->title_ru;
											}
	                                        if ($loc=='Город не указан'&&$lot->address) {
	                                           	$loc = $lot->address;
	                                        }
											//echo $loc;
                                            ?>
                                            
                                            <div class="place-time">
                                                <div class="place"><?=$loc?></div>
                                                <div class="time"><?=echoRussianDate($lot->time)?></div>
                                            </div>
                                            <div class="price-box-col-view">от <span><?=$lot->day_payment; ?></span> / сутки</div>
                                        </div>
                                        <div class="price-holder">
                                            <div class="evaluation">
                                                <?php if($lot->rating != 0){ ?>
                                                        <div class="rateit" data-rateit-value="<?=$lot->rating; ?>" data-rateit-starwidth="12" data-rateit-starheight="13"></div>
                                                <?php }else{ ?>
                                                        <div class="rateit" data-rateit-value="0" data-rateit-starwidth="12" data-rateit-starheight="13"></div>
                                                <?php } ?>
                                                <a href="/lot/view/<?=$lot->url?>"><?=$lot->reviewsCount?> отзыв(ов)</a>
                                            </div>
                                            <div class="price">
                                                <strong><?=$lot->day_payment; ?> грн.</strong> 
                       
                                                <span>Цена за сутки</span>
                                                <?php if($lot->week_payment or $lot->month_payment){ ?>
                                                <div class="other-price">
                                                    <span><?=$lot->week_payment; ?> / <i>Цена за неделю</i></span>
                                                    <span><?=$lot->month_payment; ?> / <i>Цена за месяц</i></span>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                <!--                <a href="/myprofile/tofavorite/<?=$lot->url; ?>">Добавить лот в избранное</a>
                                <form action="/myprofile/addreview" method="POST">
                                    <textarea name="review[text]"></textarea><br>
                                    <input type="hidden" name="review[id_lot]" value="<?=$lot->id; ?>" />
                                    <input type="submit" value="Добавить отзыв на лот" />
                                </form>
                                <form action="/myprofile/addreview" method="POST">
                                    <textarea name="review[text]"></textarea><br>
                                    <input type="hidden" name="review[id_user]" value="<?=$lot->id_user; ?>" />
                                    <input type="submit" value="Добавить отзыв на пользователя" />
                                </form>
                                <hr>-->
                        <?php
                            }
                        }else{ ?>
                            </div>
                            <h5>В данной категории пока что нет лотов</h5>
                        <?php
                        }
                    }
                ?>
                </div>
        <?php }else{ ?>  
            <h5>Поиск не дал результатов</h5>
        <?php } ?>
    </div>
    <script>
    
    	$(document).on('click', '.reset', function(){
    		var $this = $(this);
            $('select.'+$this.attr('id')).val('');
            $this.hide(10);
    		
    		
    	});
    
       
    </script>



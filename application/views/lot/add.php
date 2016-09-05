<div id="main-edit-ad">
    <div class="title-section-holder">
        <div class="main-title">Создать объявление</div>
    </div>
    <input type='hidden' class='lot_id' value="0">
    <form method="post" enctype="multipart/form-data" class="main-ad-form">
        <div class="edit-ad-content">
            <div class="top-section-holder">
                <div class="top-section">
                    <label>
                        <strong>Заголовок<i>*</i></strong>
                        <input name="form[title]" type="text" id="inputField" required class="form-control required" placeholder="Заголовок">
                        <b></b>
                    </label>
                    <div class="count-holder">
                        <i id="count">70</i><span> символов осталось</span><br>
                    </div>
                    
                    <input type="hidden" id="id_category" class="required" name="form[id_category]" required>
                    <div class="rubric">
                        <strong>Рубрика<i>*</i></strong>
                        <ul class="rubric-nav">
                            <li>
                            	
                                <a href="#" class="edit-choice-rubric" data-toggle="dropdown">Выберите категорию <span class="caret"></span></a>
                                
                                <div class="choice-rubric-menu parentcats">
                                    <div class="header-nav-holder">
                                        <div id="header-nav" class="navbar navbar-default">
                                            <ul id="nav" class="nav navbar-nav">
                                            	<?php $i=1; foreach ($category as $key => $cat) { ?>
                                                <li class="select_cat">
                                                    <a href="javascript: void(0)" class="lnk-categ lnk-<?=$i?>" id="<?=$cat->id?>"><i><?=$cat->title?></i></a>
                                                </li>
                                                <?php $i++; } ?>
                                            </ul>
                                            <ul class="subcategory-list"></ul>
                                        </div>
                                    </div>
                                    <div class="overlay"></div>
                                </div>
                            </li>
                            
                            <li class="subcats_list" style="display:none">
                            	
                                <a href="#" class="edit-choice-rubric sub" data-toggle="dropdown"> Подкатегория... <span class="caret"></span></a>
                                
                                <div class="choice-rubric-menu childcats">
                                    <div class="header-nav-holder">
                                        <div id="header-suvnav" class="navbar navbar-default">
                                            <ul id="subnav" class="nav navbar-nav grand_childs_cats">
                                            	<?php $i=1; foreach ($category as $k => $cat) {  ?>
                                                <li class="selectsub_cat">
                                                    <a href="javascript: void(0)" class="lnk-categ lnk-<?=$i?>" id="<?=$cat->id?>"><i><?=$cat->title?></i></a>
                                                </li>
                                                <?php $i++; } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="overlay"></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- <label class="subcats_list" style="display:none">
                        <strong>Выберите подрубрику<i>*</i></strong>
                        <select class="grand_childs_cats"></select>
                        <b></b>
                    </label> -->
                   
                </div>
            </div>
            <div class="prices-and-characteristics">
            	
            	
            	<div class="characteristics" style="margin-bottom: 20px;">
                   
                </div>
            	
            	
                <div class="prices-block">
                    <strong>Цена<i>*</i></strong>
                    <div class="form-holder">
                    	<input name="form[currency]" class="currency_inp" type="hidden" value="грн.">
                        <label>
                            <span>День</span>
                            <input name="form[day_payment]" type="number" required class="form-control required">
                            <b></b>
                            <select class="selectpicker">
                                <option>грн.</option>
                                <option>$</option>
                                <option>&euro;</option>
                            </select>
                        </label>
                        <label>
                            <span>Неделя</span>
                            <input name="form[week_payment]" type="number" class="form-control">
                            <select class="selectpicker">
                                <option>грн.</option>
                                <option>$</option>
                                <option>&euro;</option>
                            </select>
                            <b></b>
                        </label>
                        <label>
                            <span>Месяц</span>
                            <input name="form[month_payment]" type="number" class="form-control">
                            <select class="selectpicker">
                                <option>грн.</option>
                                <option>$</option>
                                <option>&euro;</option>
                            </select>
                            <b></b>
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" class="sp_checkbox">
                            <span class="lbl padding-8"></span>
                            <i>Особые условия</i>
                        </label>
                        <textarea name="form[special_provisio]" class="form-control special_conditions"></textarea>
                    </div>
                </div>
                
            </div>
            <div class="more-information-holder">
                <div class="more-information">
                    <div id="deposit" class="block block-select">
                        <strong>Залог<i>*</i></strong>
                        <select name="form[deposit]" class="selectpicker deposit">
                            <option value="document">Документ</option>
                            <option value="money">Деньги</option>
                        </select>
                        <div class="money-interval">
                            <strong>Сумма<i>*</i></strong>
                            <input type="number" class="form-control pledge">
                            <input type="hidden" name="form[deposit]" class="deposit">
                            <div class="select-holder">
                                <select class="currency-select currency">
                                    <option value="grn">грн.</option>
                                    <option value="dol">$</option>
                                    <option value="euro">&euro;</option>
                                </select>
                            </div>
                       	</div>
                    </div>
                    <div class="block block-input required">
                        <strong>Состояние<i>*</i></strong>
                        <label>
                            <input type="text" name="form[condition_title]" required class="form-control required">
                            <b></b>
                        </label>
                    </div>
                    <div class="block block-select user_type required">
                        <strong>Частное лицо/Бизнес<i>*</i></strong>
                        <input type="hidden" name="form[type]" class="itype-user">
                        <select name="form[type]" class="selectpicker business_private">
                            <option value="0">Бизнес </option>
                            <option value="1">Частное лицо</option>
                        </select>
                    </div>
                    <div class="block block-textarea des_for_lot required">
                        <strong>Описание<i>*</i></strong>
                        <div class="descr_holder">
                            <textarea name="form[description]" type="text" id="textareaField" required class="form-control required" placeholder="Описание лота"></textarea>
                            <b></b>
                            <div class="count-holder">
                                <i id="count2">4000</i><span> символов осталось</span><br>
                            </div>
                        </div>
                    </div>
                    <div class="block block-textarea rental-сonditions">
                        <strong>Условия проката</strong>
                        <textarea name="form[rental_terms]" type="text" class="form-control" placeholder="Описание условий проката"></textarea>
                        <b></b>
                        <span>386 симоволов осталось</span>
                    </div>
                </div>
            </div>
            <div class="download-images-holder">
                <div class="download-images">
                    <div class="description-text">
                        <strong>Фотографии</strong>
                        <p>Объявления с фото получают в среднем в 3-5 раз больше откликов</p>
                    </div>

                    <?php //debug($lot); ?>

                    <div class="marker">Главная фотография</div>
                    <div class="download-images-list">
                        <input type="hidden" name="lot-url" class="lot-url" value="" />
                        <input type="hidden" class="progress-img-class" value=''>
                        <div class="addpost-image-block"> 
                            <div class="addpost-upload-image">
                                <img src="" width='118' height='99' class="img0" alt="">
                                <span class="glyphicon glyphicon-remove delete_img" id="img0" rel=""></span>
                                <div class="loading img0">
                                    <div class="percent"></div>
                                </div>
                                <input type="hidden" name="form[img0]" class="img0" value="" />
                                <input type="file" name="img0" class="inp0" accept="image/*" />
                            </div>
                        </div>
                        <div class="addpost-image-block">
                            <div class="addpost-upload-image">
                                <img src="" width='118' height='99' class="img1" alt="">
                                <span class="glyphicon glyphicon-remove delete_img" id="img1" rel=""></span>
                                <div class="loading img1">
                                    <div class="percent"></div>
                                </div>
                                <input type="hidden" name="form[img1]" class="img1" value="" />
                                <input type="file" name="img1" class="inp1" accept="image/*" />
                            </div>
                        </div>
                        <div class="addpost-image-block">
                            <div class="addpost-upload-image">
                                <img src="" width='118' height='99' class="img2" alt="">
                                <span class="glyphicon glyphicon-remove delete_img" id="img2" rel=""></span>
                                <div class="loading img2">
                                    <div class="percent"></div>
                                </div>
                                <input type="hidden" name="form[img2]" class="img2" value="" />
                                <input type="file" name="img2" class="inp2" accept="image/*" />
                            </div>
                        </div>
                        <div class="addpost-image-block">
                            <div class="addpost-upload-image">
                                <img src="" class="img3" width='118' height='99' alt="">
                                <span class="glyphicon glyphicon-remove delete_img" id="img3" rel=""></span>
                                <div class="loading img3">
                                    <div class="percent"></div>
                                </div>
                                <input type="hidden" name="form[img3]" class="img3" value="" />
                                <input type="file" name="img3" class="inp3 " accept="image/*" />
                            </div>
                        </div>
                        <div class="addpost-image-block">
                            <div class="addpost-upload-image">
                                <img src="" class="img4" width='118' height='99' alt="">
                                <span class="glyphicon glyphicon-remove delete_img" id="img4" rel=""></span>
                                <div class="loading img4">
                                    <div class="percent"></div>
                                </div>
                                <input type="hidden" name="form[img4]" class="img4" value="" />
                                <input type="file" name="img4" class="inp4 img4" accept="image/*" />
                            </div>
                        </div>
                        <div class="addpost-image-block">
                            <div class="addpost-upload-image">
                                <img src="" class="img5"  width='118' height='99' alt="">
                                <span class="glyphicon glyphicon-remove delete_img" id="img5" rel=""></span>
                                <div class="loading img5">
                                    <div class="percent"></div>
                                </div>
                                <input type="hidden" name="form[img5]" class="img5" value="" />
                                <input type="file" name="img5" class="inp5" accept="image/*" />
                            </div>
                        </div>
                        <div class="addpost-image-block">
                            <div class="addpost-upload-image">
                                <img src="" class="img6"  width='118' height='99' alt="">
                                <span class="glyphicon glyphicon-remove delete_img" id="img6" rel=""></span>
                                <div class="loading img6">
                                    <div class="percent"></div>
                                </div>
                                <input type="hidden" name="form[img6]" class="img6" value="" />
                                <input type="file" class="inp6" name="img6" accept="image/*" />
                            </div>
                        </div>
                        <div class="addpost-image-block">
                            <div class="addpost-upload-image">
                                <img src="" class="img7" width='118' height='99' alt="">
                                <span class="glyphicon glyphicon-remove delete_img" id="img7" rel=""></span>
                                <div class="loading img7">
                                    <div class="percent"></div>
                                </div>
                                <input type="hidden" name="form[img7]" class="img7" value="" />
                                <input type="file" class="inp7" name="img7" accept="image/*" />
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
                            <a href="#" onclick="return false" class="show-location" data-lat="" data-long="" data-toggle="modal" data-target="#mapForUsers">Посмотреть что будут видеть другие пользователи.</a>
                            <div class="map-holder">
                                <div class="marker">Мы будем скрывать Ваш точный адрес</div>
                                <input id="pac-input" name="form[address]" value="<?=($user->position)?$user->position->address:'Харьков, Харьковская область, Украина'?>" class="controls" type="text" placeholder="Ваше местоположение">
                                                    
                                    <input name="form[latitude]" value="<?=($user->position)?$user->position->latitude:'49.9935'?>" class="mlat" type="hidden">
                                    <input name="form[longitude]" value="<?=($user->position)?$user->position->longitude:'36.230383'?>" class="mlong" type="hidden">
                                    
                                    <div id="map"></div>
                                    
                                    <script> function initAutocomplete() {
                                    	var map = new google.maps.Map(document.getElementById('map'),
                                    {
                                    	center: {lat: <?=($user->position)?$user->position->latitude:'49.9935'?>,
                                                 lng: <?=($user->position)?$user->position->longitude:'36.230383'?>},
                                    	zoom: 13,
                                    	scrolwheel: false,
                                    	mapTypeId: google.maps.MapTypeId.ROADMAP
                                    });
                                    var marker = new google.maps.Marker({
                                        position: {lat: <?=($user->position)?$user->position->latitude:'49.9935'?>,
                                                 lng: <?=($user->position)?$user->position->longitude:'36.230383'?>},
                                        map: map,
                                    });
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
                             		
                             		//<div id=\"map2\"></div>
                             		
                             		</script>      
                                    <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCpz0h1gSI6h2qsxrq6wsgVgDcemQzyEWU&libraries=places&signed_in=true&callback=initAutocomplete' async defer></script>

                                
                                <div class="marker2">Мы будем скрывать Ваш точный адрес</div>
                            </div>
                            <label class="checkbox">
                                <input name="form[show_address]" <?=($user->show_all_adresses == 1) ? 'checked' : ''; ?> type="checkbox" class="show_address">
                                <span class="lbl padding-8"></span>
                                <i>Показывать точный адрес для подтвержденных заказов</i>
                            </label>
                        </div>

                        <div class="modal fade" id="mapForUsers" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <div class="modal-body">
                                        <div id="map2"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-info">
                        <label class="private-person">
                            <strong>Имя</strong>
                            <input type="text" name="name" required class="form-control" disabled="disabled" placeholder="Ваше имя" value="<?=$user->name;?>">
                            <b></b>
                        </label>
                        <label class="private-person">
                            <strong>Фамилия</strong>
                            <input type="text" name="last_name" required class="form-control" disabled="disabled" placeholder="Ваша фамилия" value="<?=$user->surname;?>">
                            <b></b>
                        </label>
                        <label class="business">
                            <strong>Название компании</strong>
                            <input type="text" name="form[company_name]" required class="form-control" disabled="disabled" placeholder="Ваше имя" value="<?=($user->company_name) ? $user->company_name : ''; ?>">
                            <b></b>
                        </label>
                        <label>
                            <strong>E-mail</strong>
                            <input type="email" name="email" required class="form-control" disabled="disabled" placeholder="Ваш e-mail" value="<?=$user->email;?>">
                            <b></b>
                        </label>
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
            <div class="save-btn-block">
                <input type="submit" class="btn main-btn" value="Создать объявление">
                <a href="#" class="preview" data-toggle="modal" data-target="#lotPreview">Предпросмотр</a>
                <span class="error-str">Выбирете категорию и заполните все поля с меткой *</span>
            </div>
            <div class="modal fade" id="lotPreview" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <div class="modal-body">
                            <div class="main-lot-holder"> 
                               <div id="main-lot" class="clearfix">
                                    <h3></h3>
                                    <div class="top-section">
                                        <span class="number">Номер объявления: <i></i></span>
                                        <div class="evaluation">
                                            <div class="rateit" data-rateit-value="4" data-rateit-starwidth="12" data-rateit-starheight="13"></div>
                                            <a href="#"> отзыв(ов)</a>
                                        </div>
                                    </div>

                                    <div class="blocks-holder clearfix">
                                        <div class="left-block">
                                            <div class="carousel">
                                            <div id="sync1" class="owl-carousel">
                                                <div class="item"><div style="background-image: url(/assets/images/no-img.png)"></div></div>
                                            </div>
                                            <div id="sync2" class="owl-carousel">
                                                <div class="item"><div style="background-image: url(/assets/images/no-img.png)"></div></div>
                                            </div>
                                        </div>
                                            <div class="block-order">
                                                <div class="price-holder">
                                                    <div class="price pr_v"></div>
                                                    <select class="selectpicker pr_picker">
                                                        <option value="">сутки</option>
                                                        <option value="">неделя</option>
                                                        <option value="">месяц</option>
                                                    </select>
                                                </div>
                                                <form action="#" method="POST" class="booking_calendar">
                                                    <div class="period">
                                                        <div class="part part1">
                                                            <p>Период с</p>
                                                            <input name="calendar[start]" data-defaults = "<?=date('Y-m-d', strtotime( '+1 days' ))?>" placeholder="<?=date('Y-m-d', strtotime( '+1 days' ))?>" type="text" id="datepicker3">
                                                            <select class="selectpicker start_rent">
                                                                <option>00:00</option>
                                                                <option>01:00</option>
                                                                <option>02:00</option>
                                                                <option>03:00</option>
                                                                <option>04:00</option>
                                                                <option>05:00</option>
                                                                <option>06:00</option>
                                                                <option>07:00</option>
                                                                <option>08:00</option>
                                                                <option>09:00</option>
                                                                <option>10:00</option>
                                                                <option>11:00</option>
                                                                <option selected="selected">12:00</option>
                                                                <option>13:00</option>
                                                                <option>14:00</option>
                                                                <option>15:00</option>
                                                                <option>16:00</option>
                                                                <option>17:00</option>
                                                                <option>18:00</option>
                                                                <option>19:00</option>
                                                                <option>20:00</option>
                                                                <option>21:00</option>
                                                                <option>22:00</option>
                                                                <option>23:00</option>
                                                            </select>
                                                        </div>
                                                        <div class="part">
                                                            <p>До</p>
                                                            <input name="calendar[end]" data-defaultf = "<?=date('Y-m-d', strtotime( '+2 days' ))?>" placeholder="<?=date('Y-m-d', strtotime( '+2 days' ))?>" type="text" id="datepicker4">
                                                            <select class="selectpicker end_rent">
                                                                <option>00:00</option>
                                                                <option>01:00</option>
                                                                <option>02:00</option>
                                                                <option>03:00</option>
                                                                <option>04:00</option>
                                                                <option>05:00</option>
                                                                <option>06:00</option>
                                                                <option>07:00</option>
                                                                <option>08:00</option>
                                                                <option>09:00</option>
                                                                <option>10:00</option>
                                                                <option>11:00</option>
                                                                <option>12:00</option>
                                                                <option>13:00</option>
                                                                <option>14:00</option>
                                                                <option>15:00</option>
                                                                <option>16:00</option>
                                                                <option>17:00</option>
                                                                <option selected="selected">18:00</option>
                                                                <option>19:00</option>
                                                                <option>20:00</option>
                                                                <option>21:00</option>
                                                                <option>22:00</option>
                                                                <option>23:00</option>
                                                            </select>
                                                        </div>
                                                        <!--<div class="clear_field"><span class="glyphicon glyphicon-remove"></span></div>-->
                                                        <div class="message_field">Некоректно задан диапозон</div>
                                                    </div>
                                                    <div class="total clearfix">
                                                        <span>Итого</span>
                                                        <div class="total-price">
                                                            <span class="prev_currency"></span>
                                                            <div class="btn-group">
                                                                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                                                    Узнать цену подробнее
                                                                    <span class="caret"></span>
                                                                </a>

                                                            </div>
                                                        </div>
                                                        <input type="submit" value="Отправить заявку" class="btn sent" onclick="return false">
                                                    </div>
                                                </form>

                                                <div class="note"><span>Аренда предпологает залог: </span></div>

                                            </div>
                                            <div class="char-prew">
                                                <table class="table table1">
                                                    <tbody>

                                                        <tr>
                                                            <td><strong>Объявление от:</strong></td>
                                                            <td><span></span></td>
                                                        </tr>


                                                                <tr>
                                                                    <td><strong></strong></td>
                                                                    <td><span></span></td>
                                                                </tr>

                                                                <tr>
                                                                    <td><strong></strong></td>
                                                                    <td><span></span></td>
                                                                </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="requirements requirements-prew">
                                                <div class="description">
                                                    <p></p>
                                                </div>
                                                <div class="rules">
                                                    <strong>Условия проката</strong>
                                                    <p></p>
                                                </div>
                                               <div class="age">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="right-block">
                                            <div class="top-section">
                                                <span class="number">Номер объявления: <i></i></span>
                                                <div class="evaluation">
                                                    <div class="rateit" data-rateit-value="" data-rateit-starwidth="12" data-rateit-starheight="13"></div>
                                                    <a href="javascript:void(0)">отзыв(ов)</a>
                                                </div>
                                            </div>
                                            <div class="block-order">
                                                <div class="price-holder">
                                                    <div class="price pr_v"> грн.</div>
                                                    <select class="selectpicker pr_picker">
                                                        <option value="">сутки</option>

                                                        <option value="">неделя</option>

                                                        <option value="">месяц</option>

                                                    </select>
                                                </div>
                                                <form action="#" method="POST" class="booking_calendar">
                                                    <div class="period">
                                                        <div class="part part1">
                                                            <p>Период с</p>
                                                            <input name="calendar[start]" data-defaults = "<?=date('Y-m-d', strtotime( '+1 days' ))?>" placeholder="<?=date('Y-m-d', strtotime( '+1 days' ))?>" type="text" id="datepicker">
                                                            <select class="selectpicker start_rent">
                                                                <option>00:00</option>
                                                                <option>01:00</option>
                                                                <option>02:00</option>
                                                                <option>03:00</option>
                                                                <option>04:00</option>
                                                                <option>05:00</option>
                                                                <option>06:00</option>
                                                                <option>07:00</option>
                                                                <option>08:00</option>
                                                                <option>09:00</option>
                                                                <option>10:00</option>
                                                                <option>11:00</option>
                                                                <option selected="selected">12:00</option>
                                                                <option>13:00</option>
                                                                <option>14:00</option>
                                                                <option>15:00</option>
                                                                <option>16:00</option>
                                                                <option>17:00</option>
                                                                <option>18:00</option>
                                                                <option>19:00</option>
                                                                <option>20:00</option>
                                                                <option>21:00</option>
                                                                <option>22:00</option>
                                                                <option>23:00</option>
                                                            </select>
                                                        </div>
                                                        <div class="part">
                                                            <p>До</p>
                                                            <input name="calendar[end]" data-defaultf = "<?=date('Y-m-d', strtotime( '+2 days' ))?>" placeholder="<?=date('Y-m-d', strtotime( '+2 days' ))?>" type="text" id="datepicker2">
                                                            <select class="selectpicker end_rent">
                                                                <option>00:00</option>
                                                                <option>01:00</option>
                                                                <option>02:00</option>
                                                                <option>03:00</option>
                                                                <option>04:00</option>
                                                                <option>05:00</option>
                                                                <option>06:00</option>
                                                                <option>07:00</option>
                                                                <option>08:00</option>
                                                                <option>09:00</option>
                                                                <option>10:00</option>
                                                                <option>11:00</option>
                                                                <option>12:00</option>
                                                                <option>13:00</option>
                                                                <option>14:00</option>
                                                                <option>15:00</option>
                                                                <option>16:00</option>
                                                                <option>17:00</option>
                                                                <option selected="selected">18:00</option>
                                                                <option>19:00</option>
                                                                <option>20:00</option>
                                                                <option>21:00</option>
                                                                <option>22:00</option>
                                                                <option>23:00</option>
                                                            </select>
                                                        </div>
                                                        <!--<div class="clear_field"><span class="glyphicon glyphicon-remove"></span></div>-->
                                                        <div class="message_field">Некоректно задан диапозон</div>
                                                    </div>
                                                    <div class="total clearfix">
                                                        <span>Итого</span>
                                                        <div class="total-price">
                                                            <span class="prev_currency"></span>
                                                            <div class="btn-group">
                                                                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                                                    Узнать цену подробнее
                                                                    <span class="caret"></span>
                                                                </a>

                                                            </div>
                                                        </div>
                                                        <input type="submit" value="Отправить заявку" class="btn sent" onclick="return false">
                                                    </div>
                                                </form>

                                                <div class="note"><span>Аренда предпологает залог: </span></div>

                                            </div>
                                            <div class="map-section">

                                                        <div id="map6">Адрес еще не указан</div>
                                                        
                                                       <!--  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpONh6QjiiZyV7Emi4nsSB7KJFApSbkzM&signed_in=true&callback=initMap">
                                                        </script> -->


                                            </div>
                                            <div class="author-ad">
                                                <div class="author-info">
                                                    <div class="name"><a href="javascript:void(0)"><?= $user->name; ?></a></div>
                                                    <?php if($user->avatar != ''){ ?>
                                                        <div class="foto" style="background-image: url(<?=$user->avatar?>)"><a href="javascript:void(0)"></a></div>
                                                    <?php }else{ ?>
                                                        <div class="foto" style="background-image: url(/assets/images/photo.jpg)"><a href="javascript:void(0)"></a></div>
                                                    <?php } ?>
                                                    <div class="evaluation">
                                                        <div class="rateit" data-rateit-value="" data-rateit-starwidth="12" data-rateit-starheight="13"></div>
                                                        <a href="javascript:void(0)"><?=$user->reviewsCount; ?> отзыв(ов)</a>
                                                    </div>
                                                    <span>на stuffe<i>x</i> c <?= echoRussianDate($user->register_time); ?></span>
                                                </div>
                                                <div class="link-holder">
                                                    <?php for($i = 0; $i<5; $i++){
                                                        $phone = 'phone'.$i;
                                                        if($user->$phone != null){ ?>
                                                            <a href="javascript:void(0)" class="phone">+38<?=$user->$phone; ?></a>
                                                        <?php }
                                                    }?>
                                                     <a href="javascript:void(0)" class="write-to-author">Написать автору</a> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="overlay"></div>
                        <div class="close-modal" data-dismiss="modal" aria-label="Close"><a href="javascript: void(0);">Назад к оформлению</a></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>

    // Counter symbols
    $('#inputField').keyup(function () {
        var box = $(this).val();
        var count = 70 - box.length;

        if (box.length <= 70) {
            $('#count').html(count);
        } else {
            text = box.slice(0, 70);
            $("#inputField").val(text);
        }
        ;
        return false;
    });
    
    // Counter symbols
    $('#textareaField').keyup(function () {
        var box = $(this).val();
        var count = 4000 - box.length;

        if (box.length <= 4000) {
            $('#count2').html(count);
        } else {
            text = box.slice(0, 4000);
            $("#textareaField").val(text);
        }
        ;
        return false;
    });

</script>

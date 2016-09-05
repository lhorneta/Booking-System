$(document).ready(function(){
	
	$(document).on('change', 'input[type="checkbox"]', function(){
		var name = $(this).attr('name');
		if ($(this).is(':checked')) {
			$('input[name="'+name+'"]').attr('checked', 'checked');
		} else {
			$('input[name="'+name+'"]').removeAttr('checked');
		}
	});

	//Custom select by bootstrap.
	$('#region').selectpicker();
	$('.grand_childs_cats').selectpicker();

	//owl-carousel on the lot page
	var sync1 = $("#sync1");
	var sync2 = $("#sync2");
	 
	sync1.owlCarousel({
	singleItem : true,
	slideSpeed : 1000,
	navigation: true,
	pagination:false,
	afterAction : syncPosition,
	responsiveRefreshRate : 200,
	});

	sync2.owlCarousel({
	items : 6,
	itemsDesktop      : [1199,6],
	itemsDesktopSmall     : [979,4],
        itemsTablet       : [768,4],
	itemsMobile       : [735,5],
	pagination:false,
	responsiveRefreshRate : 100,
	afterInit : function(el){
	  el.find(".owl-item").eq(0).addClass("synced");
	}
	});

	function syncPosition(el){
	var current = this.currentItem;
	$("#sync2")
	  .find(".owl-item")
	  .removeClass("synced")
	  .eq(current)
	  .addClass("synced")
	if($("#sync2").data("owlCarousel") !== undefined){
	  center(current)
	}
	}

	$("#sync2").on("click", ".owl-item", function(e){
	e.preventDefault();
	var number = $(this).data("owlItem");
	sync1.trigger("owl.goTo",number);
	});

	function center(number){
	var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
	var num = number;
	var found = false;
	for(var i in sync2visible){
	  if(num === sync2visible[i]){
	    var found = true;
	  }
	}

	if(found===false){
	  if(num>sync2visible[sync2visible.length-1]){
	    sync2.trigger("owl.goTo", num - sync2visible.length+2)
	  }else{
	    if(num - 1 === -1){
	      num = 0;
	    }
	    sync2.trigger("owl.goTo", num);
	  }
	} else if(num === sync2visible[sync2visible.length-1]){
	  sync2.trigger("owl.goTo", sync2visible[1])
	} else if(num === sync2visible[0]){
	  sync2.trigger("owl.goTo", num-1)
	}
	}
	
	function NotBeforeToday(date)
	{
	    var now = new Date();//this gets the current date and time
	    if (date.getFullYear() == now.getFullYear() && date.getMonth() == now.getMonth() && date.getDate() > now.getDate())
	        return [true];
	    if (date.getFullYear() >= now.getFullYear() && date.getMonth() > now.getMonth())
	       return [true];
	     if (date.getFullYear() > now.getFullYear())
	       return [true];
	    return [false];
	}
	
	//Datepicker by jQuery UI
	
		
	
        $( "#datepicker3, #datepicker4").datepicker({
            dateFormat: "dd-mm-yy",
            firstDay: 1,
            altField: "#actualDate",
            minDate: "#actualDate",
            
        });
        
        $('#datepicker5, #datepicker6').datepicker({
            dateFormat: "dd-mm-yy",
            firstDay: 1,
            altField: "#actualDate"
        });
        
        //Append scripts for google map
        // $('.show-link-holder .show-link').click( function () {
        	// var mlat = $('.mlat').val();
            // var mlong = $('.mlong').val();
            // $('#modalMap .modal-body').html(
                // "<div id=\"map2\"></div><script> var citymap = { kharkov: {center: {lat: "+mlat+", lng: "+mlong+"}, population: 100} }; function initMap() { var map = new google.maps.Map(document.getElementById('map'), { zoom: 10, center: {lat: 49.990249, lng: 36.2586307}, mapTypeId: google.maps.MapTypeId.TERRAIN}); for (var city in citymap) { var cityCircle = new google.maps.Circle({strokeColor: '#FF0000', strokeOpacity: 0.8, strokeWeight: 2, fillColor: '#FF0000', fillOpacity: 0.35, map: map, center: citymap[city].center, radius: Math.sqrt(citymap[city].population) * 100}); } } </script>  <script async defer  src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCxVrklpJnCePOkiyo7EjHL5TWGa-4ivoY&signed_in=true&callback=initMap'></script>")
        // });

        //Show or hide .table-last-orders or .table-new-orders
        $(document).on("click", ".private-office-content .new-order", function() {
            $('.private-office-content .last-order').removeClass('active');
            $(this).addClass('active');
            $('.private-office-content .table-last-orders').hide(0);
            $('.private-office-content .table-new-orders').show(0);
        });
        $(document).on("click", ".private-office-content .last-order", function() {
            $('.private-office-content .new-order').removeClass('active');
            $(this).addClass('active');
            $('.private-office-content .table-new-orders').hide(0);
            $('.private-office-content .table-last-orders').show(0);
        });

        //Show or hide other orders at the .table-my-orders
        $(document).on("click", ".table-my-orders .all-orders", function() {
            $('.table-my-orders .confirm, .table-my-orders .cancel,.table-my-orders .wait').show(100); 
        });
        $(document).on("click", ".table-my-orders .confirmed-orders", function() {
            $('.table-my-orders .cancel,.table-my-orders .wait').hide(100);
            $('.table-my-orders .confirm').show(100); 
        });
        $(document).on("click", ".table-my-orders .canceled-orders", function() {
            $('.table-my-orders .confirm,.table-my-orders .wait').hide(100); 
            $('.table-my-orders .cancel').show(100);
        });
        $(document).on("click", ".table-my-orders .for-confirmation", function() {
            $('.table-my-orders .confirm, .table-my-orders .cancel').hide(100); 
            $('.table-my-orders .wait').show(100);
        });		

        //Add class 'active' at the '.table' and show link '.del' and checked all input[type="ckeckbox"]
        $(document).on("click", ".table-my-messages .table-incoming-messages thead input[type=checkbox]", function() {

            $('.table-my-messages .table-incoming-messages').toggleClass('active');
            var nonChecked = $('.table-my-messages .table-incoming-messages input[type="checkbox"]');
            if($(this).prop('checked') == true){
                $(nonChecked).each(function(){
                    $(this).prop('checked', true);
                });
            } else {
                $(nonChecked).each(function(){
                    $(this).prop('checked', false);
                });
            };
        });

        //Add class 'active' at the '.table' and show link '.del' and checked all input[type="ckeckbox"]
        $(document).on("click", ".table-my-messages .table-outgoing-messages thead input[type=checkbox]", function() {
        	
            $('.table-my-messages .table-outgoing-messages').toggleClass('active');
            var nonChecked = $('.table-my-messages .table-outgoing-messages input[type="checkbox"]');
            if($(this).prop('checked') == true){
                $(nonChecked).each(function(){
                    $(this).prop('checked', true);
                });
            } else {
                $(nonChecked).each(function(){
                    $(this).prop('checked', false);
                });
            };
        });

        //Add class 'active' at the '.table' and show link '.del' and checked all input[type="ckeckbox"]
        $(document).on("click", ".table-my-messages .table-archive-messages thead input[type=checkbox]", function() {
            $('.table-my-messages .table-archive-messages').toggleClass('active');
            var nonChecked = $('.table-my-messages .table-archive-messages input[type="checkbox"]');
            if($(this).prop('checked') == true){
                $(nonChecked).each(function(){
                    $(this).prop('checked', true);
                });
            } else {
                $(nonChecked).each(function(){
                    $(this).prop('checked', false);
                });
            };
        });
 
    	//Выделение всех нажатых чекбоксов (удаление сообщений из архива)
    	$(document).on("click", ".del_archive_checkbox", function() {
        
            var checkedInput = $('.del_archive_checkbox input:checked');
            for(var i = 0; i < checkedInput.length; i++) {
                if(checkedInput.length > 1) {
                    $('.table-my-messages .table-archive-messages thead .del a').css('display', 'inline-block');
                } else {
                    $('.table-my-messages .table-archive-messages thead .del a').css('display', 'none');
                };
            };
        });
        
    	//Выделение всех нажатых чекбоксов (помещение исходящих сообщений в архив)
    	$(document).on("click", ".checkbox-del-outmessage", function() {
        
            var checkedInput = $('.checkbox-del-outmessage input:checked');
            for(var i = 0; i < checkedInput.length; i++) {
                if(checkedInput.length > 1) {
                    $('.table-my-messages .table-outgoing-messages thead .del a').css('display', 'inline-block');
                } else {
                    $('.table-my-messages .table-outgoing-messages thead .del a').css('display', 'none');
                };
            };
        });

		//Send all checked outcoming messages to archive
		$(document).on("click", ".checked_outmess_to_archive", function(e) {
			e.preventDefault();
			var 
				url = '/myprofile/allouttoarchive/',
				messages = [],
				result = null,
				checkedInput = $('.checkbox-del-outmessage input:checked'),
				that = $(this);

            for(var i = 0; i < checkedInput.length; i++) {
                if(checkedInput.length > 1) {
                	checkedInput.parents('.lotrow').css('background','#fbfcea');
                    var json = checkedInput.parents('.lotrow:eq('+i+')').find('.del a').attr('data-json');
                    messages.push(json);
                }
            };
			result = JSON.stringify(messages);
			console.log('result',result);
			if(messages.length > 1){
				 $.ajax({
		            url: url,
		            data:{json:result},
		            method: "POST",
		           	success:function(data){
		           		
		           		var checkedInput = $('.checkbox-del-outmessage input:checked');
			            for(var i = 0; i < checkedInput.length; i++) {
			                if(checkedInput.length > 1) {
			                    var obj = checkedInput.parents('.lotrow:eq('+i+')').remove();
		           				//$(obj).load(document.location+' '+obj+' > *');
			                }
			            };

		            	return false;
		            },
		            error:function(xhr, ajaxOptions, thrownError){
		            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		            }
	            });
			}
			
		});	

		//Delete all checked messages from archive
		$(document).on("click", ".del_checked_messages", function(e) {
			e.preventDefault();
			var 
				url = '/myprofile/deletearchiveall/',
				messages = [],
				result = null,
				checkedInput = $('.del_archive_checkbox input:checked'),
				that = $(this);

            for(var i = 0; i < checkedInput.length; i++) {
                if(checkedInput.length > 1) {
                	checkedInput.parents('.lotrow').css('background','#fbfcea');
                    var json = checkedInput.parents('.lotrow:eq('+i+')').find('.del a').attr('data-id');
                    messages.push(json);
                }
            };
			result = JSON.stringify(messages);
			console.log('result',result);
			if(messages.length > 1){
				 $.ajax({
		            url: url,
		            data:{json:result},
		            method: "POST",
		           	success:function(data){
		           		var checkedInput = $('.del_archive_checkbox input:checked');
			            for(var i = 0; i < checkedInput.length; i++) {
			                if(checkedInput.length > 1) {
			                    var obj = checkedInput.parents('.lotrow:eq('+i+')').remove();
			                }
			            };
		            	return false;
		            },
		            error:function(xhr, ajaxOptions, thrownError){
		            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		            }
	            });
			}
			
		});	
    
    	//Выделение всех нажатых чекбоксов (помещение сообщений в архив)
    	$(document).on("click", ".checkbox-del-message", function() {
        
            var checkedInput = $('.checkbox-del-message input:checked');
            for(var i = 0; i < checkedInput.length; i++) {
                if(checkedInput.length > 1) {
                    $('.table-my-messages thead .del a').css('display', 'inline-block');
                } else {
                    $('.table-my-messages thead .del a').css('display', 'none');
                };
            };
        });

		//Send all checked messages to archive
		$(document).on("click", ".checked_mess_to_archive", function(e) {
			e.preventDefault();
			var 
				url = '/myprofile/alltoarchive/',
				messages = [],
				result = null,
				checkedInput = $('.checkbox-del-message input:checked'),
				that = $(this);

            for(var i = 0; i < checkedInput.length; i++) {
                if(checkedInput.length > 1) {
                	checkedInput.parents('.lotrow').css('background','#fbfcea');
                    var json = checkedInput.parents('.lotrow:eq('+i+')').find('.del a').attr('data-json');
                    messages.push(json);
                }
            };
			result = JSON.stringify(messages);
			console.log('result',result);
			if(messages.length > 1){
				 $.ajax({
		            url: url,
		            data:{json:result},
		            method: "POST",
		           	success:function(data){
		           		
		           		var checkedInput = $('.checkbox-del-message input:checked');
			            for(var i = 0; i < checkedInput.length; i++) {
			                if(checkedInput.length > 1) {
			                    var obj = checkedInput.parents('.lotrow:eq('+i+')').remove();
		           				//$(obj).load(document.location+' '+obj+' > *');
			                }
			            };

		            	return false;
		            },
		            error:function(xhr, ajaxOptions, thrownError){
		            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		            }
	            });
			}
			
		});		

		//Send message-lot to archive
		$(document).on("click", ".lot_to_archive a", function(e) {
			e.preventDefault();
			var url = $(this).attr('href'),
				id = $(this).parents('.lotrow').attr('id'),
				that = $(this);
				
			that.parents('.lotrow').css('background','#fbfcea');
			
			if(url !== ''){
				 $.ajax({
		            url: url,
		            method: "POST",
		           	success:function(data){
		           		that.parents('.lotrow').remove();
		            	return false;
		            },
		            error:function(xhr, ajaxOptions, thrownError){
		            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		            }
	            });
			}
		});
		
		//Delete message-lot from archive
		$(document).on("click", ".del_archive a", function(e) {
			e.preventDefault();
			var url = $(this).attr('href'),
				id = $(this).attr('data-id'),
				that = $(this);
				
			that.parents('.lotrow').css('background','#fbfcea');
			
			if(url !== ''){
				 $.ajax({
		            url: url,
		            method: "POST",
		           	success:function(data){
		           		that.parents('.lotrow').remove();
		            	return false;
		            },
		            error:function(xhr, ajaxOptions, thrownError){
		            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		            }
	            });
			}
		});
		
		//Send outcoming message-lot to archive
		$(document).on("click", ".lot_to_archive_out a", function(e) {
			e.preventDefault();
			var url = $(this).attr('href'),
				that = $(this);
				
			that.parents('.lotrow').css('background','#fbfcea');
			
			if(url !== ''){
				 $.ajax({
		            url: url,
		            method: "POST",
		           	success:function(data){
		           		that.parents('.lotrow').remove();
		            	return false;
		            },
		            error:function(xhr, ajaxOptions, thrownError){
		            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		            }
	            });
			}
		});
		
		//Send message-message to archive
		$(document).on("click", ".user_to_archive a", function(e) {
			e.preventDefault();
			var url = $(this).attr('href'),
				id = $(this).attr('data-id'),
				that = $(this);
				
			that.parents('.lotrow').css('background','#fbfcea');
			
			if(url !== ''){
				 $.ajax({
		            url: url,
		            method: "POST",
		           	success:function(data){
		           		var obj = that.parents('.lotrow');
		           		that.parents('.lotrow').remove();
		           		//$(obj).load(document.location+' '+obj+' > *');
		            	return false;
		            },
		            error:function(xhr, ajaxOptions, thrownError){
		            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		            }
	            });
			}
		});
		

        //Show or hide '.table-outgoing-messages' or '.table-archive-messages' or '.table-incoming-messages'
        $(document).on("click", ".messages-holder .inbox", function() {
            $(this).addClass('active');
            $('.messages-holder .outbox').removeClass('active');
            $('.messages-holder .archive').removeClass('active');
            $('.messages-holder .table-outgoing-messages').hide(0);
            $('.messages-holder .table-archive-messages').hide(0);
            $('.messages-holder .table-incoming-messages').show(0);
            $('#dialog-open').hide();
            $('.table-my-messages .table-section').show();
        });
        $(document).on("click", ".messages-holder .outbox", function() {
            $(this).addClass('active');
            $('.messages-holder .inbox').removeClass('active');
            $('.messages-holder .archive').removeClass('active');
            $('.messages-holder .table-archive-messages').hide(0);
            $('.messages-holder .table-incoming-messages').hide(0);
            $('.messages-holder .table-outgoing-messages').show(0);
            $('#dialog-open').hide();
            $('.table-my-messages .table-section').show();
        });
        $(document).on("click", ".messages-holder .archive", function() {
            $(this).addClass('active');
            $('.messages-holder .inbox').removeClass('active');
            $('.messages-holder .outbox').removeClass('active');
            $('.messages-holder .table-incoming-messages').hide(0);
            $('.messages-holder .table-outgoing-messages').hide(0);
            $('.messages-holder .table-archive-messages').show(0);
            $('#dialog-open').hide();
            $('.table-my-messages .table-section').show();
        });

        //Checked only one checkbox
        $('.main-info .pol .male input[type="checkbox"]').click( function () {
            $('.main-info .pol .female input[type="checkbox"]').prop('checked', false);
        });
        $('.main-info .pol .female input[type="checkbox"]').click( function () {
            $('.main-info .pol .male input[type="checkbox"]').prop('checked', false);
        });

        //Показывать загруженую картинку на аватар
        var post = [];
        function readURL(input) {
            $('.add-image .img-holder img').onerror = function () {
                $(this).css("display", "none");
            };
            var formData = new FormData();
            var imgLink = '';
            file = input.files;
            formData.append('userpic', input.files[0], 'chris.jpg');
            $.ajax({
                url: '/file/loadimage',
                type: 'POST',
                data: formData,
                cache: false,
                dataType: 'json',
                processData: false, // Не обрабатываем файлы (Don't process the files)
                contentType: false, // Так jQuery скажет серверу что это строковой запрос
                success: function (data) {
                    console.log(data);
                    $('.add-image .img-holder.choosen img').attr('src', data.tmp_file);
    //                $('.addpost-upload-image.choosen .addpost-upload-image-text').hide();
                    $('.add-image .img-holder.choosen').css('background', 'transparent');
                    var currentImage = {"type": "image", "src": data.tmp_file, "comment": $('.add-image .img-holder.choosen').parents(".addpost").find("textarea").val()};

                    $('.add-image .img-holder.choosen').parents('.avatar ').data('id', post.length);
                    console.log('data-id = ' + $('.add-image .img-holder.choosen').parents('.avatar ').data('id'));
                    post[post.length] = currentImage;
                    console.log(post);
                    $('.add-image .img-holder.choosen').removeClass("choosen");
                }
            });

        }
        $(".private-office-content").on("change", ".add-image .input-holder input", function () {
            console.log($(this).parents(".avatar").data('id'));
            delete post[$(this).parents(".avatar").data('id')];
    //            post.splice($(this).parents(".addpost").data('id'), 1);
            console.log(post);
            $(".add-image .img-holder").addClass("choosen");
            readURL(this);
        });
  
        //Append scripts for google map on the .edit-lot page
        
        $('#mapForUsers').on('shown.bs.modal', function (e) {
        	
        	var lat =  $('#main-edit-ad .show-location').attr('data-lat'),
        		lng = $('#main-edit-ad .show-location').attr('data-lng'),
        		mlat = $('#main-edit-ad .mlat').val(),
        		mlong = $('#main-edit-ad .mlong').val();
        		
        	if(lat !== '' || lat !== undefined || lat !== null){lat= lat;}else{lat= 50.4021702;}
        	if(mlat !== '' || mlat !== undefined || mlat !== null){lat= mlat;}else{lat= 50.4021702;}
        	        		
        	if(lng !== '' || lng !== undefined || lng !== null){lng= lng;}else{lng= 50.4021702;}
        	if(mlong !== '' || mlong !== undefined || mlong !== null){lng= mlong;}else{lng= 30.3926087;}

			var citymap = {
                kiev: {
                    center: {lat: (+lat), lng: (+lng)},
                    population: 100
                }
            };

        	var map = new google.maps.Map(document.getElementById('map2'),
            {
            	center: {lat: (+lat), lng: (+lng)},
            	zoom: 13,
            	scrolwheel: false,
            	mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            for (var city in citymap) { var cityCircle = new google.maps.Circle({strokeColor: '#FF0000', strokeOpacity: 0.8, strokeWeight: 2, fillColor: '#FF0000', fillOpacity: 0.35, map: map, center: citymap[city].center, radius: Math.sqrt(citymap[city].population) * 100}); }
        	
        	google.maps.event.trigger(map, "resize");
         });
         
         //Предпросмотр в лотах
         $('#lotPreview').on('shown.bs.modal', function (e) {
        	
        	//Слайдер изображений
        	var images = [];
        	$('.addpost-upload-image img').each(function(){
        		var src = $(this).attr('src');
        		if(src !=='/assets/images/addphoto.png' && src !=='' && src !== null){
        			images.push(src);
        		}
        	});
        	//console.log(images);
        	if(images.length >0){
	        	for (var key in images) {
	        		$('#sync1 .item > div').eq(0).css('background-image','url('+images[0]+')');
	        		$('#sync2 .item > div').eq(key).css('background-image','url('+images[key]+')');
	        	};
        	};
        	
        	//Отображение атрибутов лота
        	var attribytes = [];
            //Состояние лота
            var valueCondition = $('.more-information-holder input[name="form[condition_title]"]').val(),
                conditTitle = $('.more-information-holder .block-input').find('strong').text();
            if(conditTitle !=='' && conditTitle !== null && valueCondition !=='' && valueCondition !== null){
                attribytes.push({title:conditTitle, value:valueCondition});
            };
             
            //Стоимость лота за сутки
            var dayPrice = $('.form-holder input[name="form[day_payment]"]').val(),
                depositTitle = $('#deposit .btn').attr('title'),
                currencyVal = $('.prices-block .btn').attr('title');

            if(depositTitle !=='' && depositTitle !== null && dayPrice !=='' && dayPrice !== null){
                $('.price.pr_v').html(dayPrice + ' ' + currencyVal);
                $('.total-price .prev_currency').html(dayPrice + ' ' + currencyVal);
                
                if(depositTitle === 'Деньги') {
                    var depositVal = $('.money-interval .pledge').val(),
                        depCurrencyVal = $('.money-interval .currency-select').val();
                    $('.block-order .note span').html('Аренда предпологает залог: ' + depositVal + ' ' + depCurrencyVal);
                } else{
                    $('.block-order .note span').html('Аренда предпологает залог: ' + depositTitle);
                };
            };
             
            //Условия проката
            var desForLot = $('.des_for_lot textarea').val(),
                rentalCond = $('.rental-сonditions textarea').val();
            $('.requirements-prew .description').html(desForLot);
            $('.requirements-prew .rules').html('<strong>Условия проката</strong>' + '<p>' + rentalCond + '</p>');
             
            //Особые условия
            var spConditions = $('.special_conditions').val();
            if($('.sp_checkbox').prop('checked') == true) {
                $('.requirements-prew .age').html('<strong>Особые условия:</strong><p>' + spConditions + '</p>');  
            } else{
                $('.requirements-prew .age').html('');
            };
             
            //Объявление от: Частное лицо/Бизнес
            var userType = $('.user_type .btn').attr('title');
            if(userType !=='' && userType !== null){
                attribytes.push({title:'Объявление от: ', value:userType});
            };
             
        	$('.characteristics .block-select').each(function(){
        		var 
        			title = $(this).find('strong').text(),
        			input = '',
        			valueInput = $(this).find('label input.form-control').val(),
        			valueSelect = $(this).find('button').attr('title');
        		
        		if($(this).find('label input.form-control').length >0){input = valueInput;}
        		if($(this).find('button').length >0){input = valueSelect;}
        		
        		if(title !=='' && title !== null && input !=='' && input !== null){
        			attribytes.push({title:title, value:input});
        		}
        		
        	});
        	//attribytes
			//console.log(attribytes);
			var 
				roleId = $('.char-prew').attr('data-user-role'),
				role = '',
				html = '<table class="table table1">'+
			               ' <tbody>';
//			if(parseInt(roleId) === 2){role = 'Частное лицо';}
//			else if(parseInt(roleId) === 3){role = 'Бизнес';}
//        	
//			 html += '  <tr>' +
//                        '<td><strong> Объявление от :</strong></td>'+
//                        '<td><span>' + role + '</span></td>'+
//                    	'</tr>';

        	if(attribytes.length >0){
	        	for (var key in attribytes) {
						
                  html += '  <tr>' +
                        '<td><strong> '+ attribytes[key].title + ':</strong></td>'+
                        '<td><span>' + attribytes[key].value + '</span></td>'+
                    	'</tr>';                          
		                   
            	};
        	}

        	html += '</tbody></table>';
        	 
        	$('.char-prew').html(html);

			//Отображение карты и адреса
        	var lat =  $('#main-edit-ad .show-location').attr('data-lat'),
        		lng = $('#main-edit-ad .show-location').attr('data-lng'),
        		mlat = $('#main-edit-ad .mlat').val(),
        		mlong = $('#main-edit-ad .mlong').val();
        		
        	if(lat !== '' || lat !== undefined || lat !== null){lat= lat;}else{lat= 50.4021702;}
        	if(mlat !== '' || mlat !== undefined || mlat !== null){lat= mlat;}else{lat= 50.4021702;}
        	        		
        	if(lng !== '' || lng !== undefined || lng !== null){lng= lng;}else{lng= 50.4021702;}
        	if(mlong !== '' || mlong !== undefined || mlong !== null){lng= mlong;}else{lng= 30.3926087;}

			var citymap = {
                kiev: {
                    center: {lat: (+lat), lng: (+lng)},
                    population: 100
                }
            };

        	var map = new google.maps.Map(document.getElementById('map6'),
            {
            	center: {lat: (+lat), lng: (+lng)},
            	zoom: 13,
            	scrolwheel: false,
            	mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            //marker
            /*var marker = new google.maps.Marker({
	            position: {lat: (+lat), lng: (+lng)},
	            map: map,
	        });*/
	        //circle
            for (var city in citymap) { var cityCircle = new google.maps.Circle({strokeColor: '#FF0000', strokeOpacity: 0.8, strokeWeight: 2, fillColor: '#FF0000', fillOpacity: 0.35, map: map, center: citymap[city].center, radius: Math.sqrt(citymap[city].population) * 100}); }
        	
        	google.maps.event.trigger(map, "resize");
         });
        
        $('#showMap').on('shown.bs.modal', function (e) {
        	
        	var lat =  $('#main-private-office .show-location').attr('data-lat'),
        		lng = $('#main-private-office .show-location').attr('data-lng'),
        		mlat = $('#main-private-office .mlat').val(),
        		mlong = $('#main-private-office .mlong').val();
        		
        	if(lat !== '' || lat !== undefined || lat !== null){lat= lat;}else{lat= 50.4021702;}
        	if(mlat !== '' || mlat !== undefined || mlat !== null){lat= mlat;}else{lat= 50.4021702;}
        	        		
        	if(lng !== '' || lng !== undefined || lng !== null){lng= lng;}else{lng= 50.4021702;}
        	if(mlong !== '' || mlong !== undefined || mlong !== null){lng= mlong;}else{lng= 30.3926087;}

			var citymap = {
                kiev: {
                    center: {lat: (+lat), lng: (+lng)},
                    population: 100
                }
            };
            
        	var map = new google.maps.Map(document.getElementById('map2'),
            {
            	center: {lat: (+lat), lng: (+lng)},
            	zoom: 13,
            	scrolwheel: false,
            	mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            for (var city in citymap) { var cityCircle = new google.maps.Circle({strokeColor: '#FF0000', strokeOpacity: 0.8, strokeWeight: 2, fillColor: '#FF0000', fillOpacity: 0.35, map: map, center: citymap[city].center, radius: Math.sqrt(citymap[city].population) * 100}); }
        	
        	google.maps.event.trigger(map, "resize");
         });
             

        //Append scripts for google map - max-width: 640px
        $('.location .show-location-640px').click( function () {
            var lat = $(this).data('lat');
            var long = $(this).data('long');
            $('#showMap-640px .modal-body').append(
                "<script> var citymap = { kharkov: {center: {lat: "+ lat +", lng: "+ long +"}, population: 100} }; function initMap() { var map = new google.maps.Map(document.getElementById('map4'), { zoom: 10, center: {lat: "+ lat +", lng: "+ long +"}, mapTypeId: google.maps.MapTypeId.TERRAIN}); for (var city in citymap) { var cityCircle = new google.maps.Circle({strokeColor: '#FF0000', strokeOpacity: 0.8, strokeWeight: 1, fillColor: '#FF0000', fillOpacity: 0.35, map: map, center: citymap[city].center, radius: Math.sqrt(citymap[city].population) * 100}); } } </script>  <script async defer  src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCsdd3LyP4wNP_07rvJUpg--lPrC9IkhAs&signed_in=true&callback=initMap'></script>")
        });

//        $('a[href="#tab4"]').on('shown.bs.tab', function (e) {
//            if($(this).data('loaded') !== 'true'){
//                $('.location .map-holder-640px').append("<script src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyCugU_FR5N8I0StHsvC0qiqbRrkt4M-a3w&libraries=places&callback=initAutocomplete\" async defer><\/script>");
//            }
//            $(this).data('loaded', 'true');
//            }
//        );

        //Sliding '.add-filters-section-holder'
        $('.middle-section .add-filters').click( function () {
            $('.add-filters-section-holder').slideToggle(200);
        });

        //Rows or colums product`s list
        $('.switches .colums').click( function () {
            $(this).addClass('active');
            $('.switches .rows').removeClass('active');
            $('.products-holder').addClass('active'); 
        });
        $('.switches .rows').click( function () {
            $(this).addClass('active');
            $('.switches .colums').removeClass('active');
            $('.products-holder').removeClass('active'); 
        });
    
        $(window).resize( function () {
            if( $(window).width() < 624 ) {
                $('.products-holder').addClass('active');
            };  
//            else if( $(window).width() > 623 ){
//                $('.products-holder').removeClass('active');
//            };    
        });
        if( $(window).width() < 624 ) {
                $('.products-holder').addClass('active');
            } else if( $(window).width() > 624 ){
                $('.products-holder').removeClass('active'); 
            }; 
        
        //Accordion that showing privat-office blocks
        $('.private-office-content .toggle-orders').click( function () {
            $('.toggle-ads, .toggle-messages, .toggle-settings').removeClass('active');
            $(this).toggleClass('active');
            $('.my-ads-640px, .my-messages-640px, .my-settings-640px').slideUp(200);
            $('.private-office-content .my-orders-640px').slideToggle(300);
        });
        $('.private-office-content .toggle-ads').click( function () {
            $('.toggle-orders, .toggle-messages, .toggle-settings').removeClass('active');
            $(this).toggleClass('active');
            $('.my-orders-640px, .my-messages-640px, .my-settings-640px').slideUp(200);
            $('.private-office-content .my-ads-640px').slideToggle(300);
        });
        $('.private-office-content .toggle-messages').click( function () {
            $('.toggle-orders, .toggle-ads, .toggle-settings').removeClass('active');
            $(this).toggleClass('active');
            $('.my-orders-640px, .my-ads-640px, .my-settings-640px').slideUp(200);
            $('.private-office-content .my-messages-640px').slideToggle(300);
        });
        $('.private-office-content .toggle-settings').click( function () {
            $('.toggle-orders, .toggle-ads, .toggle-messages').removeClass('active');
            $(this).toggleClass('active');
            $('.my-orders-640px, .my-ads-640px, .my-messages-640px').slideUp(200);
            $('.private-office-content .my-settings-640px').slideToggle(300);
        });
		
		$(document).on('click', '.print', function(){
			var URL = this.href;
			var W = window.open(URL);
			W.window.print();
			return false;
		});	
		
        //Show dialog
        $(document).on('click', '#main-private-office .to-open-dialog', function () {
            var lot = $(this).data('lot');
            var user = $(this).data('user');
            
            $.ajax({
                url: '/query/messagestolot/' + lot + '/' + user ,
                dataType: "html",
                success: function (data) {
                    $('#dialog-holder').html(data);
                } 
            });
            
            $('.table-my-messages .table-section').hide();
        });
        
        //Show dialog from user to athour
        $(document).on('click', '#main-private-office .to-open-dialog-toauthor', function () {
      
            var user = $(this).data('user');
            
            $.ajax({
                url: '/query/messagestoauthor/'+ user ,
                dataType: "html",
                success: function (data) {
                    $('#dialog-holder').html(data);
                } 
            });
            
            $('.table-my-messages .table-section').hide();
        });
        
        //Show open-blog
        $('#blog .article-title, #blog .read-more, #blog .read-article').click( function () {
            var href = $(this).attr('href');
            $(".blogindex").load( href + ' .blogindex > *');
            window.history.pushState('', '', href);
            //$(".blog-content").append("<link media='all' rel='stylesheet' href='/assets/css/social-likes_classic.css'>  <script src='/assets/js/jquery-1.11.2.min.js'></script> <script src='/assets/js/jquery.rateit.min.js'></script>  <script src='/assets/js/social-likes.min.js'></script>")
            
            return false;
        });
    
        //Transition on blog navigation > .rubrics-links
        $('.rubrics-links .rubriclink').click( function () {
            var href = $(this).attr('href');
            $(".blog-content-holder").load( href + ' .all-articles > *');
            window.history.pushState('', '', href);
            
            return false;
        });
            
        //Pritn some div (method 1)
        $('.print-btn').click( function () {
            $('body').find('#header, #footer, .back-nav-holder').hide();
            window.print();
            $('body').find('#header, #footer, .back-nav-holder').show();
            
            return false;
        });
       
       //Toggle .reviews-container and .goods-container
        $('.reviews-goods-container .orders-btn').click( function () {
            $('.reviews-goods-container .buttons-row .orders-btn').addClass('active');
            $('.reviews-goods-container .buttons-row .reviews-btn').removeClass('active');
            $('#main-user-profile .reviews-container').hide();
            $('#main-user-profile .goods-container').show();
        });
        $('.reviews-goods-container .reviews-btn').click( function () {
            $('.reviews-goods-container .buttons-row .reviews-btn').addClass('active');
            $('.reviews-goods-container .buttons-row .orders-btn').removeClass('active');
            $('#main-user-profile .goods-container').hide();
            $('#main-user-profile .reviews-container').show();
        });
        
        // Counter symbols
        $('#textField').keyup( function () {
            var box = $(this).val();
            var count = 500 - box.length;

            if (box.length <= 500) {
                $('#count').html(count);
            } else {
                text = box.slice(0,500); 
                $("#textField").val(text);
            };
            return false;
        });
        $('#textField_bus').keyup( function () {
            var box = $(this).val();
            var count = 500 - box.length;

            if (box.length <= 500) {
                $('#count_bus').html(count);
            } else {
                text = box.slice(0,500); 
                $("#textField_bus").val(text);
            };
            return false;
        });
        
        //Sorting elements through select on the privat-office page => messages
        $(document).on('change', '.sorting-for-messages .lots_select', function(){
            var val = $(this).find('option:selected').prop('value');
            switch( $(this).val() ) {
                case "0":
                    $('.table-my-messages .table').find('.lotrow').show();
                break;

                case val:
                    $('.table-my-messages .table').find('.lotrow').hide();
                    $('.table-my-messages .lotrow#' + val).show();
                break;
            };
        }); 
        
        /** Switch beetwen 'inbox', 'outbox' and 'archive' messages 
        on the privat-office page => messages (MOBILE VERSION)**/
        $(document).on('change', '.sorting-for-messages .messages-type', function(){
            var val = $(this).val;
            switch( $(this).val() ) {
                case "0":
                    $('.table-section').find('.table').removeClass('_active');
                    $('.table-section .table-incoming-messages').addClass('_active');
                    $('.lots_select').css('display', 'block');
                    $('.table-my-messages .sorting-for-messages').css({minHeight: '82px', marginBottom: '19px'});
                break;

                case "1":
                    $('.table-section').find('.table').removeClass('_active');
                    $('.table-section .table-outgoing-messages').addClass('_active');
                    $('.lots_select').css('display', 'none');
                    $('.table-my-messages .sorting-for-messages').css({minHeight: '46px', marginBottom: '5px'});
                break;
                    
                case "2":
                    $('.table-section').find('.table').removeClass('_active');
                    $('.table-section .table-archive-messages').addClass('_active');
                    $('.lots_select').css('display', 'none');
                    $('.table-my-messages .sorting-for-messages').css({minHeight: '46px', marginBottom: '5px'});
                break;
            };
        });
    
        //Sorting elements through select on the myprofile page => my-orders
        $(document).on('change', '.sorting-orders .selectpicker', function(){
            var val = $(this).find('option:selected').prop('value');
            switch( $(this).val() ) {
                case "new":
                    $('.private-office-content #tab1').removeClass('last');
                break;

                case "last":
                    $('.private-office-content #tab1').addClass('last');
                break;
            };
        });
    

        //Switching between BUSINESS and PRIVATE person on the privat-office page => settings
        $(document).on('change', '.user_type .business_private ', function(){
            switch( $(this).val() ) {
                case '0':
                    $('.edit-ad-content').removeClass('private');
                    break;
                case '1':
                    $('.edit-ad-content').addClass('private');
                    break;
            };
        });
    
        //Switching between BUSINESS and PRIVATE person on the add-lot page and edit-lot page
        $(document).on('change', '.select-privat-business', function(){
            switch( $(this).val() ) {
                case '2':
                    $('.settings-holder').removeClass('business');
                    break;
                case '3':
                    $('.settings-holder').addClass('business');
                    break;
            };
        });
        
        //#BLOG: Toggle .interesting-articles, .all-articles and .best-articles
        $('#blog .intresting-art').click( function() {
            $('#blog .switches-block .btn').removeClass('active');
            $(this).addClass('active');
            $('#blog .articles-list').removeClass('active');
            $('#blog .interesting-articles').addClass('active');
        });
        $('#blog .all-art').click( function() {
            $('#blog .switches-block .btn').removeClass('active');
            $(this).addClass('active');
            $('#blog .articles-list').removeClass('active');
            $('#blog .all-articles').addClass('active');
        });
        $('#blog .best-art').click( function() {
            $('#blog .switches-block .btn').removeClass('active');
            $(this).addClass('active');
            $('#blog .articles-list').removeClass('active');
            $('#blog .best-articles').addClass('active');
        });
        
        //Аякс запрос на изменение статуса лота с активного на деактивированый
        $('.ordered-product .description .deactivate').click(function(){
            var lot = $(this).data('lot');
            $.ajax({
                url:'/lot/posttype/'+ lot ,
                type: 'POST',
                data: lot,
                success: function(data) {
                    window.location.href='/myprofile?tab2';
                }
            });
        })
        
        //По умолчанию деактивированые лоты скрыты
        $('.lot-hide-1').hide();
        
        //Отображение или скрывание деактивированых лотов
        $('.show-deactivated').click(function(){
            console.log($('.deactivated-controll').prop);
            if($('.deactivated-controll').prop('checked') == true){
                $('.lot-hide-1').show();            
            }
            if($('.deactivated-controll').prop('checked') == false){
                $('.lot-hide-1').hide();            
            }
        });
               
        // Append map insert modal window #modalmapUserProf on the user-profile page
        $('.link-user-map-holder .show-user-map').click( function () {
            $('#modalmapUserProf .modal-body').append("<script> var citymap = { kiev: {center: {lat: 50.4016974, lng: 30.2518283}, population: 100}}; function initMap() { var map = new google.maps.Map(document.getElementById('mapUserProf'), {zoom: 13, scrollwheel: false, center: {lat: 50.4016974, lng: 30.2518283}, mapTypeId: google.maps.MapTypeId.TERRAIN}); for (var city in citymap) { var cityCircle = new google.maps.Circle({strokeColor: '#FF0000', strokeOpacity: 0.8, strokeWeight: 2, fillColor: '#FF0000', fillOpacity: 0.35, map: map, center: citymap[city].center, radius: Math.sqrt(citymap[city].population) * 100}); } } </script>    <script async defer src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDpONh6QjiiZyV7Emi4nsSB7KJFApSbkzM&signed_in=true&callback=initMap'></script>")
        });
        
        // $('.add-filters-section select').change(function(){ 
            // console.log($(this).find('option:selected').val());
            // if($(this).find('option:selected').val() != ''){
                // constructUrl(this);
            // }
        // });
        
        // $('.price-filters input').change(function(){
            // constructFiltersString($(this).parents('.price-filters'));
        // });
        
        //Button for cleaning input field
        $('.search-input').keypress( function () {
            $(this).next('.clear-input').css('display', 'inline-block');
            $(this).css('box-shadow', '0 0 0 2px #fa5400');
        });
        $('.clear-input').click( function () {
            $(this).prev('.search-input').val('');
            $(this).prev('.search-input').css('box-shadow', 'none');
            if( $(this).prev('.search-input').val('') ) {
                $(this).css('display', 'none');
            }
        });
        //Button for cleaning all form's fields (inputs, checkboxes)
        $('#cleanBtn').click( function () {
            $('.search-input').val('');
            $('#selecter').val('');
            $('.find-section input[type=checkbox]').prop('checked', false);
            $('.clear-input').css('display', 'none');
            $('.search-input').css('box-shadow', 'none');
        });
        
        //Append .bottom-div-marker under datepicker
        $('#datepicker, #datepicker2, #datepicker3, #datepicker4, #ui-datepicker-div').bind('click', function() {
            if ( $('.bottom-div-marker').length < 1 ) {
                $('#ui-datepicker-div').append("<div class='bottom-div-marker'><span></span> Аренда недоступна</div>");
            } else {
                return false;
            };
        }); 
        
        if ($(".add-image").length) {
        	var dropZone = $('#avatar'),
			maxFileSize = 1000000;
			if (typeof(window.FileReader) == 'undefined') {
			    //$(".addphotos").html('<div class="bb">Не поддерживается браузером!</div>');
			    $(".add-image").addClass('errorfile');
			}
			dropZone[0].ondragover = function() {
			    $(".add-image").addClass('drag');
			    return false;
			};
			    
			dropZone[0].ondragleave = function() {
			    $(".add-image").removeClass('drag');
			    return false;
			};
	        
	        $(".add-image .input-holder p").on('click', function(){
				$("#avatar").click();
				return false;
			});
			
			$("#avatar").on('change', function(){
				var files = this.files;
				var fd = new FormData();
				fd.append('userfile', files[0]);
				$(".add-image").removeClass('drag');
				var xhr = new XMLHttpRequest();        
			    xhr.upload.addEventListener("progress", uploadProgress, false);
			    xhr.addEventListener("load", uploadComplete, false);
			    xhr.addEventListener("error", uploadFailed, false);
			    xhr.addEventListener("abort", uploadCanceled, false);
			    
			    xhr.open("POST", "/myprofile/uploadphoto?r="+Math.random(), true);
			    xhr.send(fd);
			});
			
			function uploadProgress(event){
			   var percentComplete = Math.round(event.loaded * 100 / event.total);
			   console.log("Upload "+percentComplete);
			}
			function uploadCanceled(event) {
			    console.log("Upload canceled.");
			}
			function uploadFailed(event) {
			    console.log("Upload failed.");
			}
			function uploadComplete(event) {
				var res = event.target.responseText;
				$(".img_avatar").attr('style', 'background-image: url('+res+');  background-size: cover;');
				$(".delete").attr('rel', res);
				$(".inp_avatar").val(res);
			}
			
	        $('.delete').on('click', function(){
	        	var rel = $(this).attr('rel');
	        	$.ajax({
	                url: '/myprofile/deleteavatar',
	                type: 'POST',
	                data: 'img='+rel,
	                cache: false,
	                dataType: 'json',
	                success: function (data) {
	                    console.log(data);
	                    $(".img_avatar").attr('style', 'background-image: url(/assets/images/photo.jpg); background-size: cover;');
	                    $(".delete").attr('rel', '');
	                    $(".inp_avatar").val('');
	                    
	                },
	                error: function(xhr, ajaxOptions, thrownError) {
			       		console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
	            });
	        	
	        	return false;
	        });
        };
    
        $('.save_info').on('click', function(){
        	var settingsdata = $(this).closest('form').serialize();
        	console.log(settingsdata);
        	$.ajax({
                url: '/myprofile/editinfo',
                type: 'POST',
                data: settingsdata,
                cache: false,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if (data.user==true && data.map==true) {
                    	$('.about-yourself .success-change').fadeIn(0.1);
                        setTimeout( function() {
                            $('.about-yourself .success-change').fadeOut(0.1);
                        }, 2000);
                    } else {
                    	//$('html, body').animate({scrollTop:$('.content-holder').position().top}, 500);
                        $('.about-yourself .error-change').fadeIn(0.1);
                        setTimeout( function() {
                            $('.about-yourself .error-change').fadeOut(0.1);
                        }, 2000);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
		       		console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
            });
        	return false;
        });
        
    
        //Showing .subcategory-list at the EDIT-PAGE
        $('.edit-choice-rubric:not(.sub)').click( function() {
           $('.parentcats.choice-rubric-menu').fadeIn();
        });
        $('.parentcats.choice-rubric-menu .overlay').click( function() {
            $('.parentcats.choice-rubric-menu').fadeOut(0.5);
            $('.subcategory-list').fadeOut(0.5);
        });
        $('.parentcats.choice-rubric-menu .lnk-categ').click( function() {
            $('.parentcats.choice-rubric-menu #nav > li').removeClass('opened');
            $('.parentcats.choice-rubric-menu #nav > li').not( $(this).parent() ).removeClass('active');
            $(this).parent().toggleClass('active');
            $('#header-nav').find('.subcategory-list').fadeOut(0.5);
            $('#header-nav .subcategory-list').fadeIn(0.5);
        });
        $('.subcategory-list li a').click( function() {
            $('.parentcats.choice-rubric-menu').fadeOut(0.5);
            $('.subcategory-list').fadeOut(0.5);
        });
        $('.subcategory-list .to-back').click( function() {
            $('.subcategory-list').fadeOut(0.5);
        });
    
        
        
        $('.edit-choice-rubric.sub').click( function() {
           $('.childcats.choice-rubric-menu').fadeIn();
        });
        $('.childcats.choice-rubric-menu .overlay').click( function() {
            $('.childcats.choice-rubric-menu').fadeOut(0.5);
        });
        $('.choice-rubric-menu .lnk-categ').click( function() {
            $('.childcats.choice-rubric-menu #nav > li').removeClass('opened');
            $('.childcats.choice-rubric-menu #nav > li').not( $(this).parent() ).removeClass('active');
            $(this).parent().toggleClass('active');
            
        });
        
        
    
        //Modal window '.modal-del .delete-review'
        $('.avatar .del-avatar').click(function(){
           $('.avatar .delete-avatar').fadeIn();
        });
        $('.delete-avatar .closer, .delete-avatar .ok,  .delete-avatar .cancel, .overlay').click(function(){
           $('.avatar .delete-avatar').fadeOut();
        });
        $(window).scroll( function() {
           $('.avatar .delete-avatar').fadeOut(0.1);
        });
    
    	
    	// $("#filter_submit").on('click', function(){
    		// var form = $('.filter_form').serialize();
    		// var url = window.location.hostname+window.location.pathname;
    		// console.log(url);
    		// $.ajax({
                // url: url,
                // dataType: "json",
                // success: function (json) {
//                 	
                    // console.log(json);
                // } 
            // });
    		// return false;
//     		
    	// }); 
    	
    	$("#cleanBtn").on('click', function(){
    		$('.filter_form').clear;
    		return false;
    		
    	});
    	
        $('.description a.deactivate').on('click', function () {
    		var deact = $(this);
    		deact.html('Подождите...');
            $.ajax({
                url: deact.attr('href'),
                dataType: "json",
                success: function (json) {
                	deact.removeClass('deactivate');
                	deact.addClass('activate');
                	deact.html('Активировать');
                	
                    console.log(json);
                } 
            });
            return false;
        });
    	
    	$('.description a.activate').on('click', function () {
    		var act = $(this);
    		act.html('Подождите...');
            $.ajax({
                url: act.attr('href'),
                dataType: "json",
                success: function (json) {
                	act.removeClass('activate');
                	act.addClass('deactivate');
                	act.html('Дективировать');
                    console.log(json);
                } 
            });
            return false;
        });
    	
    	$(document).on('focus', "#selecter", function(){
    		$(".regions").fadeIn();
    	});
    	$(document).on('mouseleave', ".filter_form", function(){
    		if (!$("#selecter").is(":focus")) {
    			$(".regions").fadeOut();
    		}
    	});
    	$(document).on('keyup', "#selecter", function(e){
    		$(this).blur();
    		if (e.keyCode === 27) $(".regions").fadeOut();
    		return false;
    	});
    	
    	$(".all_u").on('click', function(){
    		$("#city").val(0);
    		$("#reg").val(0);
    		$("#selecter").val('Вся Украина');
    		$(".regions").fadeOut();
    		return false;
    	})
    	
    	$(".city_id").on('click', function(){
    		$(".loads").fadeIn();
    		var city_id = $(this).attr('rel');
    		$("#selecter").val($(this).text());
    		$("#reg").val(city_id);
    		var html = '';
    		$.getJSON('http://' + document.location.hostname + '/query/getcitiesbyregionid/'+city_id, '', function (city_list) {
				html += '<ul class="column">';
				$.each(city_list, function (k, v) {
					//console.log(v);
					if (parseInt(v.center)>0) {
						var name = '<b>'+v.name+'</b>';
					} else {
						var name = v.name;
					}
					html += '<li><a href="#" class="city" rel="' + v.id + '">' +name+ '</a></li>';
					if ((k+1)%7==0) {
						html += '</ul><ul class="column">';
					}
		        });
		        html += '</ul>';
		        $(".cities_list").html(html);
		        $(".reg_list").fadeOut();
		        $(".cities_list").fadeIn();
		        $(".all_u").fadeOut();
		        $(".another_c, .all_c").fadeIn();
		        
		        $(".loads").fadeOut();
		    });
		    return false;
	    });
    	$(".another_c").on('click', function(){
    		$("#selecter").val('');
    		$(".cities_list").fadeOut();
		    $(".reg_list").fadeIn();
		    $(".another_c, .all_c").fadeOut();
		    $(".all_u").fadeIn();
		    $("#city").val(0);
		    $("#reg").val(0);
		    return false;
	    });
    	
    	$(".all_c").on('click', function(){
    		$("#city").val(0);
    		$(".regions").fadeOut();
    		return false;
    	});
    	
    	$(document).on('click', '.city', function(){
    		$("#city").val($(this).attr('rel'));
    		$("#selecter").val($(this).text());
    		$(".regions").fadeOut();
    		return false;
    	});
    	
    	if (parseInt($("#id_category").val())>0) {
    		var lot_id = 0;
    		var html = '';
    		var $this = $("#id_category");
    		lot_id = $('.lot_id').val();

					    
    		$.getJSON('http://' + document.location.hostname + '/query/getattrbycatIdInputs/'+$this.val()+'/'+lot_id, '', function (attrs) {
    			console.log('attrs',attrs);
				$.each(attrs, function (k, attr) {
					html += '<div class="block block-select block-input required">';
					if (attr.type=='dynamic') {
						html += '<strong>'+attr.title+'</strong>';
						html += '<label> <input name="form[attr][dynamic]['+attr.id+']" type="text" class="form-control" value='+attr.values[0].dynamic_attribute_value+'> <b></b> </label>';
					}

					html += '</div>';
		        });
		        $(".characteristics").html(html);
		    });

    		$.getJSON('http://' + document.location.hostname + '/query/getattrbycatId/'+$this.val()+'/'+lot_id, '', function (attrs) {
				
				$.each(attrs, function (k, attr) {
					html += '<div class="block block-select block-input required">';

					if (attr.type=='static') {
						
						html += '<strong>'+attr.title+'</strong>';
						html += '<select name="form[attr][static]['+attr.id+']" class="selectpicker">';
						
						$.each(attr.values, function (val, v) {
							var selected_id = attr.values[0].id_static_attribute_value;
							
							var selected = '';
							
							if(parseInt(v.id) === parseInt(selected_id)){selected="selected";}
							
							if(!v.id_static_attribute_value){

								html += '<option '+selected+' value="'+v.id+'">'+v.value+'</option>';
							}
						});
						html += '</select>';
					}
					
					if (attr.untis) {
						html += '<span class="marker">'+attr.untis+'</span>';
					}
					html += '</div>';
		        });
		        $(".characteristics").html(html);
		        $('.selectpicker').selectpicker();
		    });

    	}
    	
    	$(document).on('click', '.selectcat', function(){
    		$("#id_category").val($(this).attr('rel'));
    		$("#selectedcat").html('<b>'+$(this).text()+'</b>');
    		$(".close").click();
    		var lot_id = 0;
    		lot_id = $('.lot_id').val();
    		var $this = $("#id_category");
    		//console.log(lot_id)
    		var html = '';
    		
    		
    		$.getJSON('http://' + document.location.hostname + '/query/getattrbycatIdInputs/'+$this.val()+'/'+lot_id, '', function (attrs) {
    			console.log('attrs',attrs);
				$.each(attrs, function (k, attr) {
					html += '<div class="block block-select block-input required">';
					if (attr.type=='dynamic') {
						html += '<strong>'+attr.title+'</strong>';
						html += '<label> <input name="form[attr][dynamic]['+attr.id+']" type="text" class="form-control" value='+attr.values[0].dynamic_attribute_value+'> <b></b> </label>';
					}

					html += '</div>';
		        });
		        $(".characteristics").html(html);
		    });
    		
    		
    		$.getJSON('http://' + document.location.hostname + '/query/getattrbycatIdInputs/'+$this.val()+'/'+lot_id, '', function (attrs) {
				console.log('attrs2',attrs);
				$.each(attrs, function (k, attr) {
					html += '<div class="block block-select block-input required">';
					html += '<strong>'+attr.title+'</strong>';
					if (attr.type=='static') {
						html += '<select name="form[attr][static]['+attr.id+']" class="selectpicker">';
						console.log(attr)
						$.each(attr.values, function (val, v) {
							html += '<option value="'+v.id+'">'+v.value+'</option>';
						});
						html += '</select>';
					} else {
						html += '<label> <input name="form[attr][dynamic]['+attr.id+']" type="text" required class="form-control"> <b></b> </label>';
					}
					if (attr.untis) {
						html += '<span class="marker">'+attr.untis+'</span>';
					}
					html += '</div>';
		        });
		        $(".characteristics").html(html);
		        $('.selectpicker').selectpicker();
		    });
    		return false;
    	});
    	
    	$(document).on('click', '#regbutton', function(){
    		console.log($("#regform").serialize());
    		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    		if ($("#emailr").val()=='') {
    			$(".error_reg").html('Введите свой E-mail');
    			$(".error_reg").css('top', '20px');
	            $(".error_reg").fadeIn();
    		} else if (!regex.test($("#emailr").val())) {
    			$(".error_reg").html('Введите правильный E-mail');
    			$(".error_reg").css('top', '20px');
	            $(".error_reg").fadeIn();
    		} else if ($("#passr").val()=='') {
    			$(".error_reg").html('Введите пароль');
    			$(".error_reg").css('top', '95px');
	            $(".error_reg").fadeIn();
    		} else if ($("#passcheckr").val()=='') {
    			$(".error_reg").html('Повторите пароль');
    			$(".error_reg").css('top', '170px');
	            $(".error_reg").fadeIn();
    		} else if ($("#passr").val()!=$("#passcheckr").val()) {
    			$(".error_reg").html('Пароли не совпадают');
    			$(".error_reg").css('top', '170px');
	            $(".error_reg").fadeIn();
    		} else if ($('#termsr:checked').length==0) {
    			$(".error_reg").html('Вы должны принять правила использования сервиса');
    			$(".error_reg").css('top', '222px');
	            $(".error_reg").fadeIn();
    		} else {
    			$.ajax({
		            url: '/query/reg',
		            method: "POST",
		            dataType: "json",
		            data: $("#regform").serialize(),
		            success:function(data){
		            	console.log(data);
		            	if (data.res==true) {
		            		console.log(1);
		            		location = '/register/success';
		            	} else {
		            		console.log(2);
		            		$(".error_reg").html(data.text);
		            		$(".error_reg").css('top', '20px');
		            		$(".error_reg").fadeIn();
		            	}
		            },
		            error:function(data){
		            	console.log(data);
		            }
		        });
    		}
    		
    		return false;
    	});
    	$(document).on('click', '.error_reg', function(){
    		$(".error_reg").fadeOut();
    		$(".error_reg").html('');
    		$(".error_reg").removeAttr('style');
    	});
    	
    	
    	$(document).on('click', '.lot_type a', function(){
    		$(".lot_type a").removeClass('act');
    		$(this).addClass('act')
    		$(".lot_type input").val($(this).attr('rel'));
    		$("#filter_submit").click();
    		return false;
    	});
    
    function savePhones(){
        var temp='';
        $('.phone-numbers input.additional-number').each(function(index,e){
            var str = $(this).val();
            if(index===0){name = 'phone';}else{name = 'phone' + index;}
            if(str !==''){
                temp += name+':'+str+',';
            }
        });

        $('.phone-numbers input.phones').attr('value',temp);
    }

    $(document).on("keyup", ".phone-numbers input", function() {
        savePhones();
    });

    //Add new number field
    $('.phone-numbers .add-number-field').click( function () {
        if ($('.phone-numbers .inputs-holder .item').length <= 4){
            var i = $('.phone-numbers .inputs-holder .item').length;
        $('.phone-numbers .inputs-holder').append("<div class='item'> <i>+38</i><input type='text' name='form[phone" + i + "]' class='form-control additional-number'>   </div>");
        $(".additional-number").mask("(999) 999-9999");
        savePhones();
        } else{
            $(this).hide();                
        }
    });
    //Add new number field
    $('.phone-numbers .add-number-field-640px').click( function () {
        if ($('.phone-numbers .inputs-holder-640px .item').length <= 4) {
            var i = $('.phone-numbers .inputs-holder-640px .item').length;
        $('.phone-numbers .inputs-holder-640px').append("<div class='item'> <i>+38</i><input type='text' name='form[phone" + i + "]' class='form-control additional-number'>   </div>");
        $(".additional-number").mask("(999) 999-9999");
        savePhones();
        } else {
            $(this).hide();
        }
    });
    //Validate 'telofon' field
        $(".additional-number").mask("(999) 999-9999");
        
    //Transfer to the page with ancor #tab 
    if(window.location.search !== ''){
        $('a[href="' + window.location.search.replace('?', '#') + '"]').tab('show');
    }
    
    /*
     * description: Saves files into server, ajax handler
     * author: lhornet
     * date: 27.04.2016
     */
    if ($('.addpost-upload-image input[type=file]').length) {
    	
	    var dropZone = $('.addpost-upload-image input[type=file]'),
	            maxFileSize = 1000000;
	    if (typeof (window.FileReader) == 'undefined') {
	        $(".addpost-upload-image").html('<div class="bb">Не поддерживается браузером!</div>');
	        $(".addpost-upload-image").addClass('errorfile');
	    }
	    dropZone[0].ondragover = function () {
	        $(".addpost-upload-image").addClass('phloadhover');
	        return false;
	    };
	
	    dropZone[0].ondragleave = function () {
	        $(".addpost-upload-image").removeClass('phloadhover');
	        return false;
	    };
	    $('.addpost-upload-image input[type=file]').ondrop = function (event) {
	        event.preventDefault();
	        $(".addpost-upload-image").removeClass('phloadhover');
	    };
	
	    $(".addpost-upload-image").on('click', function () {
	        $(".addpost-upload-image input[type=file]").click();
	        return false;
	    });
	    
	    //Status photos
	    $(".addpost-upload-image input[type=file]").change(function(){
			var field_name = $(this).attr('name');
	        $('.progress-img-class').val(field_name);
			var lot_url = $('.lot-url').val();
	
			var file = this;
	        console.log(file.name)
	
	
	        var fd = new FormData();
	        fd.append(file.name, file.files[0]);
	
			var xhr = new XMLHttpRequest();        
		    xhr.upload.addEventListener("progress", uploadProgress, false);
		    xhr.addEventListener("load", uploadComplete, false);
		    xhr.addEventListener("error", uploadFailed, false);
		    xhr.addEventListener("abort", uploadCanceled, false);
		    
		    xhr.open("POST", "/lot/addajaximages/"+lot_url+"?r="+Math.random(), true);
	
		    xhr.send(fd);
	
		});
		//Delete images from lot
	    $(document).on("click", ".delete_img", function() {
	
	    	var 
	            $this = $(this),
	            img = $this.attr('rel'),
	            lot_url = $('.lot-url').val(),
	            url = "/lot/delajaximages/"+lot_url,
	        	id = $this.attr('id');
	
	    	$("input."+id).val('');
	        $("img."+id).attr('src', '/assets/images/load.gif');
	
	        $.ajax({
	            url: url,
	            method: "POST",
	            data: {filename:img},
	            success:function(data){$("img."+id).attr('src', '/assets/images/addphoto.png');},
	            error:function(data){console.log('err')}
	        });
	
	        return false;
	    });
	
	    //functions upload photos
	    function uploadProgress(event) {
	        var 
	        progress_id = $('.progress-img-class').val(),
	        percentComplete = Math.round(event.loaded * 100 / event.total),
	        load = $('.loading.'+progress_id);
	        $(load).show();
	        $(".loading."+progress_id+" .percent").css('width',percentComplete+"%");
	    }
	
	    function uploadCanceled(event) {
	        console.log("Upload canceled.");
	    }
	    function uploadFailed(event) {
	        console.log("Upload failed.");
	    }
	    function uploadComplete(event) {
	        var 
	            res = event.target.responseText,
	            name = jQuery.parseJSON(res),
	            str = name.img,
	            classname = str.split(".");
	
	        $('.addpost-upload-image img.'+classname[0]).attr("src","/uploads/lot/"+name.path+"/"+name.img);
	        $('.addpost-upload-image #'+classname[0]).attr('rel',name.img);
	        $('.addpost-upload-image input[type=hidden].'+classname[0]).attr('value',name.img);
	        $('.loading.'+classname[0]).hide();
	        $('.progress-img-class').val('');
	    }
	    
	}
	
	/*save booking form*/
	$('.booking_save').attr('disabled','disabled');
	
	$('.booking_form').on('submit', function(e){

		var text = $('.message_text').val();
		var data = $(this).serialize();
		
		if(text !== ''){
	        $.ajax({
	            url: '/booking/savebooking/',
	            method: "POST",
	            data: data,
	            success:function(data){console.log('success',data);$('.message_text').val('');},
	            error:function(data){console.log('error',data);}
	        });
        }else{
        	$('.booking_save').attr('disabled','disabled');
        }
       
        return false;
	});

	$('.message_text').keyup(function(){
		var text = $(this).val();
		if(text !== ''){
	        $('.booking_save').removeAttr('disabled','disabled');
        }else{
        	$('.booking_save').attr('disabled','disabled');
        }
	});

	//Отправить сообщение автору
	var holder = $('#writeToAuthor form').html();

	$('#writeToAuthor form').on('submit', function(e){
		
		var 
			text = $('#writeToAuthor form textarea').val(),
			that = $(this),
			lot_url = that.attr('data-form');
			data = $(this).serialize();
		
		if(text !== ''){
	        $.ajax({
	            url: "/lot/leavemessage/"+lot_url,
	            method: "POST",
	            data: data,
	           	success:function(data){
	            	that.html('Ваше сообщение отправлено');
	            	return false;
	            },
	            error:function(xhr, ajaxOptions, thrownError){
	            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	            }
	        });
        }
       
        return false;
	});
	
	$(document).on("click", ".select_cat a", function() {
		var cat = this.id;
		$.ajax({
		  dataType: "json",
		  url: 'http://' + document.location.hostname + '/query/getsubcat/'+cat,
		  data: cat,
		  success: function (chcats) {
				html = '<li><button type="button" class="to-back">Назад</button></li>';
				$.each(chcats, function (k, chcat) {
					//console.log(chcat);
					html += '<li class="select_subcat"><a href="javascript: void(0)" id="'+chcat.id+'">'+chcat.title+'</a></li>';
				});
				$(".subcategory-list").html(html);
              
                $('.subcategory-list .to-back').click( function() {
                    $('.subcategory-list').fadeOut(0.5);
                });
			},
			error:function(xhr, ajaxOptions, thrownError){
            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
		});
		return false;
	});
	
	$(document).on("click", ".select_subcat a", function() {
		$(".edit-choice-rubric.sub").html(' Подкатегория... <span class="caret"></span>');
		$(".rubric .rubric-nav:after").fadeOut();
		var chcts='';
		var cat = this.id;
		$.ajax({
		  dataType: "json",
		  url: 'http://' + document.location.hostname + '/query/getsubcat/'+cat,
		  data: cat,
		  success: function (chcts) {
		  	var chct='';
		  	if (chcts.length!==0) {
		  		var html = '';
				$.each(chcts, function (k, chct) {
					html += '<li class="selectsub_cat">';
                    html += '<a href="javascript: void(0)" class="lnk-categ lnk-1" id="'+chct.id+'"><i>'+chct.title+'</i></a>';
                    html += '</li>';
				});
				$.getJSON('http://' + document.location.hostname + '/query/getbreadcrumbs/'+cat, '', function (bc) {
					$(".edit-choice-rubric:not(.sub)").html(bc+' <span class="caret"></span>');
				});
				$('.subcats_list').show();
		  		$('.grand_childs_cats').html(html);
		  		$('.parentcats.choice-rubric-menu').hide();
		  	} else {
		  		$(".subcats_list").fadeOut();
		  		var html ='';
		  		
		  		$.getJSON('http://' + document.location.hostname + '/query/getattrbycatIdInputs/'+cat+'/0', '', function (attrs) {
					$.each(attrs, function (k, attr) {
						html += '<div class="block block-select block-input required">';
						if (attr.type=='dynamic') {
							html += '<strong>'+attr.title+'</strong>';
							html += '<label> <input name="form[attr][dynamic]['+attr.id+']" type="text" class="form-control" value=""> <b></b> </label>';
						}
	
						html += '</div>';
			        });
			        $(".characteristics").html(html);
			    });
		  		
				$.getJSON('http://' + document.location.hostname + '/query/getattrbycatId/'+cat, '', function (attrs) {
					console.log('http://' + document.location.hostname + '/query/getattrbycatId/'+cat)
					$.each(attrs, function (k, attr) {
						console.log(attr)
						html += '<div class="block block-select block-input required">';
						html += '<strong>'+attr.title+'</strong>';
						if (attr.type=='static') {
							html += '<select name="form[attr][static]['+attr.id+']" class="selectpicker">';
							$.each(attr.values, function (val, v) {
								html += '<option value="'+v.id+'">'+v.value+'</option>';
							});
							html += '</select>';
						} else {
							html += '<input type="text" name="form[attr][dynamic]['+attr.id+']" class="form-control" />';
						}
						if (attr.untis) {
							html += '<span class="marker">'+attr.untis+'</span>';
						}
						html += '</div>';
				    });
				    $.getJSON('http://' + document.location.hostname + '/query/getbreadcrumbs/'+cat, '', function (bc) {
				    	$(".edit-choice-rubric:not(.sub)").html(bc+' <span class="caret"></span>');
				    	$(".rubric .rubric-nav:after").fadeIn();
				    });
				    $("#id_category").val(cat);
				    $(".characteristics").html(html);
				    setTimeout(function(){
				    	$('.selectpicker').selectpicker('refresh');
				    },200);
				});
		  		$('.choice-rubric-menu').removeAttr('style');
		  	}
			
		  },
		  error:function(xhr, ajaxOptions, thrownError){
           	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
		});
	});
	
	$(document).on('click', 'li.selectsub_cat a', function(){
		$(".edit-choice-rubric.sub").html(' Подкатегория... <span class="caret"></span>');
		var cat = $(this).attr('id');
		var html ='';
		
		$.getJSON('http://' + document.location.hostname + '/query/getattrbycatIdInputs/'+cat+'/0', '', function (attrs) {
			$.each(attrs, function (k, attr) {
				html += '<div class="block block-select block-input required">';
				if (attr.type=='dynamic') {
					html += '<strong>'+attr.title+'</strong>';
					html += '<label> <input name="form[attr][dynamic]['+attr.id+']" type="text" class="form-control" value=""> <b>'+attr.untis+'</b> </label>';
				}
		
				html += '</div>';
		    });
		    //$(".characteristics").html(html);
		});
		
		$.getJSON('http://' + document.location.hostname + '/query/getattrbycatId/'+cat, '', function (attrs) {
			console.log(attrs);
			$.each(attrs, function (k, attr) {
				console.log(attr);
				html += '<div class="block block-select block-input required">';
				html += '<strong>'+attr.title+'</strong>';
				if (attr.type=='static') {
					
					html += '<select name="form[attr][static]['+attr.id+']" class="selectpicker">';
					
					$.each(attr.values, function (val, v) {
						html += '<option value="'+v.id+'">'+v.value+'</option>';
					});
					html += '</select>';
				} else {
					//console.log(attr);
					html += '<input type="text" name="form[attr][dynamic]['+attr.id+']" class="form-control" />';
				}
				
				if (attr.untis) {
					html += '<span class="marker">'+attr.untis+'</span>';
				}
				html += '</div>';
		    });
		    $.getJSON('http://' + document.location.hostname + '/query/getbreadcrumbsonlyone/'+cat, '', function (bc) {
		    	$(".edit-choice-rubric.sub").html(bc+' <span class="caret"></span>');
		    	$(".rubric .rubric-nav:after").fadeIn();
		    });
		    $("#id_category").val(cat);
		    $(".characteristics").html(html).promise().done(function(){
			    $('.selectpicker').selectpicker();
			});
		    
		    $('.childcats.choice-rubric-menu').hide();
		});
		
	});
	
	var $modal = $('#writeToAuthor');
	$modal.on('hide.bs.modal', function () {
		$('#writeToAuthor form').hide();
		function f(){$('#writeToAuthor form').html(holder).show();}
		setTimeout( function() { f() } , 1500);
	});
	
	$(document).on("click", ".add-review .rateit .rateit-range", function() {
		$("input[name='review[vote]']").val($(this).attr('aria-valuenow'));
		$("input[name='review[title]']").focus();
		return false;
	});
	
	$(document).on("click", "#addreview:not(.sended)", function() {
		if ($("#textcomment").val()!='') {
			
			if ($("#votelotvalue").val()>0) {
				$.ajax({
		            url: '/lot/addreview',
		            method: "POST",
		            data: $("#addreviewform").serialize(),
		            success:function(data){
						console.log(data);
						$('.reviews').load(document.location+' .reviews > *');
		            	$(".savehide").fadeOut(300, function(){
		            		$(".savehide").animate({height:"0px"}, 500, function(){
			            		$("#addreview").addClass('sended');
			            		$("#addreview").val('Ваш отзыв отправлен');
			            	});
		            	});
		
		            },
		            error:function(xhr, ajaxOptions, thrownError){
		            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		            }
		        });
			} else {
				$("span.not_voted").show();
			}
			
			
		}
		
        return false;
    });
    $(document).on("click", "#addreviewlog, #userreviewlog", function() {
    	return false;
    });
    
    
    $(document).on("click", "#userreview:not(.sended)", function() {
    	$(".not_voted").hide();
    	if ($("#review_vote").val()>0) {
    		$("#userreview").val('Подождите...');
	    	$.ajax({
	            url: '/lot/addreview',
	            method: "POST",
	            data: $("#userreviewform").serialize(),
	            success:function(data){
	            	console.log(data);
	            	$(".successrev").fadeIn(300);
	            	$('.reviews').load(document.location+' .reviews > *');
	            	// $("#user_review_form").fadeOut(300, function(){
	            		// $("#user_review_form").load(document.location+' #user_review_form > *');
	            	// });
	            	// $(".savehide").fadeOut(300, function(){
	            		// $(".savehide").animate({height:"0px"}, 500, function(){
		            		// $("#userreview").addClass('sended');
		            		// $("#userreview").val('Ваш отзыв отправлен');
		            		// //$('.reviews-container').load(document.location+' .reviews-container > *');
		            	// });
	            	// });
	            	
	            },
	            error:function(xhr, ajaxOptions, thrownError){
	            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	            }
	        });
	        return false;
    	} else {
    		$("span.not_voted").show();
    		return false;
    	}
    	
        return false;
    });
    
    
    // Reviews
    
    $(document).on("click", ".like_review:not(.active)", function() {
    	$(this).find('i').addClass("adding_review");
    	var review = $(this).attr('rel');
    	$.ajax({
            url: '/lot/likereview',
            method: "POST",
            data: 'id_review='+review,
            success:function(data){
            	//console.log(review);
            	if ($('#rev_'+review).length) {
            		$('#rev_'+review).load(document.location+' #rev_'+review+' > *');
            	} else {
            		$('#r_'+review).load(document.location+' #r_'+review+' > *');
            	}
            	console.log(data);
            },
            error:function(xhr, ajaxOptions, thrownError){
            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    	return false;
    });
    
    $(document).on("click", ".unlike_review:not(.active)", function() {
    	$(this).find('i').addClass("adding_review");
    	var review = $(this).attr('rel');
    	$.ajax({
            url: '/lot/unlikereview',
            method: "POST",
            data: 'id_review='+review,
            success:function(data){
            	if ($('#rev_'+review).length) {
            		$('#rev_'+review).load(document.location+' #rev_'+review+' > *');
            	} else {
            		$('#r_'+review).load(document.location+' #r_'+review+' > *');
            	}
            },
            error:function(xhr, ajaxOptions, thrownError){
            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    	return false;
    });
    
    //Подтверждение бронирования    
    $(document).on("click", ".resolve_booking", function() {

    	var booking_id = $(this).attr('data-booking-id'),
    	loturl = $('.calendar').attr('data-loturl');
		
		if(booking_id !==''){
			
			
			
	    	$.ajax({
	            url: '/myprofile/resolvebooking/'+booking_id,
	            method: "POST",
	            success:function(data){
	            	
	            	$.ajax({
			            url: '/myprofile/updateorderscalendar/'+loturl,
			            method: "POST",
			            success:function(data){
			            	$('.calendar-holder').load(document.location+' .calendar-holder > *', function(){
								
								var dates = jQuery.parseJSON(data);
		
								var startDate='', endDate='';
								console.log('dates2',dates);
						
								var disableDates = function(dt) {
						
									if(dates.length > 1 ){
												
										var result = dates.reduce(function(prev, item, index, arr) {
						
											var inside = dates.reduce(function(prev, cur) {
							                 return prev || (cur.from && cur.to && dt <= (new Date(cur.to).setHours(0)) && dt >= (new Date(cur.from).setHours(0)));
							            	}, false);
						
											return [!inside && (!startDate || +dt >= (new Date(startDate)).setHours(0)) && (!endDate || +dt <= (new Date(endDate)).setHours(0))];
										});
										
										if(result[0] ===false){
											return [result,'datepicker_event'];
										}
										return result;
									}else{
										var result=null;
										if(dates.length === 1){
											startDate = dates[0].from;
											endDate = dates[0].to;
											result = (!startDate || +dt >= (new Date(startDate).setHours(0))) && (!endDate || +dt <= (new Date(endDate)).setHours(0));
											if(result === true){result = false;return [result,'datepicker_event'];}else if(result === false){result = true;return [result];}
										}else{
											result = true;return [result];
										}
										
									}
								}
								
								$(".resolve_booking").css('opacity', '0.5');
								$(".resolve_booking").removeClass('resolve_booking');
								
								console.log('disableDates',disableDates);
								$("#datepicker").datepicker({
								    dateFormat : 'yy-mm-dd',
								    firstDay: 1,
								    altField: "#actualDate",
						            minDate: "#actualDate",
								    beforeShowDay: disableDates
								});
								$('#datepicker5, #datepicker6').datepicker({
						            dateFormat: "dd-mm-yy",
						            firstDay: 1,
						            altField: "#actualDate"
						        });
							});
													
							
			            },
			            error:function(xhr, ajaxOptions, thrownError){
			            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			            }
			        });
			        
	            	$('#booking_'+booking_id).load(document.location+' #booking_'+booking_id+' > *');
	            	$('#booking_'+booking_id).toggleClass('confirm').removeClass('wait');
	            	
	            	console.log(data);
	            },
	            error:function(xhr, ajaxOptions, thrownError){
	            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	            }
	        });
       }
    	return false;
    });
      
    $(document).on("click", ".add-review-lnk.actrew", function() {
    	if ($("#blog_review_form").is(":visible")) {
    		$("#blog_review_form").fadeOut();
    	} else {
    		$("#blog_review_form").fadeIn();
    		$("html, body").animate({ scrollTop: $('#blog_review_form').offset().top }, 500);
    		$("#textcomment").focus();
    	}
    	return false;
    });
    
    $(document).on("click", ".revansw", function() {
    	var rel = $(this).attr('rel');
    	if (rel) {
    		var name = $("#rev_"+rel+" .name").text();
	    	$('.parentrev').val(rel);
	    	$(".ansname").html('ответ для <a class="ansnamelink" href="#">'+name+' <b>×</b></a>');
    	}
    	if ($("#blog_review_form").length) {
    		$("#blog_review_form").fadeIn();
    		$("html, body").animate({ scrollTop: $('#blog_review_form').offset().top }, 500);
    	} else if ($("#user_review_form").length) {
    		$("#user_review_form").fadeIn();
    		$("html, body").animate({ scrollTop: $('#user_review_form').offset().top }, 500);
    	} else {
    		//$("a[data-target='#createAdmin']").click();
    		return false;
    	}
    	
    	$("#textcomment").focus();
    	return false;
    });
    
    $(document).on("click", ".revanswlot", function() {
    	var rel = $(this).attr('rel');
    	var name = $("#r_"+rel+" .name").text();
    	//console.log($("#r_"+rel+" .user .name").text());
    	$('.parentrev').val(rel);
    	$(".ansname").html('ответ для <a class="ansnamelinklot" href="#">'+name+' <b>×</b></a>');
    	if ($("#addreviewform").length) {
    		$("html, body").animate({ scrollTop: $('#addreviewform').parent().offset().top }, 500);
    	} else if ($("#addreviewform").length) {
    		$("html, body").animate({ scrollTop: $('#addreviewform').parent().offset().top }, 500);
    	} else {
    		return false;
    	}
    	$("#addreviewform input[type='submit']").attr('id', 'addreview');
    	$("#addreviewform input[type='submit']").removeAttr('data-target');
    	$("#addreviewform input[type='submit']").removeAttr('data-toggle');
    	
    	$("#textcomment").focus();
    	return false;
    });
    
    
    $(document).on("click", "#commentblog.actrew", function() {
    	
    	$.ajax({
            url: '/info/addreview',
            method: "POST",
            data: $("#commentblogform").serialize(),
            success:function(data){
				//console.log(data);
				//$('.reviews').load(document.location+' .reviews > *');
				$(".successrev").fadeIn(300);
            	$("#blog_review_form").fadeOut(300, function(){
            		$("#blog_review_form").load(document.location+' #blog_review_form > *');
            	});

            },
            error:function(xhr, ajaxOptions, thrownError){
            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    	
    	return false;
    });
    
    $(document).on("click", ".comments_with_answers .ansnamelink, .ansnamelinklot", function() {
    	$('.parentrev').val(0);
    	$(".ansname").html('');
    	return false;
    });
    $(document).on("click", ".ansnamelinklot", function() {
    	$('.parentrev').val(0);
    	$(".ansname").html('');
    	$('#addreviewform').load(document.location+' #addreviewform > *');
    	return false;
    });
    
    $(document).on("click", ".openanswers", function() {
    	
    	var id = $(this).attr('rel');
    	console.log(id)
    	if ($(".openaningswers#rev_"+id).is(":visible")) {
    		$(".openaningswers#rev_"+id).fadeOut();
    	} else {
    		$(".openaningswers#rev_"+id).fadeIn();
    	}
    	return false;
    });
    
    //Отмена бронирования
    $(document).on("click", ".reject_booking", function() {

    	var booking_id = $(this).attr('data-booking-id'),
    	loturl = $('.calendar').attr('data-loturl');
    	
    	if(booking_id !==''){
    					
    		
	    	$.ajax({
	            url: '/myprofile/rejectbooking/'+booking_id,
	            method: "POST",
	            success:function(data){
	            	$.ajax({
			            url: '/myprofile/updateorderscalendar/'+loturl,
			            method: "POST",
			            success:function(data){

							$('.calendar-holder').load(document.location+' .calendar-holder > *', function(){
								
								var dates = jQuery.parseJSON(data);
		
								var startDate='', endDate='';
								console.log('dates2',dates);
						
								var disableDates = function(dt) {
						
									if(dates.length > 1 ){
												
										var result = dates.reduce(function(prev, item, index, arr) {
						
											var inside = dates.reduce(function(prev, cur) {
							                 return prev || (cur.from && cur.to && dt <= (new Date(cur.to).setHours(0)) && dt >= (new Date(cur.from).setHours(0)));
							            	}, false);
						
											return [!inside && (!startDate || +dt >= (new Date(startDate)).setHours(0)) && (!endDate || +dt <= (new Date(endDate)).setHours(0))];
										});
										
										if(result[0] ===false){
											return [result,'datepicker_event'];
										}
										return result;
									}else{
										var result=null;
										if(dates.length === 1){
											startDate = dates[0].from;
											endDate = dates[0].to;
											result = (!startDate || +dt >= (new Date(startDate).setHours(0))) && (!endDate || +dt <= (new Date(endDate)).setHours(0));
											if(result === true){result = false;return [result,'datepicker_event'];}else if(result === false){result = true;return [result];}
										}else{
											result = true;return [result];
										}
										
									}
								}
						
								$("#datepicker").datepicker({
								    dateFormat : 'yy-mm-dd',
								    altField: "#actualDate",
						            minDate: "#actualDate",
								    beforeShowDay: disableDates
								});
								$('#datepicker5, #datepicker6').datepicker({
						            dateFormat: "dd-mm-yy",
						            altField: "#actualDate"
						        });
							});
							
			            },
			            error:function(xhr, ajaxOptions, thrownError){
			            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			            }
			        });
			        
	            	$('#booking_'+booking_id).load(document.location+' #booking_'+booking_id+' > *');
	            	$('#booking_'+booking_id).toggleClass('cancel').removeClass('wait');
	            	
	            	console.log(data);
	            },
	            error:function(xhr, ajaxOptions, thrownError){
	            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	            }
	        });
       	}
       	
    	return false;
    });
    //Подтверждение бронирования
    $(document).on("click", ".resolve_message", function() {

    	var
	    	booking_id = $(this).attr('data-booking-id'),
			lot = $(this).attr('data-lot'),
			user = $(this).attr('data-user'),
			url = '/query/messagestolot/' + lot + '/' + user;
		console.log('url',url);
		if(booking_id !==''){
	    	$.ajax({
	            url: '/query/bookingconfirm/'+booking_id,
	            method: "POST",
	            success:function(data){
	            	//$('#booking_'+booking_id).load(document.location+' #booking_'+booking_id+' > *');
	            	$.ajax({
		                url:  url,
		                dataType: "html",
		                success: function (data) {
		                    $('#dialog-holder').html(data);
		                } 
		            });
	            },
	            error:function(xhr, ajaxOptions, thrownError){
	            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	            }
	        });
       }
    	return false;
    });

	//Send message to owner from user
    $(document).on("submit", ".send_to_user", function(e) {
		$(this).val("Отправка...");
		var 
			user = $('.send_to_user .user_id').val(),
			url = '/query/messagestoauthor/'+ user;

		
    	$.ajax({
            url: '/myprofile/dialogmessageanswer',
            method: "POST",
            dataType: 'json',
            data:$('.send_to_user').serialize(),
            success:function(data){
            	$.ajax({
	                url:  url,
	                dataType: "html",
	                success: function (data) {
	                    $('#dialog-holder').html(data);
	                },
		            error:function(xhr, ajaxOptions, thrownError){
		            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		            }
	            });
            },
            error:function(xhr, ajaxOptions, thrownError){
            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
       
    	return false;
    });

	//Send message to owner from user (booking lot)
    $(document).on("submit", ".send_to_lot", function(e) {
		$(this).val("Отправка...");
		var 
			user = $('.send_to_lot .user_id').val(),
			lot = $('.send_to_lot .lot_id').val(),
			url = '/query/messagestolot/'+lot+'/'+ user;

    	$.ajax({
            url: '/myprofile/dialogmessage/'+lot,
            method: "POST",
           // dataType: 'json',
            data:$('.send_to_lot').serialize(),
            success:function(data){
            	$.ajax({
	                url:  url,
	                dataType: "html",
	                success: function (data) {
	                    $('#dialog-holder').html(data);
	                },
		            error:function(xhr, ajaxOptions, thrownError){
		            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		            }
	            });
            },
            error:function(xhr, ajaxOptions, thrownError){
            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });

    	return false;
    });
	
	//Сортировка лотов в поиске "Самые новые", "Самые дорогие"
	$(document).on("change", ".selectpicker.bs-select-hidden.search-select", function() {
		var 
			sort = $(this).val(),
			form = $('.filter_form').serialize(),
			url =  '?'+form+'&sort='+sort;

			window.location.search = url;

	});
	
	//Delete author booking
	$(document).on("click", ".delete_boooking", function(e) {
		var booking_id = $(this).attr('data-booking-id'),
		url = '/booking/deletebookingbyid/';
		
		if(booking_id !==''){
			$.ajax({
		            url: url,
		            data:{booking_id:booking_id},
		            method: "POST",
		           	success:function(data){
		            	$('.holder-order').load(document.location+' .holder-order > *');
		            },
		            error:function(xhr, ajaxOptions, thrownError){
		            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		            }
	            });
		}
	});
		
	//Add file to message (owner to user)
	$(document).on("change", ".send_to_lot input[name=userfile]", function(e) {

		var files = this.files;
		var fd = new FormData();
		fd.append('userfile', files[0]);
		
		$(".input-holder p").attr('data-name',files[0].name);
		var xhr = new XMLHttpRequest(); 
	    xhr.addEventListener("load", uploadCompleteMessage, false);
	    xhr.upload.addEventListener("progress", uploadProgressMessage, false);
	    xhr.open("POST", "/myprofile/loadfilemessage/", true);
	    xhr.send(fd);

	});
	//Add file to message (user to owner, booking lot)
	$(document).on("change", ".send_to_user input[name=userfile]", function(e) {

		var files = this.files;
		var fd = new FormData();
		fd.append('userfile', files[0]);
		
		$(".input-holder p").attr('data-name',files[0].name);
		var xhr = new XMLHttpRequest(); 
	    xhr.addEventListener("load", uploadCompleteMessage, false);
	    xhr.upload.addEventListener("progress", uploadProgressMessage, false);
	    xhr.open("POST", "/myprofile/loadfilemessage/", true);
	    xhr.send(fd);

	});
 	//Удаление файла с сервера с сообщений
    $(document).on("click", ".del_mess_img", function(e) {
    	var path = $(this).attr('data-path');
    	
    	$.ajax({
            url: '/myprofile/deletefile/',
            type: 'POST',
            data: {path:path},
            success: function (data) {
               $(".input-holder p").html('Прикрепить файл');     
            },
            error: function(xhr, ajaxOptions, thrownError) {
	       		console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
        });
    	
    	return false;
    });
    

	function uploadProgressMessage(event){
	   var percentComplete = Math.round(event.loaded * 100 / event.total);
	   $(".input-holder p").text(" Загружено "+percentComplete + "%");
	}
	function uploadCompleteMessage(event) {
		var 
			res = event.target.responseText,
			json = JSON.parse(res);

		$("input.filename").attr('value',json.filename);
		
		var name = $(".input-holder p").attr('data-name');
		$(".input-holder p").html('<a target="_blank" href="'+json.upload+'">'+name+'</a><span data-path="'+json.path+'" class="glyphicon glyphicon-remove del_mess_img"></span>');
	}
    
    //Отмена сообщения бронивания
    $(document).on("click", ".reject_message", function() {

    	var
	    	booking_id = $(this).attr('data-booking-id'),
			lot = $(this).attr('data-lot'),
			user = $(this).attr('data-user'),
			url = '/query/messagestolot/' + lot + '/' + user;

    	if(booking_id !==''){
	    	$.ajax({
	            url: '/query/bookingdenied/'+booking_id,
	            method: "POST",
	            success:function(data){
	            	//$('#booking_'+booking_id).load(document.location+' #booking_'+booking_id+' > *');
	            	$.ajax({
		                url:  url,
		                dataType: "html",
		                success: function (data) {
		                    $('#dialog-holder').html(data);
		                } 
		            });
	            },
	            error:function(xhr, ajaxOptions, thrownError){
	            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	            }
	        });
       	}
       	
    	return false;
    });
    
    //Валидация полей с номерами в личном кабинете 
    $('input[type=number]').bind({
	  click: function() {
	    var num = $(this).val();
	    if(num < 0){
	    	$(this).val('');
	    	if ($('.form-holder').length) {
		    	$('.form-holder').append('<div class="errors_field">Введено недопустимое значение</div>');
		    	function f(){$('.errors_field').hide();}
				setTimeout( function() { f() } , 2000);
			}
	    }
	  },
	  keyup: function() {
	    var num = $(this).val();
    	if(num < 0){
	    	$(this).val('');
	    	if ($('.form-holder').length) {
		    	$('.form-holder').append('<div class="errors_field">Введено недопустимое значение</div>');
		    	function f(){$('.errors_field').hide();}
				setTimeout( function() { f() } , 2000);
			}
	    }
	  }
	});
    
    $(document).on('change', '.pr_picker', function(){
    	$('.pr_v').text($(this).val() + '  грн.');
    });
	//Смена пароля
	$(document).on('click', '.changepass', function(){
		$.ajax({
	        url: $("#changepassform").attr('action'),
	        method: "POST",
	        data: $("#changepassform").serialize(),
	        dataType: 'json',
	        success:function(data){
	        	
	        	if (data.result==true) {
	        		console.log(true);
	        		$('#changepassform .success-change').text(data.text);
                	$('#changepassform .success-change').fadeIn(0.1);
                    setTimeout( function() {
                        $('#changepassform .success-change').fadeOut(0.1);
                    }, 2000);
                } else {
                	console.log(false);
                	$('#changepassform .error-change').text(data.text);
                    $('#changepassform .error-change').fadeIn(0.1);
                    setTimeout( function() {
                        $('#changepassform .error-change').fadeOut(0.1);
                    }, 2000);
                }
	        	
	        	console.log(data);
	        },
	        error:function(xhr, ajaxOptions, thrownError){
	        	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	        }
	    });
		
		return false;
	});
	
	$(document).on('click', '.changeemail', function(){
		$.ajax({
	        url: $("#changemail").attr('action'),
	        method: "POST",
	        data: $("#changemail").serialize(),
	        dataType: 'json',
	        success:function(data){
	        	
	        	if (data.result==true) {
	        		console.log(true);
	        		$('#changemail .success-change').text(data.text);
                	$('#changemail .success-change').fadeIn();
                    setTimeout( function() {
                        $('#changemail .success-change').fadeOut();
                    }, 2000);
                } else {
                	console.log(false);
                	$('#changemail .error-change').text(data.text);
                    $('#changemail .error-change').fadeIn();
                    setTimeout( function() {
                        $('#changemail .error-change').fadeOut();
                    }, 2000);
                }
	        	
	        	console.log(data);
	        },
	        error:function(xhr, ajaxOptions, thrownError){
	        	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	        }
	    });
		
		return false;
	});
	
	$(document).on('click', '.change_recov_pass', function(){
		$(".errors_changepass").html('');
		var error = '';
		var p1 = $("#p1").val();
		var p2 = $("#p2").val();
		
		if (p1.length&&p2.length) {
			if (p1==p2) {
				$(".recovery form").submit();
			} else {
				error = 'Пароли не совпадают';
			}
		} else {
			error = 'Все поля обязательны';
		}
		if (error) {
			$(".errors_changepass").html('<span>'+error+'</span>');
		}
		return false;
	});
	
	
	//Переключение табов в личном кабинете
	$('.link_to_mess').click(function(){
		$('.nav-tabs li').removeClass('active');
		var id = $(this).attr('href');
		$('.nav-tabs a[href='+id+']').parent('li').addClass('active');
	});
	
	//Показать все лоты на главной
	$(document).on('click', '.show-all', function(){
		
		$(this).text("Загрузка...");
		
		var 
			start = $(this).attr('data-start'),
			step = $(this).attr('data-step'),
			all = $(this).attr('data-all'),
			nextstep = (+start) + (+step);

    	$.ajax({
            url: '/query/showmorelots/'+start+'/'+step,
            method: "POST",
            dataType: 'html',
            success:function(data){
            	$('.goods-list').append(data);
            	if(all >= nextstep){
            		$('.show-all').attr('data-start',nextstep).text('Загрузить еще');
            	}else{
            		$('.show-all').remove();
            	}
            },
            error:function(xhr, ajaxOptions, thrownError){
            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
        return false;
	});
	
	/*Sorting images in admin*/
	 $(document).on('click', '.sort_messages', function(){
	 	var hold = $(this).attr('data-hold'),
	 	that = $(this);
	 	
	 	$.ajax({
            url: '/myprofile/sortmessages/'+hold,
            method: "POST",
            dataType: 'html',
            success:function(data){
            	$('#main-private-office').html(data);
            	that.attr('data-hold','1');
            	$('.selectpicker').selectpicker();
            	$('.lnk3').click();
            },
            error:function(xhr, ajaxOptions, thrownError){
            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
        return false;
	 }); 
	
	//Send callback form
    $(document).on("click", "#sendfeedback", function(e) {
    	var $this = $(this)
		$this.val("Отправка...");
		
    	$.ajax({
            url: '/info/sendcallback',
            method: "POST",
            dataType: 'json',
            data:$('#cbf').serialize(),
            success:function(data){
            	console.log(data);
            	$this.val("Отправлено");
            	$('#cbf').find("input[type=text], textarea").val("");

            },
            error:function(xhr, ajaxOptions, thrownError){
            	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
       
    	return false;
    });

	//concatPledge
	function concatPledge(){
		var 
			currency = $('.currency-select').val(),
			pledge = $('.pledge').val();
			str = null;

			switch (currency) {
			  case 'grn':
			    currency = 'грн.';
			    break
			  case 'euro':
			    currency = '&euro;';
			    break
			  case 'dol':
			    currency = '$';
			    break
			}

			str = pledge + ' ' + currency;
			console.log(str);
			
		$('input.deposit').val(str);
	}

    //select currency in lot
    $(document).on("change", ".currency-select", function(e) {
		concatPledge();
    });
    //add pledge in lot
    $(document).on("keyup", ".pledge", function(e) {
    	concatPledge();
    });
    
     /*special conditions field*/
	$('.special_conditions').attr('disabled','disabled');
    
    $('.sp_checkbox').bind('click', function() {
        if($('.sp_checkbox').prop('checked') == true) {
            $('.special_conditions').removeAttr('disabled');
        } else{
            $('.special_conditions').attr('disabled','disabled'); 
            $('.special_conditions').val('');
        }; 
    });
    
    
	//select all currencies
	$(document).on("change", ".form-holder select", function(e) {
		var text = $(this).parents('label').find('button').attr('title');
		$('.currency_inp').val(text);
		$.each($('.form-holder button'),function(key, value){
			$(value).find('span.filter-option').text(text);
		});
		
	});
    
    
    //Show/hide marker "Мы будем скрывать Ваш точный адрес"
    $('input[name="form[show_address]"]').bind('click', function() {
        if($(this).prop('checked') == true) {
            $('.map-holder .marker').css('display', 'none');
        } else{
            $('.map-holder .marker').css('display', 'block');
        }; 
    });
    
    
    //Fancybox init for owl-carousel
    $(".fancybox").fancybox();
	
});

window.addEventListener('DOMContentLoaded', function() {
    
    //Adding money interval fields
    ;(function() {
    	
    	if($('#deposit').length>0){
    		
	        var depositBox = document.querySelector('#deposit'),
	            selectpicker = depositBox.querySelector('.selectpicker'),
	            depositInput = document.querySelector('.deposit'),
	            moneyInterval = depositBox.querySelector('.money-interval'),
                inputPledge = moneyInterval.querySelector('.pledge');
	
	        if(selectpicker.value === 'document'){
	       	 moneyInterval.style.cssText = 'display: none';
	        }
	        
	        function template() {
	            moneyInterval.style.cssText = 'display: block';
                moneyInterval.classList.add('active');
	            
                if(moneyInterval.classList.contains('active')) {
                    inputPledge.classList.add('required');
                } else{
                    inputPledge.classList.remove('required');
                };
                
	            if(moneyInterval) {
	                return;
	            } else{
	                depositBox.insertAdjacentHTML('beforeEnd', htmlBlock);  
	            };     
	        };
	        
	        function removeNode() {
	            var moneyInterval = depositBox.querySelector('.money-interval');
	            depositInput.value = 'document';
	            moneyInterval.style.cssText = 'display: none';
	            
	        };
	        
	        selectpicker.onchange = function() {   
	            switch(selectpicker.value) {
	                case 'money': template();
	                    break;
	
	                case 'document': removeNode();
                        inputPledge.classList.remove('required');
	                    break;
	            };
	        };  
            
            if(selectpicker.value == 'money') {
                moneyInterval.classList.add('active');
                inputPledge.classList.add('required');
            };
        }    
        
    }());
    
    
    //Main-ad-form validation
    ;(function(form) {
        
        if(!form) return;
        
        form.addEventListener('submit', validationForm);
        
        function validationForm() {
              var requiredFields = form.querySelectorAll('.required'),
                  errorStr = form.querySelector('.error-str');
            
              for(var i = 0; i < requiredFields.length; i++) {

                if(requiredFields[i].value == '' || requiredFields[i].value == 0) {
                    
                    errorStr.style.cssText = 'opacity: 1';
                    
                    setTimeout(function() {
                        errorStr.style.cssText = 'opacity: 0';
                    }, 5000);
                    requiredFields[i].focus();
                    event.preventDefault();
                };
            };  
        };
        
        //#id_category marker
        var rubric = document.querySelector('.rubric-nav'),
            inputCategory = document.getElementById('id_category');
        
        inputCategory.addEventListener('change', showMarker);
        
        function showMarker() {
            if(inputCategory.value != '' || inputCategory.value > 0) {
                rubric.classList.add('active');
            };            
        };
        
    }(document.querySelector('.main-ad-form')));
    
    
});
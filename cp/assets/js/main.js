$(document).ready(function(){

	//Modal window '.modal-del .delete-admin'
	$('.administrators .del-admin').click(function(){
	   $('.administrators').find('.delete-admin').fadeOut(200);
	   $('.administrators .delete-admin').fadeIn();
	});
	$('.delete-admin .closer, .delete-admin .ok,  .delete-admin .cancel, .overlay').click(function(){
	   $('.administrators .delete-admin').fadeOut();
	});
        
    //Modal window '.modal-del .delete-user'
	$('#users-list .del-user').click(function(){
	   $('#users-list').find('.delete-user').fadeOut();
	   $('#users-list .delete-user').fadeIn();
	});
	$('.delete-user .closer, .delete-user .ok,  .delete-user .cancel, .overlay').click(function(){
	   $('#users-list .delete-user').fadeOut();
	});
        
    //Modal window '.modal-del .delete-article'
    $('#articles-list .del-article').click(function(){
       $('#articles-list').find('.delete-article').fadeOut();
       $('#articles-list .delete-article').fadeIn();
    });
    $('.delete-article .closer, .delete-article .ok,  .delete-article .cancel, .overlay').click(function(){
       $('#articles-list .delete-article').fadeOut();
    });

    //Modal window '.modal-del .delete-review'
    $('.info-about-user .del-rev').click(function(){
       $('.info-about-user').find('.delete-review').fadeOut();
       $('.info-about-user .delete-review').fadeIn();
    });
    $('.delete-review .closer, .delete-review .ok,  .delete-review .cancel, .overlay').click(function(){
       $('.info-about-user .delete-review').fadeOut();
    });
    
    //Modal window '.modal-del .delete-lot'
    $('.lot_item .del-lot').click(function(){
       $('.search-in-database').find('.delete-lot').fadeOut();
       $('.search-in-database .delete-lot').fadeIn();
    });
    $('.delete-lot .closer, .delete-lot .ok,  .delete-lot .cancel, .overlay').click(function(){
       $('.search-in-database .delete-lot').fadeOut();
    });
    
    //Modal window '.modal-del .delete-categ'
    $('.category .del-categ').click(function(){
       $('.category-list').find('.delete-categ').fadeOut();
       $('.category-list .delete-categ').fadeIn();
    });
    $('.delete-categ .closer, .delete-categ .ok,  .delete-categ .cancel, .overlay').click(function(){
       $('.category-list .delete-categ').fadeOut();
    });
    
    //Modal WARNING '.warning-categ'
    $('.category .nodel').click(function(){
       $('.category-list').find('.warning-categ').fadeOut();
       $('.category-list .warning-categ').fadeIn();
    });
    $('.warning-categ .closer, .warning-categ .ok,  .warning-categ .cancel, .overlay').click(function(){
       $('.category-list .warning-categ').fadeOut();
    });
	
    //Переходы по сайту через навигации без перезугрузки страницы
    $('#side-menu .lnk-1, #side-menu .lnk-2, #side-menu .lnk-3, #side-menu .lnk-4, #side-menu .lnk-5, #side-menu .lnk-6, #side-menu .lnk-7').click( function() {
        var href = $(this).attr('href');
        $('#content').load(href + ' #content > *');
        $('#side-menu').find('a').removeClass('active');
        $(this).addClass('active');
        window.history.pushState('', '', href);
        
        return false;
    });
    
    $(document).on('click', '.action div', function(){
    	var href = $(this).attr('rel');
    	//alert(1)
    	$.getJSON(href, '', function (json) {
    		if (json.res) {
    			if (json.act=='blocked') {
    				$("#"+json.item).addClass('blocked');
    				$("#"+json.item+' .block').removeClass('glyphicon-ban-circle');
    				$("#"+json.item+' .block').addClass('glyphicon-ok-circle');
    			} else if (json.act=='unblocked') {
    				$("#"+json.item).removeClass('blocked');
    				$("#"+json.item+' .block').removeClass('glyphicon-ok-circle');
    				$("#"+json.item+' .block').addClass('glyphicon-ban-circle');
    			} else {
    				$("#"+json.item).fadeOut();
    			}
    		}
    		console.log(json);
    	});
    	
    	return false;
    });
    
    $(document).on('click', '.delete_val, .delete_attr', function(){
    	var href = this.href;
    	
    	$.getJSON(href, '', function (res) {
    		if (res) {
    			$("#row_"+res).fadeOut();
    		}
    		console.log(res);
    	});
    	
    	
    	return false;
    });
    
    $(document).on('click', '.review_edit', function(){
    	var $this = $(this);
    	var text = $this.html();
    	var rev = $this.attr('rel');
    	$this.html('<textarea style="width:'+(parseInt($this.width())+10)+'px; height:'+(parseInt($this.height())+10)+'px" class="edit_rev">'+text+'</textarea>')
    	$(".edit_rev").focus();
    	return false;
    });
    
    $(document).on('click', '.review_edit textarea', function(event){
    	event.stopPropagation();
    	return false;
    });
    
    $(document).on('blur', '.edit_rev', function(){
    	var $this = $(this);
    	if ($this.val()!='') {
    		var id = $this.parent().attr('rel');
    		$.ajax({
		        url: '/cp/reviews/edit/'+id,
		        method: "POST",
		        data: 'text='+$this.val(),
		        success:function(data){
				console.log(data);
				
    			$this.parent().html($this.val());
		
		        },
		        error:function(xhr, ajaxOptions, thrownError){
		        	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		        }
		    });
    	}
    	
    });
    
    $(document).on('keypress', '.edit_rev', function(e){
    	var $this = $(this);
	    if(e.which == 13) {
	    	if ($this.val()!='') {
	    		var id = $this.parent().attr('rel');
	    		$.ajax({
			        url: '/cp/reviews/edit/'+id,
			        method: "POST",
			        data: 'text='+$this.val(),
			        success:function(data){
					console.log(data);
					
	    			$this.parent().html($this.val());
			
			        },
			        error:function(xhr, ajaxOptions, thrownError){
			        	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			        }
			    });
	    	}
	    	return false;
	    }
	});
    
    
    // $(document).on('click', '.action .block', function(){
//     	
    	// return false;
    // });
//     
    // $(document).on('click', '.action .delete', function(){
//     	
    	// return false;
    // });
    
    
    
    console.log( performance.now() );
});
//подгрузка регинов
function loadRegions(select, region, city) {
   var region_select = $(region);
   var city_select = $(city);
   region_select.attr('disabled', 'disabled');
   city_select.attr('disabled', 'disabled');
   if(select.value == '0'){
       region_select.html('');
       region_select.append('<option selected value="0">Все регионы</option>');
       city_select.html('');
       city_select.append('<option selected value="0">Все страны</option>');
   } else {
       $.getJSON('http://' + document.location.hostname + '/query/getregionsbycountryid/' + select.value, '', function (region_list) {
           region_select.html('');
           region_select.append('<option selected value="0">Все регионы</option>');
           $.each(region_list, function () {
               region_select.append('<option value="' + this.id + '">' + this.name + '</option>');
           });
           region_select.removeAttr('disabled');
       });
   }
}

//подгрузка городов
function loadCities(select, load_to) {
    var city_select = $(load_to);
//    city_select.attr('disabled', 'disabled');
    $.getJSON('http://' + document.location.hostname + '/query/getcitiesbyregionid/' + select.value, '', function (city_list) {
        city_select.html('');
        //show here
        $(city_select).show();
        city_select.append('<option selected value="0" disabled>Все города</option>');
        $.each(city_list, function () {
            city_select.append('<option value="' + this.id + '">' + this.name + '</option>');
        });
        $(city_select).selectpicker();
//        city_select.removeAttr('disabled');
//        alert(city.innerHTML);
    });
}

function loadCategory(select) {
    var selectedOption = select.value;
    console.log(document.location.search);
    window.location = '/category/' + selectedOption+document.location.search;
}

function constructUrl(container) {
     var currentSearch = window.location.search.replace('?search=', '');
    console.log("Current search = " + currentSearch);
    var urlFilters = {};
    var Filters = {};
    if(currentSearch){
        //urlFilters = JSON.parse(currentSearch.replace(new RegExp("%22", 'g'), '"'));
        urlFilters = currentSearch.split(';');
    }
    $.each(urlFilters, function(k, v){
    	if (v.length) {
    		var vv = v.split(':');
    		if (found = vv[1].match(/-/)) {
    			var vv2 = vv[1].split('-');
    			Filters[vv[0]] = {
    				from:vv2[0],
    				to:vv2[1]
    			}
    		} else {
    			Filters[vv[0]] = vv[1];
    		}

    	}
    });
    
    console.log("Current search object --");
    console.log(Filters);

    $(container).each(function () {
        console.log($(this).attr('name'));
        var currentKey = $(this).attr('name');
        if ($(this).find('option:selected').length != '') {
            staticXyita(currentKey, Filters, this);

        }
    });
}

//создание урлы для фильтрации
function constructFiltersString(container) {
    var currentSearch = window.location.search.replace('?search=', '');
    console.log("Current search = " + currentSearch);
    var urlFilters = {};
    if(currentSearch){
        //urlFilters = JSON.parse(currentSearch.replace(new RegExp("%22", 'g'), '"'));
        urlFilters = currentSearch.split(';');
    }
    
    $.each(urlFilters, function(k, v){
    	if (v.length) {
    		var vv = v.split(':');
    		if (found = vv[1].match(/-/)) {
    			var vv2 = vv[1].split('-');
    			Filters[vv[0]] = {
    				from:vv2[0],
    				to:vv2[1]
    			}
    		} else {
    			Filters[vv[0]] = vv[1];
    		}

    	}
    });
    
    console.log("Current search object: ");
    console.log(urlFilters);

    $(container).find('div').each(function () {
        console.log($(this).data('filtertype'));
        var currentKey = $(this).data('filtertype');
        if (($(this).find('[name="from"]').val() != '') || ($(this).find('[name="to"]').val() != '')) {
            xyita(currentKey, Filters, this);

        }
    });

}

function xyita(currentKey, urlFilters, elem) {
    console.log(urlFilters);
    if ($(elem).find('[name="from"]').val() != '') {
        console.log(currentKey);
        if(!urlFilters[currentKey]){
            urlFilters[currentKey] = {};
        }
        
        urlFilters[currentKey]['from'] = $(elem).find('[name="from"]').val();
    }
    if ($(elem).find('[name="to"]').val() != '') {
        if(!urlFilters[currentKey]){
            urlFilters[currentKey] = {};
        }
        urlFilters[currentKey]['to'] = $(elem).find('[name="to"]').val();
    }
    console.log(urlFilters);
    
    var query = '';
    $.each(urlFilters, function(k, v){
    	if ($.type(v)==="string") {
    		query += k+":"+v+";";
    	} else {
    		query += k+":"+v.from+"-"+v.to+";";
    	}
    	console.log(query);
    });
    
    var url = window.location.pathname + '?search=' + query; //JSON.stringify(urlFilters);
    $(".products-holder").load(url + ' .products-holder > *');
    window.history.pushState('', '', url);
    //window.location = window.location.pathname + '?search=' + JSON.stringify(urlFilters);
}

function staticXyita(currentKey, urlFilters, elem) {
    console.log(urlFilters);
    if ($(elem).find('option:selected').val() != '') {
        console.log(currentKey);
        if(!urlFilters[currentKey]){
            urlFilters[currentKey] = {};
        }
        
        urlFilters[currentKey] = $(elem).find('option:selected').attr('name');
    }
    console.log(urlFilters);
    var query = '';
    $.each(urlFilters, function(k, v){
    	if ($.type(v)==="string") {
    		query += k+":"+v+";";
    	} else {
    		query += k+":"+v.from+"-"+v.to+";";
    	}
    	console.log(query);
    });
    
    var url = window.location.pathname + '?search=' + query; //JSON.stringify(urlFilters);
    $(".products-holder").load(url + ' .products-holder > *');
    window.history.pushState('', '', url);
}



//подгрузка подкатегорий
function loadSubCat(select, load_to) {
    var subcat_select = $(load_to);
    subcat_select.attr('disabled', 'disabled');
    $.getJSON('http://' + document.location.hostname + '/query/getsubcat/' + select.value, '', function (subcat_list) {
        subcat_select.html('');
        $.each(subcat_list, function () {
            subcat_select.append('<option value="' + this.id + '">' + this.title + '</option>');
        });
        subcat_select.removeAttr('disabled');
    });

}

function loadCombo(country, region, city) {
    // var select_country = $(country);
    // var select_region = $(region);
    // var select_city = $(city);

    // if(select_country.val() != 0){
    //     loadRegions(country, select_region);
    // }

}



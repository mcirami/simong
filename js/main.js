jQuery(document).ready(function($){

	//var localDev = true;
	
	//if(localDev == true) {
	//	loadReload();
	//	$('body').css('opacity', '1');
	//}

	$('.search_icon, .mobile_search').click(function(e) {
		e.preventDefault();
		$('.header_search_box').fadeToggle();
	});
	
	$('.mobile_nav_btn').click(function(e){
		e.preventDefault();
		if($(this).hasClass('mm-open') == false) {
			$('.mobile-nav').animate({
				left: '0px'
			}, function(){
				$(this).addClass('mm-open');
				$('body,html').addClass('noscroll');
			});
		} else {
			$('.mobile-nav').animate({
				left: '-999px'
			});
		}
	});
	
	$('.close').click(function(e){
		e.preventDefault();
		$('.mobile-nav').animate({
			left: '-999px'
		});
		$('.mobile_nav_btn').removeClass('mm-open');
		$('body,html').removeClass('noscroll');
	});
	
	var collectionID;
	
	$('.main_menu > li').mouseenter(function() {
		collectionID = $(this).attr('class').split(' ');
		collectionID = collectionID[0];
		$('.header_collections').removeClass('dropdown_open');
		$('#' + collectionID).addClass('dropdown_open');
		$('.main_menu > li').removeClass('menu_arrow');
		if($('#' + collectionID).length) {
			$(this).addClass('menu_arrow');
		}
		$('.header_dropdown').css('display', 'block');
	});
	
	$('.top_nav').mouseenter(function(){
		$('.header_dropdown').css('display', 'none');
		$('.main_menu > li').removeClass('menu_arrow');
	});
	
	$('.header_dropdown').mouseleave(function(){
		$(this).css('display', 'none');
		$(this).removeClass('dropdown_open');
		$('.main_menu > li').removeClass('menu_arrow');
		$('.header_collections').removeClass('dropdown_open');
	});
	
	var mySwiper = new Swiper('.swiper-container' ,{
		effect : 'fade',
		pagination: '.swiper-pagination',
		paginationClickable: true,
		nextButton: '.swiper-button-next',
		prevButton: '.swiper-button-prev',
		speed: 500,
		autoplay: 5000, 
		preloadImages: true,
		loop: true
	});
	
	$('.column h2').click(function(e){
		if($(this).hasClass('js-filter-open') == false) {
			$(this).siblings('.column_row').slideDown(500, function(){
				$(this).siblings('h2').addClass('js-filter-open');
			});
		} else {
			$(this).siblings('.column_row').slideUp(500, function(){
				$(this).siblings('h2').removeClass('js-filter-open');
			});
		}
	});
	
	$(window).resize(function(){
		var windowWidth = $(window).width();
		
		if(windowWidth > 782) {
			$('.column_row').css('display', 'block');
		} else if(windowWidth < 782) {
			$('.column_row').css('display', 'none');
			$('.last_column .column_row').css('display', 'block');
		}
		
	});

	$('#slider-range').noUiSlider({
		start: [ $('#min_price').val(), $('#max_price').val() ],
		range: {
			'min': 330,
			'max': 66000
		},

		format: wNumb({
			decimals: 0,
			thousand: ',',
			prefix: '$',
		})
	});

	$("#slider-range").Link('lower').to( $('#min_price') );
	$("#slider-range").Link('upper').to( $('#max_price') );
	

	$('.cat_filter a').click(function(e){
		e.preventDefault();
		if(!$(this).hasClass('filter_open')) {
			$('.cat_filter a').addClass('filter_open');
			$('.cat_filter .filters').slideDown();
			$('.cat_filter .arrow').removeClass('down');
		} else {
			$('.cat_filter a').removeClass('filter_open');
			$('.cat_filter .filters').slideUp();
			$('.cat_filter .arrow').addClass('down');
		}
	});

	if ($('.wish-list-product a.remove').length) {
		$('.wish-list-product a.remove').click( function(e) {
			e.preventDefault();
			var productToRemove = $(e.target).data('product-id');
			removeWishListItem(productToRemove);
			$('.product-id-'+productToRemove).remove();
			var newCount = parseInt($('.wish-list-count').text()) - 1;
			$('.wish-list-count').text(newCount);
		});			
	}
	
	if($('.js_add_to_wish_list').length) {
		
		$(".js_add_to_wish_list").click( function(e) {
			e.preventDefault();
		
			if($(this).hasClass('selected')) { // Remove item from list
				if(getCookie("wishlist")) { 
					var productToRemove = $(this).data('product-id');
					removeWishListItem(productToRemove);
					$('a[data-product-id='+productToRemove+']').removeClass('selected');
						
				} else {
					alert("Error: Invalid Cookie Data (no items to remove)")
				}
			} else { // Move on and add to the list..
				var newProductId = $(this).data('product-id');

				// do we have a cookie?	
				if(getCookie("wishlist")) {
					// Read current items
					var currentItems = JSON.parse(getCookie('wishlist'));

					// check if the new ID already exists in the list and it's not a invalid request..
					if (($.inArray(newProductId, currentItems) == -1) && (typeof newProductId !== "undefined")) {
						
						if(currentItems.length < 7){
							// add to the list
							currentItems.push(newProductId);
							setCookie("wishlist", JSON.stringify(currentItems), 365);
							$('a[data-product-id='+newProductId+']').addClass('selected');

							if(!$(".right_menu a:contains(Wish List)").parent().hasClass('has-wishlist-items')) {
								$(".right_menu a:contains(Wish List)").parent().addClass('has-wishlist-items');
							}
						} else {
							alert("You can only have up to 7 items in your wishlist. Please remove one before adding this item.");
						}
					}
				} else {
					// initialize cookie and add the first product..
					setCookie("wishlist", JSON.stringify([newProductId]), 365);
					$('a[data-product-id='+newProductId+']').addClass('selected');
					$(".right_menu a:contains(Wish List)").parent().addClass('has-wishlist-items');
				}
			}
		});	
	}

	$('#gform_3 .gform_fields li, #gform_4 .gform_fields li, #gform_5 .gform_fields li').each(function() {
		var label = $(this).find('label').text().replace(':', '');
		$(this).find('input, textarea').attr('placeholder', label);
	});

	$('.filters .column_row label').on('click', function() {
		if (!$(this).hasClass('checked')) {
			$(this).addClass('checked');
			$(this).prev().prop('checked', true);
		} else {
			$(this).removeClass('checked');
			$(this).prev().prop('checked', false);
		}
	});

	$('.reset_filters').on('click', function() {
		$('.filters .column_row label').removeClass('checked');
		$('.filters .column_row label').prev().prop('checked', false);
		
		$('#center_stone option[selected="selected"]').each(
			    function() {
			        $(this).removeAttr('selected');
			    }
			);
		$("#center_stone option:first").attr('selected','selected');
		$('#min_price').val("$330");
		$('#max_price').val("$66,000");
		$("#slider-range").val([330, 66000]);
	});
	
	$('#radius_in_submit .slp_ui_button').val('GO');
	$('.slp_ui_button').css('display', 'block');
	
	$('.gfield select').each(function(e) {
	    var selectID = $(this).attr('id');
	    var selectName = $(this).attr('name');
	    $('#'+selectID).ddslick({
	        width: '100%',
	        background: '#ffffff',
	        onSelected: function(data){
	            $('#'+selectID+' .dd-selected-value').attr('name', selectName);
	        }
	    });
	});
	
	/*
	var onlineDeskText = $('.footer_col.service ul.menu li.online_desk a').text();
	$('.footer_col.service ul.menu li.online_desk').empty();
	$('.footer_col.service .online_desk_link a').html(onlineDeskText);
	$('.footer_col.service .online_desk_link').appendTo($('.footer_col.service ul.menu li.online_desk'));
	$('.footer_col.service .online_desk_link').css('display', 'block');
	*/

});

function setCookie(name, value, days) {
    var expires;

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = escape(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return unescape(c.substring(nameEQ.length, c.length));
    }
    return null;
}

function removeWishListItem(productToRemove) {
	var currentItems = JSON.parse(getCookie('wishlist'));

	currentItems = removeItem(currentItems, productToRemove);
	setCookie("wishlist", JSON.stringify(currentItems), 365);

	if(currentItems.length == 0){
		jQuery(".right_menu a:contains(Wish List)").parent().removeClass('has-wishlist-items');
	}
}

function removeItem(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}

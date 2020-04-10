jQuery(document).ready(function($) {
	
	/*var productID;
	
	var load_related_product = function() {
		$.ajax({
			type		: "GET",
			data		: {action: "load_related_products", product_id: productID},
			dataType	: "html",
			url			: ajaxObject.ajaxurl,
			beforeSend	: function() {
				loading = true;
			},
			success		: function(data) {
				$data = $(data);
				if($data.length){  
                    $('#product_ajax_wrapper').empty();
                    $('#product_ajax_wrapper').append($data); 
                    $data.fadeIn(0, function(){  
                        $("#temp_load").remove();  
                        loading = false;  
                    });
                    //$data.insertAfter('.related_products_links');
                } else {  
                    $("#temp_load").remove();
                } 
			},
			error		: function(jqXHR, textStatus, errorThrown) {
				$("#temp_load").remove();  
				alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
			}
		});
	};*/
	
	$('.related_product_links a').click(function(e) {
		e.preventDefault();
		
		if(!$(this).hasClass('active')) {
			$('.related_product_links a.active').removeClass('active');
			$(this).addClass('active');
			
			var productType = $(this).attr('href').replace('#', '');
			
			$('.product_type_container').css('display', 'none');
			$('#product-'+productType).css('display', 'block');
			$('#product-'+productType+' .yith_magnifier_gallery .first').trigger('click');
		}
	});
});
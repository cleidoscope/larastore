jQuery(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('.add_to_cart, .subtract_from_cart').click(function(e){
    	if( !$(this).hasClass('clicked') ) 
    	{
    		var $this = $(this);
	    	var id = $this.data('id');
	    	var message = $this.data('message');
	    	var post_class;
	    	var product_quantity = $this.parent().find('.product-quantity');

	    	if( $(this).hasClass('add_to_cart') ){
	    		post_class = '/add_to_cart';
	    	} else if( $(this).hasClass('subtract_from_cart') ) {
	    		if( product_quantity.val() <= 1 ){
	    			e.preventDefault();
	    			return false;
	    		}
	    		post_class = '/subtract_from_cart';
	    	}

	    	$this.addClass('clicked');
	    	$this.addClass('loading');
	    	$.post(post_class,
	            {
	                id: id,
	                message: message,
	            },
	            function(data){
	            	var response = JSON.parse(data);
	            	if( response.success )
	            	{
				    	$.notify({
						    message: message
							},
							{
								template: '<div class="ui tiny black message"><i class="fa fa-check"></i> {2}</div>', 
							    placement: {
							        from: 'bottom',
							        align: 'right'
							    },
							    delay: 3200,
							    animate: {
							        enter: 'animated fadeInRight',
							        exit: 'animated fadeOutRight'
							    },
							    offset: {
							        x: 15,
							        y: 15
							    }
							}
						);
						$('.cart_total_items').text(response.cart_total_items);
						$('#cart_total_amount, #cart_total').text(response.cart_total_amount);
						product_quantity.val(response.quantity);
						$('#product-total-'+response.product_id).text(response.total);
			    	}
			    	$this.removeClass('loading');
			    	$this.removeClass('clicked');
            	}
            );
    	}
    });


    $('.remove_from_cart').click(function(){
		var $this = $(this);
    	var id = $this.data('id');
    	$.post('/remove_from_cart',
            {
                id: id
            },
            function(data){
            	console.log(data);
            	var response = JSON.parse(data);
            	if( response.success )
            	{
			    	$.notify({
					    message: response.message
						},
						{
							template: '<div class="ui tiny black message"><i class="fa fa-check"></i> {2}</div>', 
						    placement: {
						        from: 'bottom',
						        align: 'right'
						    },
						    delay: 3200,
						    animate: {
						        enter: 'animated fadeInRight',
						        exit: 'animated fadeOutRight'
						    },
						    offset: {
						        x: 15,
						        y: 15
						    }
						}
					);
					$('.cart_total_items').text(response.cart_total_items);
					$('#cart_total_amount, #cart_total').text(response.cart_total_amount);
					$this.parent().parent().fadeOut(100, function(){
						$this.parent().parent().remove();
					});
					if( response.cart_total_items <= 0 ) window.location.href = window.location.href;
		    	}
        	}
        );
    });


    
    $('.has-loader').on('submit',function(e){
        if( !$(this).hasClass('submitting') && $(this).form('is valid') ) {
            $(this).addClass('submitting');
            $(this).find('.has-loader-button').addClass('loading');
            $(this).find('.has-loader-button').prop('disabled', true);
            $(this).submit();
        } else {
            e.preventDefault();
            return false;
        }
    });


    $('.ui.checkbox, .ui.radio.checkbox').checkbox();
    
    $('.ui.dropdown').dropdown();
    
    $('.ui.accordion').accordion();


    $('nav .ui.toggle.button').click(function() {
      	$('nav .ui.vertical.menu').toggle(250, 'linear');
    });


    $('#subscriptionForm')
		.form({
		fields: {
			full_name 	: 'empty',
			email 		: ['empty', 'email'],
		}
	});
});


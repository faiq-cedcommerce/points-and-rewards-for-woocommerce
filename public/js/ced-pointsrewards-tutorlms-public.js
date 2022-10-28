(function( $ ) {
	'use strict';
var ced_tutorlms_frontend_obj = ced_tutorlms_frontend;
/*use for facebook icon script*/
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.9";
	fjs.parentNode.insertBefore(js, fjs);
}(document, "script", "facebook-jssdk"));

$( document ).ready( function() {

	/*Custom Points on Cart Subtotal handling via Ajax*/
	$( document ).on(
		'click',
		'#ced_tutorlms_cart_points_apply',
		function(){
			var user_id = $( this ).data( 'id' );
			var user_total_point = $( this ).data( 'point' );
			var order_limit = $( this ).data( 'order-limit' );
			var message = ''; var html = '';
			var ced_tutorlms_cart_points_rate = ced_tutorlms_frontend_obj.ced_tutorlms_cart_points_rate;
			var ced_tutorlms_cart_price_rate = ced_tutorlms_frontend_obj.ced_tutorlms_cart_price_rate;
			var ced_tutorlms_points = $( '#ced_tutorlms_cart_points' ).val();
			
			$( "#ced_tutorlms_cart_points_notice" ).html( "" );
			$( "ced_tutorlms_cart_points_success" ).html( "" );
			
			if (ced_tutorlms_points !== 'undefined' && ced_tutorlms_points !== '' && ced_tutorlms_points !== null && ced_tutorlms_points > 0) {
				if (user_total_point !== null && user_total_point > 0 && user_total_point >= ced_tutorlms_points ) {
					
					// block( $( '.woocommerce-cart-form' ) );
					// block( $( '.woocommerce-checkout' ) );
					
					var data = {
						action:'ced_tutorlms_apply_fee_on_cart_subtotal',
						user_id:user_id,
						ced_tutorlms_points:ced_tutorlms_points,
						ced_tutorlms_nonce:ced_tutorlms_frontend_obj.ced_tutorlms_nonce,
					};
					$.ajax(
						{
							url: ced_tutorlms_frontend_obj.ajax_url,
							type: "POST",
							data: data,
							dataType :'json',
							success: function(response)
							{
								
								if (response.result == true) {
									message = response.message;
									html = message;
									$( "#ced_tutorlms_cart_points_success" ).removeClass( 'ced_tutorlms_settings_display_none_notice' );
									$( "#ced_tutorlms_cart_points_success" ).html( html );
									$( "#ced_tutorlms_cart_points_success" ).show();
								} else {
									message = response.message;
									html = message;
									$( "#ced_tutorlms_cart_points_notice" ).removeClass( 'ced_tutorlms_settings_display_none_notice' );
									$( "#ced_tutorlms_cart_points_notice" ).html( html );
									$( "#ced_tutorlms_cart_points_notice" ).show();
								}
								
							},
							complete: function(){
								// unblock( $( '.woocommerce-cart-form' ) );
								// unblock( $( '.woocommerce-cart-form' ) );
								location.reload();
							}
						}
					);
				} else if( order_limit !== 'undefined' && order_limit !== '' && order_limit !== null && order_limit > 0 ){
						if ($( ".woocommerce-cart-form" ).offset() ) {
							$(".ced_tutorlms_error").remove();
							$( 'html, body' ).animate(
								{
									scrollTop: $( ".woocommerce-cart-form" ).offset().top
								},
								800
							);
							var assing_message = '<ul class="woocommerce-error ced_tutorlms_error" role="alert"><li>' + ced_tutorlms.above_order_limit + '</li></ul>';
							$( assing_message ).insertBefore( $( '.woocommerce-cart-form' ) );
						} else {
							$(".ced_tutorlms_error").remove();
							$( 'html, body' ).animate(
								{
									scrollTop: $( ".custom_point_checkout" ).offset().top
								},
								800
							);
							var assing_message = '<ul class="woocommerce-error ced_tutorlms_error" role="alert"><li>' + ced_tutorlms.above_order_limit + '</li></ul>';
							$( assing_message ).insertBefore( $( '.custom_point_checkout' ) );
						}

				}else{
						if ($( ".woocommerce-cart-form" ).offset() ) {
							$(".ced_tutorlms_error").remove();
							$( 'html, body' ).animate(
								{
									scrollTop: $( ".woocommerce-cart-form" ).offset().top
								},
								800
							);
							var assing_message = '<ul class="woocommerce-error ced_tutorlms_error" role="alert"><li>' + ced_tutorlms.not_suffient + '</li></ul>';
							$( assing_message ).insertBefore( $( '.woocommerce-cart-form' ) );
						} else {
							$(".ced_tutorlms_error").remove();
							$( 'html, body' ).animate(
								{
									scrollTop: $( ".custom_point_checkout" ).offset().top
								},
								800
							);
							var assing_message = '<ul class="woocommerce-error ced_tutorlms_error" role="alert"><li>' + ced_tutorlms.not_suffient + '</li></ul>';
							$( assing_message ).insertBefore( $( '.custom_point_checkout' ) );
						}
					}
				}
			}
		);

	/*Removing Custom Points on Cart Subtotal handling via Ajax*/  // Paypal Issue Change End //
	$( document ).on(
		'click',
		'.ced_tutorlms_remove_virtual_coupon',
		function(e){
			e.preventDefault();
			if ( ! ced_tutorlms_frontend_obj.is_checkout ) {
				//block( $( '.woocommerce-cart-form' ) );
			}
			var $this = $(this);
			
			var data = {
				action:'ced_tutorlms_remove_cart_point',
				coupon_code: $(this).data('coupon'),
				ced_tutorlms_nonce:ced_tutorlms_frontend_obj.ced_tutorlms_nonce,
				is_checkout:ced_tutorlms_frontend_obj.is_checkout
			};
			$.ajax(
				{
					url: ced_tutorlms_frontend_obj.ajax_url,
					type: "POST",
					data: data,
					dataType :'json',
					success: function(response)
					{
						if (response.result == true) {
							$( '#ced_tutorlms_cart_points' ).val( '' );
							if ( ced_tutorlms_frontend_obj.is_checkout ) {
								setTimeout(function() {
									$this.closest('tr.cart-discount').remove();
									jQuery(document.body).trigger("update_checkout");
								}, 200);	
							}
							location.reload();
						}
					},
					complete: function(){
						if ( ! ced_tutorlms_frontend_obj.is_checkout ) {
							unblock( $( '.woocommerce-cart-form' ) );
							location.reload();
						}
					}
				}
			);
		}
	);
});



})( jQuery );

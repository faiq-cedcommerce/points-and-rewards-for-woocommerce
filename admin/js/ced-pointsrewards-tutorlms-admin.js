(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 $( document ).ready( function() {
		/* Update user Points in the points Table*/
		$( '.ced_tutorlms_save_changes_table' ).click( 
			function(){
				var user_id = $( this ).data( 'id' );
				var user_points = $( document ).find( "#add_sub_points" + user_id ).val();
				var sign = $( document ).find( "#ced_tutorlms_sign" + user_id ).val();
				var reason = $( document ).find( "#ced_tutorlms_remark" + user_id ).val();
				user_points = Number( user_points );
				if (user_points > 0 && user_points === parseInt( user_points, 10 )) {
					if ( reason != '' ) {
						jQuery( "#ced_tutorlms_loader" ).show();
						var data = {
							action:'ced_tutorlms_points_update',
							points:user_points,
							user_id:user_id,
							sign:sign,
							reason:reason,
							ced_tutorlms_pr_nonce:ced_tutorlms_pr_admin_obj.ced_tutorlms_pr_nonce,
						};
						$.ajax(
							{
								url: ced_tutorlms_pr_admin_obj.ajax_url,
								type: "POST",
								data: data,
								success: function(response)
							{
									jQuery( "#ced_tutorlms_loader" ).hide();
									$( 'html, body' ).animate(
										{
											scrollTop: $( ".ced_tutorlms_pr_header" ).offset().top
										},
										800
									);
									var assing_message = '<div class="notice notice-success is-dismissible"><p><strong>Points are updated successfully</strong></p></div>';
									$( assing_message ).insertAfter( $( '.ced_tutorlms_pr_header' ) );
									setTimeout( function(){ location.reload(); }, 1000 );
								}
							}
						);
					} else {
						alert( 'Please enter Remark' );
					}
				} else {
					alert( 'Please enter a valid point' );
				}
			}
		);
		
		
			/*=====  End of Sticky-Sidebar  ======*/
		$( document ).ready(
			function(){
					$( ".dashicons.dashicons-menu" ).click(
						function(){
							$( ".ced_tutorlms_pr_navigator_template" ).toggleClass( "open-btn" );
						}
					);
			}
		);
		
		
		$( document ).on(
			'click',
			'.ced_tutorlms_common_slider',
			function(){
				$( this ).next( '.ced_tutorlms_points_view' ).slideToggle( 'slow' );
				$( this ).toggleClass( 'active' );
			}
		);
		
		//end of ready function
	});

})( jQuery );

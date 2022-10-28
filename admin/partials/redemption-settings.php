<?php
/**
 * This is setttings array for the Redemption settings
 *
 * Redemption Settings Template
 *
 * @link       https://cedcommerce.com/
 * @since      1.0.0
 *
 * @package    ced-pointsrewards-tutorlms
 * @subpackage ced-pointsrewards-tutorlms/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
include_once CED_TUTORLMS_DIRPATH . '/admin/partials/settings/class-ced-tutor-lms-pointsrewards-settings.php';
$settings_obj = new CED_Tutor_LMS_Pointsrewards_Settings();
$ced_tutorlms_pr_redemption_settings = array(
	array(
		'title' => __( 'Redemption Settings', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'title',
	),
	array(
		'title' => __( 'Redemption Over Cart Sub-total', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'checkbox',
		'id'    => 'ced_tutorlms_custom_points_on_cart',
		'desc_tip' => __( 'Check this box if you want to let your customers redeem their earned points for the cart subtotal.', 'ced-pointsrewards-tutorlms' ),
		'class' => 'input-text',
		'desc'  => __( 'Allow customers to apply points during Cart.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Conversion rate for Cart Sub-total Redemption', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number_text',
		'number_text' => array(
			array(
				'type'  => 'number',
				'id'    => 'ced_tutorlms_cart_points_rate',
				'class'   => 'input-text wc_input_price ced_tutorlms_new_woo_ver_style_text',
				'custom_attributes' => array( 'min' => '"1"' ),
				'desc_tip' => __(
					'Entered point will assign to that user by which another user referred from referral link and purchase some products.',
					'ced-pointsrewards-tutorlms'
				),
				'desc' => __( ' Points = ', 'ced-pointsrewards-tutorlms' ),
				'curr' => '',
			),
			array(
				'type'  => 'text',
				'id'    => 'ced_tutorlms_cart_price_rate',
				'class'   => 'input-text ced_tutorlms_new_woo_ver_style_text wc_input_price',
				'custom_attributes' => array( 'min' => '"1"' ),
				'desc_tip' => __(
					'Entered point will assign to that user by which another user referred from referral link and purchase some products.',
					'ced-pointsrewards-tutorlms'
				),
				'default' => '1',
				'curr' => get_woocommerce_currency_symbol(),
			),
		),
	),
	array(
		'title' => __( 'Enable apply points during checkout', 'points-and-rewards-for-woocommerce' ),
		'type'  => 'checkbox',
		'id'    => 'ced_tutorlms_apply_points_checkout',
		'desc_tip' => __( 'Check this box if you want that customer can apply also apply points on checkout', 'points-and-rewards-for-woocommerce' ),
		'class' => 'input-text',
		'desc'  => __( 'Allow customers to apply points during checkout also.', 'points-and-rewards-for-woocommerce' ),
	),
	array(
		'type'  => 'sectionend',
	),

);
$ced_tutorlms_pr_redemption_settings = apply_filters( 'ced_tutorlms_pr_redemption_settings', $ced_tutorlms_pr_redemption_settings );
$current_tab = 'ced_tutorlms_pr_redemption_setting';
if ( isset( $_POST['ced_tutorlms_pr_save_redemption'] ) && isset( $_POST['wps-wpr-nonce'] ) ) {
	$ced_tutorlms_pr_nonce = sanitize_text_field( wp_unslash( $_POST['wps-wpr-nonce'] ) );
	if ( wp_verify_nonce( $ced_tutorlms_pr_nonce, 'wps-wpr-nonce' ) ) {
		?>
		<?php
		if ( 'ced_tutorlms_pr_redemption_setting' == $current_tab ) {
			/* Save Settings and check is not empty*/
			$postdata = map_deep( wp_unslash( $_POST ), 'sanitize_text_field' );
			$postdata = $settings_obj->check_is_settings_is_not_empty( $ced_tutorlms_pr_redemption_settings, $postdata );
			/* End of the save Settings and check is not empty*/
			$redemption_settings_array = array();

			foreach ( $postdata as $key => $value ) {
				$redemption_settings_array[ $key ] = $value;
			}
			if ( is_array( $redemption_settings_array ) && ! empty( $redemption_settings_array ) ) {
				$redemption_settings_array = apply_filters( 'ced_tutorlms_pr_redemption_settings_save_option', $redemption_settings_array );
				update_option( 'ced_tutorlms_pr_redemption_settings', $redemption_settings_array );
			}
			$settings_obj->ced_tutorlms_settings_saved();
			do_action( 'ced_tutorlms_pr_redemption_settings_save_option', $redemption_settings_array );
		}
	}
}
?>
	<?php $redemption_settings = get_option( 'ced_tutorlms_pr_redemption_settings', true ); ?>
	<?php
	if ( ! is_array( $redemption_settings ) ) :
		$redemption_settings = array();
endif;
	?>
	<?php do_action( 'ced_tutorlms_pr_add_notice' ); ?>
	<div class="ced_tutorlms_pr_table">
		<div class="ced_tutorlms_general_wrapper">
				<?php
				foreach ( $ced_tutorlms_pr_redemption_settings as $key => $value ) {
					if ( 'title' == $value['type'] ) {
						?>
					<div class="ced_tutorlms_general_row_wrap">
						<?php $settings_obj->ced_tutorlms_pr_generate_heading( $value ); ?>
					<?php } ?>
					<?php if ( 'title' != $value['type'] && 'sectionend' != $value['type'] ) { ?>
				<div class="ced_tutorlms_general_row">
						<?php $settings_obj->ced_tutorlms_pr_generate_label( $value ); ?>
					<div class="ced_tutorlms_general_content">
						<?php
						$settings_obj->ced_tutorlms_pr_generate_tool_tip( $value );
						if ( 'checkbox' == $value['type'] ) {
							$settings_obj->ced_tutorlms_pr_generate_checkbox_html( $value, $redemption_settings );
						}
						if ( 'number' == $value['type'] ) {
							$settings_obj->ced_tutorlms_pr_generate_number_html( $value, $redemption_settings );
						}
						if ( 'multiple_checkbox' == $value['type'] ) {
							foreach ( $value['multiple_checkbox'] as $k => $val ) {
								$settings_obj->ced_tutorlms_pr_generate_checkbox_html( $val, $redemption_settings );
							}
						}
						if ( 'text' == $value['type'] ) {
							$settings_obj->ced_tutorlms_pr_generate_text_html( $value, $redemption_settings );
						}
						if ( 'textarea' == $value['type'] ) {
							$settings_obj->ced_tutorlms_pr_generate_textarea_html( $value, $redemption_settings );
						}
						if ( 'number_text' == $value['type'] ) {
							foreach ( $value['number_text'] as $k => $val ) {
								if ( 'text' == $val['type'] ) {

									echo isset( $val['curr'] ) ? esc_html( $val['curr'] ) : '';
									$settings_obj->ced_tutorlms_pr_generate_text_html( $val, $redemption_settings );
									echo '<br>';

								}
								if ( 'number' == $val['type'] ) {

									$settings_obj->ced_tutorlms_pr_generate_number_html( $val, $redemption_settings );
								}
							}
						}
						do_action( 'ced_tutorlms_pr_additional_redemption_settings', $value, $redemption_settings );
						?>
					</div>
				</div>
				<?php } ?>
					<?php if ( 'sectionend' == $value['type'] ) : ?>
				 </div>	
				<?php endif; ?>
			<?php } ?> 		
		</div>
	</div>
	<div class="clear"></div>
	<p class="submit">
		<input type="submit" value='<?php esc_html_e( 'Save changes', 'ced-pointsrewards-tutorlms' ); ?>' class="button-primary woocommerce-save-button ced_tutorlms_save_changes" name="ced_tutorlms_pr_save_redemption">
	</p>
	<?php


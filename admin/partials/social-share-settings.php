<?php
/**
 * This is setttings array for the Social Sharing settings
 *
 * Social Sharing Settings Template
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
$ced_tutorlms_pr_social_share_settings = array(
	array(
		'title' => __( 'Referral', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'title',
	),
	array(
		'title' => __( 'Enable Referral Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'checkbox',
		'default'   => 0,
		'id'    => 'ced_tutorlms_refer_enable',
		'heading' => __( 'Sign Up', 'ced-pointsrewards-tutorlms' ),
		'class'   => 'input-text',
		'desc_tip' => __( 'Check this box to enable the Referral Points when the customer invites another  customers.', 'ced-pointsrewards-tutorlms' ),
		'desc'    => __( 'Enable Referral Points for Rewards.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Enter Referral Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_refer_value',
		'custom_attributes'   => array( 'min' => '1' ),
		'class'   => 'input-text ced_tutorlms_new_woo_ver_style_text',
		'desc_tip' => __( 'The points which the customer will get when they successfully invite given number of customers.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'type'  => 'sectionend',
	),
	array(
		'title' => __( 'Social Sharing', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'title',
	),
	array(
		'title' => __( 'Enable Social Links', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'checkbox',
		'default'   => 0,
		'id'    => 'ced_tutorlms_social_share_enable',
		'class'   => 'input-text',
		'desc_tip' => __( 'Enable Social Media Sharing.', 'ced-pointsrewards-tutorlms' ),
		'desc'  => __( 'Enable Social Media Sharing.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Select Social Links', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'multiple_checkbox',
		'id'    => 'ced_tutorlms_social_share_facebook',
		'desc_tip' => __( 'Check these boxes to share the referral link', 'ced-pointsrewards-tutorlms' ),
		'multiple_checkbox' => array(
			array(
				'type'  => 'checkbox',
				'id'    => 'ced_tutorlms_social_share_facebook',
				'class'   => 'input-text',
				'desc'  => __( 'Facebook', 'ced-pointsrewards-tutorlms' ),
			),
			array(
				'type'  => 'checkbox',
				'id'    => 'ced_tutorlms_social_share_twitter',
				'class'   => 'input-text',
				'desc'  => __( 'Twitter', 'ced-pointsrewards-tutorlms' ),
			),
			array(
				'type'  => 'checkbox',
				'id'    => 'ced_tutorlms_social_share_email',
				'class'   => 'input-text',
				'desc'  => __( 'Email', 'ced-pointsrewards-tutorlms' ),
			),
			array(
				'type'  => 'checkbox',
				'id'    => 'ced_tutorlms_social_share_whatsapp',
				'class'   => 'input-text',
				'desc'  => __( 'Whatsapp', 'ced-pointsrewards-tutorlms' ),
			),

		),
	),
	array(
		'type'  => 'sectionend',
	),
);
$ced_tutorlms_pr_social_share_settings = apply_filters( 'ced_tutorlms_pr_social_share_settings', $ced_tutorlms_pr_social_share_settings );
$current_tab = 'ced_tutorlms_pr_social_share_setting';
if ( isset( $_POST['ced_tutorlms_pr_save_social_share'] ) && isset( $_POST['wps-wpr-nonce'] ) ) {
	$ced_tutorlms_pr_nonce = sanitize_text_field( wp_unslash( $_POST['wps-wpr-nonce'] ) );
	if ( wp_verify_nonce( $ced_tutorlms_pr_nonce, 'wps-wpr-nonce' ) ) {
		?>
<?php
		if ( 'ced_tutorlms_pr_social_share_setting' == $current_tab ) {
			/* Save Settings and check is not empty*/
			$postdata = map_deep( wp_unslash( $_POST ), 'sanitize_text_field' );
			$postdata = $settings_obj->check_is_settings_is_not_empty( $ced_tutorlms_pr_social_share_settings, $postdata );
			/* End of the save Settings and check is not empty*/
			$social_share_settings_array = array();

			foreach ( $postdata as $key => $value ) {
				$social_share_settings_array[ $key ] = $value;
			}
			if ( is_array( $social_share_settings_array ) && ! empty( $social_share_settings_array ) ) {
				$social_share_settings_array = apply_filters( 'ced_tutorlms_pr_social_share_settings_save_option', $social_share_settings_array );
				update_option( 'ced_tutorlms_pr_social_share_settings', $social_share_settings_array );
			}
			$settings_obj->ced_tutorlms_settings_saved();
			do_action( 'ced_tutorlms_pr_social_share_settings_save_option', $social_share_settings_array );
		}
	}
}
?>
<?php $social_share_settings = get_option( 'ced_tutorlms_pr_social_share_settings', true ); ?>
<?php
	if ( ! is_array( $social_share_settings ) ) :
		$social_share_settings = array();
endif;
	?>
<?php do_action( 'ced_tutorlms_pr_add_notice' ); ?>
<div class="ced_tutorlms_pr_table">
    <div class="ced_tutorlms_general_wrapper">
        <?php
				foreach ( $ced_tutorlms_pr_social_share_settings as $key => $value ) {
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
							$settings_obj->ced_tutorlms_pr_generate_checkbox_html( $value, $social_share_settings );
						}
						if ( 'number' == $value['type'] ) {
							$settings_obj->ced_tutorlms_pr_generate_number_html( $value, $social_share_settings );
						}
						if ( 'multiple_checkbox' == $value['type'] ) {
							foreach ( $value['multiple_checkbox'] as $k => $val ) {
								$settings_obj->ced_tutorlms_pr_generate_checkbox_html( $val, $social_share_settings );
							}
						}
						if ( 'text' == $value['type'] ) {
							$settings_obj->ced_tutorlms_pr_generate_text_html( $value, $social_share_settings );
						}
						if ( 'textarea' == $value['type'] ) {
							$settings_obj->ced_tutorlms_pr_generate_textarea_html( $value, $social_share_settings );
						}
						if ( 'number_text' == $value['type'] ) {
							foreach ( $value['number_text'] as $k => $val ) {
								if ( 'text' == $val['type'] ) {

									echo isset( $val['curr'] ) ? esc_html( $val['curr'] ) : '';
									$settings_obj->ced_tutorlms_pr_generate_text_html( $val, $social_share_settings );
									echo '<br>';

								}
								if ( 'number' == $val['type'] ) {

									$settings_obj->ced_tutorlms_pr_generate_number_html( $val, $social_share_settings );
								}
							}
						}
						do_action( 'ced_tutorlms_pr_additional_social_share_settings', $value, $social_share_settings );
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
    <input type="submit" value='<?php esc_html_e( 'Save changes', 'ced-pointsrewards-tutorlms' ); ?>'
        class="button-primary woocommerce-save-button ced_tutorlms_save_changes" name="ced_tutorlms_pr_save_social_share">
</p>

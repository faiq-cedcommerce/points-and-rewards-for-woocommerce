<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://cedcommerce.com/
 * @since      1.0.0
 *
 * @package    Rewardeem_woocommerce_Points_Rewards
 * @subpackage Rewardeem_woocommerce_Points_Rewards/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;

}
if ( ! defined( 'WPS_PAR_ONBOARD_PLUGIN_NAME' ) ) {
	define( 'WPS_PAR_ONBOARD_PLUGIN_NAME', 'Points and Rewards for WooCommerce' );
}
if ( class_exists( 'CED_Tutor_LMS_Pointsrewards_Settings' ) ) {
	$this->onboard = new CED_Tutor_LMS_Pointsrewards_Settings();
}

$ced_tutorlms_setting_tab = array(
	'overview-setting' => array(
		'title'     => __( 'Overview', 'ced-pointsrewards-tutorlms' ),
		'file_path' => CED_TUTORLMS_DIRPATH . '/admin/partials/overview-settings.php',
	),
	'student-settings' => array(
		'title'     => __( 'Student Settings', 'ced-pointsrewards-tutorlms' ),
		'file_path' => CED_TUTORLMS_DIRPATH . '/admin/partials/student-settings.php',
	),
	'instructor-settings' => array(
		'title'     => __( 'Instructor Settings', 'ced-pointsrewards-tutorlms' ),
		'file_path' => CED_TUTORLMS_DIRPATH . '/admin/partials/instructor-settings.php',
	),
    'social-share-settings' => array(
		'title'     => __( 'Social Sharing Settings', 'ced-pointsrewards-tutorlms' ),
		'file_path' => CED_TUTORLMS_DIRPATH . '/admin/partials/social-share-settings.php',
	),
	'points-table' => array(
		'title'     => __( 'Points Table', 'ced-pointsrewards-tutorlms' ),
		'file_path' => CED_TUTORLMS_DIRPATH . 'admin/partials/ced-class-points-logs-table.php',
	),
    'redemption-settings' => array(
		'title'     => __( 'Redemption Settings', 'ced-pointsrewards-tutorlms' ),
		'file_path' => CED_TUTORLMS_DIRPATH . 'admin/partials/redemption-settings.php',
	),
);
// if ( ! is_plugin_active( 'ultimate-woocommerce-points-and-rewards/ultimate-woocommerce-points-and-rewards.php' ) ) {
// 	$ced_tutorlms_setting_tab['premium_plugin'] = array(
// 		'title' => esc_html__( 'Premium Features', 'ced-pointsrewards-tutorlms' ),
// 		'file_path' => CED_TUTORLMS_DIRPATH . 'admin/partials/templates/wps-wpr-premium-features.php',
// 	);
// }
//   $ced_tutorlms_setting_tab = apply_filters( 'ced_tutorlms_pr_add_setting_tab', $ced_tutorlms_setting_tab );

?>
<div class="wrap woocommerce" id="ced_tutorlms_pr_setting_wrapper">
    <form enctype="multipart/form-data" action="" id="mainform" method="post">
        <div class="ced_tutorlms_pr_header">
            <div class="ced_tutorlms_pr_header_content_left">
                <div>
                    <h3 class="ced_tutorlms_pr_setting_title">
                        <?php esc_html_e( 'Tutor LMS Points and Rewards', 'ced-pointsrewards-tutorlms' ); ?>
                    </h3>
                </div>
            </div>
            <div class="ced_tutorlms_pr_header_content_right">
                <ul>
                    <li class="ced_tutorlms_get_pro"><a
                            href="https://wpswings.com/contact-us/?utm_source=wpswings-contact-us&utm_medium=par-org-backend&utm_campaign=contact-us"
                            target="_blank">
                            <span class="dashicons dashicons-phone"></span>
                            <span
                                class="ced_tutorlms_contact_doc_text"><?php esc_html_e( 'Contact us', 'ced-pointsrewards-tutorlms' ); ?></span>
                        </a>
                    </li>
                    <li class="ced_tutorlms_get_pro"><a
                            href="https://docs.wpswings.com/ced-pointsrewards-tutorlms/?utm_source=wpswings-par-doc&utm_medium=par-org-backend&utm_campaign=documentation"
                            target="_blank">
                            <span class="dashicons dashicons-media-document"></span>
                            <span
                                class="ced_tutorlms_contact_doc_text"><?php esc_html_e( 'Doc', 'ced-pointsrewards-tutorlms' ); ?></span>
                        </a>
                    </li>
                    <?php
			if ( ! is_plugin_active( 'ultimate-woocommerce-points-and-rewards/ultimate-woocommerce-points-and-rewards.php' ) ) {
				?>
                    <li class="ced_tutorlms_get_pro"><a class="ced_go_pro_btn" 
                            href="https://wpswings.com/product/ced-pointsrewards-tutorlms-pro/?utm_source=wpswings-par-pro&utm_medium=par-org-backend&utm_campaign=go-pro"
                            target="_blank"><?php esc_html_e( 'GO PRO NOW', 'ced-pointsrewards-tutorlms' ); ?></a>
                    </li>
                    <?php
			}
			?>
                </ul>
            </div>
        </div>

        <?php
wp_nonce_field( 'wps-wpr-nonce', 'wps-wpr-nonce' );

?>
        <div class="ced_tutorlms_pr_main_template">
            <div class="ced_tutorlms_pr_body_template">
                <div class="ced_tutorlms_pr_mobile_nav">
                    <span class="dashicons dashicons-menu"></span>
                </div>
                <div class="ced_tutorlms_pr_navigator_template">
                    <div class="hubwoo-navigations">
                        <?php
				if ( ! empty( $ced_tutorlms_setting_tab ) && is_array( $ced_tutorlms_setting_tab ) ) {
					foreach ( $ced_tutorlms_setting_tab as $key => $wps_tab ) {
						if ( isset( $_GET['tab'] ) && $_GET['tab'] == $key ) {
							?>
                        <div class="ced_tutorlms_pr_tabs">
                            <a class="wps_gw_nav_tab nav-tab nav-tab-active"
                                href="?page=ced_tutor_lms_points_rewards&tab=<?php echo esc_html( $key ); ?>"><?php echo esc_html( $wps_tab['title'] ); ?></a>
                        </div>
                        <?php
						} else {
							if ( empty( $_GET['tab'] ) && 'overview-setting' == $key ) {
								?>
                        <div class="ced_tutorlms_pr_tabs">
                            <a class="wps_gw_nav_tab nav-tab nav-tab-active"
                                href="?page=ced_tutor_lms_points_rewards&tab=<?php echo esc_html( $key ); ?>"><?php echo esc_html( $wps_tab['title'] ); ?></a>
                        </div>
                        <?php
							} else {
								?>
                        <div class="ced_tutorlms_pr_tabs">
                            <a class="wps_gw_nav_tab nav-tab "
                                href="?page=ced_tutor_lms_points_rewards&tab=<?php echo esc_html( $key ); ?>"><?php echo esc_html( $wps_tab['title'] ); ?></a>
                        </div>
                        <?php
							}
						}
					}
				}
				?>
                    </div>
                </div>
                <div class="loading-style-bg ced_tutorlms_pr_settings_display_none" id="ced_tutorlms_loader">
                    <img src="<?php echo esc_url( CED_TUTORLMS_URL ); ?>admin/images/loading.gif">
                </div>
                <?php
		if ( ! empty( $ced_tutorlms_setting_tab ) && is_array( $ced_tutorlms_setting_tab ) ) {

			foreach ( $ced_tutorlms_setting_tab as $key => $wps_file ) {
				if ( isset( $_GET['tab'] ) && $_GET['tab'] == $key ) {
					$include_tab = $wps_file['file_path'];
					?>
                <div class="ced_tutorlms_pr_content_template">
                    <?php include_once $include_tab; ?>
                </div>
                <?php
				} elseif ( empty( $_GET['tab'] ) && 'overview-setting' == $key ) {
					?>
                <div class="ced_tutorlms_pr_content_template">
                    <?php include_once $wps_file['file_path']; ?>
                </div>
                <?php
					break;
				}
			}
		}
		?>
            </div>
        </div>
    </form>
</div>
<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://cedcommerce.com/
 * @since      1.0.0
 *
 * @package    Ced_Pointsrewards_Tutorlms
 * @subpackage Ced_Pointsrewards_Tutorlms/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ced_Pointsrewards_Tutorlms
 * @subpackage Ced_Pointsrewards_Tutorlms/public
 * @author     Cedcommerce <support@cedcommerce.com>
 */
class Ced_Pointsrewards_Tutorlms_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ced_Pointsrewards_Tutorlms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ced_Pointsrewards_Tutorlms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ced-pointsrewards-tutorlms-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ced_Pointsrewards_Tutorlms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ced_Pointsrewards_Tutorlms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$coupon_settings          = get_option( 'ced_tutorlms_coupons_gallery', array() );
		$ced_tutorlms_minimum_points_value = isset( $coupon_settings['ced_tutorlms_redemption_minimum_value'] ) ? $coupon_settings['ced_tutorlms_redemption_minimum_value'] : 50;
		$ced_tutorlms_cart_points_rate = $this->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_cart_points_rate' );
		$ced_tutorlms_cart_price_rate = $this->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_cart_price_rate' );


		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ced-pointsrewards-tutorlms-public.js', array('jquery','jquery-blockui' ), $this->version, false );
		$ced_tutorlms_array = array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'message' => esc_html__( 'Please enter a valid point', 'ced-pointsrewards-tutorlms' ),
			'empty_notice' => __( 'Please enter some points !!', 'ced-pointsrewards-tutorlms' ),
			'minimum_points' => $ced_tutorlms_minimum_points_value,
			'confirmation_msg' => __( 'Do you really want to upgrade your user level as this process will deduct the required points from your account?', 'ced-pointsrewards-tutorlms' ),
			'minimum_points_text' => __( 'The minimum Points Required To Convert Points To Coupons is ', 'ced-pointsrewards-tutorlms' ) . $ced_tutorlms_minimum_points_value,
			'ced_tutorlms_custom_notice' => __( 'The number of points you had entered will get deducted from your Account', 'ced-pointsrewards-tutorlms' ),
			'ced_tutorlms_nonce' => wp_create_nonce( 'ced_tutorlms-verify-nonce' ),
			'ced_tutorlms_cart_points_rate' => $ced_tutorlms_cart_points_rate,
			'ced_tutorlms_cart_price_rate' => $ced_tutorlms_cart_price_rate,
			'not_allowed' => __( 'Please enter some valid points!', 'ced-pointsrewards-tutorlms' ),
			'not_suffient' => __( 'You do not have a sufficient amount of points', 'ced-pointsrewards-tutorlms' ),
			'above_order_limit' => __( 'Entered points do not apply to this order.', 'ced-pointsrewards-tutorlms' ),
			'points_empty' => __( 'Please enter points.', 'ced-pointsrewards-tutorlms' ),
			'is_checkout' => is_checkout(),
		);
		wp_localize_script( $this->plugin_name, 'ced_tutorlms_frontend', $ced_tutorlms_array );
	}

	public function ced_tutorlms_dashboard_menu_items( $nav_items ){
		$new_items 	= array(
			'my-points' =>  array( 'title' => __( 'My Points', 'tutor-pro' ),'icon' => 'tutor-icon-wallet' ),
		);
		$nav_items = array_merge( $nav_items, $new_items );

		return $nav_items;
	}

	public function ced_tutorlms_dashboard_menu_items_template_location( $location ){
		global $wp_query;
		$query_vars = $wp_query->query_vars;
		
		if ( isset( $query_vars['tutor_dashboard_page'] ) && $query_vars['tutor_dashboard_page'] == 'my-points' ) {
			$location = CED_TUTORLMS_DIRPATH . '/public/partials/my-points-template.php';
		}
		return $location;
	
	}


	/**
	 * The function is used for set the cookie for referee
	 *
	 * @name ced_tutorlms_referral_link_using_cookie
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 */
	public function ced_tutorlms_referral_link_using_cookie() {

		if ( ! is_user_logged_in() ) {
			// $ced_tutorlms_ref_link_expiry = $this->ced_tutorlms_get_redemption_settings( 'ced_tutorlms_ref_link_expiry' );
			// if ( empty( $ced_tutorlms_ref_link_expiry ) ) {
			// 	$ced_tutorlms_ref_link_expiry = 365;
			// }
			$ced_tutorlms_ref_link_expiry = 365;
			if ( isset( $_GET['pkey'] ) && ! empty( $_GET['pkey'] ) ) {// phpcs:ignore WordPress.Security.NonceVerification
				$ced_tutorlms_referral_key = sanitize_text_field( wp_unslash( $_GET['pkey'] ) );// phpcs:ignore WordPress.Security.NonceVerification

				$referral_link = trim( $ced_tutorlms_referral_key );// phpcs:ignore WordPress.Security.NonceVerification

				if ( isset( $ced_tutorlms_ref_link_expiry ) && ! empty( $ced_tutorlms_ref_link_expiry ) && ! empty( $referral_link ) ) {
					setcookie( 'ced_tutorlms_cookie_set', $referral_link, time() + ( 86400 * $ced_tutorlms_ref_link_expiry ), '/' );
				}
			}
		}
	}

	/**
	 * This function is used to display the referral link
	 *
	 * @name ced_tutorlms_referral_section
	 * @since    1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param int $user_id of the user.
	 */
	public function ced_tutorlms_referral_section( $user_id ){
		
		$get_referral        = get_user_meta( $user_id, 'ced_tutorlms_points_referral', true );
		$get_referral_invite = get_user_meta( $user_id, 'ced_tutorlms_points_referral_invite', true );
		if ( empty( $get_referral ) && empty( $get_referral_invite ) ) {
			$referral_key = $this->ced_tutorlms_create_referral_code();
			$referral_invite = 0;
			update_user_meta( $user_id, 'ced_tutorlms_points_referral', $referral_key );
			update_user_meta( $user_id, 'ced_tutorlms_points_referral_invite', $referral_invite );
		}

		$get_referral        = get_user_meta( $user_id, 'ced_tutorlms_points_referral', true );
		$get_referral_invite = get_user_meta( $user_id, 'ced_tutorlms_points_referral_invite', true );

		$site_url = apply_filters( 'ced_tutorlms_referral_link_url', site_url() );
		?>
		<div class="ced_tutorlms_account_wrapper">
			<p class="ced_tutorlms_heading"><?php echo esc_html__( 'Referral Link', 'ced-pointsrewards-tutorlms' ); ?></p>
			<fieldset class="ced_tutorlms_each_section">
				<div class="ced_tutorlms_refrral_code_copy">
					<p id="ced_tutorlms_copy"><code><?php echo esc_url( $site_url . '?pkey=' . $get_referral ); ?></code></p>
					<button class="ced_tutorlms_btn_copy ced_tutorlms_tooltip" data-clipboard-target="#ced_tutorlms_copy" aria-label="copied">
						<span class="ced_tutorlms_tooltiptext"><?php esc_html_e( 'Copy', 'ced-pointsrewards-tutorlms' ); ?></span>
						<img src="<?php echo esc_url( CED_TUTORLMS_URL . 'public/images/copy.png' ); ?>" alt="Copy to clipboard">
					</button>
				</div>
				<?php
					$this->ced_tutorlms_get_social_sharing_section( $user_id );
				?>
			</fieldset>
		</div>
		<?php
	}	

	/**
	 * This function used to display the social sharing
	 *
	 * @name ced_tutorlms_get_social_sharing_section
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param int $user_id userid of the customer.
	 */
	public function ced_tutorlms_get_social_sharing_section( $user_id ) {
		$enable_ced_tutorlms_social  = $this->ced_tutorlms_social_share_settings_num( 'ced_tutorlms_social_share_enable' );
		$user_reference_key 		 = get_user_meta( $user_id, 'ced_tutorlms_points_referral', true );
		$page_permalink 			 = apply_filters( 'ced_tutorlms_referral_link_url', site_url() );
		if ( $enable_ced_tutorlms_social ) {
			$content  = '';
			$html_div = '<div class="ced_tutorlms_wrapper_button">';
			$content  = $content . $html_div;
			$share_button = '<div class="ced_tutorlms_btn ced_tutorlms_common_class"><a class="twitter-share-button" href="https://twitter.com/intent/tweet?text=' . $page_permalink . '?pkey=' . $user_reference_key . '" target="_blank"><img src ="' . CED_TUTORLMS_URL . '/public/images/twitter.png">' . __( 'Tweet', 'cedc-pointsrewards-tutorlms' ) . '</a></div>';

			$fb_button = '<div id="fb-root"></div>
			
			<div class="fb-share-button ced_tutorlms_common_class" data-href="' . $page_permalink . '?pkey=' . $user_reference_key . '" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">' . __( 'Share', 'cedc-pointsrewards-tutorlms' ) . '</a></div>';

			$mail = '<a class="ced_tutorlms_mail_button ced_tutorlms_common_class" href="mailto:enteryour@addresshere.com?subject=Click on this link &body=Check%20this%20out:%20' . $page_permalink . '?pkey=' . $user_reference_key . '" rel="nofollow"><img src ="' . CED_TUTORLMS_URL . 'public/images/email.png"></a>';
			$maill = apply_filters( 'ced_tutorlms_mail_box', $content, $user_id );

			$whatsapp = '<a target="_blank" class="ced_tutorlms_whatsapp_share" href="https://api.whatsapp.com/send?text=' . rawurlencode( $page_permalink ) . '?pkey=' . $user_reference_key . '"><img src="' . CED_TUTORLMS_URL . 'public/images/whatsapp.png"></a>';
			if ( $this->ced_tutorlms_social_share_settings_num( 'ced_tutorlms_social_share_facebook' ) == 1 ) {

				$content = $content . $fb_button;
			}
			if ( $this->ced_tutorlms_social_share_settings_num( 'ced_tutorlms_social_share_twitter' ) == 1 ) {

				$content = $content . $share_button;
			}
			echo wp_kses_post( $content );

			if ( $this->ced_tutorlms_social_share_settings_num( 'ced_tutorlms_social_share_email' ) == 1 ) {

				if ( $maill != $html_div ) {
					$content2 = $maill;

				} else {
					$content2 = $mail;
				}
			}
			$allowed_html = array(
				'div' => array(
					'id' => array(),
					'class' => array(),
				),
				'a' => array(
					'href' => array(),
					'class' => array(),
				),
				'p' => array(
					'id' => array(),
				),
				'button' => array(
					'id' => array(),
					'class' => array(),
				),
				'img' => array(
					'src' => array(),
				),
				'input' => array(
					'type' => array(),
					'style' => array(),
					'id' => array(),
					'value' => array(),
					'placeholder' => array(),
					'name' => array(),
					'data-id' => array(),
				),
			);
			echo wp_kses( $content2, $allowed_html );
			if ( $this->ced_tutorlms_social_share_settings_num( 'ced_tutorlms_social_share_whatsapp' ) == 1 ) {

				$content3 = $whatsapp;
			}

			$content3 = $content3 . '</div>';
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo wp_kses_post( $content3 );

		}
	}

	/**
	 * Dynamically Generate referral Code
	 *
	 * @name ced_tutorlms_create_referral_code
	 * @link https://www.cedcommerce.com/
	 */
	public function ced_tutorlms_create_referral_code() {
		$length = 10;
		$pkey = '';
		$alphabets = range( 'A', 'Z' );
		$numbers = range( '0', '9' );
		$final_array = array_merge( $alphabets, $numbers );
		while ( $length-- ) {
			$key = array_rand( $final_array );
			$pkey .= $final_array[ $key ];
		}
		return $pkey;
	}

	/**
	 * Get social share settings
	 *
	 * @name ced_tutorlms_social_share_settings_num
	 * @link https://www.cedcommerce.com/
	 * @param string $id id of the setting.
	 */
	public function ced_tutorlms_social_share_settings_num( $id ) {
		$ced_tutorlms_social_share_value = 0;
		$social_share_settings = get_option( 'ced_tutorlms_pr_social_share_settings', true );
		if ( ! empty( $social_share_settings[ $id ] ) ) {
			$ced_tutorlms_social_share_value = (int) $social_share_settings[ $id ];
		}
		return $ced_tutorlms_social_share_value;
	}

	/**
	 * Add new field to the Instructor Registration Form
	 *
	 * @name ced_tutorlms_add_field_instructor_registration_form
	 * @link https://www.cedcommerce.com/
	*/
	public function ced_tutorlms_add_field_instructor_registration_form(  ){
		$cookie_val = isset( $_COOKIE['ced_tutorlms_cookie_set'] ) ? sanitize_text_field( wp_unslash( $_COOKIE['ced_tutorlms_cookie_set'] ) ) : '';
		echo '<input type="hidden" name="ced_tutorlms_cookie_val" value="'. $cookie_val .'" >';
	}

	/**
	 * Get value of Instructor registration cookie value and update in user meta 
	 *
	 * @name ced_tutorlms_add_field_value_instructor_registration_form
	 * @link https://www.cedcommerce.com/
	 * @param int $id User Id.
	*/
	public function ced_tutorlms_add_field_value_instructor_registration_form( $user_id ){
		
		update_user_meta( $user_id, 'registration_cookie_value', $_COOKIE['ced_tutorlms_cookie_set'] );
		if ( isset( $_COOKIE['ced_tutorlms_cookie_set'] ) && ! empty( $_COOKIE['ced_tutorlms_cookie_set'] ) ) {
			setcookie( 'ced_tutorlms_cookie_set', '', time() - 3600, '/' );
		}
	}

	/**
	 * Showing Date of Birth Field in the setting->profile tab of the frontend dashboard 
	 *
	 * @name ced_tutorlms_add_dob_field_profile
	 * @link https://www.cedcommerce.com/
	 * @param object $user User Data.
	*/
	public function ced_tutorlms_add_dob_field_profile( $user ){
		$today_date = date_i18n( 'Y-m-d' );
		if( empty(get_user_meta( $user->ID, '_tutor_profile_dob', true ))){
			
			?>
			<div class="tutor-row">
				<div class="tutor-col-12 tutor-col-sm-6 tutor-col-md-12 tutor-col-lg-6 tutor-mb-32">
					<label class="tutor-form-label tutor-color-secondary">
						<?php esc_html_e( 'Date of Birth', 'tutor' ); ?>
					</label>
					<input class="tutor-form-control" type="date" name="_tutor_profile_dob" value="<?php esc_attr_e( get_user_meta( $user->ID, '_tutor_profile_dob', true ) ); ?>" max="<?php echo $today_date?>" placeholder="<?php esc_attr_e( 'Date of Birth', 'tutor' ); ?>">
				</div>
			</div>
			<?php
		}else{
			?>
			<div class="tutor-row">
				<div class="tutor-col-12 tutor-col-sm-6 tutor-col-md-12 tutor-col-lg-6 tutor-mb-32">
					<label class="tutor-form-label tutor-color-secondary">
						<?php esc_html_e( 'Date of Birth', 'tutor' ); ?>
					</label>
					
					<input class="tutor-form-control" type="hidden" name="_tutor_profile_dob" value="<?php esc_attr_e( get_user_meta( $user->ID, '_tutor_profile_dob', true ) ); ?>" max="<?php echo $today_date?>" >
					<?php echo get_user_meta( $user->ID, '_tutor_profile_dob', true ); ?>
				</div>
			</div>
			<?php
		}	
	}

	/**
	 * Adding custom date of birth field value to the database
	 *
	 * @name ced_tutorlms_add_dob_field_profile_to_db
	 * @link https://www.cedcommerce.com/
	 * @param int $user User Id.
	*/
	public function ced_tutorlms_add_dob_field_profile_to_db( $user_id ){
		if( !isset( $_POST['_tutor_lms_profile_dob_field'] )){
			$today_date = date_i18n( 'Y-m-d' );
			$user_dob 	= sanitize_text_field( tutor_utils()->avalue_dot( '_tutor_profile_dob', $_POST ) );		
			$today_date = strtotime( $today_date );
			$dob 		= strtotime( $user_dob );

			if( $today_date < $dob ){
				wp_send_json_error( array('message' => 'Wrong Date of Birth' ) );
			}else{
				update_user_meta( $user_id, '_tutor_profile_dob', $user_dob );
			}
		}
		
	}

	/**
	 * This function is used to add the html boxes for "Redemption on Cart sub-total"
	 *
	 * @name ced_tutorlms_woocommerce_cart_coupon
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 */
	public function ced_tutorlms_woocommerce_cart_coupon(){
		// check allowed user for points features.
		if ( apply_filters( 'ced_tutorlms_allowed_user_roles_points_features', false ) ) {
			return;
		}
		/*Get the value of the custom points*/
		$ced_tutorlms_custom_points_on_cart = $this->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_custom_points_on_cart' );
		if ( 1 == $ced_tutorlms_custom_points_on_cart ) {
			$user_id = get_current_user_ID();
			$get_points = (int) get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
			$get_min_redeem_req = $this->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_apply_points_value' );
			if ( empty( $get_points ) ) {
				$get_points = 0;
			}
			if ( isset( $user_id ) && ! empty( $user_id ) ) {
				$ced_tutorlms_order_points = apply_filters( 'ced_tutorlms_enable_points_on_order_total', false );
				if ( $ced_tutorlms_order_points ) {
					do_action( 'ced_tutorlms_points_on_order_total', $get_points, $user_id, $get_min_redeem_req );
				} else {
					?>
					<?php
					if ( $get_min_redeem_req < $get_points ) {
						?>
						<div class="ced_tutorlms_apply_custom_points">

							<input type="number" min="0" name="ced_tutorlms_cart_points" class="input-text" id="ced_tutorlms_cart_points" value="" placeholder="<?php esc_attr_e( 'Points', 'ced-pointsrewards-tutorlms' ); ?>"/>

							<button class="button ced_tutorlms_cart_points_apply" name="ced_tutorlms_cart_points_apply" id="ced_tutorlms_cart_points_apply" value="<?php esc_html_e( 'Apply Points', 'ced-pointsrewards-tutorlms' ); ?>" data-point="<?php echo esc_html( $get_points ); ?>" data-id="<?php echo esc_html( $user_id ); ?>" data-order-limit="0"><?php esc_html_e( 'Apply Points', 'ced-pointsrewards-tutorlms' ); ?></button>
							
							<p><?php esc_html_e( 'Your available Points and Rewards Tutor LMS Points:', 'ced-pointsrewards-tutorlms' ); ?>
							<?php echo esc_html( $get_points ); ?></p>
						</div>	
						<?php
					} else {
						$extra_req = abs( $get_min_redeem_req - $get_points );
						?>
						<div class="ced_tutorlms_apply_custom_points">
						<input type="number" min="0" name="ced_tutorlms_cart_points" class="input-text" id="ced_tutorlms_cart_points" value="" placeholder="<?php esc_attr_e( 'Points', 'ced-pointsrewards-tutorlms' ); ?>" readonly/>
						<button class="button ced_tutorlms_cart_points_apply" name="ced_tutorlms_cart_points_apply" id="ced_tutorlms_cart_points_apply" value="<?php esc_html_e( 'Apply Points', 'ced-pointsrewards-tutorlms' ); ?>" data-point="<?php echo esc_html( $get_points ); ?>" data-id="<?php echo esc_html( $user_id ); ?>" data-order-limit="0" disabled><?php esc_html_e( 'Apply Points', 'ced-pointsrewards-tutorlms' ); ?></button>
						<p><?php esc_html_e( 'You require :', 'ced-pointsrewards-tutorlms' ); ?>
						<?php echo esc_html( $extra_req ); ?></p>
						<p><?php esc_html_e( 'more to get redeem', 'ced-pointsrewards-tutorlms' ); ?>
						<?php
					}
				}
			}
		}
	}

	/**
	 * This function is used to apply fee on cart total
	 *
	 * @name ced_tutorlms_apply_fee_on_cart_subtotal
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 */
	public function ced_tutorlms_apply_fee_on_cart_subtotal() {
		
		check_ajax_referer( 'ced_tutorlms-verify-nonce', 'ced_tutorlms_nonce' );
		
		$response['result'] = false;
		$response['message'] = __( 'Can not redeem!', 'ced-pointsrewards-tutorlms' );
		if ( ! empty( $_POST['user_id'] ) && isset( $_POST['user_id'] ) ) {
			$user_id = sanitize_text_field( wp_unslash( $_POST['user_id'] ) );
		}
		if ( ! empty( $_POST['ced_tutorlms_points'] ) && isset( $_POST['ced_tutorlms_points'] ) ) {
			$ced_tutorlms_cart_points = sanitize_text_field( wp_unslash( $_POST['ced_tutorlms_points'] ) );
		}
		
		if ( isset( $user_id ) && ! empty( $user_id ) ) {
			if ( isset( $ced_tutorlms_cart_points ) && ! empty( $ced_tutorlms_cart_points ) ) {
				WC()->session->set( 'ced_tutorlms_cart_points', $ced_tutorlms_cart_points );
				$response['result'] = true;
				$response['message'] = esc_html__( 'Custom Point has been applied Successfully!', 'ced-pointsrewards-tutorlms' );
			} else {
				$response['result'] = false;
				$response['message'] = __( 'Please enter some valid points!', 'ced-pointsrewards-tutorlms' );
			}
		}
		wp_send_json( $response );
		
	}

	/**
	 * This function is used to display contents before woocommerce cart
	 *
	 * @name ced_tutorlms_woocommerce_before_cart_contents
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 */
	public function ced_tutorlms_woocommerce_before_cart_contents() {
		// check allowed user for points features.
		if ( apply_filters( 'ced_tutorlms_allowed_user_roles_points_features', false ) ) {
			return;
		}
		/*Check is custom points on cart is enable*/
		$ced_tutorlms_custom_points_on_checkout = $this->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_apply_points_checkout' );
		$ced_tutorlms_custom_points_on_cart = $this->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_custom_points_on_cart' );
		/*Get the Notification*/
		$ced_tutorlms_notification_color = '';
		$ced_tutorlms_notification_color = ( ! empty( $ced_tutorlms_notification_color ) ) ? $ced_tutorlms_notification_color : '#55b3a5';
		/*Get the cart point rate*/
		$ced_tutorlms_cart_points_rate = $this->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_cart_points_rate' );
		$ced_tutorlms_cart_points_rate = ( 0 == $ced_tutorlms_cart_points_rate ) ? 1 : $ced_tutorlms_cart_points_rate;
		/*Get the cart price rate*/
		$ced_tutorlms_cart_price_rate = $this->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_cart_price_rate' );
		$ced_tutorlms_cart_price_rate = ( 0 == $ced_tutorlms_cart_price_rate ) ? 1 : $ced_tutorlms_cart_price_rate;
		/*Get current user id*/
		$user_id = get_current_user_ID();
		if ( ( 1 == $ced_tutorlms_custom_points_on_cart || 1 === $ced_tutorlms_custom_points_on_checkout ) && isset( $user_id ) && ! empty( $user_id ) ) {
			?>
			<div class="woocommerce-message"><?php esc_html_e( 'Here is the Discount Rule for Applying your Points to Cart Total', 'ced-pointsrewards-tutorlms' ); ?>
				<ul>
					<li>
					<?php
					$allowed_tags = $this->ced_tutorlms_allowed_html();
					echo esc_html( $ced_tutorlms_cart_points_rate ) . esc_html__( ' Points', 'ced-pointsrewards-tutorlms' ) . ' = ' . wp_kses( wc_price( $ced_tutorlms_cart_price_rate ), $allowed_tags );
					?>
					</li>
				</ul>
			</div>
			<div class="woocommerce-error ced_tutorlms_settings_display_none_notice" id="ced_tutorlms_cart_points_notice" ></div>
			<div class="woocommerce-message ced_tutorlms_settings_display_none_notice" id="ced_tutorlms_cart_points_success" ></div>
			<?php
		}
	}

	/**
	 * This function is used to apply custom points on Cart Total.
	 *
	 * @name ced_tutorlms_woocommerce_cart_custom_points
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param array $cart  array of the cart.
	 */
	public function ced_tutorlms_woocommerce_cart_custom_points( $cart ) {
		
		global $woocommerce;
		/*Get the current user id*/
		$my_cart_change_return = 0;
		if ( isset( $cart ) && ! empty( $cart ) ) {
			$my_cart_change_return = apply_filters( 'ced_tutorlms_cart_content_check_for_sale_item', $cart );
		}
		if ( '1' == $my_cart_change_return ) {
			return;
		} else {
			$user_id = get_current_user_ID();
			/*Check is custom points on cart is enable*/
			$ced_tutorlms_custom_points_on_cart = $this->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_custom_points_on_cart' );
			$ced_tutorlms_custom_points_on_checkout = $this->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_apply_points_checkout' );
			if ( isset( $user_id ) && ! empty( $user_id ) && ( 1 == $ced_tutorlms_custom_points_on_cart || 1 == $ced_tutorlms_custom_points_on_checkout ) ) {
				/*Get the cart point rate*/
				$ced_tutorlms_cart_points_rate = $this->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_cart_points_rate' );
				$ced_tutorlms_cart_points_rate = ( 0 == $ced_tutorlms_cart_points_rate ) ? 1 : $ced_tutorlms_cart_points_rate;
				$ced_tutorlms_cart_price_rate = $this->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_cart_price_rate' );
				$ced_tutorlms_cart_price_rate = ( 0 == $ced_tutorlms_cart_price_rate ) ? 1 : $ced_tutorlms_cart_price_rate;
				
				if ( ! empty( WC()->session->get( 'ced_tutorlms_cart_points' ) ) ) {
					
					$ced_tutorlms_points = WC()->session->get( 'ced_tutorlms_cart_points' );
					$ced_tutorlms_fee_on_cart = ( $ced_tutorlms_points * $ced_tutorlms_cart_price_rate / $ced_tutorlms_cart_points_rate );
					$cart_discount = __( 'Tutor LMS Cart Discount', 'ced-pointsrewards-tutorlms' );
					// apply points on subtotal.
					$subtotal = $cart->get_subtotal();
					
					if ( $subtotal > $ced_tutorlms_fee_on_cart ) {
						$ced_tutorlms_fee_on_cart = $ced_tutorlms_fee_on_cart;
					} else {

						$ced_tutorlms_fee_on_cart = $subtotal;
					}
					do_action( 'ced_tutorlms_change_amount_cart', $ced_tutorlms_fee_on_cart, $cart, $cart_discount );

					// Paypal Issue Change Start.
					
					if ( isset( $woocommerce->cart ) ) {
						if ( ! $woocommerce->cart->has_discount( $cart_discount ) ) {
							if ( $woocommerce->cart->applied_coupons ) {
								foreach ( $woocommerce->cart->applied_coupons as $code ) {
									if ( $cart_discount === $code ) {
										return;
									}
								}
							}
							$woocommerce->cart->applied_coupons[] = $cart_discount;
						}
					}
				}
			}
		}
	}

	/**
	 * This is function is used for the validating the data.
	 *
	 * @name ced_tutorlms_allowed_html
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 */
	public function ced_tutorlms_allowed_html() {
		$allowed_tags = array(
			'span' => array(
				'class' => array(),
				'title' => array(),
				'style' => array(),
				'data-tip' => array(),
			),
			'min' => array(),
			'max' => array(),
			'class' => array(),
			'style' => array(),
			'<br>'  => array(),
			'div'   => array(
				'class' => array(),
				'id'    => 'fb-root',
				'data-href' => array(),
				'data-size' => array(),
				'data-mobile-iframe' => array(),
				'data-layount' => array( 'button_count' ),

			),
			'script' => '(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.9"; fjs.parentNode.insertBefore(js, fjs); }(document, "script", "facebook-jssdk"))',
			'a'     => array(
				'class' => array(),
				'target' => array(),
				'href'  => array(),
				'src'   => array(),
			),
			'img' => array(
				'src' => array(),
			),
		);
		return apply_filters( 'ced_tutorlms_allowed_html', $allowed_tags );

	}

	
	/**
	 * This function is used to apply discount using coupon.
	 *
	 * @param string $response response.
	 * @param object $coupon_data coupon data.
	 * @return string
	 */
	public function ced_tutorlms_validate_virtual_coupon_for_points( $response, $coupon_data ) {
		
		if ( ! is_plugin_active( 'ultimate-woocommerce-points-and-rewards/ultimate-woocommerce-points-and-rewards.php' ) ) {
			if ( ! is_admin() ) {
				if ( false !== $coupon_data && 0 !== $coupon_data ) {

					/*Get the current user id*/
					$my_cart_change_return = 0;
					if ( ! empty( WC()->cart ) ) {
						$my_cart_change_return = apply_filters( 'ced_tutorlms_cart_content_check_for_sale_item', WC()->cart->get_cart() );
					}
					$cart_discount = __( 'Tutor LMS Cart Discount', 'ced-pointsrewards-tutorlms' );
					if ( '1' == $my_cart_change_return ) {
						return;
					} else {
							$user_id = get_current_user_ID();
							/*Check is custom points on cart is enable*/
							$ced_tutorlms_custom_points_on_cart = $this->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_custom_points_on_cart' );
							$ced_tutorlms_custom_points_on_checkout = $this->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_apply_points_checkout' );
							if ( isset( $user_id ) && ! empty( $user_id ) && ( 1 == $ced_tutorlms_custom_points_on_cart || 1 == $ced_tutorlms_custom_points_on_checkout ) ) {
								/*Get the cart point rate*/
								$ced_tutorlms_cart_points_rate = $this->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_cart_points_rate' );
								$ced_tutorlms_cart_points_rate = ( 0 == $ced_tutorlms_cart_points_rate ) ? 1 : $ced_tutorlms_cart_points_rate;
								$ced_tutorlms_cart_price_rate = $this->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_cart_price_rate' );
								$ced_tutorlms_cart_price_rate = ( 0 == $ced_tutorlms_cart_price_rate ) ? 1 : $ced_tutorlms_cart_price_rate;

								if ( isset( WC()->session ) && WC()->session->has_session() ) {
									if ( ! empty( WC()->session->get( 'ced_tutorlms_cart_points' ) ) ) {
										$ced_tutorlms_points = WC()->session->get( 'ced_tutorlms_cart_points' );
										$ced_tutorlms_fee_on_cart = ( $ced_tutorlms_points * $ced_tutorlms_cart_price_rate / $ced_tutorlms_cart_points_rate );

										global $woocommerce;
										
										// apply points on subtotal.
										$subtotal = $woocommerce->cart->get_subtotal();
										if ( $subtotal > $ced_tutorlms_fee_on_cart ) {
											$ced_tutorlms_fee_on_cart = $ced_tutorlms_fee_on_cart;
										} else {

											$ced_tutorlms_fee_on_cart = $subtotal;
										}
										
										if ( $coupon_data == $cart_discount ) {
											$discount_type = 'fixed_cart';
											$coupon = array(
												'id' => time() . rand( 2, 9 ),
												'amount' => $ced_tutorlms_fee_on_cart,
												'individual_use' => false,
												'product_ids' => array(),
												'exclude_product_ids' => array(),
												'usage_limit' => '',
												'usage_limit_per_user' => '',
												'limit_usage_to_x_items' => '',
												'usage_count' => '',
												'expiry_date' => '',
												'apply_before_tax' => 'yes',
												'free_shipping' => false,
												'product_categories' => array(),
												'exclude_product_categories' => array(),
												'exclude_sale_items' => false,
												'minimum_amount' => '',
												'maximum_amount' => '',
												'customer_email' => '',
											);
											$coupon['discount_type'] = $discount_type;
											return $coupon;
										}
									}
								}
							}
					}
				}
			}
		}
		return $response;
	}

	/**
	 * This function is used to rename discount type in cart page
	 *
	 * @param string $sprintf sprintf.
	 * @param object $coupon coupon.
	 * @return string
	 */
	public function ced_tutorlms_filter_woocommerce_coupon_label( $sprintf, $coupon ){
		$cart_discount = __( 'Tutor LMS Cart Discount', 'ced-pointsrewards-tutorlms' );
		$coupon_data   = $coupon->get_data();
		if ( ! empty( $coupon_data ) ) {
			if ( strtolower( $coupon_data['code'] ) === strtolower( $cart_discount ) ) {
				$sprintf = $cart_discount;
			}
		}
		return $sprintf;
	}

	/**
	 * This function is used to remove coupon.
	 *
	 * @param string $coupon_html coupon html.
	 * @param object $coupon coupon.
	 * @param string $discount_amount_html discount amount html.
	 * @return string
	 */
	public function ced_tutorlms_virtual_coupon_remove( $coupon_html, $coupon, $discount_amount_html ) {
		
		$cart_discount = __( 'Tutor LMS Cart Discount', 'ced-pointsrewards-tutorlms' );
		$coupon_data = $coupon->get_data();
		if ( ! empty( $coupon_data ) ) {
			if ( strtolower( $coupon_data['code'] ) === strtolower( $cart_discount ) ) {
				$coupon_html = $discount_amount_html . ' <a href="' . esc_url( add_query_arg( 'remove_coupon', urlencode( $coupon->get_code() ), defined( 'WOOCOMMERCE_CHECKOUT' ) ? wc_get_checkout_url() : wc_get_cart_url() ) ) . '" class="ced_tutorlms_remove_virtual_coupon" data-coupon="' . esc_attr( $coupon->get_code() ) . '">' . __( '[Remove]', 'woocommerce' ) . '</a>';
			}
		}
		return $coupon_html;
	}

	/**
	 * This function is used to Remove Cart Discount Fee.
	 *
	 * @name ced_tutorlms_remove_cart_point
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 */
	public function ced_tutorlms_remove_cart_point() {
		check_ajax_referer( 'ced_tutorlms-verify-nonce', 'ced_tutorlms_nonce' );
		$response['result']  = false;
		$response['message'] = __( 'Failed to Remove Cart Discount', 'ced-pointsrewards-tutorlms' );
		$cart_discount       = __( 'Tutor LMS Cart Discount', 'ced-pointsrewards-tutorlms' );
		$coupon_code         = isset( $_POST['coupon_code'] ) && ! empty( $_POST['coupon_code'] ) ? sanitize_text_field( wp_unslash( $_POST['coupon_code'] ) ) : '';
		if ( ! empty( WC()->session->get( 'ced_tutorlms_cart_points' ) ) ) {
			WC()->session->__unset( 'ced_tutorlms_cart_points' );
			$response['result'] = true;
			$response['message'] = __( 'Successfully Removed Cart Discount', 'ced-pointsrewards-tutorlms' );
		}
		if ( isset( WC()->cart ) ) {
			if ( null !== WC()->cart->get_applied_coupons() && ! empty( WC()->cart->get_applied_coupons() ) ) {
				foreach ( WC()->cart->get_applied_coupons() as $code ) {
					$coupon = new WC_Coupon( $code );
					if ( strtolower( $code ) === strtolower( $cart_discount ) ) {
						WC()->cart->remove_coupon( $code );
					}
				}
			}
		}
		wp_send_json( $response );
	}

	
	/**
	 * This function is used to allow customer can apply points during checkout.
	 *
	 * @name ced_tutorlms_overwrite_form_temp
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param string $path path of the templates.
	 * @param string $template_name name of the file.
	 */
	public function ced_tutorlms_overwrite_form_temp( $path, $template_name ) {
		/*Check is apply points on the cart is enable or not*/
		$ced_tutorlms_custom_points_on_checkout = $this->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_apply_points_checkout' );
		$ced_tutorlms_custom_points_on_cart = $this->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_custom_points_on_cart' );

		if ( 1 == $ced_tutorlms_custom_points_on_checkout ) {
			if ( 'checkout/form-coupon.php' == $template_name ) {
				return CED_TUTORLMS_DIRPATH . 'public/woocommerce/checkout/form-coupon.php';
			}
		}
		return $path;
	}

	/**
	 * This function is used to add Remove button along with Cart Discount Fee
	 *
	 * @name ced_tutorlms_woocommerce_cart_totals_fee_html.
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param string $cart_totals_fee_html html of the fees.
	 * @param array  $fee array of the fees.
	 */
	public function ced_tutorlms_woocommerce_cart_totals_fee_html( $cart_totals_fee_html, $fee ) {
		if ( isset( $fee ) && ! empty( $fee ) ) {
			$fee_name = $fee->name;
			$cart_discount = __( 'Tutor LMS Cart Discount', 'ced-pointsrewards-tutorlms' );
			if ( isset( $fee_name ) && $cart_discount == $fee_name ) {
				$cart_totals_fee_html = $cart_totals_fee_html . '<a href="javascript:void(0);" id="ced_tutorlms_remove_cart_point">' . __( '[Remove]', 'ced-pointsrewards-tutorlms' ) . '</a>';
			}
		}
		return $cart_totals_fee_html;
	}

	

	/**
	 * Get redemption settings
	 *
	 * @name ced_tutorlms_redemption_settings_num
	 * @link https://www.cedcommerce.com/
	 * @param string $id id of the setting.
	 */
	public function ced_tutorlms_get_redemption_settings_num( $id ) {
		$ced_tutorlms_referal_value = 0;
		$redemption_settings = get_option( 'ced_tutorlms_pr_redemption_settings', true );
		if ( ! empty( $redemption_settings[ $id ] ) ) {
			$ced_tutorlms_redemption_value = (int) $redemption_settings[ $id ];
		}
		return $ced_tutorlms_redemption_value;
	}

	/**
	 * This function is used for display the apply points Setting.
	 *
	 * @since 1.0.1
	 * @name ced_tutorlms_display_apply_points_checkout
	 * @link https://cedcommerce.com
	 */
	public function ced_tutorlms_display_apply_points_checkout() {
	
		// check allowed user for points features.
		if ( apply_filters( 'ced_tutorlms_allowed_user_roles_points_features', false ) ) {
			return;
		}
		$user_id = get_current_user_ID();
		if ( isset( $user_id ) && ! empty( $user_id ) ) {
			if ( class_exists( 'Ced_Pointsrewards_Tutorlms_Public' ) ) {
				$public_obj = new Ced_Pointsrewards_Tutorlms_Public( 'ced-pointsrewards-tutorlms', '1.0.0' );
			}

			$get_points = (int) get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
			$get_min_redeem_req = $this->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_apply_points_value' );
			/* Points Rate*/
			$ced_tutorlms_cart_points_rate = $public_obj->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_cart_points_rate' );
			$ced_tutorlms_cart_points_rate = ( 0 == $ced_tutorlms_cart_points_rate ) ? 1 : $ced_tutorlms_cart_points_rate;
			/* Points Rate*/
			$ced_tutorlms_cart_price_rate = $public_obj->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_cart_price_rate' );
			$ced_tutorlms_cart_price_rate = ( 0 == $ced_tutorlms_cart_price_rate ) ? 1 : $ced_tutorlms_cart_price_rate;
			$conversion              = ( $get_points * $ced_tutorlms_cart_price_rate / $ced_tutorlms_cart_points_rate );

			$ced_tutorlms_order_points = apply_filters( 'ced_tutorlms_enable_points_on_order_total', false );
			if ( $ced_tutorlms_order_points ) {
				do_action( 'ced_tutorlms_point_limit_on_order_checkout', $get_points, $user_id, $get_min_redeem_req );
			} else {
				if ( $get_min_redeem_req < $get_points ) {
					?>
				<div class="custom_point_checkout woocommerce-info ced_tutorlms_checkout_points_class">

					<input type="number" min="0" name="ced_tutorlms_points" class="input-text" id="ced_tutorlms_cart_points" value="" placeholder="<?php esc_attr_e( 'Points', 'ced-pointsrewards-tutorlms' ); ?>"/>

					<button class="button ced_tutorlms_points_apply" name="ced_tutorlms_points_apply" id="ced_tutorlms_cart_points_apply" value="<?php esc_html_e( 'Apply Points', 'ced-pointsrewards-tutorlms' ); ?>" data-point="<?php echo esc_html( $get_points ); ?>" data-id="<?php echo esc_html( $user_id ); ?>" data-order-limit="0"><?php esc_html_e( 'Apply Points', 'ced-pointsrewards-tutorlms' ); ?></button>

					<p><?php echo esc_html( $get_points ) . esc_html__( ' Points', 'ced-pointsrewards-tutorlms' ) . ' = ' . wp_kses( wc_price( $conversion ), $this->ced_tutorlms_allowed_html() ); ?></p>
				</div>
					<?php
				} else {
					$extra_req = abs( $get_min_redeem_req - $get_points );
					?>
				<div class="custom_point_checkout woocommerce-info ced_tutorlms_checkout_points_class">
				
				<input type="number" min="0" name="ced_tutorlms_points" class="input-text" id="ced_tutorlms_cart_points" value="" placeholder="<?php esc_attr_e( 'Points', 'ced-pointsrewards-tutorlms' ); ?>" readonly/>


				<button class="button ced_tutorlms_points_apply" name="ced_tutorlms_points_apply" id="ced_tutorlms_cart_points_apply" value="<?php esc_html_e( 'Apply Points', 'ced-pointsrewards-tutorlms' ); ?>" data-point="<?php echo esc_html( $get_points ); ?>" data-id="<?php echo esc_html( $user_id ); ?>" data-order-limit="0" disabled><?php esc_html_e( 'Apply Points', 'ced-pointsrewards-tutorlms' ); ?></button>
				<p><?php esc_html_e( 'You require :', 'ced-pointsrewards-tutorlms' ); ?> <?php echo esc_html( $extra_req ); ?> <?php esc_html_e( 'more points to get redeem', 'ced-pointsrewards-tutorlms' ); ?></p>
				</div>
					<?php
				}
			}
		}
	}


	/**
	 * This function will update the user points as they purchased products through points
	 *
	 * @name ced_tutorlms_woocommerce_checkout_update_order_meta..
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param int   $order_id id of the order.
	 * @param array $data data of the order.
	 */
	public function ced_tutorlms_woocommerce_checkout_update_order_meta( $order_id, $data ) {
		$user_id = get_current_user_id();
		$user = get_user_by( 'ID', $user_id );
		$user_email = $user->user_email;
		$woo_ver = WC()->version;
		$deduct_point = '';
		$points_deduct = 0;
		$ced_tutorlms_is_pnt_fee_applied = false;
		// $ced_tutorlms_notificatin_array = get_option( 'ced_tutorlms_notificatin_array', true );
		$get_points = (int) get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
		/*Get the cart points rate*/
		$ced_tutorlms_cart_points_rate = $this->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_cart_points_rate' );
		$ced_tutorlms_cart_points_rate = ( 0 == $ced_tutorlms_cart_points_rate ) ? 1 : $ced_tutorlms_cart_points_rate;
		/*Get the cart price rate*/
		$ced_tutorlms_cart_price_rate = $this->ced_tutorlms_get_redemption_settings_num( 'ced_tutorlms_cart_price_rate' );
		$ced_tutorlms_cart_price_rate = ( 0 == $ced_tutorlms_cart_price_rate ) ? 1 : $ced_tutorlms_cart_price_rate;
		/*Order*/
		$order = wc_get_order( $order_id );
		if ( isset( $order ) && ! empty( $order ) ) {
			// Paypal Issue Change Start.
			$order_data = $order->get_data();
			if ( ! empty( $order_data['coupon_lines'] ) ) {
				foreach ( $order_data['coupon_lines'] as $coupon ) {
					$coupon_data = $coupon->get_data();
					if ( ! empty( $coupon_data ) ) {
						$coupon_name = $coupon_data['code'];
						$cart_discount = __( 'Tutor LMS Cart Discount', 'ced-pointsrewards-tutorlms' );
						if ( strtolower( $cart_discount ) == strtolower( $coupon_name ) ) {
							$coupon_meta = $coupon_data['meta_data'][0]->get_data();
							$coupon_amount = $coupon_meta['value']['amount'];
							update_post_meta( $order_id, 'ced_tutorlms_cart_discount#$fee_id', $coupon_amount );
							$fee_to_point = ceil( ( $ced_tutorlms_cart_points_rate * $coupon_amount ) / $ced_tutorlms_cart_price_rate );
							$fee_to_point  = apply_filters( 'ced_tutorlms_round_down_cart_total_value_amount', $fee_to_point, $ced_tutorlms_cart_points_rate, $coupon_amount, $ced_tutorlms_cart_price_rate );
							$remaining_point = $get_points - $fee_to_point;
							/*update the users points in the*/
							update_user_meta( $user_id, 'ced_tutorlms_pr_points', $remaining_point );
							$data = array();
							/*update points of the customer*/
							$this->ced_tutorlms_update_points_details( $user_id, 'cart_subtotal_point', $fee_to_point, $data );
							/*Send mail to the customer*/
							//$this->ced_tutorlms_send_points_deducted_mail( $user_id, 'ced_tutorlms_cart_discount', $fee_to_point );
							/*Unset the session*/
							if ( ! empty( WC()->session->get( 'ced_tutorlms_cart_points' ) ) ) {
								update_post_meta( $order_id, 'ced_tutorlms_cart_discount#points', WC()->session->get( 'ced_tutorlms_cart_points' ) );
								WC()->session->__unset( 'ced_tutorlms_cart_points' );
							}
						}
					}
				}
			}
			// Paypal Issue Change End.
		}
	}

	/**
	 * Update points details in the public section.
	 *
	 * @name ced_tutorlms_update_points_details
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param int    $user_id  User id of the user.
	 * @param string $type type of description.
	 * @param int    $points  No. of points.
	 * @param array  $data  Data of the points details.
	 */
	public function ced_tutorlms_update_points_details( $user_id, $type, $points, $data ) {

		$today_date = date_i18n( 'Y-m-d h:i:sa' );
		
		/*Here is cart discount through the points*/
		if ( 'cart_subtotal_point' == $type ) {
			$cart_subtotal_point_arr = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
			if ( isset( $cart_subtotal_point_arr[ $type ] ) && ! empty( $cart_subtotal_point_arr[ $type ] ) ) {
				$cart_array = array(
					$type => $points,
					'date' => $today_date,
				);
				$cart_subtotal_point_arr[ $type ][] = $cart_array;
			} else {
				if ( ! is_array( $cart_subtotal_point_arr ) ) {
					$cart_subtotal_point_arr = array();
				}
				$cart_array = array(
					$type => $points,
					'date' => $today_date,
				);
				$cart_subtotal_point_arr[ $type ][] = $cart_array;
			}
			/*Update the user meta for the points details*/
			update_user_meta( $user_id, 'ced_tutorlms_points_details', $cart_subtotal_point_arr );
		}
	
		do_action( 'ced_tutorlms_update_points_log', $user_id );
		return 'Successfully';
	}



}

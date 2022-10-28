<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://cedcommerce.com/
 * @since      1.0.0
 *
 * @package    Ced_Pointsrewards_Tutorlms
 * @subpackage Ced_Pointsrewards_Tutorlms/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Ced_Pointsrewards_Tutorlms
 * @subpackage Ced_Pointsrewards_Tutorlms/includes
 * @author     Cedcommerce <support@cedcommerce.com>
 */
class Ced_Pointsrewards_Tutorlms {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ced_Pointsrewards_Tutorlms_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'CED_POINTSREWARDS_TUTORLMS_VERSION' ) ) {
			$this->version = CED_POINTSREWARDS_TUTORLMS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'ced-pointsrewards-tutorlms';
		$this->define_constants();
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}
	public function define_constants() {
		define( 'CED_TUTORLMS_DIRPATH', plugin_dir_path( dirname( __FILE__ ) ) );
		define( 'CED_TUTORLMS_URL', plugin_dir_url( dirname( __FILE__ ) ) );
		define( 'CED_TUTORLMS_HOME_URL', admin_url() );
		define( 'CED_TUTORLMS_PREFIX', 'ced_tutorlms_' );
	}
	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Ced_Pointsrewards_Tutorlms_Loader. Orchestrates the hooks of the plugin.
	 * - Ced_Pointsrewards_Tutorlms_i18n. Defines internationalization functionality.
	 * - Ced_Pointsrewards_Tutorlms_Admin. Defines all hooks for the admin area.
	 * - Ced_Pointsrewards_Tutorlms_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ced-pointsrewards-tutorlms-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ced-pointsrewards-tutorlms-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ced-pointsrewards-tutorlms-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ced-pointsrewards-tutorlms-public.php';

		$this->loader = new Ced_Pointsrewards_Tutorlms_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Ced_Pointsrewards_Tutorlms_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Ced_Pointsrewards_Tutorlms_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Ced_Pointsrewards_Tutorlms_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'ced_tutor_lms_points_rewards_admin_menu' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'ced_tutorlms_remove_default_submenu', 50 );


		$this->loader->add_filter( 'wps_add_plugins_menus_array', $plugin_admin, 'ced_pointsrewards_tutorlms_add_marketplace_menus_to_array', 13 );
		
		$this->loader->add_action( 'tutor_after_student_signup', $plugin_admin, 'ced_tutorlms_student_registration_pr', 10, 1 );
		$this->loader->add_action( 'tutor_after_enrolled', $plugin_admin, 'ced_tutorlms_student_course_enroll',11,3 );
		$this->loader->add_action( 'tutor_quiz/attempt_ended', $plugin_admin, 'ced_tutorlms_student_quiz_pass_pr',12,20 );
		$this->loader->add_action( 'tutor_mark_lesson_complete_after', $plugin_admin, 'ced_tutorlms_student_lesson_completed_pr',13,2 );
		$this->loader->add_action( 'tutor_course_complete_after', $plugin_admin, 'ced_tutorlms_student_course_completed_pr',19,2 );

		$this->loader->add_action( 'tutor_assignment/after/submitted', $plugin_admin, 'ced_tutorlms_student_assignment_submit',14,1 );
		$this->loader->add_action( 'tutor_assignment/evaluate/after', $plugin_admin, 'ced_tutorlms_student_assignment_passed',15,3 );
		$this->loader->add_action( 'tutor_course/single/enrolled/before/reviews', $plugin_admin, 'ced_tutorlms_student_reviews',16 );
		$this->loader->add_action( 'tutor_after_approved_instructor', $plugin_admin, 'ced_tutorlms_instructor_registration_approved',17 ,1);
		$this->loader->add_action( 'tutor_save_course_after', $plugin_admin, 'ced_tutorlms_instructor_save_course',18 ,2 );
		
		/*Student and Instructor Daily Login Points*/
		$this->loader->add_action( 'wp_login', $plugin_admin, 'ced_tutorlms_student_daily_login',20 ,2 );
		$this->loader->add_action( 'wp_login', $plugin_admin, 'ced_tutorlms_instructor_daily_login',21 ,2 );
		
		/*Giving points on Birthday*/
		$this->loader->add_action( 'init', $plugin_admin, 'ced_tutorlms_add_points_to_student_on_birthday' );
		$this->loader->add_action( 'init', $plugin_admin, 'ced_tutorlms_add_points_to_instructor_on_birthday' );

		
		/*Added Date of Birth Edit field to the user dashboard*/
		$this->loader->add_action( 'show_user_profile', $plugin_admin, 'ced_tutorlms_add_dob_custom_field_to_profile' );
		$this->loader->add_action( 'edit_user_profile', $plugin_admin, 'ced_tutorlms_add_dob_custom_field_to_profile' );
		$this->loader->add_action( 'edit_user_profile_update', $plugin_admin, 'ced_tutorlms_update_dob_profile_field',1 );
		
		$this->loader->add_action( 'tutor/lesson/created', $plugin_admin, 'ced_tutorlms_instructor_lesson_created',22 ,1 );
		
		/*Adding +/- for points updates in the settings panel*/
		$this->loader->add_action( 'wp_ajax_ced_tutorlms_points_update', $plugin_admin, 'ced_tutorlms_points_update' );
		$this->loader->add_action( 'wp_ajax_ced_tutorlms_points_update', $plugin_admin, 'ced_tutorlms_points_update' );		

		

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Ced_Pointsrewards_Tutorlms_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		/*Adding tab to the dashboard*/
		$this->loader->add_filter( 'tutor_dashboard/nav_items', $plugin_public, 'ced_tutorlms_dashboard_menu_items' );
		$this->loader->add_filter( 'load_dashboard_template_part_from_other_location', $plugin_public, 'ced_tutorlms_dashboard_menu_items_template_location' );

		$this->loader->add_action( 'wp_loaded', $plugin_public, 'ced_tutorlms_referral_link_using_cookie' );
		$this->loader->add_action( 'register_form' ,$plugin_public, 'ced_tutorlms_add_field_instructor_registration_form');
		$this->loader->add_action( 'tutor_new_instructor_after', $plugin_public, 'ced_tutorlms_add_field_value_instructor_registration_form');

		$this->loader->add_action( 'tutor_profile_edit_input_after', $plugin_public, 'ced_tutorlms_add_dob_field_profile',21 ,2 );
		$this->loader->add_action( 'profile_update', $plugin_public, 'ced_tutorlms_add_dob_field_profile_to_db',22 ,1 );

		
		$this->loader->add_action( 'woocommerce_cart_actions', $plugin_public, 'ced_tutorlms_woocommerce_cart_coupon' );
		$this->loader->add_action( 'wp_ajax_ced_tutorlms_apply_fee_on_cart_subtotal', $plugin_public, 'ced_tutorlms_apply_fee_on_cart_subtotal', 2 );
		$this->loader->add_action( 'woocommerce_cart_calculate_fees', $plugin_public, 'ced_tutorlms_woocommerce_cart_custom_points' , 3);
		$this->loader->add_action( 'woocommerce_before_cart_contents', $plugin_public, 'ced_tutorlms_woocommerce_before_cart_contents' );
		$this->loader->add_filter( 'woocommerce_cart_totals_fee_html', $plugin_public, 'ced_tutorlms_woocommerce_cart_totals_fee_html', 10, 2 );
		
		$this->loader->add_action( 'wp_ajax_ced_tutorlms_remove_cart_point', $plugin_public, 'ced_tutorlms_remove_cart_point' );
		$this->loader->add_filter( 'wc_get_template', $plugin_public, 'ced_tutorlms_overwrite_form_temp', 15, 2 );
		
		$this->loader->add_action( 'woocommerce_before_calculate_totals', $plugin_public, 'ced_tutorlms_woocommerce_cart_custom_points' );
		
		$this->loader->add_action( 'woocommerce_checkout_update_order_meta', $plugin_public, 'ced_tutorlms_woocommerce_checkout_update_order_meta', 10, 2 );

		$this->loader->add_filter( 'woocommerce_get_shop_coupon_data', $plugin_public, 'ced_tutorlms_validate_virtual_coupon_for_points', 10, 2 );
		$this->loader->add_filter( 'woocommerce_cart_totals_coupon_label', $plugin_public, 'ced_tutorlms_filter_woocommerce_coupon_label', 10, 2 );
		$this->loader->add_filter( 'woocommerce_cart_totals_coupon_html', $plugin_public, 'ced_tutorlms_virtual_coupon_remove', 30, 3 );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Ced_Pointsrewards_Tutorlms_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

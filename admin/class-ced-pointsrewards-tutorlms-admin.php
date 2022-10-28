<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://cedcommerce.com/
 * @since      1.0.0
 *
 * @package    Ced_Pointsrewards_Tutorlms
 * @subpackage Ced_Pointsrewards_Tutorlms/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ced_Pointsrewards_Tutorlms
 * @subpackage Ced_Pointsrewards_Tutorlms/admin
 * @author     Cedcommerce <support@cedcommerce.com>
 */
class Ced_Pointsrewards_Tutorlms_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Add points when student registered on Tutor LMS.
	 *
	 * @name ced_tutorlms_student_registration_pr
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param int    $user_id  User id of Registered Student.
	 */
	public function ced_tutorlms_student_registration_pr( $user_id ){
		if ( get_user_by( 'ID', $user_id ) ) {
			$enable_student_setting = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_setting_enable' );
			if ( $enable_student_setting ) {
				$enable_student_registration_setting = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_registration_enable' );
				if( $enable_student_registration_setting ){
					$student_registration_value = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_registration_value' );
					update_user_meta( $user_id, 'ced_tutorlms_pr_points', $student_registration_value );
					$data = array();
					$this->ced_tutorlms_update_points_details( $user_id, 'student_registration', $student_registration_value, $data );
				}
			}
			$enable_ced_tutorlms_refer = $this->ced_tutorlms_get_referal_settings_num( 'ced_tutorlms_refer_enable' );
			/*Check for the Referral*/
			if ( $enable_ced_tutorlms_refer ) {
			
				$ced_tutorlms_refer_value = $this->ced_tutorlms_get_referal_settings_num( 'ced_tutorlms_refer_value' );
				$ced_tutorlms_refer_value = ( 0 == $ced_tutorlms_refer_value ) ? 1 : $ced_tutorlms_refer_value;
				/*Get Data from the Cookies*/
				$cookie_val = isset( $_COOKIE['ced_tutorlms_cookie_set'] ) ? sanitize_text_field( wp_unslash( $_COOKIE['ced_tutorlms_cookie_set'] ) ) : '';
				
				$retrive_data = $cookie_val;
				if ( ! empty( $retrive_data ) ) {
					$args['meta_query'] = array(
						array(
							'key' => 'ced_tutorlms_points_referral',
							'value' => trim( $retrive_data ),
							'compare' => '==',
						),
					);
					$refere_data = get_users( $args );
					$refere_id = $refere_data[0]->data->ID;
					
					$refere = get_user_by( 'ID', $refere_id );
					/*Get email of the Refree*/
					$refere_email = $refere->user_email;
					$get_referral = get_user_meta( $refere_id, 'ced_tutorlms_points_referral', true );
					$get_referral_invite = get_user_meta( $refere_id, 'ced_tutorlms_points_referral_invite', true );
					// $custom_ref_pnt = get_user_meta( $refere_id, 'wps_custom_points_referral_invite', true );
					/*Check */
					$get_points = (int) get_user_meta( $refere_id, 'ced_tutorlms_pr_points', true );
					if ( empty( $get_points ) ) {
						$get_points = 0;
					}
					update_option( 'refereeid', $get_points );
					$ced_tutorlms_referral_program = true;
					/*filter that will add restriction*/
					$ced_tutorlms_referral_program = apply_filters( 'ced_tutorlms_referral_points', $ced_tutorlms_referral_program, $customer_id, $refere_id );
					if ( $ced_tutorlms_referral_program ) {
						$total_points = (int) ( $get_points + $ced_tutorlms_refer_value );
						/*update the points of the referred user*/
						update_user_meta( $refere_id, 'ced_tutorlms_pr_points', $total_points );
						$data = array(
							'referr_id' => $customer_id,
						);

						/*
						Update the points Details of the users
						*/
						$this->ced_tutorlms_update_points_details( $refere_id, 'reference_details', $ced_tutorlms_refer_value, $data );
						
						/*Destroy the cookie*/
						$this->ced_tutorlms_destroy_cookie();
					}
				}
			}
		}
	}

	
	/**
	 * The function is used for destroy the cookie
	 *
	 * @name ced_tutorlms_destroy_cookie
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 */
	public function ced_tutorlms_destroy_cookie() {
		if ( isset( $_COOKIE['ced_tutorlms_cookie_set'] ) && ! empty( $_COOKIE['ced_tutorlms_cookie_set'] ) ) {
			setcookie( 'ced_tutorlms_cookie_set', '', time() - 3600, '/' );
		}
	}
	/**
	 * Update points when course enrolled by student & Giving points to instructor for their course by a limit.
	 *
	 * @name ced_tutorlms_student_course_enroll
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param int    $course_id  course id of the selected course.
	 * @param int    $user_id User id.
	 * @param boolean    $isEnrolled  Whether enrolled or not.
	 */
	public function ced_tutorlms_student_course_enroll( $course_id, $user_id, $isEnrolled ){
		if( empty( $course_id ) && empty( $user_id ) && empty( $isEnrolled ) ){
			return;
		}

		/*Giving points to instructor for their course by a limit of enollment*/
		$course_author_id = get_post_field ('post_author', $course_id );
		$enable_instructor_setting = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_setting_enable' );
		if ( $enable_instructor_setting ) {
			$enable_instructor_course_enroll_setting = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_enrolled_student_enable' );
			if( $enable_instructor_course_enroll_setting ){
				$instructor_max_enrolled_student = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_max_enrolled_student' );
				$instructor_enrolled_student_value = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_enrolled_student_value' );

				$maxno_course_enroll_instructor = (int) get_user_meta( $course_author_id, 'ced_tutorlms_maxno_course_enroll_instructor', true );
				$enroll_total_student = $maxno_course_enroll_instructor + 1;
				update_user_meta( $course_author_id, 'ced_tutorlms_maxno_course_enroll_instructor', $enroll_total_student );
				$maxno_course_enroll_instructor = (int) get_user_meta( $course_author_id, 'ced_tutorlms_maxno_course_enroll_instructor', true );
				if( $maxno_course_enroll_instructor % $instructor_max_enrolled_student == 0 ){
					update_user_meta( $course_author_id, 'ced_tutorlms_maxno_course_enroll_instructor', 0 );
					$get_points_instructor = (int) get_user_meta( $course_author_id, 'ced_tutorlms_pr_points', true );
					$total_points_instructor = $get_points_instructor + $instructor_enrolled_student_value;
					update_user_meta( $course_author_id, 'ced_tutorlms_pr_points', $total_points_instructor );
					$data = array();
					$this->ced_tutorlms_update_points_details( $course_author_id, 'instructor_total_students', $instructor_enrolled_student_value, $data );
				}
			}
		}

		/* Giving points on enrolling the course */
		$enable_student_setting = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_setting_enable' );
		if ( $enable_student_setting ) {
			$enable_student_course_enroll_setting = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_course_enroll_enable' );
			if( $enable_student_course_enroll_setting ){
				$maxno_course_enroll_value = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_maxno_course_enroll_value' );
				$course_enroll_point_value = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_course_enroll_value' );

				$max_no_of_course_enroll_counter = (int) get_user_meta( $user_id, 'ced_tutorlms_maxno_course_enroll_student', true );
				$enroll_total = $max_no_of_course_enroll_counter + 1;
				update_user_meta( $user_id, 'ced_tutorlms_maxno_course_enroll_student', $enroll_total );
				$max_no_of_course_enroll_counter = (int) get_user_meta( $user_id, 'ced_tutorlms_maxno_course_enroll_student', true );
				if( $max_no_of_course_enroll_counter % $maxno_course_enroll_value == 0 ){
					update_user_meta( $user_id, 'ced_tutorlms_maxno_course_enroll_student', 0 );
					$get_points = (int) get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
					$total_points = $get_points + $course_enroll_point_value;
					update_user_meta( $user_id, 'ced_tutorlms_pr_points', $total_points );
					$data = array();
					$this->ced_tutorlms_update_points_details( $user_id, 'course_enrollment', $course_enroll_point_value, $data );
				}
			}
		}
	}

	/**
	 * Update points when quiz passed by student.
	 *
	 * @name ced_tutorlms_student_quiz_pass_pr
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param int    $attempt_id  Attempt id of the selected quiz.
	 */
	public function ced_tutorlms_student_quiz_pass_pr( $attempt_id ){
		if( empty( $attempt_id ) ){
			return;
		}
		$enable_student_setting = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_setting_enable' );
		if ( $enable_student_setting ) {
			$enable_student_quiz_passed_setting = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_quiz_passed_enable' );
			if( $enable_student_quiz_passed_setting ){

				$attempt = tutor_utils()->get_attempt($attempt_id);
				$quiz_id = $attempt->quiz_id;
				$course_id = $attempt->course_id;
				$quiz_earned_marks = $attempt->earned_marks;
				$quiz_total_marks = $attempt->total_marks;
				$earned_percentage = $attempt->earned_marks > 0 ? ( number_format(($attempt->earned_marks * 100) / $attempt->total_marks)) : 0;
				$user_id = $attempt->user_id;
				$passing_grade = (int) tutor_utils()->get_quiz_option($attempt->quiz_id, 'passing_grade', 0);				

				$maxno_quiz_passed_value = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_maxno_quiz_passed_value' );
				$quiz_passed_point_value = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_quiz_passed_value' );

				if( $earned_percentage >= $passing_grade ){
					$max_no_of_quiz_passed_counter = (int) get_user_meta( $user_id, 'ced_tutorlms_maxno_quiz_passed_student', true );
					$quiz_total = $max_no_of_quiz_passed_counter + 1;
					update_user_meta( $user_id, 'ced_tutorlms_maxno_quiz_passed_student', $quiz_total );
					$max_no_of_quiz_passed_counter = (int) get_user_meta( $user_id, 'ced_tutorlms_maxno_quiz_passed_student', true );
					if( $max_no_of_quiz_passed_counter % $maxno_quiz_passed_value == 0 ){
						update_user_meta( $user_id, 'ced_tutorlms_maxno_quiz_passed_student', 0 );
						$get_points = (int) get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
						$total_points = $get_points + $quiz_passed_point_value;
						update_user_meta( $user_id, 'ced_tutorlms_pr_points', $total_points );
						$data = array();
						$this->ced_tutorlms_update_points_details( $user_id, 'quiz_points', $quiz_passed_point_value, $data );
					}
				}
			}
		}
	}
	
	/**
	 * Update points when lesson completed by student.
	 *
	 * @name ced_tutorlms_student_lesson_completed_pr
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param int    $post_id  post id.
	 * @param int    $user_id User id.
	 */
	public function ced_tutorlms_student_lesson_completed_pr( $post_id, $user_id ){
		if( empty( $post_id ) && empty( $user_id ) ){
			return;
		}
		$enable_student_setting = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_setting_enable' );
		if ( $enable_student_setting ) {
			$enable_student_lesson_setting = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_lesson_complete_enable' );
			if( $enable_student_lesson_setting ){
				$maxno_lesson_complete_value = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_maxno_lesson_completed_value' );
				$lesson_complete_point_value = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_lesson_completed_value' );

				$max_no_of_lesson_complete_counter = (int) get_user_meta( $user_id, 'ced_tutorlms_maxno_lesson_complete_student', true );
				$lesson_complete_total = $max_no_of_lesson_complete_counter + 1;
				update_user_meta( $user_id, 'ced_tutorlms_maxno_lesson_complete_student', $lesson_complete_total );
				$max_no_of_lesson_complete_counter = (int) get_user_meta( $user_id, 'ced_tutorlms_maxno_lesson_complete_student', true );
				if( $max_no_of_lesson_complete_counter % $maxno_lesson_complete_value == 0 ){
					update_user_meta( $user_id, 'ced_tutorlms_maxno_lesson_complete_student', 0 );
					$get_points = (int) get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
					$total_points = $get_points + $lesson_complete_point_value;
					update_user_meta( $user_id, 'ced_tutorlms_pr_points', $total_points );
					$data = array();
					$this->ced_tutorlms_update_points_details( $user_id, 'lesson_complete', $lesson_complete_point_value, $data );
				}
			}
		}
	}

	/**
	 * Update points when course completed by student.
	 *
	 * @name ced_tutorlms_student_course_completed_pr
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param int    $course_id  course id.
	 * @param int    $user_id User id.
	 */
	public function ced_tutorlms_student_course_completed_pr( $course_id, $user_id ){
		if( empty( $course_id ) && empty( $user_id ) ){
			return;
		}
		$enable_student_setting = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_setting_enable' );
		if ( $enable_student_setting ) {
			$enable_student_course_setting = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_course_complete_enable' );
			if( $enable_student_course_setting ){
				$maxno_course_complete_value = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_maxno_course_completed_value' );
				$course_complete_point_value = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_course_completed_value' );

				$max_no_of_course_complete_counter = (int) get_user_meta( $user_id, 'ced_tutorlms_maxno_course_complete_student', true );
				$course_complete_total = $max_no_of_course_complete_counter + 1;
				update_user_meta( $user_id, 'ced_tutorlms_maxno_course_complete_student', $course_complete_total );
				$max_no_of_course_complete_counter = (int) get_user_meta( $user_id, 'ced_tutorlms_maxno_course_complete_student', true );
				if( $max_no_of_course_complete_counter % $maxno_course_complete_value == 0 ){
					update_user_meta( $user_id, 'ced_tutorlms_maxno_course_complete_student', 0 );
					$get_points = (int) get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
					$total_points = $get_points + $course_complete_point_value;
					update_user_meta( $user_id, 'ced_tutorlms_pr_points', $total_points );
					$data = array();
					$this->ced_tutorlms_update_points_details( $user_id, 'course_complete', $course_complete_point_value, $data );
				}
			}
		}
	}

	/**
	 * Update points when submit assignment by student.
	 *
	 * @name ced_tutorlms_student_assignment_submit
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param int    $submitted_id  Submitted Id.
	 * @param int    $course_id Course id.
	 * @param int    $student_id Student id.
	 */
	public function ced_tutorlms_student_assignment_submit( $submitted_id ){
		$info 		= tutor_utils()->get_assignment_submit_info( $submitted_id );
		$user_id    = $info->user_id;
		if( empty( $submitted_id ) && empty( $user_id ) ){
			return;
		}

		$enable_student_setting = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_setting_enable' );
		if ( $enable_student_setting ) {
			$enable_student_assignment_submit_setting = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_assignment_submit_enable' );
			if( $enable_student_assignment_submit_setting ){
				$maxno_assignment_submit_value = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_maxno_assignment_submit_value' );
				$assignment_submit_point_value = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_assignment_submit_value' );
				
				$max_no_of_assignment_submit_counter = (int) get_user_meta( $user_id, 'ced_tutorlms_maxno_assignment_submit_student', true );
				$assignment_submit_total = $max_no_of_assignment_submit_counter + 1;
				update_user_meta( $user_id, 'ced_tutorlms_maxno_assignment_submit_student', $assignment_submit_total );
				$max_no_of_assignment_submit_counter = (int) get_user_meta( $user_id, 'ced_tutorlms_maxno_assignment_submit_student', true );				
				if( $max_no_of_assignment_submit_counter % $maxno_assignment_submit_value == 0 ){
				
					update_user_meta( $user_id, 'ced_tutorlms_maxno_assignment_submit_student', 0 );
					$get_points = (int) get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
					$total_points = $get_points + $assignment_submit_point_value;
					update_user_meta( $user_id, 'ced_tutorlms_pr_points', $total_points );
					$data = array();
					$this->ced_tutorlms_update_points_details( $user_id, 'assignment_submit', $assignment_submit_point_value, $data );
				
				}

			
			}
		}

	}

	/**
	 * Update points when passed assignment by student.
	 *
	 * @name ced_tutorlms_student_assignment_passed
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param int    $submitted_id  Submitted Id.
	 * @param int    $course_id Course id.
	 * @param int    $student_id Student id.
	 */
	public function ced_tutorlms_student_assignment_passed( $submitted_id, $course_id, $user_id ){
		
		if( empty( $submitted_id ) && empty( $user_id ) ){
			return;
		}

		$enable_student_setting = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_setting_enable' );
		if ( $enable_student_setting ) {
			$enable_student_assignment_pass_setting = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_assignment_passed_enable' );
			if( $enable_student_assignment_pass_setting ){
				$maxno_assignment_pass_value = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_maxno_assignment_passed_value' );
				$assignment_pass_point_value = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_assignment_passed_value' );
				$info 		= tutor_utils()->get_assignment_submit_info( $submitted_id );
				$max_mark   = tutor_utils()->get_assignment_option( $info->comment_post_ID, 'total_mark' );
				$pass_mark  = tutor_utils()->get_assignment_option( $info->comment_post_ID, 'pass_mark' );
				$given_mark = get_comment_meta( $submitted_id, 'assignment_mark', true );
			
				$get_submitid_array = get_user_meta( $user_id, 'ced_tutorlms_submitid_assignment_pass_student' ,true);

				if ( ( $given_mark >= $pass_mark ) && !in_array( $submitted_id, $get_submitid_array ) ){
					if ( empty( $get_submitid_array ) ){
						$get_submitid_array = array();
						$get_submitid_array[] = $submitted_id;
						update_user_meta( $user_id, 'ced_tutorlms_submitid_assignment_pass_student', $get_submitid_array );
					}
					else{
						$get_submitid_array[] = $submitted_id;
						update_user_meta( $user_id, 'ced_tutorlms_submitid_assignment_pass_student', $get_submitid_array );
					}	


					$max_no_of_assignment_pass_counter = (int) get_user_meta( $user_id, 'ced_tutorlms_maxno_assignment_pass_student', true );
					$assignment_pass_total = $max_no_of_assignment_pass_counter + 1;
					update_user_meta( $user_id, 'ced_tutorlms_maxno_assignment_pass_student', $assignment_pass_total );
					$max_no_of_assignment_pass_counter = (int) get_user_meta( $user_id, 'ced_tutorlms_maxno_assignment_pass_student', true );				
					if( $max_no_of_assignment_pass_counter % $maxno_assignment_pass_value == 0 ){
					
						update_user_meta( $user_id, 'ced_tutorlms_maxno_assignment_pass_student', 0 );
						$get_points = (int) get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
						$total_points = $get_points + $assignment_pass_point_value;
						update_user_meta( $user_id, 'ced_tutorlms_pr_points', $total_points );
						$data = array();
						$this->ced_tutorlms_update_points_details( $user_id, 'assignment_pass', $assignment_pass_point_value, $data );
					
					}
				}
			
			}
		}

	}

	/**
	 * Update points when review given by student.
	 *
	 * @name ced_tutorlms_student_reviews
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 */
	public function ced_tutorlms_student_reviews(){
		$user_id = get_current_user_id();
		$course_id = isset($_POST['course_id']) ? (int)$_POST['course_id'] : get_the_ID();
		$my_rating = tutor_utils()->get_reviews_by_user(0, 0, 150, false, $course_id, array('approved', 'hold'));
		if( is_object( $my_rating ) ){
			$my_rating_point = $my_rating->rating;
		}else{
			$my_rating_point = 0;
		}
		
		$enable_student_setting = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_setting_enable' );
		if ( $enable_student_setting ) {
			$enable_student_review_setting = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_review_enable' );
			if( $enable_student_review_setting ){
				$maxno_review_value = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_maxno_review_value' );
				$review_point_value = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_review_value' );
				$rating_value = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_rating_review_value' );
				
				$get_courseid_array = get_user_meta( $user_id, 'ced_tutorlms_courseid_review_student' ,true);

				if ( ( $my_rating_point >= $rating_value ) && !in_array( $course_id, $get_courseid_array ) ){
					if ( empty( $get_courseid_array ) ){
						$get_courseid_array = array();
						$get_courseid_array[] = $course_id;
						update_user_meta( $user_id, 'ced_tutorlms_courseid_review_student', $get_courseid_array );
					}
					else{
						$get_courseid_array[] = $course_id;
						update_user_meta( $user_id, 'ced_tutorlms_courseid_review_student', $get_courseid_array );
					}	
					$max_no_of_review_counter = (int) get_user_meta( $user_id, 'ced_tutorlms_maxno_review_student', true );
					$review_total = $max_no_of_review_counter + 1;
					update_user_meta( $user_id, 'ced_tutorlms_maxno_review_student', $review_total );
					$max_no_of_review_counter = (int) get_user_meta( $user_id, 'ced_tutorlms_maxno_review_student', true );				
					if( $max_no_of_review_counter % $maxno_review_value == 0 ){
						update_user_meta( $user_id, 'ced_tutorlms_maxno_review_student', 0 );
						$get_points = (int) get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
						$total_points = $get_points + $review_point_value;
						update_user_meta( $user_id, 'ced_tutorlms_pr_points', $total_points );
						$data = array();
						$this->ced_tutorlms_update_points_details( $user_id, 'student_review', $review_point_value, $data );
					
					}
				}
			
			}
		}
	}

	/**
	 * Update points when Instructor registration approved by admin.
	 *
	 * @name ced_tutorlms_instructor_registration_approved
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param int    $user_id  Instructor Id.
	 */
	public function ced_tutorlms_instructor_registration_approved( $user_id ){
		if( empty( $user_id ) ){
			return;
		}
		$enable_instructor_setting = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_setting_enable' );
		if ( $enable_instructor_setting ) {
			$enable_instructor_registration_setting = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_registration_enable' );
			if( $enable_instructor_registration_setting ){	

				$registration_point_value = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_registration_value' );
				$get_instructor_approved_array = get_user_meta( $user_id, 'ced_tutorlms_instructor_approved_registration_instructor' ,true);

				if ( !in_array( $user_id, $get_instructor_approved_array ) ){
					if ( empty( $get_instructor_approved_array ) ){
						$get_instructor_approved_array = array();
						$get_instructor_approved_array[] = $user_id;
						update_user_meta( $user_id, 'ced_tutorlms_instructor_approved_registration_instructor', $get_instructor_approved_array );
					}
					else{
						$get_instructor_approved_array[] = $user_id;
						update_user_meta( $user_id, 'ced_tutorlms_instructor_approved_registration_instructor', $get_instructor_approved_array );
					}				
					$get_points = (int) get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
					$total_points = $get_points + $registration_point_value;
					update_user_meta( $user_id, 'ced_tutorlms_pr_points', $total_points );
					$data = array();
					$this->ced_tutorlms_update_points_details( $user_id, 'instructor_registration', $registration_point_value, $data );
					
					$enable_ced_tutorlms_refer = $this->ced_tutorlms_get_referal_settings_num( 'ced_tutorlms_refer_enable' );
					/*Check for the Referral*/
					if ( $enable_ced_tutorlms_refer ) {
					
						$ced_tutorlms_refer_value = $this->ced_tutorlms_get_referal_settings_num( 'ced_tutorlms_refer_value' );
						$ced_tutorlms_refer_value = ( 0 == $ced_tutorlms_refer_value ) ? 1 : $ced_tutorlms_refer_value;
						/*Get Data from the Cookies*/
						$cookie_val = get_user_meta( $user_id, 'registration_cookie_value', true );
						
						$retrive_data = $cookie_val;
						if ( ! empty( $retrive_data ) ) {
							$args['meta_query'] = array(
								array(
									'key' => 'ced_tutorlms_points_referral',
									'value' => trim( $retrive_data ),
									'compare' => '==',
								),
							);
							$refere_data = get_users( $args );
							$refere_id = $refere_data[0]->data->ID;
							
							$refere = get_user_by( 'ID', $refere_id );
							/*Get email of the Refree*/
							$refere_email = $refere->user_email;
							$get_referral = get_user_meta( $refere_id, 'ced_tutorlms_points_referral', true );
							$get_referral_invite = get_user_meta( $refere_id, 'ced_tutorlms_points_referral_invite', true );
							// $custom_ref_pnt = get_user_meta( $refere_id, 'wps_custom_points_referral_invite', true );
							/*Check */
							$get_points = (int) get_user_meta( $refere_id, 'ced_tutorlms_pr_points', true );
							if ( empty( $get_points ) ) {
								$get_points = 0;
							}
							update_option( 'refereeid', $get_points );
							$ced_tutorlms_referral_program = true;
							/*filter that will add restriction*/
							$ced_tutorlms_referral_program = apply_filters( 'ced_tutorlms_referral_points', $ced_tutorlms_referral_program, $customer_id, $refere_id );
							if ( $ced_tutorlms_referral_program ) {
								$total_points = (int) ( $get_points + $ced_tutorlms_refer_value );
								/*update the points of the referred user*/
								update_user_meta( $refere_id, 'ced_tutorlms_pr_points', $total_points );
								$data = array(
									'referr_id' => $customer_id,
								);
		
								/*
								Update the points Details of the users
								*/
								$this->ced_tutorlms_update_points_details( $refere_id, 'reference_details', $ced_tutorlms_refer_value, $data );
								
								delete_user_meta( $user_id, 'registration_cookie_value' );
							}
						}
					}

				}
			}
		}
	}

	/**
	 * Update points when Instructor created course.
	 *
	 * @name ced_tutorlms_instructor_save_course
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param int    $post_ID  Post Id.
	 * @param int    $post  Post Data.
	 */
	public function ced_tutorlms_instructor_save_course( $post_ID, $post ){
		
		
		if( empty( $post_ID ) ){
			return;
		}
		
		$course_id 	= $post_ID;
		$user_id 	= $post->post_author;
		
		$enable_instructor_setting = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_setting_enable' );
		if ( $enable_instructor_setting ) {

			/* Course Update Frequency points */
			$enable_instructor_course_update_freq_setting = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_course_update_freq_enable' );
			if( $enable_instructor_course_update_freq_setting ){
				
				
				$get_courseid_array = get_user_meta( $user_id, 'ced_tutorlms_courseid_course_created_instructor' ,true);
				$get_courseid_array = is_array( $get_courseid_array ) ? $get_courseid_array : array();
				$current_status = get_post_status ( $course_id );
				if ( in_array( $course_id, $get_courseid_array ) && 'publish' == $current_status ){
					$maxno_course_update_freq_value = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_maxno_course_update_freq_value' );
					$course_update_freq_point_value = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_course_update_freq_value' );
					$max_no_of_course_update_freq_counter = (int) get_user_meta( $user_id, 'ced_tutorlms_maxno_course_update_freq_instructor', true );				
					$course_update_freq_total = $max_no_of_course_update_freq_counter + 1;
					update_user_meta( $user_id, 'ced_tutorlms_maxno_course_update_freq_instructor', $course_update_freq_total );
					$max_no_of_course_update_freq_counter = (int) get_user_meta( $user_id, 'ced_tutorlms_maxno_course_update_freq_instructor', true );	
					
				
					if( $max_no_of_course_update_freq_counter % $maxno_course_update_freq_value == 0 ){
						update_user_meta( $user_id, 'ced_tutorlms_maxno_course_update_freq_instructor', 0 );
						$get_points_freq = (int) get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
						$total_points_freq = $get_points_freq + $course_update_freq_point_value;
						update_user_meta( $user_id, 'ced_tutorlms_pr_points', $total_points_freq );
						$data = array();
						$this->ced_tutorlms_update_points_details( $user_id, 'instructor_course_update_freq', $course_update_freq_point_value, $data );
					
					}
				}

				
							
			}
		
			
			
			/* Course creation points */
			$enable_instructor_course_created_setting = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_course_created_enable' );
			if( $enable_instructor_course_created_setting ){
				$maxno_course_created_value = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_maxno_course_created_value' );
				$course_created_point_value = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_course_created_value' );
				
				$get_courseid_array = get_user_meta( $user_id, 'ced_tutorlms_courseid_course_created_instructor' ,true);
				$get_courseid_array = is_array( $get_courseid_array ) ? $get_courseid_array : array();
				if ( !in_array( $course_id, $get_courseid_array ) ){
					if ( empty( $get_courseid_array ) ){
						$get_courseid_array = array();
						$get_courseid_array[] = $course_id;
						update_user_meta( $user_id, 'ced_tutorlms_courseid_course_created_instructor', $get_courseid_array );
					}
					else{
						$get_courseid_array[] = $course_id;
						update_user_meta( $user_id, 'ced_tutorlms_courseid_course_created_instructor', $get_courseid_array );
					}	
					$max_no_of_course_created_counter = (int) get_user_meta( $user_id, 'ced_tutorlms_maxno_course_created_instructor', true );
					$course_created_total = $max_no_of_course_created_counter + 1;
					update_user_meta( $user_id, 'ced_tutorlms_maxno_course_created_instructor', $course_created_total );
					$max_no_of_course_created_counter = (int) get_user_meta( $user_id, 'ced_tutorlms_maxno_course_created_instructor', true );				
					if( $max_no_of_course_created_counter % $maxno_course_created_value == 0 ){
						update_user_meta( $user_id, 'ced_tutorlms_maxno_course_created_instructor', 0 );
						$get_points = (int) get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
						$total_points = $get_points + $course_created_point_value;
						update_user_meta( $user_id, 'ced_tutorlms_pr_points', $total_points );
						$data = array();
						$this->ced_tutorlms_update_points_details( $user_id, 'instructor_course_created', $course_created_point_value, $data );
					
					}
				}
			
			}
		}


	}

	/**
	 * Update points on Student Daily Login and points on login frequency.
	 *
	 * @name ced_tutorlms_student_daily_login
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param string    $user_login  User Login.
	 * @param string    $user  User.
	 */
	public function ced_tutorlms_student_daily_login( $user_login, $user ){
		
		if( empty( $user_login ) ) {
			return;
		}
	
		if( !is_object( $user ) || is_null( $user ) || empty( $user ) ) {
			return;
		}
		$user_id = intval( $user->ID );
		$is_tutor_student = get_user_meta( $user_id, '_is_tutor_student', true );
		if( !$is_tutor_student ){
			return;
		}


		$enable_student_setting = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_setting_enable' );
		if ( $enable_student_setting ) {
			
			/*Points on login Frequency*/
			$student_login_frequency_enable = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_login_frequency_enable' );
			if( $student_login_frequency_enable ){
				$student_maxno_login_frequency_value = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_maxno_login_frequency_value' );
				$student_login_frequency_value = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_login_frequency_value' );

				$maxno_student_login_freq_counter = (int) get_user_meta( $user_id, 'ced_tutorlms_maxno_student_login_freq_counter', true );
				$total_freq_counter_stud = $maxno_student_login_freq_counter + 1;
				update_user_meta( $user_id, 'ced_tutorlms_maxno_student_login_freq_counter', $total_freq_counter_stud );
				$maxno_student_login_freq_counter = (int) get_user_meta( $user_id, 'ced_tutorlms_maxno_student_login_freq_counter', true );
				if( $maxno_student_login_freq_counter % $student_maxno_login_frequency_value == 0 ){
					update_user_meta( $user_id, 'ced_tutorlms_maxno_student_login_freq_counter', 0 );
					$get_points_student = (int) get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
					$total_points_student = $get_points_student + $student_login_frequency_value;
					update_user_meta( $user_id, 'ced_tutorlms_pr_points', $total_points_student );
					$data = array();
					$this->ced_tutorlms_update_points_details( $user_id, 'student_login_frequency', $student_login_frequency_value, $data );
				}
			}

			/*Points on Daily login*/
			$enable_student_daily_login_setting = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_daily_login_enable' );
			if( $enable_student_daily_login_setting ){
				$daily_login_point_value = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_daily_login_value' );
				$ced_tutorlms_daily_login_student_last_login = get_user_meta( $user_id, 'ced_tutorlms_daily_login_student_last_login', true );
				$today_date = date_i18n( 'Y-m-d' );	
				if( $today_date != $ced_tutorlms_daily_login_student_last_login ){
					update_user_meta( $user_id, 'ced_tutorlms_daily_login_student_last_login', $today_date );
					$get_points = (int) get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
					$total_points = $get_points + $daily_login_point_value;
					update_user_meta( $user_id, 'ced_tutorlms_pr_points', $total_points );
					$data = array();
					$this->ced_tutorlms_update_points_details( $user_id, 'student_daily_login', $daily_login_point_value, $data );
				}
			}
		}

	}

	/**
	 * Update points on Instructor Daily Login.
	 *
	 * @name ced_tutorlms_instructor_daily_login
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param string    $user_login  User Login.
	 * @param string    $user  User.
	 */
	public function ced_tutorlms_instructor_daily_login( $user_login, $user ){
		
		if( empty( $user_login ) ) {
			return;
		}
	
		if( !is_object( $user ) || is_null( $user ) || empty( $user ) ) {
			return;
		}
		$user_id = intval( $user->ID );
		// $is_tutor_instructor = get_user_meta( $user_id, '_is_tutor_instructor', true );
		// if( !$is_tutor_instructor ){
		// 	return;
		// }

		$get_instructor_approved_array = get_user_meta( $user_id, 'ced_tutorlms_instructor_approved_registration_instructor' ,true);
		if ( !in_array( $user_id, $get_instructor_approved_array ) ){
			return;
		}
		$enable_instructor_setting = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_setting_enable' );
		if ( $enable_instructor_setting ) {
			$enable_instructor_daily_login_setting = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_daily_login_enable' );
			if( $enable_instructor_daily_login_setting ){
				$daily_login_point_value = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_daily_login_value' );
				$ced_tutorlms_daily_login_instructor_last_login = get_user_meta( $user_id, 'ced_tutorlms_daily_login_instructor_last_login', true );
				$today_date = date_i18n( 'Y-m-d' );	
				if( $today_date != $ced_tutorlms_daily_login_instructor_last_login ){
					update_user_meta( $user_id, 'ced_tutorlms_daily_login_instructor_last_login', $today_date );
					$get_points = (int) get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
					$total_points = $get_points + $daily_login_point_value;
					update_user_meta( $user_id, 'ced_tutorlms_pr_points', $total_points );
					$data = array();
					$this->ced_tutorlms_update_points_details( $user_id, 'instructor_daily_login', $daily_login_point_value, $data );
				}
			}
		}

	}
	
	/**
	 * Update points on Student Birthday.
	 *
	 * @name ced_tutorlms_add_points_to_student_on_birthday
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 */
	public function ced_tutorlms_add_points_to_student_on_birthday(){
		$users = get_users(array(
			'meta_key'     => array( '_is_tutor_student' ),
		));
		foreach( $users as $user ){
			
			$user_tutorlms_dob 	= get_user_meta( $user->ID, '_tutor_profile_dob', true );
			if( !empty( get_user_meta( $user->ID, '_tutor_profile_dob', true ) ) ){
			
				$birthday = new DateTime( $user_tutorlms_dob );
				$today 	  = new DateTime( date( "Y-m-d" ) );
				if ( $birthday->format( "m-d" ) == $today->format( "m-d" ) ) {
				 	$user_id = $user->ID;
					$enable_student_setting = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_setting_enable' );
					if ( $enable_student_setting ) {
						
						$enable_student_birthday_setting = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_birthday_enable' );
						if( $enable_student_birthday_setting ){
							
							$birthday_point_value = $this->ced_tutorlms_get_student_settings_num( 'ced_tutorlms_pr_student_birthday_value' );
							
							$ced_tutorlms_birthday_student_last_update = get_user_meta( $user_id, 'ced_tutorlms_birthday_student_last_update', true );
							$today_date = date_i18n( 'Y-m-d' );	
							if( $today_date != $ced_tutorlms_birthday_student_last_update ){
								update_user_meta( $user_id, 'ced_tutorlms_birthday_student_last_update', $today_date );
								$get_points = (int) get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
								$total_points = $get_points + $birthday_point_value;
								update_user_meta( $user_id, 'ced_tutorlms_pr_points', $total_points );
								$data = array();
								$this->ced_tutorlms_update_points_details( $user_id, 'student_birthday', $birthday_point_value, $data );
							}
						}
					}		
				}
			}
		}		
	}

	/**
	 * Update points on Instructor Birthday.
	 *
	 * @name ced_tutorlms_add_points_to_instructor_on_birthday
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 */
	public function ced_tutorlms_add_points_to_instructor_on_birthday(){
		$users = get_users(array(
			'meta_key'     => array( '_is_tutor_instructor' ),
		));
		foreach( $users as $user ){

			$user_tutorlms_dob 	= get_user_meta( $user->ID, '_tutor_profile_dob', true );
			if( !empty( get_user_meta( $user->ID, '_tutor_profile_dob', true ) ) ){
			
				$birthday = new DateTime( $user_tutorlms_dob );
				$today 	  = new DateTime( date( "Y-m-d" ) );
				if ( $birthday->format( "m-d" ) == $today->format( "m-d" ) ) {
				 	$user_id = $user->ID;
					$get_instructor_approved_array = get_user_meta( $user_id, 'ced_tutorlms_instructor_approved_registration_instructor' ,true);
					if( !empty( $get_instructor_approved_array ) && is_array( $get_instructor_approved_array ) ){
						if ( !in_array( $user_id, $get_instructor_approved_array ) ){
							return;
						}
						$enable_instructor_setting = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_setting_enable' );
						if ( $enable_instructor_setting ) {
							
							$enable_instructor_birthday_setting = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_birthday_enable' );
							if( $enable_instructor_birthday_setting ){
								
								$birthday_point_value = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_birthday_value' );
								
								$ced_tutorlms_birthday_instructor_last_update = get_user_meta( $user_id, 'ced_tutorlms_birthday_instructor_last_update', true );
								$today_date = date_i18n( 'Y-m-d' );	
								if( $today_date != $ced_tutorlms_birthday_instructor_last_update ){
									update_user_meta( $user_id, 'ced_tutorlms_birthday_instructor_last_update', $today_date );
									$get_points = (int) get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
									$total_points = $get_points + $birthday_point_value;
									update_user_meta( $user_id, 'ced_tutorlms_pr_points', $total_points );
									$data = array();
									$this->ced_tutorlms_update_points_details( $user_id, 'instructor_birthday', $birthday_point_value, $data );
								}
							}
						}
					}
							
				}
			}
		}		
	}

	
	/**
	 * Added the date of birth field to the user profile
	 *
	 * @name ced_tutorlms_add_dob_custom_field_to_profile
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param object    $user  User details object.
	 */
	public function ced_tutorlms_add_dob_custom_field_to_profile( $user ){
		$today_date = date_i18n( 'Y-m-d' );
		$current_user = wp_get_current_user();
		if ( $current_user->wp_capabilities['administrator'] == 1 ) {
			wp_nonce_field( '_tutor_lms_profile_dob_action', '_tutor_lms_profile_dob_field' );
			?>
			<table class="form-table">
				<tr>
					<th>
						<label for="_tutor_profile_dob"><?php _e( 'Date of Birth (Filled in Tutor LMS Dashboard)' ); ?></label>
					</th>
					<td>
						<input type="date" name="_tutor_profile_dob" id="_tutor_profile_dob" value="<?php esc_attr_e( get_user_meta( $user->ID, '_tutor_profile_dob', true ) ); ?>" class="regular-text" max= "<?php echo $today_date?>"/>
					</td>
				</tr>
			</table>
			<?php
		}else{
			?>
			<input type="hidden" name="_tutor_profile_dob" id="_tutor_profile_dob" value="<?php esc_attr_e( get_user_meta( $user->ID, '_tutor_profile_dob', true ) ); ?>" class="regular-text"/>
			
		<?php
		}
	}

	/**
	 * Update the date of birth field to the user profile
	 *
	 * @name ced_tutorlms_update_dob_profile_field
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param int    $user_id  User Id.
	 */
	public function ced_tutorlms_update_dob_profile_field( $user_id ) {
		$current_user = wp_get_current_user();
		if ( $current_user->wp_capabilities['administrator'] == 1 ) {

			$today_date = date_i18n( 'Y-m-d' );
			$user_dob 	= $_POST['_tutor_profile_dob'];
			$today_date = strtotime( $today_date );
			$dob 		= strtotime( $user_dob );

			if( $today_date < $dob ){
				
			}else{
				update_user_meta( $user_id, '_tutor_profile_dob', $user_dob );
			}
			
		}
	}

	/**
	 * Update the points for instructor lesson created and reaches a particular limit
	 *
	 * @name ced_tutorlms_instructor_lesson_created
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param int    $lesson_id  Lesson Id.
	 */
	public function ced_tutorlms_instructor_lesson_created( $lesson_id ){
		
		$user_id = get_post_field ('post_author', $lesson_id );

		$enable_instructor_setting = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_setting_enable' );
		if ( $enable_instructor_setting ) {
			$enable_instructor_lesson_created_setting = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_lesson_created_enable' );
			if( $enable_instructor_lesson_created_setting ){
				$maxno_lesson_created_value = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_maxno_lesson_created_value' );
				$lesson_created_point_value = $this->ced_tutorlms_get_instructor_settings_num( 'ced_tutorlms_pr_instructor_lesson_created_value' );				
			
				$max_no_of_lesson_created_counter = (int) get_user_meta( $user_id, 'ced_tutorlms_maxno_lesson_created_instructor', true );
				$lesson_created_total = $max_no_of_lesson_created_counter + 1;
				update_user_meta( $user_id, 'ced_tutorlms_maxno_lesson_created_instructor', $lesson_created_total );
				$max_no_of_lesson_created_counter = (int) get_user_meta( $user_id, 'ced_tutorlms_maxno_lesson_created_instructor', true );				
				if( $max_no_of_lesson_created_counter % $maxno_lesson_created_value == 0 ){
					update_user_meta( $user_id, 'ced_tutorlms_maxno_lesson_created_instructor', 0 );
					$get_points = (int) get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
					$total_points = $get_points + $lesson_created_point_value;
					update_user_meta( $user_id, 'ced_tutorlms_pr_points', $total_points );
					$data = array();
					$this->ced_tutorlms_update_points_details( $user_id, 'instructor_lesson_created', $lesson_created_point_value, $data );
				
				}
			
			
			}
		}
	}

	/**
	 * Return the Student settings value.
	 *
	 * @name ced_tutorlms_get_student_settings_num
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param string    $id  ID for settings.
	 */
	public function ced_tutorlms_get_student_settings_num( $id ) {
		$ced_tutorlms_student_setting_value = 0;
		$student_settings = get_option( 'ced_tutorlms_pr_student_settings', true );
		if ( ! empty( $student_settings[ $id ] ) ) {
			$ced_tutorlms_student_setting_value = (int) $student_settings[ $id ];
		}
		return $ced_tutorlms_student_setting_value;
	}

	/**
	 * Return the Instructor settings value.
	 *
	 * @name ced_tutorlms_get_instructor_settings_num
	 * @since 1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param string    $id  ID for settings.
	 */
	public function ced_tutorlms_get_instructor_settings_num( $id ) {
		$ced_tutorlms_instructor_setting_value = 0;
		$instructor_settings = get_option( 'ced_tutorlms_pr_instructor_settings', true );
		if ( ! empty( $instructor_settings[ $id ] ) ) {
			$ced_tutorlms_instructor_setting_value = (int) $instructor_settings[ $id ];
		}
		return $ced_tutorlms_instructor_setting_value;
	}

	/**
	 * Get referal settings
	 *
	 * @name ced_tutorlms_referal_settings_num
	 * @link https://www.cedcommerce.com/
	 * @param string $id id of the setting.
	 */
	public function ced_tutorlms_get_referal_settings_num( $id ) {
		$ced_tutorlms_referal_value = 0;
		$referal_settings = get_option( 'ced_tutorlms_pr_social_share_settings', true );
		if ( ! empty( $referal_settings[ $id ] ) ) {
			$ced_tutorlms_referal_value = (int) $referal_settings[ $id ];
		}
		return $ced_tutorlms_referal_value;
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
		if ( 'student_registration' == $type ) {
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
		if ( 'admin_points' == $type && ! empty( $data ) ) {
			$admin_points = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
			if ( isset( $admin_points['admin_points'] ) && ! empty( $admin_points['admin_points'] ) ) {
				$admin_array                    = array();
				$admin_array                    = array(
					'admin_points' => $points,
					'date'         => $today_date,
					'sign'         => $data['sign'],
					'reason'       => $data['reason'],
				);
				$admin_points['admin_points'][] = $admin_array;
			} else {
				if ( ! is_array( $admin_points ) ) {
					$admin_points = array();
				}
				$admin_array                    = array(
					'admin_points' => $points,
					'date'         => $today_date,
					'sign'         => $data['sign'],
					'reason'       => $data['reason'],
				);
				$admin_points['admin_points'][] = $admin_array;
			}
			/* Update the points details*/
			if ( ! empty( $admin_points ) && is_array( $admin_points ) ) {
				update_user_meta( $user_id, 'ced_tutorlms_points_details', $admin_points );
			}
		}
		if ( 'quiz_points' == $type ) {
			$my_points = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
			if ( isset( $my_points['quiz_points'] ) && ! empty( $my_points['quiz_points'] ) ) {
				$points_array        = array();
				$points_array        = array(
					'quiz_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Passing Quiz',
				);
				$my_points['quiz_points'][] = $points_array;
			} else {
				if ( ! is_array( $my_points ) ) {
					$my_points = array();
				}
				$points_array                    = array(
					'quiz_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Passing Quiz',
				);
				$my_points['quiz_points'][] = $points_array;
			}
			update_user_meta( $user_id, 'ced_tutorlms_points_details', $my_points );
		}
		if ( 'course_enrollment' == $type ) {
			$my_points = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
			if ( isset( $my_points['course_enrollment_points'] ) && ! empty( $my_points['course_enrollment_points'] ) ) {
				$points_array        = array();
				$points_array        = array(
					'course_enrollment_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Course Enrollment',
				);
				$my_points['course_enrollment_points'][] = $points_array;
			} else {
				if ( ! is_array( $my_points ) ) {
					$my_points = array();
				}
				$points_array                    = array(
					'course_enrollment_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Course Enrollment',
				);
				$my_points['course_enrollment_points'][] = $points_array;
			}
			update_user_meta( $user_id, 'ced_tutorlms_points_details', $my_points );
		}
		if ( 'course_complete' == $type ) {
			$my_points = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
			if ( isset( $my_points['course_complete_points'] ) && ! empty( $my_points['course_complete_points'] ) ) {
				$points_array        = array();
				$points_array        = array(
					'course_complete_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Course Complete',
				);
				$my_points['course_complete_points'][] = $points_array;
			} else {
				if ( ! is_array( $my_points ) ) {
					$my_points = array();
				}
				$points_array = array(
					'course_complete_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Course Complete',
				);
				$my_points['course_complete_points'][] = $points_array;
			}
			update_user_meta( $user_id, 'ced_tutorlms_points_details', $my_points );
		}
		if ( 'lesson_complete' == $type ) {
			$my_points = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
			if ( isset( $my_points['lesson_complete_points'] ) && ! empty( $my_points['lesson_complete_points'] ) ) {
				$points_array        = array();
				$points_array        = array(
					'lesson_complete_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Lesson Complete',
				);
				$my_points['lesson_complete_points'][] = $points_array;
			} else {
				if ( ! is_array( $my_points ) ) {
					$my_points = array();
				}
				$points_array = array(
					'lesson_complete_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Lesson Complete',
				);
				$my_points['lesson_complete_points'][] = $points_array;
			}
			update_user_meta( $user_id, 'ced_tutorlms_points_details', $my_points );
		}
		if ( 'assignment_submit' == $type ) {
			$my_points = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
			if ( isset( $my_points['assignment_submit_points'] ) && ! empty( $my_points['assignment_submit_points'] ) ) {
				$points_array        = array();
				$points_array        = array(
					'assignment_submit_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Assignment Submit',
				);
				$my_points['assignment_submit_points'][] = $points_array;
			} else {
				if ( ! is_array( $my_points ) ) {
					$my_points = array();
				}
				$points_array = array(
					'assignment_submit_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Assignment Submit',
				);
				$my_points['assignment_submit_points'][] = $points_array;
			}
			update_user_meta( $user_id, 'ced_tutorlms_points_details', $my_points );
		}
		if ( 'assignment_pass' == $type ) {
			$my_points = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
			if ( isset( $my_points['assignment_pass_points'] ) && ! empty( $my_points['assignment_pass_points'] ) ) {
				$points_array        = array();
				$points_array        = array(
					'assignment_pass_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Assignment Passed',
				);
				$my_points['assignment_pass_points'][] = $points_array;
			} else {
				if ( ! is_array( $my_points ) ) {
					$my_points = array();
				}
				$points_array = array(
					'assignment_pass_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Assignment Passed',
				);
				$my_points['assignment_pass_points'][] = $points_array;
			}
			update_user_meta( $user_id, 'ced_tutorlms_points_details', $my_points );
		}
		if ( 'student_review' == $type ) {
			$my_points = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
			if ( isset( $my_points['student_review_points'] ) && ! empty( $my_points['student_review_points'] ) ) {
				$points_array        = array();
				$points_array        = array(
					'student_review_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Student Review',
				);
				$my_points['student_review_points'][] = $points_array;
			} else {
				if ( ! is_array( $my_points ) ) {
					$my_points = array();
				}
				$points_array = array(
					'student_review_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Student Review',
				);
				$my_points['student_review_points'][] = $points_array;
			}
			update_user_meta( $user_id, 'ced_tutorlms_points_details', $my_points );
		}
		if ( 'instructor_registration' == $type ) {
			$my_points = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
			if ( isset( $my_points['instructor_registration_points'] ) && ! empty( $my_points['instructor_registration_points'] ) ) {
				$points_array        = array();
				$points_array        = array(
					'instructor_registration_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Instructor Registration',
				);
				$my_points['instructor_registration_points'][] = $points_array;
			} else {
				if ( ! is_array( $my_points ) ) {
					$my_points = array();
				}
				$points_array = array(
					'instructor_registration_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Instructor Registration',
				);
				$my_points['instructor_registration_points'][] = $points_array;
			}
			update_user_meta( $user_id, 'ced_tutorlms_points_details', $my_points );
		}
		if ( 'instructor_course_created' == $type ) {
			$my_points = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
			if ( isset( $my_points['instructor_course_created_points'] ) && ! empty( $my_points['instructor_course_created_points'] ) ) {
				$points_array        = array();
				$points_array        = array(
					'instructor_course_created_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Instructor Course Created',
				);
				$my_points['instructor_course_created_points'][] = $points_array;
			} else {
				if ( ! is_array( $my_points ) ) {
					$my_points = array();
				}
				$points_array = array(
					'instructor_course_created_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Instructor Course Created',
				);
				$my_points['instructor_course_created_points'][] = $points_array;
			}
			update_user_meta( $user_id, 'ced_tutorlms_points_details', $my_points );
		}
		if ( 'reference_details' == $type ) {
			$my_points = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
			if ( isset( $my_points['reference_details_points'] ) && ! empty( $my_points['reference_details_points'] ) ) {
				$points_array        = array();
				$points_array        = array(
					'reference_details_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Reference Details',
				);
				$my_points['reference_details_points'][] = $points_array;
			} else {
				if ( ! is_array( $my_points ) ) {
					$my_points = array();
				}
				$points_array = array(
					'reference_details_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Reference Details',
				);
				$my_points['reference_details_points'][] = $points_array;
			}
			update_user_meta( $user_id, 'ced_tutorlms_points_details', $my_points );
		}
		if ( 'student_daily_login' == $type ) {
			$my_points = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
			if ( isset( $my_points['student_daily_login_points'] ) && ! empty( $my_points['student_daily_login_points'] ) ) {
				$points_array        = array();
				$points_array        = array(
					'student_daily_login_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Student Daily Login',
				);
				$my_points['student_daily_login_points'][] = $points_array;
			} else {
				if ( ! is_array( $my_points ) ) {
					$my_points = array();
				}
				$points_array = array(
					'student_daily_login_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Student Daily Login',
				);
				$my_points['student_daily_login_points'][] = $points_array;
			}
			update_user_meta( $user_id, 'ced_tutorlms_points_details', $my_points );
		}
		if ( 'instructor_daily_login' == $type ) {
			$my_points = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
			if ( isset( $my_points['instructor_daily_login_points'] ) && ! empty( $my_points['instructor_daily_login_points'] ) ) {
				$points_array        = array();
				$points_array        = array(
					'instructor_daily_login_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Instructor Daily Login',
				);
				$my_points['instructor_daily_login_points'][] = $points_array;
			} else {
				if ( ! is_array( $my_points ) ) {
					$my_points = array();
				}
				$points_array = array(
					'instructor_daily_login_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Instructor Daily Login',
				);
				$my_points['instructor_daily_login_points'][] = $points_array;
			}
			update_user_meta( $user_id, 'ced_tutorlms_points_details', $my_points );
		}
		if ( 'student_birthday' == $type ) {
			$my_points = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
			if ( isset( $my_points['student_birthday_points'] ) && ! empty( $my_points['student_birthday_points'] ) ) {
				$points_array        = array();
				$points_array        = array(
					'student_birthday_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Student Birthday',
				);
				$my_points['student_birthday_points'][] = $points_array;
			} else {
				if ( ! is_array( $my_points ) ) {
					$my_points = array();
				}
				$points_array = array(
					'student_birthday_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Student Birthday',
				);
				$my_points['student_birthday_points'][] = $points_array;
			}
			update_user_meta( $user_id, 'ced_tutorlms_points_details', $my_points );
		}
		if ( 'instructor_birthday' == $type ) {
			$my_points = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
			if ( isset( $my_points['instructor_birthday_points'] ) && ! empty( $my_points['instructor_birthday_points'] ) ) {
				$points_array        = array();
				$points_array        = array(
					'instructor_birthday_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Instructor Birthday',
				);
				$my_points['instructor_birthday_points'][] = $points_array;
			} else {
				if ( ! is_array( $my_points ) ) {
					$my_points = array();
				}
				$points_array = array(
					'instructor_birthday_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Instructor Birthday',
				);
				$my_points['instructor_birthday_points'][] = $points_array;
			}
			update_user_meta( $user_id, 'ced_tutorlms_points_details', $my_points );
		}
		if ( 'instructor_total_students' == $type ) {
			$my_points = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
			if ( isset( $my_points['instructor_total_students_points'] ) && ! empty( $my_points['instructor_total_students_points'] ) ) {
				$points_array        = array();
				$points_array        = array(
					'instructor_total_students_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Instructor Total Students',
				);
				$my_points['instructor_total_students_points'][] = $points_array;
			} else {
				if ( ! is_array( $my_points ) ) {
					$my_points = array();
				}
				$points_array = array(
					'instructor_total_students_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Instructor Total Students',
				);
				$my_points['instructor_total_students_points'][] = $points_array;
			}
			update_user_meta( $user_id, 'ced_tutorlms_points_details', $my_points );
		}
		if ( 'instructor_lesson_created' == $type ) {
			$my_points = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
			if ( isset( $my_points['instructor_lesson_created_points'] ) && ! empty( $my_points['instructor_lesson_created_points'] ) ) {
				$points_array        = array();
				$points_array        = array(
					'instructor_lesson_created_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Instructor Total Lesson',
				);
				$my_points['instructor_lesson_created_points'][] = $points_array;
			} else {
				if ( ! is_array( $my_points ) ) {
					$my_points = array();
				}
				$points_array = array(
					'instructor_lesson_created_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Instructor Total Lesson',
				);
				$my_points['instructor_lesson_created_points'][] = $points_array;
			}
			update_user_meta( $user_id, 'ced_tutorlms_points_details', $my_points );
		}
		if ( 'student_login_frequency' == $type ) {
			$my_points = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
			if ( isset( $my_points['student_login_frequency_points'] ) && ! empty( $my_points['student_login_frequency_points'] ) ) {
				$points_array        = array();
				$points_array        = array(
					'student_login_frequency_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Student Login Frequency',
				);
				$my_points['student_login_frequency_points'][] = $points_array;
			} else {
				if ( ! is_array( $my_points ) ) {
					$my_points = array();
				}
				$points_array = array(
					'student_login_frequency_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Student Login Frequency',
				);
				$my_points['student_login_frequency_points'][] = $points_array;
			}
			update_user_meta( $user_id, 'ced_tutorlms_points_details', $my_points );
		}
		if ( 'instructor_course_update_freq' == $type ) {
			$my_points = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
			if ( isset( $my_points['instructor_course_update_freq_points'] ) && ! empty( $my_points['instructor_course_update_freq_points'] ) ) {
				$points_array        = array();
				$points_array        = array(
					'instructor_course_update_freq_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Course Update Frequency',
				);
				$my_points['instructor_course_update_freq_points'][] = $points_array;
			} else {
				if ( ! is_array( $my_points ) ) {
					$my_points = array();
				}
				$points_array = array(
					'instructor_course_update_freq_points'  => $points,
					'date'         => $today_date,
					'reason'       => 'Course Update Frequency',
				);
				$my_points['instructor_course_update_freq_points'][] = $points_array;
			}
			update_user_meta( $user_id, 'ced_tutorlms_points_details', $my_points );
		}
		return 'Successfully';
	}


	/**
	 * Check is student module is enable.
	 *
	 * @return true/false
	 * @since    1.0.0
	 */
	public function ced_tutorlms_pr_student_is_enable() {

		$is_enable = false;
		$ced_tutorlms_pr_student_enable = '';
		$student_settings = get_option( 'ced_tutorlms_pr_student_settings', true );
		if ( isset( $student_settings['ced_tutorlms_pr_general_setting_enable'] ) ) {
			$ced_tutorlms_pr_student_enable = $student_settings['ced_tutorlms_pr_general_setting_enable'];
		}
		if ( ! empty( $ced_tutorlms_pr_student_enable ) && 1 == $ced_tutorlms_pr_student_enable ) {
			$is_enable = true;
		}
		return $is_enable;
	}

	/**
	 * This function update points
	 *
	 * @name ced_tutorlms_points_update
	 * @since      1.0.0
	 * @link https://www.cedcommerce.com/
	 */
	public function ced_tutorlms_points_update() {
		check_ajax_referer( 'ced_tutorlms-pr-verify-nonce', 'ced_tutorlms_pr_nonce' );
		if ( isset( $_POST['points'] ) && is_numeric( $_POST['points'] ) && isset( $_POST['user_id'] ) && isset( $_POST['sign'] ) && isset( $_POST['reason'] ) ) {

			$user_id = sanitize_text_field( wp_unslash( $_POST['user_id'] ) );
			/* Get the user points*/
			$get_points = (int) get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
			/* Get the Input Values*/
			$points     = sanitize_text_field( wp_unslash( $_POST['points'] ) );
			$sign       = sanitize_text_field( wp_unslash( $_POST['sign'] ) );
			$reason     = sanitize_text_field( wp_unslash( $_POST['reason'] ) );
			/* calculate users points*/
			if ( '+' === $sign ) {
				$total_points = $get_points + $points;
			} elseif ( '-' === $sign ) {
				if ( $points <= $get_points ) {
					$total_points = $get_points - $points;
				} else {
					$points = $get_points;
					$total_points = $get_points - $points;
				}
			}
			$data = array(
				'sign'   => $sign,
				'reason' => $reason,
			);
			/* Update user points*/
			if ( isset( $total_points ) && $total_points >= 0 ) {
				update_user_meta( $user_id, 'ced_tutorlms_pr_points', $total_points );
			}
			/* Update user points*/
			$this->ced_tutorlms_update_points_details( $user_id, 'admin_points', $points, $data );
			wp_die();
		}
	}


	

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ced-pointsrewards-tutorlms-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ced-pointsrewards-tutorlms-admin.js', array( 'jquery','jquery-blockui' ), $this->version, false );
		$localize_array = array(
			'ajax_url'   => admin_url( 'admin-ajax.php' ),
			'ced_tutorlms_pr_nonce' => wp_create_nonce( 'ced_tutorlms-pr-verify-nonce' ),
		);
		wp_localize_script( $this->plugin_name, 'ced_tutorlms_pr_admin_obj', $localize_array );

		wp_register_script( 'jquery-tiptip', WC()->plugin_url() . '/assets/js/jquery-tiptip/jquery.tipTip.js', array( 'jquery' ), WC_VERSION, true );
	}

	/**
	 * class-ced-pointsrewards-tutorlms-admin ced_tutor_lms_points_rewards_admin_menu.
	 *
	 * @since 1.0.0
	 */
	public function ced_tutor_lms_points_rewards_admin_menu() {
		global $submenu;
		
		if ( empty( $GLOBALS['admin_page_hooks']['wps-plugins'] ) ) {
			add_menu_page( __( 'WP Swings', 'ced-pointsrewards-tutorlms' ), __( 'WP Swings', 'ced-pointsrewards-tutorlms' ), 'manage_woocommerce', 'wps-plugins', array( $this, 'ced_marketplace_listing_page' ), plugins_url( 'ced-pointsrewards-tutorlms/admin/images/wpswings_logo.png' ), 15 );
			$menus = apply_filters( 'wps_add_plugins_menus_array', array() );
			
			if ( is_array( $menus ) && ! empty( $menus ) ) {
				foreach ( $menus as $key => $value ) {
					add_submenu_page( 'wps-plugins', $value['name'], $value['name'], 'manage_woocommerce', $value['menu_link'], array( $value['instance'], $value['function'] ) );
				}
			}
		}

	}

	/**
	 * class-ced-pointsrewards-tutorlms-admin ced_marketplace_listing_page.
	 *
	 * @since 1.0.0
	 */
	public function ced_marketplace_listing_page() {
		
		$active_marketplaces = apply_filters( 'wps_add_plugins_menus_array', array() );
		if ( is_array( $active_marketplaces ) && ! empty( $active_marketplaces ) ) {
			require CED_TUTORLMS_DIRPATH . 'admin/partials/marketplaces.php';
		}
	}

	/**
	 * class-ced-pointsrewards-tutorlms-admin ced_pointsrewards_tutorlms_add_marketplace_menus_to_array.
	 *
	 * @since 1.0.0
	 * @param array $menus Marketplace menus.
	 */
	public function ced_pointsrewards_tutorlms_add_marketplace_menus_to_array( $menus = array() ) {
		$menus[] = array(
			'name'            => 'Tutor LMS Points and Rewards',
			'slug'            => 'ced-tutor-lms-points-rewards',
			'menu_link'       => 'ced_tutor_lms_points_rewards',
			'instance'        => $this,
			'function'        => 'ced_tutor_lms_points_rewards_main_page',
			//'card_image_link' => CED_TUTORLMS_URL . 'admin/images/fbmp.png',
		);
		return $menus;
	}

	/**
	 * Removing default submenu of parent menu in backend dashboard.
	 *
	 * @since   1.0.0
	 */
	public function ced_tutorlms_remove_default_submenu() {
		global $submenu;
		if ( is_array( $submenu ) && array_key_exists( 'wps-plugins', $submenu ) ) {
			if ( isset( $submenu['wps-plugins'][0] ) ) {
				unset( $submenu['wps-plugins'][0] );
			}
		}
	}

	/**
	 * class-ced-pointsrewards-tutorlms-admin ced_tutor_lms_points_rewards_main_page.
	 *
	 * @since 1.0.0
	 */
	public function ced_tutor_lms_points_rewards_main_page() {
		include_once CED_TUTORLMS_DIRPATH . '/admin/partials/ced-tutorlms-pointsrewards-admin-display.php';
	}

}
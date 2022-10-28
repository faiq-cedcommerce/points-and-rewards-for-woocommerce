<?php
/**
 * This is setttings array for the Student settings
 *
 * Student Settings Template
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
$ced_tutorlms_pr_student_settings = array(
	array(
		'title' => __( 'Enable', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'title',
	),
	array(
		'title' => __( 'Enable', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'checkbox',
		'desc'  => __( 'Enable Tutor LMS Points and Rewards Setting for Student', 'ced-pointsrewards-tutorlms' ),
		'id'    => 'ced_tutorlms_pr_student_setting_enable',
		'desc_tip' => __( 'Check this box to enable the Settings for Student.', 'ced-pointsrewards-tutorlms' ),
		'default'   => 0,
	),
	array(
		'type'  => 'sectionend',
	),


	array(
		'title' => __( 'Registration', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'title',
	),
	array(
		'title' => __( 'Enable Registration Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'checkbox',
		'id'    => 'ced_tutorlms_pr_student_registration_enable',
		'heading' => __( 'Registration', 'ced-pointsrewards-tutorlms' ),
		'class'   => 'input-text',
		'desc_tip' => __( 'Check this box to enable the Registration Points.', 'ced-pointsrewards-tutorlms' ),
		'default'   => 0,
		'desc'    => __( 'Enable Registration Points for Student Rewards', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Enter registration Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		
		'id'    => 'ced_tutorlms_pr_student_registration_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'The points that the new Student will get after signup.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'type'  => 'sectionend',
	),

	array(
		'title' => __( 'Birthday Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'title',
	),
	array(
		'title' => __( 'Enable Birthday Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'checkbox',
		'id'    => 'ced_tutorlms_pr_student_birthday_enable',
		'heading' => __( 'Birthday', 'ced-pointsrewards-tutorlms' ),
		'class'   => 'input-text',
		'desc_tip' => __( 'Check this box to enable the Birthday Points.', 'ced-pointsrewards-tutorlms' ),
		'default'   => 0,
		'desc'    => __( 'Enable Birthday Points for Student Rewards', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Enter Birthday Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_student_birthday_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'The points that the Student will get on Birthday.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'type'  => 'sectionend',
	),

	array(
		'title' => __( 'Daily Login', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'title',
	),
	array(
		'title' => __( 'Enable Daily Login Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'checkbox',
		'id'    => 'ced_tutorlms_pr_student_daily_login_enable',
		'heading' => __( 'Daily Login', 'ced-pointsrewards-tutorlms' ),
		'class'   => 'input-text',
		'desc_tip' => __( 'Check this box to enable the Daily Login Points.', 'ced-pointsrewards-tutorlms' ),
		'default'   => 0,
		'desc'    => __( 'Enable Daily Login Points for Student Rewards', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Enter Daily Login Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_student_daily_login_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'The points that the student will get after daily login.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'type'  => 'sectionend',
	),

	array(
		'title' => __( 'Points on Login Frequency', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'title',
	),
	array(
		'title' => __( 'Enable Login Frequency Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'checkbox',
		'id'    => 'ced_tutorlms_pr_student_login_frequency_enable',
		'heading' => __( 'Enable Login Frequency Points', 'ced-pointsrewards-tutorlms' ),
		'class'   => 'input-text',
		'desc_tip' => __( 'Check this box to enable the Login Frequency Points.', 'ced-pointsrewards-tutorlms' ),
		'default'   => 0,
		'desc'    => __( 'Enable Login Frequency Points for Student Rewards', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Max No of Login Frequency', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_student_maxno_login_frequency_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'Maximum no of Login Frequency.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Enter Login Frequency Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_student_login_frequency_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'The points that the  student get after frequency of login.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'type'  => 'sectionend',
	),

	array(
		'title' => __( 'Courses Enrollment', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'title',
	),
	array(
		'title' => __( 'Enable Course Enrollment Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'checkbox',
		'id'    => 'ced_tutorlms_pr_student_course_enroll_enable',
		'heading' => __( 'Enable Course Enrollment Points', 'ced-pointsrewards-tutorlms' ),
		'class'   => 'input-text',
		'desc_tip' => __( 'Check this box to enable the Course Enrollment Points.', 'ced-pointsrewards-tutorlms' ),
		'default'   => 0,
		'desc'    => __( 'Enable Course Enrollment Points for Student Rewards', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Max No of Course Enrollments', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_student_maxno_course_enroll_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'Maximum no of Course Enrollment.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Enter Course Enrollment Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_student_course_enroll_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'The points that the  student get after enrollment to a course.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'type'  => 'sectionend',
	),


	array(
		'title' => __( 'Lesson Completed Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'title',
	),
	array(
		'title' => __( 'Enable Lesson Completed Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'checkbox',
		'id'    => 'ced_tutorlms_pr_student_lesson_complete_enable',
		'heading' => __( 'Enable Lesson Completed Points', 'ced-pointsrewards-tutorlms' ),
		'class'   => 'input-text',
		'desc_tip' => __( 'Check this box to enable the Lesson Completed Points.', 'ced-pointsrewards-tutorlms' ),
		'default'   => 0,
		'desc'    => __( 'Enable Lesson Completed Points for Student Rewards', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Max No of Lesson Completed', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_student_maxno_lesson_completed_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'Maximum no of Lesson Completed.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Enter Lesson Completed Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_student_lesson_completed_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'The points that the  student get after enrollment to a course.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'type'  => 'sectionend',
	),

	array(
		'title' => __( 'Course Completed Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'title',
	),
	array(
		'title' => __( 'Enable Course Completed Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'checkbox',
		'id'    => 'ced_tutorlms_pr_student_course_complete_enable',
		'heading' => __( 'Enable Course Completed Points', 'ced-pointsrewards-tutorlms' ),
		'class'   => 'input-text',
		'desc_tip' => __( 'Check this box to enable the Course Completed Points.', 'ced-pointsrewards-tutorlms' ),
		'default'   => 0,
		'desc'    => __( 'Enable Course Completed Points for Student Rewards', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Max No of Course Completed', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_student_maxno_course_completed_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'Maximum no of Course Completed.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Enter Course Completed Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_student_course_completed_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'The points that the  student get after Completed a course.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'type'  => 'sectionend',
	),

	array(
		'title' => __( 'Quiz Passed Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'title',
	),
	array(
		'title' => __( 'Enable Quiz Passed Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'checkbox',
		'id'    => 'ced_tutorlms_pr_student_quiz_passed_enable',
		'heading' => __( 'Enable Quiz Passed Points', 'ced-pointsrewards-tutorlms' ),
		'class'   => 'input-text',
		'desc_tip' => __( 'Check this box to enable the Quiz Passed Points.', 'ced-pointsrewards-tutorlms' ),
		'default'   => 0,
		'desc'    => __( 'Enable Quiz Passed Points for Student Rewards', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Max No of Quiz Passed', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_student_maxno_quiz_passed_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'Maximum no of Quiz Passed.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Enter Quiz Passed Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_student_quiz_passed_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'The points that the student get after passed a quiz.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'type'  => 'sectionend',
	),


	array(
		'title' => __( 'Assignment Submit Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'title',
	),
	array(
		'title' => __( 'Enable Assignment Submit Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'checkbox',
		'id'    => 'ced_tutorlms_pr_student_assignment_submit_enable',
		'heading' => __( 'Enable Assignment Submit Points', 'ced-pointsrewards-tutorlms' ),
		'class'   => 'input-text',
		'desc_tip' => __( 'Check this box to enable the Assignment Submit Points.', 'ced-pointsrewards-tutorlms' ),
		'default'   => 0,
		'desc'    => __( 'Enable Assignment Submit Points for Student Rewards', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Max No of Assignment Submit', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_student_maxno_assignment_submit_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'Maximum no of Assignment Submit.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Enter Assignment Submit Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_student_assignment_submit_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'The points that the student get after submit an Assignment.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'type'  => 'sectionend',
	),

	array(
		'title' => __( 'Assignment Passed Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'title',
	),
	array(
		'title' => __( 'Enable Assignment Passed Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'checkbox',
		'id'    => 'ced_tutorlms_pr_student_assignment_passed_enable',
		'heading' => __( 'Enable Assignment Passed Points', 'ced-pointsrewards-tutorlms' ),
		'class'   => 'input-text',
		'desc_tip' => __( 'Check this box to enable the Assignment Passed Points.', 'ced-pointsrewards-tutorlms' ),
		'default'   => 0,
		'desc'    => __( 'Enable Assignment Passed Points for Student Rewards', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Max No of Assignment Passed', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_student_maxno_assignment_passed_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'Maximum no of Assignment Passed.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Enter Assignment Passed Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_student_assignment_passed_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'The points that the student get after passed a Assignment.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'type'  => 'sectionend',
	),

	array(
		'title' => __( 'Course Review Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'title',
	),
	array(
		'title' => __( 'Enable Review Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'checkbox',
		'id'    => 'ced_tutorlms_pr_student_review_enable',
		'heading' => __( 'Enable Review Points', 'ced-pointsrewards-tutorlms' ),
		'class'   => 'input-text',
		'desc_tip' => __( 'Check this box to enable the Review Points.', 'ced-pointsrewards-tutorlms' ),
		'default'   => 0,
		'desc'    => __( 'Enable Review Points for Student Rewards', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Max No of Review', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_student_maxno_review_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'Maximum no of Review.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'On Rating', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_student_rating_review_value',
		'custom_attributes'   => array( 'min' => '"1"', 'max' => '"5"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'Rating Range on review.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Enter Review Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_student_review_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'The points that the student get after passed a Assignment.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'type'  => 'sectionend',
	),
	
	
);
$ced_tutorlms_pr_student_settings = apply_filters( 'ced_tutorlms_pr_student_settings', $ced_tutorlms_pr_student_settings );
$current_tab = 'ced_tutorlms_pr_student_setting';
if ( isset( $_POST['ced_tutorlms_pr_save_general'] ) && isset( $_POST['wps-wpr-nonce'] ) ) {
	$ced_tutorlms_pr_nonce = sanitize_text_field( wp_unslash( $_POST['wps-wpr-nonce'] ) );
	if ( wp_verify_nonce( $ced_tutorlms_pr_nonce, 'wps-wpr-nonce' ) ) {
		?>
<?php
		if ( 'ced_tutorlms_pr_student_setting' == $current_tab ) {
			/* Save Settings and check is not empty*/
			$postdata = map_deep( wp_unslash( $_POST ), 'sanitize_text_field' );
			$postdata = $settings_obj->check_is_settings_is_not_empty( $ced_tutorlms_pr_student_settings, $postdata );
			/* End of the save Settings and check is not empty*/
			$student_settings_array = array();

			foreach ( $postdata as $key => $value ) {
				$student_settings_array[ $key ] = $value;
			}
			if ( is_array( $student_settings_array ) && ! empty( $student_settings_array ) ) {
				$student_settings_array = apply_filters( 'ced_tutorlms_pr_student_settings_save_option', $student_settings_array );
				update_option( 'ced_tutorlms_pr_student_settings', $student_settings_array );
			}
			$settings_obj->ced_tutorlms_settings_saved();
			do_action( 'ced_tutorlms_pr_student_settings_save_option', $student_settings_array );
		}
	}
}
?>
<?php $student_settings = get_option( 'ced_tutorlms_pr_student_settings', true ); ?>
<?php
	if ( ! is_array( $student_settings ) ) :
		$student_settings = array();
endif;
	?>
<?php do_action( 'ced_tutorlms_pr_add_notice' ); ?>
<div class="ced_tutorlms_pr_table">
    <div class="ced_tutorlms_general_wrapper">
        <?php
				foreach ( $ced_tutorlms_pr_student_settings as $key => $value ) {
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
							$settings_obj->ced_tutorlms_pr_generate_checkbox_html( $value, $student_settings );
						}
						if ( 'number' == $value['type'] ) {
							$settings_obj->ced_tutorlms_pr_generate_number_html( $value, $student_settings );
						}
						if ( 'multiple_checkbox' == $value['type'] ) {
							foreach ( $value['multiple_checkbox'] as $k => $val ) {
								$settings_obj->ced_tutorlms_pr_generate_checkbox_html( $val, $student_settings );
							}
						}
						if ( 'text' == $value['type'] ) {
							$settings_obj->ced_tutorlms_pr_generate_text_html( $value, $student_settings );
						}
						if ( 'textarea' == $value['type'] ) {
							$settings_obj->ced_tutorlms_pr_generate_textarea_html( $value, $student_settings );
						}
						if ( 'number_text' == $value['type'] ) {
							foreach ( $value['number_text'] as $k => $val ) {
								if ( 'text' == $val['type'] ) {

									echo isset( $val['curr'] ) ? esc_html( $val['curr'] ) : '';
									$settings_obj->ced_tutorlms_pr_generate_text_html( $val, $student_settings );
									echo '<br>';

								}
								if ( 'number' == $val['type'] ) {

									$settings_obj->ced_tutorlms_pr_generate_number_html( $val, $student_settings );
								}
							}
						}
						do_action( 'ced_tutorlms_pr_additional_student_settings', $value, $student_settings );
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
        class="button-primary woocommerce-save-button ced_tutorlms_save_changes" name="ced_tutorlms_pr_save_general">
</p>

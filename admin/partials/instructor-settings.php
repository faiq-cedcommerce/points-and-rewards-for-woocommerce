<?php
/**
 * This is setttings array for the instructor settings
 *
 * instructor Settings Template
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
$ced_tutorlms_pr_instructor_settings = array(
	array(
		'title' => __( 'Enable', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'title',
	),
	array(
		'title' => __( 'Enable', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'checkbox',
		'desc'  => __( 'Enable Tutor LMS Points and Rewards Setting for Instructor', 'ced-pointsrewards-tutorlms' ),
		'id'    => 'ced_tutorlms_pr_instructor_setting_enable',
		'desc_tip' => __( 'Check this box to enable the Settings for Instructor.', 'ced-pointsrewards-tutorlms' ),
		'default'   => 0,
	),
	array(
		'type'  => 'sectionend',
	),


	array(
		'title' => __( 'Instructor Registration', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'title',
	),
	array(
		'title' => __( 'Enable Instructor Registration Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'checkbox',
		'id'    => 'ced_tutorlms_pr_instructor_registration_enable',
		'heading' => __( 'Instructor Registration', 'ced-pointsrewards-tutorlms' ),
		'class'   => 'input-text',
		'desc_tip' => __( 'Check this box to enable the Instructor Registration Points.', 'ced-pointsrewards-tutorlms' ),
		'default'   => 0,
		'desc'    => __( 'Enable Instructor Registration Points for Points Rewards', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Enter Instructor Registration Points (After approval)', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_instructor_registration_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'The points that the new Instructor will get after signup.', 'ced-pointsrewards-tutorlms' ),
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
		'id'    => 'ced_tutorlms_pr_instructor_daily_login_enable',
		'heading' => __( 'Daily Login', 'ced-pointsrewards-tutorlms' ),
		'class'   => 'input-text',
		'desc_tip' => __( 'Check this box to enable the Daily Login Points.', 'ced-pointsrewards-tutorlms' ),
		'default'   => 0,
		'desc'    => __( 'Enable Daily Login Points for Instructor Rewards', 'ced-pointsrewards-tutorlms' ),
	),
	
	array(
		'title' => __( 'Enter Daily Login Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_instructor_daily_login_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'The points that the Instructor will get after daily login.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'type'  => 'sectionend',
	),

	array(
		'title' => __( 'Enrolled Students', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'title',
	),
	array(
		'title' => __( 'Enable Enrolled Students Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'checkbox',
		'id'    => 'ced_tutorlms_pr_instructor_enrolled_student_enable',
		'heading' => __( 'Enrolled Students', 'ced-pointsrewards-tutorlms' ),
		'class'   => 'input-text',
		'desc_tip' => __( 'Check this box to enable the Enrolled Students Points.', 'ced-pointsrewards-tutorlms' ),
		'default'   => 0,
		'desc'    => __( 'Enable Enrolled Students Points for Instructor Rewards', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Max No of Students Enrolled', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_instructor_max_enrolled_student',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'Maximum no of Student Enrolled.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Enter Enrolled Students Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_instructor_enrolled_student_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'The points that the Instructor will get after no of Enrolled Students.', 'ced-pointsrewards-tutorlms' ),
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
		'id'    => 'ced_tutorlms_pr_instructor_birthday_enable',
		'heading' => __( 'Birthday', 'ced-pointsrewards-tutorlms' ),
		'class'   => 'input-text',
		'desc_tip' => __( 'Check this box to enable the Birthday Points.', 'ced-pointsrewards-tutorlms' ),
		'default'   => 0,
		'desc'    => __( 'Enable Birthday Points for instructor Rewards', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Enter Birthday Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_instructor_birthday_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'The points that the Instructor will get on Birthday.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'type'  => 'sectionend',
	),

    array(
		'title' => __( 'Course Created Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'title',
	),
	array(
		'title' => __( 'Enable Course Created Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'checkbox',
		'id'    => 'ced_tutorlms_pr_instructor_course_created_enable',
		'heading' => __( 'Enable Course Created Points', 'ced-pointsrewards-tutorlms' ),
		'class'   => 'input-text',
		'desc_tip' => __( 'Check this box to enable the Course Created Points.', 'ced-pointsrewards-tutorlms' ),
		'default'   => 0,
		'desc'    => __( 'Enable Course Created Points for Instructor Rewards', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Max No of Course Created', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_instructor_maxno_course_created_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'Maximum no of Course Created.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Enter Course Created Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_instructor_course_created_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'The points that the  instructor get after Creating a course.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'type'  => 'sectionend',
	),

	array(
		'title' => __( 'Course Update Frequency', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'title',
	),
	array(
		'title' => __( 'Enable Course Update Frequency', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'checkbox',
		'id'    => 'ced_tutorlms_pr_instructor_course_update_freq_enable',
		'heading' => __( 'Enable Course Update Frequency', 'ced-pointsrewards-tutorlms' ),
		'class'   => 'input-text',
		'desc_tip' => __( 'Check this box to enable the Course Update Frequency.', 'ced-pointsrewards-tutorlms' ),
		'default'   => 0,
		'desc'    => __( 'Enable Course Update Frequency for Instructor Rewards', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Max No of Course Update Frequency', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_instructor_maxno_course_update_freq_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'Maximum no of Course Update Frequency.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Enter Course Update Frequency Points Value', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_instructor_course_update_freq_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'The points that the  instructor get after Updating a course upto a frequency.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'type'  => 'sectionend',
	),

	array(
		'title' => __( 'Lesson Created Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'title',
	),
	array(
		'title' => __( 'Enable Lesson Created Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'checkbox',
		'id'    => 'ced_tutorlms_pr_instructor_lesson_created_enable',
		'heading' => __( 'Enable Lesson Created Points', 'ced-pointsrewards-tutorlms' ),
		'class'   => 'input-text',
		'desc_tip' => __( 'Check this box to enable the Lesson Created Points.', 'ced-pointsrewards-tutorlms' ),
		'default'   => 0,
		'desc'    => __( 'Enable Lesson Created Points for Instructor Rewards', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Max No of Lesson Created', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_instructor_maxno_lesson_created_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'Maximum no of Lesson Created.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'title' => __( 'Enter Lesson Created Points', 'ced-pointsrewards-tutorlms' ),
		'type'  => 'number',
		'default'   => 1,
		'id'    => 'ced_tutorlms_pr_instructor_lesson_created_value',
		'custom_attributes'   => array( 'min' => '"1"' ),
		'class'   => 'input-text ced_tutorlms_pr_new_woo_ver_style_text',
		'desc_tip' => __( 'The points that the  instructor get after Creating a Lesson.', 'ced-pointsrewards-tutorlms' ),
	),
	array(
		'type'  => 'sectionend',
	),

);
$ced_tutorlms_pr_instructor_settings = apply_filters( 'ced_tutorlms_pr_instructor_settings', $ced_tutorlms_pr_instructor_settings );
$current_tab = 'ced_tutorlms_pr_instructor_setting';
if ( isset( $_POST['ced_tutorlms_pr_save_instructor'] ) && isset( $_POST['wps-wpr-nonce'] ) ) {
	$ced_tutorlms_pr_nonce = sanitize_text_field( wp_unslash( $_POST['wps-wpr-nonce'] ) );
	if ( wp_verify_nonce( $ced_tutorlms_pr_nonce, 'wps-wpr-nonce' ) ) {
		?>
		<?php
		if ( 'ced_tutorlms_pr_instructor_setting' == $current_tab ) {
			/* Save Settings and check is not empty*/
			$postdata = map_deep( wp_unslash( $_POST ), 'sanitize_text_field' );
			$postdata = $settings_obj->check_is_settings_is_not_empty( $ced_tutorlms_pr_instructor_settings, $postdata );
			/* End of the save Settings and check is not empty*/
			$instructor_settings_array = array();

			foreach ( $postdata as $key => $value ) {
				$instructor_settings_array[ $key ] = $value;
			}
			if ( is_array( $instructor_settings_array ) && ! empty( $instructor_settings_array ) ) {
				$instructor_settings_array = apply_filters( 'ced_tutorlms_pr_instructor_settings_save_option', $instructor_settings_array );
				update_option( 'ced_tutorlms_pr_instructor_settings', $instructor_settings_array );
			}
			$settings_obj->ced_tutorlms_settings_saved();
			do_action( 'ced_tutorlms_pr_instructor_settings_save_option', $instructor_settings_array );
		}
	}
}
?>
	<?php $instructor_settings = get_option( 'ced_tutorlms_pr_instructor_settings', true ); ?>
	<?php
	if ( ! is_array( $instructor_settings ) ) :
		$instructor_settings = array();
endif;
	?>
	<?php do_action( 'ced_tutorlms_pr_add_notice' ); ?>
	<div class="ced_tutorlms_pr_table">
		<div class="ced_tutorlms_general_wrapper">
				<?php
				foreach ( $ced_tutorlms_pr_instructor_settings as $key => $value ) {
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
							$settings_obj->ced_tutorlms_pr_generate_checkbox_html( $value, $instructor_settings );
						}
						if ( 'number' == $value['type'] ) {
							$settings_obj->ced_tutorlms_pr_generate_number_html( $value, $instructor_settings );
						}
						if ( 'multiple_checkbox' == $value['type'] ) {
							foreach ( $value['multiple_checkbox'] as $k => $val ) {
								$settings_obj->ced_tutorlms_pr_generate_checkbox_html( $val, $instructor_settings );
							}
						}
						if ( 'text' == $value['type'] ) {
							$settings_obj->ced_tutorlms_pr_generate_text_html( $value, $instructor_settings );
						}
						if ( 'textarea' == $value['type'] ) {
							$settings_obj->ced_tutorlms_pr_generate_textarea_html( $value, $instructor_settings );
						}
						if ( 'number_text' == $value['type'] ) {
							foreach ( $value['number_text'] as $k => $val ) {
								if ( 'text' == $val['type'] ) {

									echo isset( $val['curr'] ) ? esc_html( $val['curr'] ) : '';
									$settings_obj->ced_tutorlms_pr_generate_text_html( $val, $instructor_settings );
									echo '<br>';

								}
								if ( 'number' == $val['type'] ) {

									$settings_obj->ced_tutorlms_pr_generate_number_html( $val, $instructor_settings );
								}
							}
						}
						do_action( 'ced_tutorlms_pr_additional_instructor_settings', $value, $instructor_settings );
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
		<input type="submit" value='<?php esc_html_e( 'Save changes', 'ced-pointsrewards-tutorlms' ); ?>' class="button-primary woocommerce-save-button ced_tutorlms_save_changes" name="ced_tutorlms_pr_save_instructor">
	</p>
	<?php


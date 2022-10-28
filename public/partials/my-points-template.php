<?php
$user_id = get_current_user_id();
$social_share_settings = get_option( 'ced_tutorlms_pr_social_share_settings');
$enable_social_share = isset( $social_share_settings['ced_tutorlms_social_share_enable'] ) ? $social_share_settings['ced_tutorlms_social_share_enable'] : 0; 
/*Start of the Referral Section*/
if ( $enable_social_share ) {
    $public_obj = new Ced_Pointsrewards_Tutorlms_Public( 'ced-pointsrewards-tutorlms', '1.0.0' );
    $public_obj->ced_tutorlms_referral_section( $user_id );
}

?>

<div class="ced_tutorlms_points_wrapper_with_exp">
	<div class="ced_tutorlms_points_only"><p class="ced_tutorlms_heading_para" >
		<span class="ced_tutorlms_heading">Tutor LMS Points: </span></p>
		<?php
		$get_points = get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
		$get_point = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
		?>
		<span class="ced_tutorlms_heading" id="ced_tutorlms_points_only">
			<?php
			echo ( isset( $get_points ) && null != $get_points ) ? esc_html( $get_points ) : 0;
			?>
		</span>
	</div>
</div>	
<?php	
if ( isset( $user_id ) && null != $user_id && is_numeric( $user_id ) ) {
	$point_log    = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
	$total_points = get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
	if ( isset( $point_log ) && is_array( $point_log ) && null != $point_log ) {
		?>

<div class="ced_tutorlms_wrapper_div">
<?php
				if ( array_key_exists( 'admin_points', $point_log ) ) {
					?>
<div class="ced_tutorlms_slide_toggle">
	<p class="ced_tutorlms_view_log_notice">
		<?php esc_html_e( 'Admin Updates', 'ced-pointsrewards-tutorlms' ); ?>
		<a class="ced_tutorlms_open_toggle" href="javascript:;"></a>
	</p>
	<div class="ced_tutorlms_points_view">
		<table class="form-table mwp_wpr_settings  ced_tutorlms_common_table">
			<thead>
				<tr valign="top">
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Date & Time', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Point Status', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Reason', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
				</tr>
			</thead>
			<?php
			
					foreach ( $point_log['admin_points'] as $key => $value ) {
						$value['sign']   = isset( $value['sign'] ) ? $value['sign'] : '+ /-';
						$value['reason'] = isset( $value['reason'] ) ? $value['reason'] : __( 'Updated By Admin', 'ced-pointsrewards-tutorlms' );
						?>
			<tr valign="top">
				<td class="forminp forminp-text"><?php echo esc_html( $value['date'] ); ?></td>
				<td class="forminp forminp-text">
					<?php echo esc_html( $value['sign'] ) . ' ' . esc_html( $value['admin_points'] ); ?></td>
				<td class="forminp forminp-text"><?php echo esc_html( $value['reason'] ); ?></td>
			</tr>
			<?php
					}
					?>
		</table>
	</div>
</div>
<?php
				}
			if ( array_key_exists( 'student_registration', $point_log ) ) {
				?>
<div class="ced_tutorlms_slide_toggle">
	<p class="ced_tutorlms_view_log_notice">
		<?php esc_html_e( 'Signup Event', 'ced-pointsrewards-tutorlms' ); ?>
		<a class="ced_tutorlms_open_toggle" href="javascript:;"></a>
	</p>
	<div class="ced_tutorlms_points_view">
		<table class="form-table mwp_wpr_settings ced_tutorlms_common_table">
			<thead>
				<tr valign="top">
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Date & Time', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Point Status', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
				</tr>
			</thead>
			<tr valign="top">
				<td class="forminp forminp-text">
					<?php echo( esc_html( $point_log['student_registration']['0']['date'] ) ); ?></td>
				<td class="forminp forminp-text">
					<?php echo '+ ' . esc_html( $point_log['student_registration']['0']['student_registration'] ); ?></td>
			</tr>
		</table>
	</div>
</div>
<?php
			}
			if ( array_key_exists( 'course_enrollment_points', $point_log ) ) {
				?>
<div class="ced_tutorlms_slide_toggle">
	<p class="ced_tutorlms_view_log_notice">
		<?php esc_html_e( 'Course Enrollment', 'ced-pointsrewards-tutorlms' ); ?>
		<a class="ced_tutorlms_open_toggle" href="javascript:;"></a>
	</p>
	<div class="ced_tutorlms_points_view">
		<table class="form-table mwp_wpr_settings ced_tutorlms_common_table">
			<thead>
				<tr valign="top">
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Date & Time', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Point Status', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
				</tr>
			</thead>
			<?php
						foreach ( $point_log['course_enrollment_points'] as $key => $value ) {
					?>
			<tr valign="top">
				<td class="forminp forminp-text"><?php echo esc_html( $value['date'] ); ?></td>
				<td class="forminp forminp-text"><?php echo '+ ' . esc_html( $value['course_enrollment_points'] ); ?>
				</td>
			</tr>
			<?php
						}
					?>
		</table>
	</div>
</div>
<?php
			}
			if ( array_key_exists( 'lesson_complete_points', $point_log ) ) {
				?>
<div class="ced_tutorlms_slide_toggle">
	<p class="ced_tutorlms_view_log_notice">
		<?php esc_html_e( 'Lesson Complete Points', 'ced-pointsrewards-tutorlms' ); ?>
		<a class="ced_tutorlms_open_toggle" href="javascript:;"></a>
	</p>
	<div class="ced_tutorlms_points_view">
		<table class="form-table mwp_wpr_settings ced_tutorlms_common_table">
			<thead>
				<tr valign="top">
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Date & Time', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Point Status', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
				</tr>
			</thead>
			<?php
						foreach ( $point_log['lesson_complete_points'] as $key => $value ) {
							?>
			<tr valign="top">
				<td class="forminp forminp-text"><?php echo esc_html( $value['date'] ); ?></td>
				<td class="forminp forminp-text"><?php echo '+ ' . esc_html( $value['lesson_complete_points'] ); ?>
				</td>
			</tr>
			<?php
						}
						?>
		</table>
	</div>
</div>
<?php
			}
			if ( array_key_exists( 'quiz_points', $point_log ) ) {
				?>
<div class="ced_tutorlms_slide_toggle">
	<p class="ced_tutorlms_view_log_notice">
		<?php esc_html_e( 'Quiz Pass Points', 'ced-pointsrewards-tutorlms' ); ?>
		<a class="ced_tutorlms_open_toggle" href="javascript:;"></a>
	</p>
	<div class="ced_tutorlms_points_view">
		<table class="form-table mwp_wpr_settings ced_tutorlms_common_table">
			<thead>
				<tr valign="top">
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Date & Time', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Point Status', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
				</tr>
			</thead>
			<?php
						foreach ( $point_log['quiz_points'] as $key => $value ) {
							?>
			<tr valign="top">
				<td class="forminp forminp-text"><?php echo esc_html( $value['date'] ); ?></td>
				<td class="forminp forminp-text"><?php echo '+ ' . esc_html( $value['quiz_points'] ); ?></td>
			</tr>
			<?php
						}
						?>
		</table>
	</div>
</div>
<?php
			}
			if ( array_key_exists( 'assignment_submit_points', $point_log ) ) {
				?>
<div class="ced_tutorlms_slide_toggle">
	<p class="ced_tutorlms_view_log_notice">
		<?php esc_html_e( 'Assignment Submit Points', 'ced-pointsrewards-tutorlms' ); ?>
		<a class="ced_tutorlms_open_toggle" href="javascript:;"></a>
	</p>
	<div class="ced_tutorlms_points_view">
		<table class="form-table mwp_wpr_settings ced_tutorlms_common_table">
			<thead>
				<tr valign="top">
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Date & Time', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Point Status', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
				</tr>
			</thead>
			<?php
						foreach ( $point_log['assignment_submit_points'] as $key => $value ) {
							?>
			<tr valign="top">
				<td class="forminp forminp-text"><?php echo esc_html( $value['date'] ); ?></td>
				<td class="forminp forminp-text"><?php echo '+ ' . esc_html( $value['assignment_submit_points'] ); ?>
				</td>
			</tr>
			<?php
						}
						?>
		</table>
	</div>
</div>
<?php
			}
			if ( array_key_exists( 'assignment_pass_points', $point_log ) ) {
				?>
<div class="ced_tutorlms_slide_toggle">
	<p class="ced_tutorlms_view_log_notice">
		<?php esc_html_e( 'Assignment Pass Points', 'ced-pointsrewards-tutorlms' ); ?>
		<a class="ced_tutorlms_open_toggle" href="javascript:;"></a>
	</p>
	<div class="ced_tutorlms_points_view">
		<table class="form-table mwp_wpr_settings ced_tutorlms_common_table">
			<thead>
				<tr valign="top">
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Date & Time', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Point Status', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
				</tr>
			</thead>
			<?php
						foreach ( $point_log['assignment_pass_points'] as $key => $value ) {
							?>
			<tr valign="top">
				<td class="forminp forminp-text"><?php echo esc_html( $value['date'] ); ?></td>
				<td class="forminp forminp-text"><?php echo '+ ' . esc_html( $value['assignment_pass_points'] ); ?>
				</td>
			</tr>
			<?php
						}
						?>
		</table>
	</div>
</div>
<?php
			}
			if ( array_key_exists( 'student_review_points', $point_log ) ) {
				?>
<div class="ced_tutorlms_slide_toggle">
	<p class="ced_tutorlms_view_log_notice">
		<?php esc_html_e( 'Student Review Points', 'ced-pointsrewards-tutorlms' ); ?>
		<a class="ced_tutorlms_open_toggle" href="javascript:;"></a>
	</p>
	<div class="ced_tutorlms_points_view">
		<table class="form-table mwp_wpr_settings ced_tutorlms_common_table">
			<thead>
				<tr valign="top">
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Date & Time', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Point Status', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
				</tr>
			</thead>
			<?php
						foreach ( $point_log['student_review_points'] as $key => $value ) {
							?>
			<tr valign="top">
				<td class="forminp forminp-text"><?php echo esc_html( $value['date'] ); ?></td>
				<td class="forminp forminp-text"><?php echo '+ ' . esc_html( $value['student_review_points'] ); ?>
				</td>
			</tr>
			<?php
						}
						?>
		</table>
	</div>
</div>
<?php
			}

			if ( array_key_exists( 'instructor_registration_points', $point_log ) ) {
				?>
<div class="ced_tutorlms_slide_toggle">
	<p class="ced_tutorlms_view_log_notice">
		<?php esc_html_e( 'Instructor Registration Points', 'ced-pointsrewards-tutorlms' ); ?>
		<a class="ced_tutorlms_open_toggle" href="javascript:;"></a>
	</p>
	<div class="ced_tutorlms_points_view">
		<table class="form-table mwp_wpr_settings ced_tutorlms_common_table">
			<thead>
				<tr valign="top">
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Date & Time', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Point Status', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
				</tr>
			</thead>
			<?php
						foreach ( $point_log['instructor_registration_points'] as $key => $value ) {
							?>
			<tr valign="top">
				<td class="forminp forminp-text"><?php echo esc_html( $value['date'] ); ?></td>
				<td class="forminp forminp-text"><?php echo '+ ' . esc_html( $value['instructor_registration_points'] ); ?>
				</td>
			</tr>
			<?php
						}
						?>
		</table>
	</div>
</div>
<?php
			}
			if ( array_key_exists( 'instructor_course_created_points', $point_log ) ) {
				?>
<div class="ced_tutorlms_slide_toggle">
	<p class="ced_tutorlms_view_log_notice">
		<?php esc_html_e( 'Instructor Course Create Points', 'ced-pointsrewards-tutorlms' ); ?>
		<a class="ced_tutorlms_open_toggle" href="javascript:;"></a>
	</p>
	<div class="ced_tutorlms_points_view">
		<table class="form-table mwp_wpr_settings ced_tutorlms_common_table">
			<thead>
				<tr valign="top">
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Date & Time', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Point Status', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
				</tr>
			</thead>
			<?php
						foreach ( $point_log['instructor_course_created_points'] as $key => $value ) {
							?>
			<tr valign="top">
				<td class="forminp forminp-text"><?php echo esc_html( $value['date'] ); ?></td>
				<td class="forminp forminp-text"><?php echo '+ ' . esc_html( $value['instructor_course_created_points'] ); ?>
				</td>
			</tr>
			<?php
						}
						?>
		</table>
	</div>
</div>
<?php
			}		
			
			if ( array_key_exists( 'reference_details_points', $point_log ) ) {
				?>
<div class="ced_tutorlms_slide_toggle">
	<p class="ced_tutorlms_view_log_notice">
		<?php esc_html_e( 'Reference Points', 'ced-pointsrewards-tutorlms' ); ?>
		<a class="ced_tutorlms_open_toggle" href="javascript:;"></a>
	</p>
	<div class="ced_tutorlms_points_view">
		<table class="form-table mwp_wpr_settings ced_tutorlms_common_table">
			<thead>
				<tr valign="top">
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Date & Time', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Point Status', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
				</tr>
			</thead>
			<?php
						foreach ( $point_log['reference_details_points'] as $key => $value ) {
							?>
			<tr valign="top">
				<td class="forminp forminp-text"><?php echo esc_html( $value['date'] ); ?></td>
				<td class="forminp forminp-text"><?php echo '+ ' . esc_html( $value['reference_details_points'] ); ?>
				</td>
			</tr>
			<?php
						}
						?>
		</table>
	</div>
</div>
<?php
			}	
			if ( array_key_exists( 'course_complete_points', $point_log ) ) {
				?>
<div class="ced_tutorlms_slide_toggle">
	<p class="ced_tutorlms_view_log_notice">
		<?php esc_html_e( 'Course Complete Points', 'ced-pointsrewards-tutorlms' ); ?>
		<a class="ced_tutorlms_open_toggle" href="javascript:;"></a>
	</p>
	<div class="ced_tutorlms_points_view">
		<table class="form-table mwp_wpr_settings ced_tutorlms_common_table">
			<thead>
				<tr valign="top">
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Date & Time', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Point Status', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
				</tr>
			</thead>
			<?php
						foreach ( $point_log['course_complete_points'] as $key => $value ) {
							?>
			<tr valign="top">
				<td class="forminp forminp-text"><?php echo esc_html( $value['date'] ); ?></td>
				<td class="forminp forminp-text"><?php echo '+ ' . esc_html( $value['course_complete_points'] ); ?>
				</td>
			</tr>
			<?php
						}
						?>
		</table>
	</div>
</div>
<?php
			}	
			
			if ( array_key_exists( 'student_daily_login_points', $point_log ) ) {
				?>
<div class="ced_tutorlms_slide_toggle">
	<p class="ced_tutorlms_view_log_notice">
		<?php esc_html_e( 'Student Daily Login Points', 'ced-pointsrewards-tutorlms' ); ?>
		<a class="ced_tutorlms_open_toggle" href="javascript:;"></a>
	</p>
	<div class="ced_tutorlms_points_view">
		<table class="form-table mwp_wpr_settings ced_tutorlms_common_table">
			<thead>
				<tr valign="top">
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Date & Time', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Point Status', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
				</tr>
			</thead>
			<?php
						foreach ( $point_log['student_daily_login_points'] as $key => $value ) {
							?>
			<tr valign="top">
				<td class="forminp forminp-text"><?php echo esc_html( $value['date'] ); ?></td>
				<td class="forminp forminp-text"><?php echo '+ ' . esc_html( $value['student_daily_login_points'] ); ?>
				</td>
			</tr>
			<?php
						}
						?>
		</table>
	</div>
</div>
<?php
			}
			if ( array_key_exists( 'student_birthday_points', $point_log ) ) {
				?>
<div class="ced_tutorlms_slide_toggle">
	<p class="ced_tutorlms_view_log_notice">
		<?php esc_html_e( 'Student Birthday Points', 'ced-pointsrewards-tutorlms' ); ?>
		<a class="ced_tutorlms_open_toggle" href="javascript:;"></a>
	</p>
	<div class="ced_tutorlms_points_view">
		<table class="form-table mwp_wpr_settings ced_tutorlms_common_table">
			<thead>
				<tr valign="top">
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Date & Time', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Point Status', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
				</tr>
			</thead>
			<?php
						foreach ( $point_log['student_birthday_points'] as $key => $value ) {
							?>
			<tr valign="top">
				<td class="forminp forminp-text"><?php echo esc_html( $value['date'] ); ?></td>
				<td class="forminp forminp-text"><?php echo '+ ' . esc_html( $value['student_birthday_points'] ); ?>
				</td>
			</tr>
			<?php
						}
						?>
		</table>
	</div>
</div>
<?php
			}	
			if ( array_key_exists( 'instructor_birthday_points', $point_log ) ) {
				?>
<div class="ced_tutorlms_slide_toggle">
	<p class="ced_tutorlms_view_log_notice">
		<?php esc_html_e( 'Instructor Birthday Points', 'ced-pointsrewards-tutorlms' ); ?>
		<a class="ced_tutorlms_open_toggle" href="javascript:;"></a>
	</p>
	<div class="ced_tutorlms_points_view">
		<table class="form-table mwp_wpr_settings ced_tutorlms_common_table">
			<thead>
				<tr valign="top">
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Date & Time', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Point Status', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
				</tr>
			</thead>
			<?php
						foreach ( $point_log['instructor_birthday_points'] as $key => $value ) {
							?>
			<tr valign="top">
				<td class="forminp forminp-text"><?php echo esc_html( $value['date'] ); ?></td>
				<td class="forminp forminp-text"><?php echo '+ ' . esc_html( $value['instructor_birthday_points'] ); ?>
				</td>
			</tr>
			<?php
						}
						?>
		</table>
	</div>
</div>
<?php
			}		
			if ( array_key_exists( 'instructor_daily_login_points', $point_log ) ) {
				?>
<div class="ced_tutorlms_slide_toggle">
	<p class="ced_tutorlms_view_log_notice">
		<?php esc_html_e( 'Instructor Daily Login Points', 'ced-pointsrewards-tutorlms' ); ?>
		<a class="ced_tutorlms_open_toggle" href="javascript:;"></a>
	</p>
	<div class="ced_tutorlms_points_view">
		<table class="form-table mwp_wpr_settings ced_tutorlms_common_table">
			<thead>
				<tr valign="top">
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Date & Time', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Point Status', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
				</tr>
			</thead>
			<?php
						foreach ( $point_log['instructor_daily_login_points'] as $key => $value ) {
							?>
			<tr valign="top">
				<td class="forminp forminp-text"><?php echo esc_html( $value['date'] ); ?></td>
				<td class="forminp forminp-text"><?php echo '+ ' . esc_html( $value['instructor_daily_login_points'] ); ?>
				</td>
			</tr>
			<?php
						}
						?>
		</table>
	</div>
</div>
<?php
			}	
			if ( array_key_exists( 'instructor_total_students_points', $point_log ) ) {
				?>
<div class="ced_tutorlms_slide_toggle">
	<p class="ced_tutorlms_view_log_notice">
		<?php esc_html_e( 'Instructor Total Students Points', 'ced-pointsrewards-tutorlms' ); ?>
		<a class="ced_tutorlms_open_toggle" href="javascript:;"></a>
	</p>
	<div class="ced_tutorlms_points_view">
		<table class="form-table mwp_wpr_settings ced_tutorlms_common_table">
			<thead>
				<tr valign="top">
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Date & Time', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Point Status', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
				</tr>
			</thead>
			<?php
						foreach ( $point_log['instructor_total_students_points'] as $key => $value ) {
							?>
			<tr valign="top">
				<td class="forminp forminp-text"><?php echo esc_html( $value['date'] ); ?></td>
				<td class="forminp forminp-text"><?php echo '+ ' . esc_html( $value['instructor_total_students_points'] ); ?>
				</td>
			</tr>
			<?php
						}
						?>
		</table>
	</div>
</div>
<?php
			}   
			if ( array_key_exists( 'instructor_lesson_created_points', $point_log ) ) {
				?>
<div class="ced_tutorlms_slide_toggle">
	<p class="ced_tutorlms_view_log_notice">
		<?php esc_html_e( 'Instructor Lesson Created Points', 'ced-pointsrewards-tutorlms' ); ?>
		<a class="ced_tutorlms_open_toggle" href="javascript:;"></a>
	</p>
	<div class="ced_tutorlms_points_view">
		<table class="form-table mwp_wpr_settings ced_tutorlms_common_table">
			<thead>
				<tr valign="top">
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Date & Time', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Point Status', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
				</tr>
			</thead>
			<?php
						foreach ( $point_log['instructor_lesson_created_points'] as $key => $value ) {
							?>
			<tr valign="top">
				<td class="forminp forminp-text"><?php echo esc_html( $value['date'] ); ?></td>
				<td class="forminp forminp-text"><?php echo '+ ' . esc_html( $value['instructor_lesson_created_points'] ); ?>
				</td>
			</tr>
			<?php
						}
						?>
		</table>
	</div>
</div>
<?php
			}  
			if ( array_key_exists( 'student_login_frequency_points', $point_log ) ) {
				?>
<div class="ced_tutorlms_slide_toggle">
	<p class="ced_tutorlms_view_log_notice">
		<?php esc_html_e( 'Student Login Frequency Points', 'ced-pointsrewards-tutorlms' ); ?>
		<a class="ced_tutorlms_open_toggle" href="javascript:;"></a>
	</p>
	<div class="ced_tutorlms_points_view">
		<table class="form-table mwp_wpr_settings ced_tutorlms_common_table">
			<thead>
				<tr valign="top">
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Date & Time', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Point Status', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
				</tr>
			</thead>
			<?php
						foreach ( $point_log['student_login_frequency_points'] as $key => $value ) {
							?>
			<tr valign="top">
				<td class="forminp forminp-text"><?php echo esc_html( $value['date'] ); ?></td>
				<td class="forminp forminp-text"><?php echo '+ ' . esc_html( $value['student_login_frequency_points'] ); ?>
				</td>
			</tr>
			<?php
						}
						?>
		</table>
	</div>
</div>
<?php
			} 

			if ( array_key_exists( 'instructor_course_update_freq_points', $point_log ) ) {
				?>
<div class="ced_tutorlms_slide_toggle">
	<p class="ced_tutorlms_view_log_notice">
		<?php esc_html_e( 'Instructor Course Update Frequency Points', 'ced-pointsrewards-tutorlms' ); ?>
		<a class="ced_tutorlms_open_toggle" href="javascript:;"></a>
	</p>
	<div class="ced_tutorlms_points_view">
		<table class="form-table mwp_wpr_settings ced_tutorlms_common_table">
			<thead>
				<tr valign="top">
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Date & Time', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Point Status', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
				</tr>
			</thead>
			<?php
						foreach ( $point_log['instructor_course_update_freq_points'] as $key => $value ) {
							?>
			<tr valign="top">
				<td class="forminp forminp-text"><?php echo esc_html( $value['date'] ); ?></td>
				<td class="forminp forminp-text"><?php echo '+ ' . esc_html( $value['instructor_course_update_freq_points'] ); ?>
				</td>
			</tr>
			<?php
						}
						?>
		</table>
	</div>
</div>
<?php
			} 	
			
			if ( array_key_exists( 'cart_subtotal_point', $point_log ) ) {
				?>
<div class="ced_tutorlms_slide_toggle">
	<p class="ced_tutorlms_view_log_notice">
		<?php esc_html_e( 'Cart Subtotal Points', 'ced-pointsrewards-tutorlms' ); ?>
		<a class="ced_tutorlms_open_toggle" href="javascript:;"></a>
	</p>
	<div class="ced_tutorlms_points_view">
		<table class="form-table mwp_wpr_settings ced_tutorlms_common_table">
			<thead>
				<tr valign="top">
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Date & Time', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
					<th scope="row" class="ced_tutorlms_head_titledesc">
						<span
							class="ced_tutorlms_nobr"><?php echo esc_html__( 'Point Status', 'ced-pointsrewards-tutorlms' ); ?></span>
					</th>
				</tr>
			</thead>
			<?php
						foreach ( $point_log['cart_subtotal_point'] as $key => $value ) {
							?>
			<tr valign="top">
				<td class="forminp forminp-text"><?php echo esc_html( $value['date'] ); ?></td>
				<td class="forminp forminp-text"><?php echo '- ' . esc_html( $value['cart_subtotal_point'] ); ?>
				</td>
			</tr>
			<?php
						}
						?>
		</table>
	</div>
</div>
<?php
			} 	
			do_action( 'ced_tutorlms_points_admin_table_log', $point_log );
			?>

<table class="form-table mwp_wpr_settings ced_tutorlms_points_view_total">
	<tr valign="top">
		<td class="forminp forminp-text">
			<strong><?php esc_html_e( 'Total Points', 'ced-pointsrewards-tutorlms' ); ?></strong>
		</td>
		<td class="forminp forminp-text"><strong><?php echo esc_html( $total_points ); ?></strong>
		</td>
		<td class="forminp forminp-text"></td>
	</tr>
</table>
</div>
<?php
	} else {
		echo '<h3>' . esc_html__( 'No Points Generated Yet.', 'ced-pointsrewards-tutorlms' ) . '<h3>';
	}
}
?>
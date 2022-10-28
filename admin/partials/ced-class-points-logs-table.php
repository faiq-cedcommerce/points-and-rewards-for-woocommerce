<?php
/**
 * Exit if accessed directly
 *
 * @since      1.0.0
 * @package    ced_pointsrewards-tutorlms
 * @subpackage ced_pointsrewards-tutorlms/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * This is construct of class where all users point listed.
 *
 * @name Points_Log_List_Table
 * @since      1.0.0
 * @category Class
 * @link https://www.cedcommerce.com/
 */
class CED_Points_Log_List_Table extends WP_List_Table {
	/**
	 * This is variable which is used for the store all the data.
	 *
	 * @var array $example_data variable for store data.
	 */
	public $example_data;

	/**
	 * This is variable which is used for the store all the data.
	 *
	 * @var array $wps_total_counta variable for store data.
	 */
	public $wps_total_count;


	/**
	 * This construct colomns in point table.
	 *
	 * @name get_columns.
	 * @since      1.0.0
	 * @link https://www.cedcommerce.com/
	 */
	public function get_columns() {

		$columns = array(
			'cb'             => '<input type="checkbox" />',
			'user_name'      => __( 'User Name', 'ced-pointsrewards-tutorlms' ),
			'user_email'     => __( 'User Email', 'ced-pointsrewards-tutorlms' ),
			'user_points'    => __( 'Total Points', 'ced-pointsrewards-tutorlms' ),
			'sign'           => __( 'Choose +/-', 'ced-pointsrewards-tutorlms' ),
			'add_sub_points' => __( 'Enter Points', 'ced-pointsrewards-tutorlms' ),
			'reason'         => __( 'Enter Remark', 'ced-pointsrewards-tutorlms' ),
			'details'        => __( 'Action', 'ced-pointsrewards-tutorlms' ),

		);
		return $columns;
	}

	/**
	 * This show points table list.
	 *
	 * @name column_default.
	 * @since      1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param array  $item  array of the items.
	 * @param string $column_name name of the colmn.
	 */
	public function column_default( $item, $column_name ) {

		switch ( $column_name ) {

			case 'user_name':
				$actions = array(
					'view_point_log' => '<a href="' . CED_TUTORLMS_HOME_URL . 'admin.php?page=ced_tutor_lms_points_rewards&tab=points-table&user_id=' . $item['id'] . '&action=view_point_log">' . __( 'View Point Log', 'ced-pointsrewards-tutorlms' ) . '</a>',

				);
				return $item[ $column_name ] . $this->row_actions( $actions );
			case 'user_email':
				return '<b>' . $item[ $column_name ] . '</b>';
			case 'user_points':
				return '<b>' . $item[ $column_name ] . '</b>';
			case 'sign':
				$html = '<select id="ced_tutorlms_sign' . $item['id'] . '" ><option value="+">+</option><option value="-">-</option></select>';
				return $html;
			case 'add_sub_points':
				$html = '<input class="ced_tutorlms_pr_width_seventyfive" type="number" min="0" id="add_sub_points' . $item['id'] . '" value="">';
				return $html;
			case 'reason':
				$html = '<input class="ced_tutorlms_pr_width_hundred" type="text" id="ced_tutorlms_remark' . $item['id'] . '" min="0" value="">';
				return $html;
			case 'details':
				return $this->view_html( $item['id'] );

			default:
				return false;
		}
	}

	/**
	 * This construct update button on points table.
	 *
	 * @name view_html.
	 * @since      1.0.0
	 * @link https://www.cedcommerce.com/
	 * @param int $user_id  user id of the user.
	 */
	public function view_html( $user_id ) {

		echo '<a  href="javascript:void(0)" class="wps_points_update button button-primary ced_tutorlms_save_changes_table" data-id="' . esc_html( $user_id ) . '">' . esc_html__( 'Update', 'ced-pointsrewards-tutorlms' ) . '</a>';

	}

	/**
	 * Perform admin bulk action setting for points table.
	 *
	 * @name process_bulk_action.
	 * @link https://www.cedcommerce.com/
	 */
	public function process_bulk_action() {

		if ( 'bulk-delete' === $this->current_action() ) {
			if ( isset( $_POST['points-log'] ) ) {
				$wps_membership_nonce = sanitize_text_field( wp_unslash( $_POST['points-log'] ) );
				if ( wp_verify_nonce( $wps_membership_nonce, 'points-log' ) ) {
					if ( isset( $_POST['mpr_points_ids'] ) && ! empty( $_POST['mpr_points_ids'] ) ) {
						$all_id = map_deep( wp_unslash( $_POST['mpr_points_ids'] ), 'sanitize_text_field' );
						foreach ( $all_id as $key => $value ) {
							delete_user_meta( $value, 'ced_tutorlms_pr_points' );
						}
					}
				}
			}
		}
		do_action( 'ced_tutorlms_process_bulk_reset_option', $this->current_action(), $_POST );

	}
	/**
	 * Returns an associative array containing the bulk action
	 *
	 * @name process_bulk_action.
	 * @since      1.0.0
	 * @return array
	 * @author cedcommerce<ticket@cedcommerce.com>
	 * @link https://www.cedcommerce.com/
	 */
	public function get_bulk_actions() {
		$actions = array(
			'bulk-delete' => __( 'Delete', 'ced-pointsrewards-tutorlms' ),
		);
		return apply_filters( 'ced_tutorlms_points_log_bulk_option', $actions );
	}

	/**
	 * Returns an associative array containing the bulk action for sorting.
	 *
	 * @name get_sortable_columns.
	 * @since      1.0.0
	 * @return array
	 * @author cedcommerce<ticket@cedcommerce.com>
	 * @link https://www.cedcommerce.com/
	 */
	public function get_sortable_columns() {
		$sortable_columns = array(
			'user_name'   => array( 'user_name', false ),
			'user_email'  => array( 'user_email', false ),
			'user_points' => array( 'user_points', false ),
		);
		return $sortable_columns;
	}

	/**
	 * Prepare items for sorting.
	 *
	 * @name prepare_items.
	 * @since      1.0.0
	 * @author cedcommerce<ticket@cedcommerce.com>
	 * @link https://www.cedcommerce.com/
	 */
	public function prepare_items() {
		$per_page              = 10;
		$columns               = $this->get_columns();
		$hidden                = array();
		$sortable              = $this->get_sortable_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );
		$this->process_bulk_action();
		$current_page = $this->get_pagenum();

		$this->example_data = $this->get_users_points( $current_page, $per_page );
		$data               = $this->example_data;

		usort( $data, array( $this, 'ced_tutorlms_usort_reorder' ) );

		$total_items = $this->wps_total_count;
		$this->items  = $data;
		$this->set_pagination_args(
			array(
				'total_items' => $total_items,
				'per_page'    => $per_page,
				'total_pages' => ceil( $total_items / $per_page ),
			)
		);

	}

	/**
	 * Return sorted associative array.
	 *
	 * @name ced_tutorlms_usort_reorder.
	 * @since      1.0.0
	 * @return array
	 * @author cedcommerce<ticket@cedcommerce.com>
	 * @link https://www.cedcommerce.com/
	 * @param array $cloumna column of the points.
	 * @param array $cloumnb column of the points.
	 */
	public function ced_tutorlms_usort_reorder( $cloumna, $cloumnb ) {
		$orderby = ( ! empty( $_REQUEST['orderby'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['orderby'] ) ) : 'id';
		$order   = ( ! empty( $_REQUEST['order'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['order'] ) ) : 'desc';
		if ( is_numeric( $cloumna[ $orderby ] ) && is_numeric( $cloumnb[ $orderby ] ) ) {
			if ( $cloumna[ $orderby ] == $cloumnb[ $orderby ] ) {
				return 0;
			} elseif ( $cloumna[ $orderby ] < $cloumnb[ $orderby ] ) {
				$result = -1;
				return ( 'asc' === $order ) ? $result : -$result;
			} elseif ( $cloumna[ $orderby ] > $cloumnb[ $orderby ] ) {
				$result = 1;
				return ( 'asc' === $order ) ? $result : -$result;
			}
		} else {
			$result = strcmp( $cloumna[ $orderby ], $cloumnb[ $orderby ] );
			return ( 'asc' === $order ) ? $result : -$result;
		}
	}

	/**
	 * THis function is used for the add the checkbox.
	 *
	 * @name column_cb.
	 * @since      1.0.0
	 * @return array
	 * @link https://www.cedcommerce.com/
	 * @param array $item array of the items.
	 */
	public function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="mpr_points_ids[]" value="%s" />',
			$item['id']
		);
	}

	/**
	 * This function gives points to user if he doesnot get points.
	 *
	 * @name get_users_points.
	 * @since      1.0.0
	 * @return array
	 * @link https://www.cedcommerce.com/
	 * @param int $current_page current page.
	 * @param int $per_page no of pages.
	 */
	public function get_users_points( $current_page, $per_page ) {
		$args['meta_query'] = array(
			'relation' => 'OR',
			array(
				'key'     => 'ced_tutorlms_pr_points',
				'compare' => 'EXISTS',
			),
			array(
				'key'     => 'ced_tutorlms_pr_points',
				'compare' => 'NOT EXISTS',

			),
		);
		$args['number'] = $per_page;
		$args['offset'] = ( $current_page - 1 ) * $per_page;
		if ( isset( $_REQUEST['s'] ) ) {
			$wps_request_search = sanitize_text_field( wp_unslash( $_REQUEST['s'] ) );
			$args['search']     = '*' . $wps_request_search . '*';
		}

		$user_data        = new WP_User_Query( $args );
		$total_count      = $user_data->get_total();
		$user_data        = $user_data->get_results();
		$points_data      = array();
		foreach ( $user_data as $key => $value ) {
			$poin = ! empty( get_user_meta( $value->ID, 'ced_tutorlms_pr_points', true ) ) ? get_user_meta( $value->ID, 'ced_tutorlms_pr_points', true ) : 0;
			$points_data[] = array(
				'id'          => $value->data->ID,
				'user_name'   => $value->data->user_nicename,
				'user_email'  => $value->data->user_email,
				'user_points' => $poin,
			);
		}
		$this->wps_total_count = $total_count;
		return $points_data;
	}
}

if ( isset( $_GET['action'] ) && isset( $_GET['user_id'] ) ) {
	if ( 'view_point_log' == $_GET['action'] ) {
		$user_id      = sanitize_text_field( wp_unslash( $_GET['user_id'] ) );
		$point_log    = get_user_meta( $user_id, 'ced_tutorlms_points_details', true );
		$total_points = get_user_meta( $user_id, 'ced_tutorlms_pr_points', true );
		?>
<h3 class="wp-heading-inline" id="ced_tutorlms_points_table_heading">
    <?php esc_html_e( 'Points Earned Table', 'ced-pointsrewards-tutorlms' ); ?></h3>
<?php
		if ( isset( $point_log ) && is_array( $point_log ) && null != $point_log ) {
			?>

<div class="ced_tutorlms_wrapper_div">
    <?php
					if ( array_key_exists( 'admin_points', $point_log ) ) {
						?>
    <div class="ced_tutorlms_slide_toggle">
        <p class="ced_tutorlms_view_log_notice ced_tutorlms_common_slider">
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
							$value['sign']   = isset( $value['sign'] ) ? $value['sign'] : '+/-';
							$value['reason'] = isset( $value['reason'] ) ? $value['reason'] : __( 'Updated By Admin', 'ced-pointsrewards-tutorlms' );
							?>
                <tr valign="top">
                    <td class="forminp forminp-text"><?php echo esc_html( $value['date'] ); ?></td>
                    <td class="forminp forminp-text">
                        <?php echo esc_html( $value['sign'] ) .' '. esc_html( $value['admin_points'] ); ?></td>
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
        <p class="ced_tutorlms_view_log_notice ced_tutorlms_common_slider">
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
                        <?php echo '+' . esc_html( $point_log['student_registration']['0']['student_registration'] ); ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <?php
				}
				if ( array_key_exists( 'course_enrollment_points', $point_log ) ) {
					?>
    <div class="ced_tutorlms_slide_toggle">
        <p class="ced_tutorlms_view_log_notice ced_tutorlms_common_slider">
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
                    <td class="forminp forminp-text"><?php echo '+' . esc_html( $value['course_enrollment_points'] ); ?>
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
        <p class="ced_tutorlms_view_log_notice ced_tutorlms_common_slider">
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
                    <td class="forminp forminp-text"><?php echo '+' . esc_html( $value['lesson_complete_points'] ); ?>
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
        <p class="ced_tutorlms_view_log_notice ced_tutorlms_common_slider">
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
                    <td class="forminp forminp-text"><?php echo '+' . esc_html( $value['quiz_points'] ); ?></td>
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
        <p class="ced_tutorlms_view_log_notice ced_tutorlms_common_slider">
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
                    <td class="forminp forminp-text"><?php echo '+' . esc_html( $value['assignment_submit_points'] ); ?>
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
        <p class="ced_tutorlms_view_log_notice ced_tutorlms_common_slider">
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
                    <td class="forminp forminp-text"><?php echo '+' . esc_html( $value['assignment_pass_points'] ); ?>
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
        <p class="ced_tutorlms_view_log_notice ced_tutorlms_common_slider">
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
                    <td class="forminp forminp-text"><?php echo '+' . esc_html( $value['student_review_points'] ); ?>
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
        <p class="ced_tutorlms_view_log_notice ced_tutorlms_common_slider">
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
                    <td class="forminp forminp-text">
                        <?php echo '+' . esc_html( $value['instructor_registration_points'] ); ?>
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
        <p class="ced_tutorlms_view_log_notice ced_tutorlms_common_slider">
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
                    <td class="forminp forminp-text">
                        <?php echo '+' . esc_html( $value['instructor_course_created_points'] ); ?>
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
        <p class="ced_tutorlms_view_log_notice ced_tutorlms_common_slider">
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
                    <td class="forminp forminp-text"><?php echo '+' . esc_html( $value['reference_details_points'] ); ?>
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
        <p class="ced_tutorlms_view_log_notice ced_tutorlms_common_slider">
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
                    <td class="forminp forminp-text"><?php echo '+' . esc_html( $value['course_complete_points'] ); ?>
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
        <p class="ced_tutorlms_view_log_notice ced_tutorlms_common_slider">
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
                    <td class="forminp forminp-text">
                        <?php echo '+' . esc_html( $value['student_daily_login_points'] ); ?>
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
        <p class="ced_tutorlms_view_log_notice ced_tutorlms_common_slider">
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
                    <td class="forminp forminp-text">
                        <?php echo '+' . esc_html( $value['student_birthday_points'] ); ?>
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
        <p class="ced_tutorlms_view_log_notice ced_tutorlms_common_slider">
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
                    <td class="forminp forminp-text">
                        <?php echo '+' . esc_html( $value['instructor_birthday_points'] ); ?>
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
        <p class="ced_tutorlms_view_log_notice ced_tutorlms_common_slider">
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
                    <td class="forminp forminp-text">
                        <?php echo '+' . esc_html( $value['instructor_daily_login_points'] ); ?>
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
        <p class="ced_tutorlms_view_log_notice ced_tutorlms_common_slider">
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
                    <td class="forminp forminp-text">
                        <?php echo '+' . esc_html( $value['instructor_total_students_points'] ); ?>
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
        <p class="ced_tutorlms_view_log_notice ced_tutorlms_common_slider">
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
                    <td class="forminp forminp-text">
                        <?php echo '+' . esc_html( $value['instructor_lesson_created_points'] ); ?>
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
        <p class="ced_tutorlms_view_log_notice ced_tutorlms_common_slider">
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
                    <td class="forminp forminp-text">
                        <?php echo '+' . esc_html( $value['student_login_frequency_points'] ); ?>
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
        <p class="ced_tutorlms_view_log_notice ced_tutorlms_common_slider">
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
                    <td class="forminp forminp-text">
                        <?php echo '+' . esc_html( $value['instructor_course_update_freq_points'] ); ?>
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
        <p class="ced_tutorlms_view_log_notice ced_tutorlms_common_slider">
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
                    <td class="forminp forminp-text">
                        <?php echo '-' . esc_html( $value['cart_subtotal_point'] ); ?>
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
} else {
	do_action( 'ced_tutorlms_add_additional_import_points' );
	?>
<h3 class="wp-heading-inline" id="ced_tutorlms_points_table_heading">
    <?php esc_html_e( 'Points Table', 'ced-pointsrewards-tutorlms' ); ?></h3>

<form method="post">
    <input type="hidden" name="page"
        value="<?php esc_html_e( 'points_log_list_table', 'ced-pointsrewards-tutorlms' ); ?>">
    <?php wp_nonce_field( 'points-log', 'points-log' ); ?>
    <?php
		$mylisttable = new CED_Points_Log_List_Table();
		$mylisttable->prepare_items();
		$mylisttable->search_box( __( 'Search Users', 'ced-pointsrewards-tutorlms' ), 'wps-wpr-user' );
		$mylisttable->display();
		?>
</form>
<?php
}
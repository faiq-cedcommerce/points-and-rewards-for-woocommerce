<?php
/**
 * Exit if accessed directly
 *
 * @since      1.0.0
 * @package    overview-settings
 * @subpackage ced-pointsrewards/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wps-overview__wrapper">
    <div class="wps-overview__banner">
        <!-- image -->
    </div>
    <div class="wps-overview__content">
        <div class="wps-overview__content-description">
            <h3><?php echo esc_html_e( 'What is Tutor LMS Points And Rewards? ', 'ced-pointsrewards-tutorlms' ); ?>
            </h3>
            <p>
                <?php
				esc_html_e(
					'A free and pro WordPress plugin for Tutor LMS to provide points to the students and the instructors based on different activities, and reward the students and instructors based on the achieved points with ranking, total points, and credits to purchase other courses.',
					'ced-pointsrewards-tutorlms'
				);
				?>
            </p>
            <h3><?php esc_html_e( 'As a Tutor LMS and store owner, you get to:', 'ced-pointsrewards-tutorlms' ); ?></h3>
            <ul class="wps-overview__features">
                <li><?php esc_html_e( 'Award points to students and instructors on the basis of the actions and performance to boost engagements', 'ced-pointsrewards-tutorlms' ); ?>
                </li>
                <li><?php esc_html_e( 'Rank students and instructors, and showcase them on the leaderboards', 'ced-pointsrewards-tutorlms' ); ?>
                </li>
                <li><?php esc_html_e( 'Inspire students to take courses, complete lessons, attempt quizzes, and do participate on other learning activities', 'ced-pointsrewards-tutorlms' ); ?>
                </li>
                <li><?php esc_html_e( 'Reward students and instructors with points that can be used as coupons on the eLearning sites', 'ced-pointsrewards-tutorlms' ); ?>
                </li>
                <li><?php esc_html_e( 'Award badges on the basis of earned points', 'ced-pointsrewards-tutorlms' ); ?>
                </li>
                
            </ul>
        </div>

    </div>
</div>
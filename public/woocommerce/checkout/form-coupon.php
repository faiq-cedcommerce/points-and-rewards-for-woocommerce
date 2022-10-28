<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}
?>
<div class="woocommerce-form-coupon-toggle">
	<?php wc_print_notice( apply_filters( 'woocommerce_checkout_coupon_message', __( 'Have a coupon?', 'ced-pointsrewards-tutorlms' ) . ' <a href="#" class="showcoupon">' . __( 'Click here to enter your code', 'ced-pointsrewards-tutorlms' ) . '</a>' ), 'notice' ); ?>
</div>
<!-- /*WPS CUSTOM CODE*/ -->
<div class="woocommerce-error ced_tutorlms_settings_display_none_notice" id="ced_tutorlms_cart_points_notice" >
	
</div>
<div class="woocommerce-message ced_tutorlms_settings_display_none_notice" id="ced_tutorlms_cart_points_success" >
	
</div>
<!-- /*END OF WPS CUSTOM CODE*/ -->
<form class="checkout_coupon woocommerce-form-coupon" method="post">

	<p><?php esc_html_e( 'If you have a coupon code, please apply it below.', 'ced-pointsrewards-tutorlms' ); ?></p>

	<p class="form-row form-row-first">
		<input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e( 'Coupon code', 'ced-pointsrewards-tutorlms' ); ?>" id="coupon_code" value="" />
	</p>

	<p class="form-row form-row-last">
		<button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'ced-pointsrewards-tutorlms' ); ?>"><?php esc_html_e( 'Apply coupon', 'ced-pointsrewards-tutorlms' ); ?></button>
	</p>

	<div class="clear"></div>
</form>
<?php
  $public_obj = new Ced_Pointsrewards_Tutorlms_Public( 'ced-pointsrewards-tutorlms', '1.0.0' );
  $public_obj->ced_tutorlms_display_apply_points_checkout();
?>

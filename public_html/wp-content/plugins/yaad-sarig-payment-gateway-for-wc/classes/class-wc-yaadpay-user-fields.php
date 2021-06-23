<?php

/**
 * Created by PhpStorm.
 * User: Nurit
 * Date: 01/11/2017
 * Time: 14:49
 */
class WC_yaadpay_user_fields{

	function __construct() {
		add_action( 'show_user_profile', array($this,'woocommerce_10bit_yaadpay_extra_user_profile_fields' ));
		add_action( 'edit_user_profile', array($this,'woocommerce_10bit_yaadpay_extra_user_profile_fields' ));
		add_action( 'personal_options_update', array($this,'woocommerce_10bit_yaadpay_save_extra_user_profile_fields' ));
		add_action( 'edit_user_profile_update', array($this,'woocommerce_10bit_yaadpay_save_extra_user_profile_fields' ));
	}

	function woocommerce_10bit_yaadpay_extra_user_profile_fields( $user ) {
		?>
		<h3><?php _e("Yaadpay profile information", WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN); ?></h3>
		<table class="form-table">
			<tr>
				<th><label for="yaadpay-token"><?php _e("Token" ,WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN); ?></label></th>
				<td>
					<input type="text" name="yaadpay-token" id="yaadpay-token" class="regular-text"
						   value="<?php echo esc_attr( $user->ID, get_user_meta( WC_Gateway_Yaadpay::YAADPAY_TOKEN_USER,true ) ); ?>" /><br />
					<span class="description"><?php _e("Yaadpay Token for future payments" ,WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="yaadpay-tmonth"><?php _e("Expiration Month" ,WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN); ?></label></th>
				<td>
					<input type="text" name="yaadpay-tmonth" id="yaadpay-tmonth" class="regular-text"
						   value="<?php echo esc_attr( get_the_author_meta( WC_Gateway_Yaadpay::YAADPAY_TMONTH_USER, $user->ID ) ); ?>" /><br />
				</td>
			</tr>
			<tr>
				<th><label for="yaadpay-tyear"><?php _e("Expiration Year" ,WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN); ?></label></th>
				<td>
					<input type="text" name="yaadpay-tyear" id="yaadpay-tyear" class="regular-text"
						   value="<?php echo esc_attr( get_the_author_meta( WC_Gateway_Yaadpay::YAADPAY_TYEAR_USER, $user->ID ) ); ?>" /><br />
				</td>
			</tr>
			<tr>
				<th><label for="yaadpay-last4digits"><?php _e("Card Number" ,WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN); ?></label></th>
				<td>
					<input type="text" name="yaadpay-last4digits" id="yaadpay-last4digits" class="regular-text"
						   value="<?php echo esc_attr( get_the_author_meta( WC_Gateway_Yaadpay::YAADPAY_CC_LAST4_USER, $user->ID ) ); ?>" /><br />
				</td>
			</tr>
		</table>
		<?php
	}


	function woocommerce_10bit_yaadpay_save_extra_user_profile_fields( $user_id ) {
		if ( current_user_can( 'edit_user', $user_id ) ) {
			update_user_meta( $user_id, WC_Gateway_Yaadpay::YAADPAY_TOKEN_USER, sanitize_textarea_field($_POST['yaadpay-token']) );
			update_user_meta( $user_id, WC_Gateway_Yaadpay::YAADPAY_TMONTH_USER, sanitize_text_field($_POST['yaadpay-expmonth']) );
			update_user_meta( $user_id, WC_Gateway_Yaadpay::YAADPAY_TYEAR_USER, sanitize_text_field($_POST['yaadpay-expyear']) );
			update_user_meta( $user_id, WC_Gateway_Yaadpay::YAADPAY_CC_LAST4_USER, sanitize_text_field($_POST['yaadpay-ccnumber']) );
		}
		return true;
	}
}



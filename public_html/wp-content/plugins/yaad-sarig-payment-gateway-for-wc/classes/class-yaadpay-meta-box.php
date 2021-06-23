<?php
use tb_infra_1_0_11\tb_wc_object as tb_wc_object;
use tb_infra_1_0_11\tb_wc_order as tb_wc_order;

final class  WC_Gateway_YaadPay_Metabox {

	function __construct () {
		add_action ( 'wp_ajax_yaadpay_token_pay', array( $this, 'yaadpay_token_pay_callback' ) );
		add_action ( 'wp_ajax_yaadpay_commit_trans', array( $this, 'yaadpay_commit_trans_callback' ) );
		add_action ( 'wp_ajax_yaadpay_get_token_data', array( $this, 'yaadpay_get_token_data_callback' ) );
		add_action ( 'wp_ajax_yaadpay_update_subscription_parent', array( $this, 'yaadpay_update_subscription_parent_callback' ) );
		//add_action( 'save_post',  array( $this, 'yaadpay_save_meta_box_data' ) );
		// add_action ( 'save_post_product', array( $this, 'yaadpay_product_meta_box_save' ) );
		add_action ( 'add_meta_boxes', array( $this, 'yaadpay_add_meta_box' ) );
	}


	public function yaadpay_add_meta_box($screen) {
		global $post;

		if ($screen !== 'shop_order') {
			return;
		}

		$order = wc_get_order($post->ID);
		$allGateways = WC_Payment_Gateways::instance()->payment_gateways();
		$gateway = $allGateways[$order->get_payment_method()] ?? false;
		if (!$gateway || $order->get_payment_method() !== $gateway->id) {
			return;
		}

		if ($gateway->get_option('yaad_invoices') === 'yes') {
			add_meta_box(
				'yaadpay_invoice',
				__ ( 'Yaadpay Invoice', WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN ),
				array( $this, 'yaad_invoice_meta_box_callback' ),
				$screen,
				'side',
				'default',
				['gateway' => $gateway]
			);
		}

		add_meta_box(
			'yaadpay_sectionid',
			__ ( 'Yaadpay Transaction information', '10bit-woocommerce-gateway-yaadpay' ),
			array( $this, 'yaadpay_order_meta_box_callback' ),
			$screen
		);
	}

	public function yaad_invoice_meta_box_callback(\WP_Post $post, $metabox) {
		$order = wc_get_order($post->ID);
		$invoiceLink = $order->get_meta('yaad_invoice_link');
		if (!$invoiceLink && !$order->has_status('on-hold')) {
			$invoiceLink = $metabox['args']['gateway']->get_invoice_link($order);
		}

		if ($invoiceLink) {
			printf(
				'<a class="button" href="%s" target="_blank">%s</a>',
				esc_url($invoiceLink),
				__('Download Invoice', WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN)
			);
		} else {
			printf(
				'<div class="button disabled">%s</div>',
				__('Download Invoice', WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN)
			);
		}
	}

	function yaadpay_get_token_data_callback () {
		WC_Gateway_Yaadpay::log ( '[INFO]: yaadpay_get_token_data_callback' );
		$order_id       = sanitize_text_field($_POST['order_id']);
		$transaction_id = sanitize_text_field($_POST['transaction_id']);
		WC_Gateway_Yaadpay::log ( '[INFO]: order id: ' . $order_id . " transaction id: " . $transaction_id );
		$gateways              = WC_Payment_Gateways::instance ();
		$available_gateways    = $gateways->get_available_payment_gateways ();
		$yaadpay               = $available_gateways['yaadpay'];
//		$no_method = method_exists($yaadpay,"request_token_data_by_trans_id")?"method is there":"no method";
		$got_a_token_from_yaad = $yaadpay->request_token_data_by_trans_id ( $transaction_id, $order_id );
		$what_to_reply         = $got_a_token_from_yaad ? 'success' : __ ( 'an error occurred, please contact Yaad Sarig', '10bit-woocommerce-gateway-yaadpay' );
		echo $what_to_reply;
		WC_Gateway_Yaadpay::log ( '[INFO]: reply: ' . $what_to_reply );
		wp_die ();
	}

	function yaadpay_update_subscription_parent_callback(){
		WC_Gateway_Yaadpay::log ( '[INFO]: yaadpay_update_subscription_parent_callback' );
		$order_id       = sanitize_text_field($_POST['order_id']);
		WC_Gateway_Yaadpay::log ( '[INFO]: order id: ' . $order_id);
		$gateways              = WC_Payment_Gateways::instance ();
		$available_gateways    = $gateways->get_available_payment_gateways ();
		$yaadpay               = $available_gateways['yaadpay'];
		$updated_ok = $yaadpay->update_subscription_parent_order( $order_id );
		$what_to_reply         = $updated_ok ? 'success' : __( 'Failed to update subscription parent order, please contact 10bit', WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN );
		echo $what_to_reply;
		WC_Gateway_Yaadpay::log ( '[INFO]: reply: ' . $what_to_reply );
		wp_die ();
	}

	function yaadpay_token_pay_callback () {
		WC_Gateway_Yaadpay::log ( '[INFO]: ' . __METHOD__ );
		$orderId = (int)sanitize_text_field($_POST['orderId']);

		$gateways           = WC_Payment_Gateways::instance ();
		$available_gateways = $gateways->get_available_payment_gateways ();
		$yaadpay            = $available_gateways['yaadpay'];

		$transaction_id = sanitize_text_field($_POST['transaction_id']);
		$token_code = sanitize_textarea_field($_POST['YaadpayTK']);
		$token_epiration_month = sanitize_text_field($_POST['expmonth']);
		$token_expiration_year = sanitize_text_field($_POST['expyear']);

		$resp = $yaadpay->process_token_payment($orderId, $transaction_id, $token_code, $token_epiration_month, $token_expiration_year);

		WC_Gateway_Yaadpay::log('resp: ' . print_r($resp,true) . ' type: ' .gettype($resp));
		$payment_error = '';
		switch ( $resp ) {
			case '0' :
				add_post_meta ( $orderId, 'Payment Gateway', 'Yaadpay' );
				$order   = tb_wc_object::factory ( "order", $orderId );
				$order->add_order_note ( __ ( 'Yaadpay payment completed', '10bit-woocommerce-gateway-yaadpay' ) );
				$order->payment_complete ();
				echo 'success';
				break;
			default :
				$payment_error .= __ ( 'Paymnet failure, please try again or contact the store administrator', '10bit-woocommerce-gateway-yaadpay' );
				$payment_error .= print_r ( $resp, true );
				echo $payment_error;
				break;
		}

		wp_die ();
	}

	function yaadpay_commit_trans_callback () {
		WC_Gateway_Yaadpay::log ( '[INFO]: ' . __METHOD__ );
		$orderId = (int)sanitize_text_field($_POST['orderId']);

		$gateways           = WC_Payment_Gateways::instance ();
		$available_gateways = $gateways->get_available_payment_gateways ();
		$yaadpay            = $available_gateways['yaadpay'];

		$transaction_id = sanitize_text_field($_POST['transaction_id']);
		$resp = $yaadpay->process_postpone_payment($orderId, $transaction_id);

		WC_Gateway_Yaadpay::log('resp: ' . print_r($resp,true) . ' type: ' .gettype($resp));
		$payment_error = '';
		switch ( $resp ) {
			case '0' :
				add_post_meta ( $orderId, 'Payment Gateway', 'Yaadpay' );
				$order   = tb_wc_object::factory ( "order", $orderId );
				$order->add_order_note ( __ ( 'Yaadpay payment completed', '10bit-woocommerce-gateway-yaadpay' ) );
				$order->payment_complete ();
				echo 'success';
				break;
			default :
				$payment_error .= __ ( 'Paymnet failure, please try again or contact the store administrator', '10bit-woocommerce-gateway-yaadpay' );
				$payment_error .= print_r ( $resp, true );
				echo $payment_error;
				break;
		}

		wp_die ();
	}

	/**
	 * Prints the box content.
	 *
	 * @param WP_Post $post The object for the current post/page.
	 */
	function yaadpay_order_meta_box_callback ( WP_Post $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field ( 'yaadpay_meta_box', 'yaadpay_meta_box_nonce' );
		$order     = tb_wc_object::factory ( "order", get_the_ID () );
		$YaadpayTK = get_post_meta ( $order->get_id (), '_yaadpay_token', true );
		$YaadPostpone = get_post_meta ( $order->get_id (), '_yaad_postpone', true );

		if ( empty( $YaadpayTK ) == false ) { // J5
			$this->build_token_payment_form ( $order, $YaadpayTK );
		} else if ($YaadPostpone) { // Postpone
			$this->build_commit_trans_form( $order );
		} else { // Direct
			$this->build_missing_token_form( $order);
		}

		if (function_exists('wcs_order_contains_renewal')){
			if(wcs_order_contains_renewal($order->get_id())) {
				$this->update_subscription_parent_order($order);
			}
		}

	}

	public static function WC_Gateway_yaadpay_metabox_init () {
		new WC_Gateway_yaadpay_metabox;

	}

	/**
	 * @param string $YaadpayTK
	 * @param tb_wc_order $order
	 */
	private function build_token_payment_form ( tb_wc_order $order, $YaadpayTK ) {
		$expmonth       = get_post_meta ( $order->get_id (), '_yaadpay_tokef_month', true );
		$expyear        = get_post_meta ( $order->get_id (), '_yaadpay_tokef_year', true );
		$transaction_id = get_post_meta ( $order->get_id (), '_yaadpay_id', true );
		echo "<script>
				function yaadpay_pay(button) {
					button.disabled      = true;
					var loader           = document.getElementById('chargeLoader');
					loader.style.display = 'block';

					var data = {
						'action':         'yaadpay_token_pay',
						'orderId':        '" . $order->get_id () . "',
						'YaadpayTK':      '" . $YaadpayTK . "',
						'expmonth':       '" . $expmonth . "',
						'expyear':        '" . $expyear . "',
						'transaction_id': '" . $transaction_id . "',
					};
					jQuery.post(ajaxurl, data, function(response) {
						if (response=='success'){
							location.reload();
						}
						else{
							alert(response);
							loader.style.display = 'none';
							button.disabled 	 = false;
						}
					});

			};</script>";

		echo '<div>';
		_e ( 'Transaction Type :', WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN );
		_e ( 'Token ', WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN );
		echo '</div>';

		echo '<div>';
		echo '<label for="yaadpay_token">';
		_e ( 'Transaction Id :', WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN );
		echo '</label> ';
		echo esc_attr ( $transaction_id );
		echo '</div>';
		echo '<div>';
		echo '<label for="yaadpay_token">';
		_e ( 'Yaadpay Token :', WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN );
		echo '</label> ';
		echo esc_attr ( $YaadpayTK );
		echo '</div>';
		echo '<div>';
		echo '<label for="yaadpay_expmonth">';
		_e ( 'Card expiration month : ', WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN );
		echo '</label> ';
		echo esc_attr ( $expmonth );
		echo '</div>';
		echo '<div>';
		echo '<label for="yaadpay_expyear">';
		_e ( 'Card expiration year :', WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN );
		echo '</label> ';
		echo esc_attr ( $expyear );
		echo '</div>';
		if ( $order->get_status () != "on-hold" ) {
			return;
		}
		echo '<div>';
		$pay_btn_str = __("Charge",WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN);
		echo '<button type="button" class="button" onclick="yaadpay_pay(this);">'. $pay_btn_str .'</button>';
		echo '</div>';
		echo '<div id="chargeLoader" style="text-align: center; display:none; margin-top: -100px;">
				<h3>ברגעים אלה מתבצעת עסקה, אנא המתינו ...</h3>
				<div style="border: 5px solid #f3f3f3;border-top-color: rgb(243, 243, 243);border-top-style: solid;	border-top-width: 5px;-webkit-animation: spin 1s linear infinite;animation: spin 1s linear infinite;border-top: 5px solid #555;border-radius: 50%;width: 50px;height: 50px;margin: auto;"></div>
			  </div>';
	}

/**
	 * @param string $YaadpayTK
	 * @param tb_wc_order $order
	 * 800 - postpone
	 */
	private function build_commit_trans_form ( tb_wc_order $order ) {
		$transaction_id = get_post_meta ( $order->get_id (), '_yaadpay_id', true );
		$transaction_amount = get_post_meta ( $order->get_id (), '_yaadpay_amount', true );
		echo "<script>
				function yaadpay_commit_trans(button) {
					button.disabled = true;

					var data = {
						'action': 'yaadpay_commit_trans',
						'orderId':'" . $order->get_id () . "',
						'transaction_id':'" . $transaction_id . "',

					};
					jQuery.post(ajaxurl, data, function(response) {
						if (response=='success'){
							location.reload();
						}
						else{
							alert(response);
							button.disabled = false;
						}
					});

			};</script>";

		echo '<div>';
		_e ( 'Transaction Type :', WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN );
		_e ( 'Postpone', WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN );
		echo '</div>';

		echo '<div>';
		echo '<label for="yaadpay_token">';
		_e ( 'Transaction Id :', WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN );
		echo '</label> ';
		echo esc_attr ( $transaction_id );
		echo '</div>';

		echo '<div>';
		echo '<label for="yaadpay_amount">';
		_e ( 'Amount :', WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN );
		echo '</label> ';
		echo esc_attr ( $transaction_amount );
		echo '</div>';

		echo '<div>';
		echo '<label for="yaad_helper"><strong>';
		_e ( "Do not change the order's total amount", WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN );
		echo '</strong></label> ';
		echo '</div>';

		if ( $order->get_status () != "on-hold" ) {
			return;
		}
		echo '<div>';
		$pay_btn_str = __("Charge",WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN);
		echo '<button type="button" class="button" onclick="yaadpay_commit_trans(this);">'. $pay_btn_str .'</button>';
		echo '</div>';
	}



	private function build_missing_token_form( tb_wc_order $order ) {
		$arg=get_post_meta($order->get_id(),'yaad_credit_card_payment',true);
		$args_array= array();
		parse_str($arg,$args_array);
		if ( empty( $args_array['Id']) ) {		return;		}

		WC_Gateway_Yaadpay::log ( '[INFO]: CCode : ' . $args_array['CCode'] . ' (should NOT be 800)' );

		echo '<div>';
		if ( $args_array['CCode']==800){
			return ;//_e( 'Postponed', WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN );
		}else{
			_e( 'Transaction Type : ', WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN );
			_e( 'Regular payment', WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN );
		}

		$token_btn_str = __("Get Token",WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN);

		echo '</div>';

		echo '<div>';
		echo '<label for="yaadpay_id">';
		_e( 'Transaction Id :', WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN );
		echo '</label> ';
		$trans_id = esc_attr( $args_array['Id'] );
		echo $trans_id;
		echo '</div>';
		echo '<div>';
		echo '<button type="button" class="button" onclick="yaadpay_get_token();">'. $token_btn_str .'</button>';
		echo '</div>';


		echo '<script>
			function yaadpay_get_token(p1, p2) {
				var yaadpay_id = jQuery("#yaadpay_id").val();
		        var data = {
            		"action" : "yaadpay_get_token_data",
            		"transaction_id" : "'.$trans_id.'",
            		"order_id": "'.$order->get_id().'"
        		};
				jQuery.post(ajaxurl, data, function(response) {
					console.log(response);
					if (response=="success"){
						location.reload();
					}
					else{
						alert(response);
					}
				});
			};
			</script>';
	}

	private function update_subscription_parent_order( tb_wc_order $order ) {
		$btn_str = __("Update Parent Oder",WC_Gateway_Yaadpay::YAADPAY_TEXTDOMAIN);
		echo '<div><br>';
		echo '<button type="button" class="button" onclick="yaadpay_update_subscription_parent_order();">'. $btn_str .'</button>';
		echo '</div>';
		echo '<script>
			function yaadpay_update_subscription_parent_order(p1, p2) {
		        var data = {
            		"action" : "yaadpay_update_subscription_parent",
            		"order_id": "'.$order->get_id().'"
        		};
				jQuery.post(ajaxurl, data, function(response) {
					console.log(response);
					if (response=="success"){
						location.reload();
					}
					else{
						alert(response);
					}
				});
			};
			</script>';
	}

}




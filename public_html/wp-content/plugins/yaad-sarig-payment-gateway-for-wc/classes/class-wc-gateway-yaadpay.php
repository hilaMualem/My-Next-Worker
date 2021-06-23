<?php

use tb_infra_1_0_11\tb_wc_object as tb_wc_object;
//use tb_infra_1_0_11\tb_wc_product as tb_wc_product;
use tb_infra_1_0_11\tb_wc_order as tb_wc_order;
use tb_infra_1_0_11\tb_wc_item as tb_wc_item;

final class WC_Gateway_Yaadpay extends WC_Payment_Gateway
{

	//private $_yaadpay_payment_params;

	static $yaad_debug;
	static $yaad_extra_debug;
	static $logger;
	const DEMO_VERSION = ' - <b>Demo Version</b> !';
	private $license_type;
	const YAADPAY_TEXTDOMAIN = '10bit-woocommerce-gateway-yaadpay';
	const YAADPAY_TOKEN = '_yaadpay_token';
	const YAADPAY_ID = '_yaadpay_id';
	const YAADPAY_TOKEF_YEAR = '_yaadpay_tokef_year';
	const YAADPAY_TOKEF_MONTH = '_yaadpay_tokef_month';
	const YAADPAY_TEST_TERM_META = "testTermNo";
	const YAADPAY_CC_PAYMENT_HISTORY = 'yaad_credit_card_payment_history';
	const YAADPAY_CC_PAYMENT = 'yaad_credit_card_payment';
	const YAADPAY_TOKEN_PAYMENT = 'yaad_token_payment';
	const YAADPAY_POSTPONE_PAYMENT = 'yaad_postpone_payment';
	const YAADPAY_QUERY_STRING = 'yaad_query_string';
	const YAADPAY_PAYMENT_ORDER_ID = 'yaad_payment_order_id';
	const YAADPAY_TYEAR_USER = 'yaadpay_tyear';
	const YAADPAY_TMONTH_USER = 'yaadpay_tmonth';
	const YAADPAY_TOKEN_USER = 'yaadpay_token';
	const YAADPAY_CC_LAST4_USER = 'yaadpay_last4digits';
	const YAADPAY_ID_USER = 'yaadpay_user_id';
	private $yaad_payment_type;
	private $yaad_subscriptions;
	const YAAD_J5 = 'J5';
	const YAAD_POSTPONE = 'Postpone';
	public $yaad_PassP;
	const SUBSCRIPTION = 'Subscription';

	const WCML_STRINGS_CONTEXT = 'admin_texts_woocommerce_gateways';

	/**
	 * @return mixed
	 */
	public function getNotifyUrl()
	{
		return $this->notify_url;
	}

	/**
	 * @return mixed
	 */
	public function getYaadTermNo()
	{
		return $this->yaad_termNo;
	}

	/**
	 * @return boolean
	 */
	public function isIframe()
	{
		return $this->iframe;
	}

	/**
	 * @return string
	 */
	public function getYaadWPLMSHK()
	{
		return $this->yaad_WPLMS_HK;
	}

	/**
	 * @return string
	 */
	public function getYaadInvoices()
	{
		return $this->yaad_invoices;
	}

	/**
	 * @return string
	 */
	public function getYaadTieredPayments()
	{
		return $this->yaad_tiered_payments;
	}

	/**
	 * @return string
	 */
	public function getYaadLanguage()
	{
		return $this->yaad_language;
	}


	/**
	 * @return string
	 */
	public function getDemoText()
	{
		return $this->demo_text;
	}

	/**
	 * @return mixed
	 */
	public function getLicense()
	{
		return $this->license;
	}

	/**
	 * @return mixed
	 */
	public function getYaadSignature()
	{
		return $this->yaad_signature;
	}


	/**
	 * @return boolean
	 */
	public function isDemo()
	{
		return $this->demo;
	}

	/**
	 * @return string
	 */
	public function getIframeHeight()
	{
		return $this->iframe_height;
	}

	/**
	 * @return string
	 */
	public function getIframeWidth()
	{
		return $this->iframe_width;
	}


	var $notify_url;


	private $yaad_termNo;
	private $iframe;
	private $yaad_WPLMS_HK;
	private $yaad_invoices;
	private $yaad_tiered_payments;
	private $maxPayments;
	private $yaad_language;
	private $demo_text;
	private $license;
	private $yaad_signature;
	private $yaad_allow_saved_cc;
	private $demo;
	private $iframe_height;
	private $iframe_width;

	const TEST_TERM = '0010070211';
	const TEST_PassP = '1234';
	private $use_test_term;

	private $current_language;

	function __construct()
	{

		$this->id = "yaadpay";
		//$this->icon – If you want to show an image next to the gateway’s name on the frontend, enter a URL to an image.
		$this->has_fields = false;
		$this->method_title = __('Yaadpay', self::YAADPAY_TEXTDOMAIN);
		$this->method_description = __('Allow payments using yaadpay', self::YAADPAY_TEXTDOMAIN);


		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();

		self::$yaad_debug = $this->get_is_debug();
		self::$yaad_extra_debug = $this->get_is_extra_debug();
		self::$logger = new WC_Logger();


		$this->license = $this->get_license();
		$this->license_type = $this->get_license_level($this->license, self::YAADPAY_TEXTDOMAIN);
		$this->define_supported_functionality($this->license_type);
		$this->define_demo_text();
		$this->yaad_termNo = $this->get_terminal_number();
		$this->yaad_signature = $this->get_signature();


		$this->title = __($this->get_option('title'), self::YAADPAY_TEXTDOMAIN);
		$this->iframe = $this->get_option('yaad_iframe') == 'yes';
		$this->iframe_width = $this->get_option('yaad_iframe_width');
		$this->iframe_height = $this->get_option('yaad_iframe_height');
		$this->yaad_template = $this->get_option('yaad_template');
		$this->description = $this->get_option('description');
		$this->yaad_language = $this->get_option('yaad_language');
		$this->yaad_currency = $this->get_option('yaad_currency');
		$this->yaad_invoices = $this->get_option('yaad_invoices');
		$this->yaad_payment_type = $this->get_option('yaad_payment_type');
		$this->yaad_subscriptions = $this->get_option('yaad_subscriptions');
		$this->yaad_allow_saved_cc = $this->get_option('yaad_allow_saved_cc') == 'yes';
		$this->yaad_PassP = $this->get_option('yaad_PassP');

		$this->maxPayments = $this->get_option('yaad_maxPayments');
		$this->yaad_tiered_payments = $this->get_option('yaad_tiered_payments');
		$this->yaad_WPLMS_HK = $this->get_option('yaad_WPLMS_HK');
		$this->use_test_term = $this->get_option('yaad_TestTerm') == 'yes';

		// $is_ssl = get_option('woocommerce_force_ssl_checkout') == 'yes'; // Use this line and comment the line below if site doesn't support HTTPS
		$is_ssl = true;
		$this->build_notify_url($is_ssl);

		//$this->_yaadpay_payment_params = new Yaadpay_Payment_Params();

		// Add hooks
		add_action('woocommerce_subscriptions_changed_failing_payment_method_' . $this->id, array($this, 'tb_failing_payment_method'), 10, 2);
		add_action('woocommerce_scheduled_subscription_payment_' . $this->id, array($this, 'scheduled_subscription_payment'), 10, 2);
		add_action('woocommerce_receipt_' . $this->id, array($this, 'receipt_page'));
		add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
		// Payment listener/API hook
		add_action('woocommerce_api_wc_gateway_' . $this->id, array($this, 'yaadpay_callback_handler'));
		add_action('cancelled_subscription_' . $this->id, array($this, 'yaadpay_cancel_subscription'));
		if ($this->iframe) {
			add_action('woocommerce_thankyou', 'yaad_break_out_of_frames');
			add_action('woocommerce_before_checkout_form', 'yaad_break_out_of_frames');
			self::extra_log("[INFO]: adding break out of frames");
		}

		if ($this->yaad_subscriptions != 'no' && !function_exists('wcs_is_subscription')) {
			self::log('[INFO]: Missing plugin WOOCOMMERCE SUBSCRIPTIONS, will process as if set to: no');
			$this->yaad_subscriptions = 'no';
		}

		add_action('woocommerce_checkout_order_processed', [$this, 'yaad_update_query_string']); // user  CREATE order

		add_action('woocommerce_thankyou', [$this, 'yaad_update_query_string']); 				 // user finish order (for offline payments)
		add_action('woocommerce_after_pay_action', [$this, 'yaad_update_query_string']); 		 // user finish order (for offline payments)

		add_action('woocommerce_new_order', [$this, 'yaad_update_query_string']); 				 // admin CREATE order
		add_action('woocommerce_process_shop_order_meta', [$this, 'yaad_update_query_string']);  // admin UPDATE order

		// WPML Support
		$this->yaad_wcml_get_current_language();
		add_filter('wcml_gateway_text_keys_to_translate', [$this, 'yaad_wcml_translated_keys']);
	}

	public function is_trial($order)
	{
		return $order->get_total() === 0 || (function_exists('wcs_is_subscription') ? wcs_is_subscription($order->get_id()) : false);
	}

	public function yaad_update_query_string($order_id)
	{
		$order = tb_wc_object::factory(tb_wc_object::ORDER, $order_id);
		// Removed to support offline payments - need to validate it doesn't break anything
		// if ($order->get_payment_method() != $this->id) {
		// 	return;
		// }

		$args = $this->collect_yaad_args($order, $this->is_trial($order));
		ksort($args);
		$args_string = '';
		foreach($args as $key => $value) {
			$args_string .= "$key=" . rawurlencode($value) . "&";
		}
		$secret = $this->get_signature();
		unset($args['ACTION']);
		unset($args['User']);
		unset($args['Pass']);
		unset($args['isHash']);
		unset($args['PassP']);
		unset($args['KEY']);
		unset($args['What']);
		$args['action'] = 'pay';
		ksort($args);
		$args_string = '';
		foreach($args as $key => $value) {
			$args_string .= "$key=" . rawurlencode($value) . "&";
		}
		$args_string  = chop($args_string, "&");
		$signature 	  = hash_hmac('sha256', $args_string, $secret);
		$args_string .= "&signature=$signature";
		self::$logger->add(self::YAADPAY_TEXTDOMAIN, '[INFO]: APISign - self signed args: ' . $args_string);
		$order->get_WC_order()->update_meta_data(self::YAADPAY_QUERY_STRING, $args_string ?? '');
		$order->get_WC_order()->save();

		/* ------------------------------API Sign - Deprecated--------------------------------------
		$order = tb_wc_object::factory(tb_wc_object::ORDER, $order_id);
		if ($order->get_payment_method() != $this->id) {
			return;
		}

		$args = $this->collect_yaad_args($order, $this->is_trial($order));
		$args['action'] = 'APISign';
		$args['What'] = 'SIGN';
		$args['KEY'] = $this->get_signature();
		$response = wp_remote_get(add_query_arg($args, $this->get_url()), array('timeout' => 60));
		if (is_wp_error($response)) {
			self::log(sprintf('[ERROR]: %s', $response->get_error_message()));
			throw new Exception(__('Unable to proceed with checkout.', self::YAADPAY_TEXTDOMAIN));
		}

		$order->get_WC_order()->update_meta_data(self::YAADPAY_QUERY_STRING, $response['body'] ?? '');
		$order->get_WC_order()->save();
		-------------------------------------------------------------------------------------------- */
	}

	public function get_option($key, $empty_value = null)
	{
		$option = parent::get_option($key, $empty_value);

		if (function_exists('wpml_translate_single_string_filter')) {
			$option = wpml_translate_single_string_filter(
				$option,
				self::WCML_STRINGS_CONTEXT,
				$this->id . '_gateway_' . $key,
				$this->current_language
			);
		}

		return $option;
	}

	public function yaad_wcml_get_current_language()
	{
		global $sitepress;

		$this->current_language = is_callable([
			$sitepress, 'get_current_language'
		]) ? $sitepress->get_current_language() : '';

		if ('all' === $this->current_language) {
			$this->current_language = $sitepress->get_default_language();
		}
	}

	public function yaad_wcml_translated_keys($text_keys)
	{
		if (isset($_REQUEST['section']) && $this->id === $_REQUEST['section']) {
			$text_keys = array_keys($this->form_fields);
		}
		return $text_keys;
	}

	public function tb_failing_payment_method($wc_original_order, $wc_new_renewal_order)
	{
		$original_order = tb_wc_object::factory(tb_wc_object::ORDER, $wc_original_order);
		$new_renewal_order = tb_wc_object::factory(tb_wc_object::ORDER, $wc_new_renewal_order);
		$this->update_parent_meta($new_renewal_order->get_id(), $original_order->get_id());
	}


	/**
	 * @param int $new_order_id
	 * @return bool
	 *
	 */
	public function update_subscription_parent_order($new_order_id)
	{

		if (!function_exists('wcs_is_subscription')) {
			return false;
		}

		if (wcs_is_subscription($new_order_id)) { //"change payment" scenario
			$subscription = wcs_get_subscription($new_order_id);
			self::$logger->add(self::YAADPAY_TEXTDOMAIN, 'order id: ' . $new_order_id . ' is actually the subscription');
		} else { //"create pending renewal order" scenario
			$subscriptions = (wcs_order_contains_renewal($new_order_id)) ?
				wcs_get_subscriptions_for_renewal_order($new_order_id) :
				wcs_get_subscriptions_for_order($new_order_id);

			if (empty($subscriptions)) {
				self::$logger->add(self::YAADPAY_TEXTDOMAIN, '[INFO]: no subscription associated with order id: ' . $new_order_id);
				return false;
			}
			$subscription = reset($subscriptions);
		}

		$parent_order_wc = $subscription->order;
		$parent_order = tb_wc_object::factory(tb_wc_object::ORDER, $parent_order_wc);
		$parent_order_id = $parent_order->get_id();

		self::$logger->add(self::YAADPAY_TEXTDOMAIN, 'id: ' . $new_order_id . ' parent id: ' . $parent_order_id);

		if ($parent_order_id != $new_order_id) {
			self::$logger->add(self::YAADPAY_TEXTDOMAIN, '[INFO]: updating payment data in subscription parent-order');
			$this->update_parent_meta($new_order_id, $parent_order_id);
		}
		return true;
	}

	private function update_parent_meta($new_order_id, $parent_order_id)
	{
		$yaadpay_token = get_post_meta($new_order_id, self::YAADPAY_TOKEN, true);
		$yaadpay_id = get_post_meta($new_order_id, self::YAADPAY_ID, true);
		$yaadpay_tokef_year = get_post_meta($new_order_id, self::YAADPAY_TOKEF_YEAR, true);
		$yaadpay_tokef_month = get_post_meta($new_order_id, self::YAADPAY_TOKEF_MONTH, true);
		$orig_yaad_credit_card_payment = get_post_meta($parent_order_id, self::YAADPAY_CC_PAYMENT, true);
		$renewal_yaad_credit_card_payment = get_post_meta($new_order_id, self::YAADPAY_CC_PAYMENT, true);

		self::$logger->add(self::YAADPAY_TEXTDOMAIN, '[INFO]: parent order# : ' . $parent_order_id);
		self::$logger->add(self::YAADPAY_TEXTDOMAIN, '[INFO]: payed order# : ' . $new_order_id);
		self::$logger->add(self::YAADPAY_TEXTDOMAIN, '[INFO]: yaad query data : ' . $renewal_yaad_credit_card_payment);
		self::$logger->add(self::YAADPAY_TEXTDOMAIN, '[INFO]: new token: ' . $yaadpay_token);
		self::$logger->add(self::YAADPAY_TEXTDOMAIN, '[INFO]: new id: ' . $yaadpay_id);
		self::$logger->add(self::YAADPAY_TEXTDOMAIN, '[INFO]: new exp year: ' . $yaadpay_tokef_year);
		self::$logger->add(self::YAADPAY_TEXTDOMAIN, '[INFO]: new exp month: ' . $yaadpay_tokef_month);

		add_post_meta($parent_order_id, self::YAADPAY_CC_PAYMENT_HISTORY, $orig_yaad_credit_card_payment);
		update_post_meta($parent_order_id, self::YAADPAY_CC_PAYMENT, $renewal_yaad_credit_card_payment);

		delete_post_meta($parent_order_id, self::YAADPAY_TOKEN);
		update_post_meta($parent_order_id, self::YAADPAY_TOKEN, $yaadpay_token);

		delete_post_meta($parent_order_id, self::YAADPAY_ID);
		update_post_meta($parent_order_id, self::YAADPAY_ID, $yaadpay_id);

		delete_post_meta($parent_order_id, self::YAADPAY_TOKEF_YEAR);
		update_post_meta($parent_order_id, self::YAADPAY_TOKEF_YEAR, $yaadpay_tokef_year);

		delete_post_meta($parent_order_id, self::YAADPAY_TOKEF_MONTH);
		update_post_meta($parent_order_id, self::YAADPAY_TOKEF_MONTH, $yaadpay_tokef_month);

		update_post_meta($parent_order_id, self::YAADPAY_PAYMENT_ORDER_ID, $new_order_id);
	}

	public function get_title()
	{
		$title = __($this->get_option('title'), self::YAADPAY_TEXTDOMAIN);
		$this->license_type = $this->get_license_level($this->license, self::YAADPAY_TEXTDOMAIN);

		$this->define_demo_text();

		if ($this->demo) {
			$title .= $this->demo_text;
		}
		return $title;
	}


	public static function extra_log($msg)
	{

		if (self::$yaad_extra_debug) {
			self::$logger->add(self::YAADPAY_TEXTDOMAIN, $msg);
		}
	}


	public static function log($msg)
	{

		if (self::$yaad_debug) {
			//				self::$logger->add( self::YAADPAY_TEXTDOMAIN, htmlspecialchars($msg));
			self::$logger->add(self::YAADPAY_TEXTDOMAIN, $msg);
		}
	}

	/**
	 * @return string
	 */
	public function getYaadPaymentType()
	{
		return $this->yaad_payment_type;
	}

	/**
	 * @return string
	 */
	public function getYaadSubscription()
	{
		return $this->yaad_subscriptions;
	}

	private function check_yaad_signature($order)
	{

		$deal 	  = sanitize_text_field($_GET['Id']); // מס' עסקה
		$CCode 	  = sanitize_text_field($_GET['CCode']); // מס' תשובה משבא
		$Amount   = sanitize_textarea_field(rawurlencode($_GET['Amount'])); // סכום
		$ACode 	  = sanitize_text_field($_GET['ACode']); //
		$token 	  = sanitize_textarea_field(rawurlencode($_GET['Order'])); // token
		$fullName = rawurlencode($_GET['Fild1']); // שם פרטי ושם משפחה
		$email	  = rawurlencode($_GET['Fild2']); // כתובת מייל
		$phone	  = rawurlencode($_GET['Fild3']); // טלפון
		$Sign 	  = sanitize_textarea_field($_GET['Sign']); // חתימה דיגיטלית

		$sign_array = array(
			'Id' 	 => $deal,
			'CCode'  => $CCode,
			'Amount' => $Amount,
			'ACode'  => $ACode,
			'Order'  => $token,
			'Fild1'  => $fullName,
			'Fild2'  => $email,
			'Fild3'  => $phone
		);
		$args_string = (isset($_GET['HKId'])) ? ('HKId=' . $_GET['HKId'] . '&') : ('');
		foreach($sign_array as $key => $val) {
			$args_string .= "$key=$val&";
		}
		$args_string = chop($args_string, "&");
		$secret 	 = $this->get_signature();
		$verify 	 = hash_hmac('sha256', $args_string, $secret);
		self::$logger->add(self::YAADPAY_TEXTDOMAIN, '[INFO]: APISign - order #' . $order->get_id() . ' self verify hash: ' . $verify);
		return ($verify == $Sign);

		/* ------------------------------API Sign VERIFY - Deprecated--------------------------------------
		$args = $_GET ?? [];
		$args['action'] = 'APISign';
		$args['What']   = 'VERIFY';
		$args['Masof']  = $this->decide_which_masof($order->get_id());
		$args['PassP']  = $this->decide_which_passp($order->get_id());
		$args['KEY']    = $this->get_signature();

		if (isset($args['wc-api'])) {
			unset($args['wc-api']);
		}

		// URL encode to avoid sending invalid chars
		foreach ($args as $arg_key => $arg_val) {
			$args[$arg_key] = rawurlencode($arg_val);
		}


		$response = wp_remote_get(add_query_arg($args, $this->get_url()), array('timeout' => 60));
		if (is_wp_error($response)) {
			self::log(sprintf('[ERROR]: %s', $response->get_error_message()));
			return false;
		}

		parse_str($response['body'] ?? '', $result);
		$result = array_map('trim', $result);

		return ($result['CCode'] ?? null) === '0';
		-------------------------------------------------------------------------------------------- */

	}

	function yaadpay_callback_handler()
	{

		@ob_end_clean();

		self::log("Result :" . print_r($_GET, true));
		self::log('yaad_payment_type: ' . $this->yaad_payment_type);


		if (!empty($_GET)) {
			$res = sanitize_text_field($_GET['CCode']);
			$order_id = (int) sanitize_text_field($_GET['Order']);
			$order = tb_wc_object::factory(tb_wc_object::ORDER, $order_id);
			$is_a_subscription = $this->test_if_subscription($order_id);
			if (($is_a_subscription) && ($res == '0')) { //} ||$res=='700' || $res=='800')){
				$res = '1000';
			}
			self::log("res :" . $res);
			$l4digits = '';
			switch ($res) {
				case '0':
					$this->validate_signature($order);
					$this->process_successful_order($order, 'Yaadpay payment completed');
					$order->payment_complete();
					wp_redirect($this->get_return_url($order));
					break;
				case '700': // j5
					$this->validate_signature($order);
					$l4digits = $this->process_successful_order($order, 'Yaadpay payment -  J5');
					$this->save_token_data($l4digits);
					$order->update_status('on-hold');
					wp_redirect($this->get_return_url($order));
					break;
				case '800': // postpone
					$this->validate_signature($order);
					$this->process_successful_order($order, 'Yaadpay payment -  Postpone');
					update_post_meta($order->get_id(), '_yaad_postpone', 'True');
					update_post_meta($order->get_id(), '_yaadpay_id', sanitize_text_field($_GET['Id']));
					update_post_meta($order->get_id(), '_yaadpay_amount', sanitize_text_field($_GET['Amount']));
					$order->update_status('on-hold');
					wp_redirect($this->get_return_url($order));
					break;
				case '1000': // Subscription
					$this->validate_signature($order);
					$l4digits = $this->process_successful_order($order, 'Yaadpay payment -  subscription');
					$this->save_token_data($l4digits);
					$order->payment_complete();
					$this->update_subscription_parent_order($order->get_id());
					wp_redirect($this->get_return_url($order));
					break;
				default:
					$this->process_error();
					// No action
			}
		} else {
			wp_die(__("Yaadpay payment failure", self::YAADPAY_TEXTDOMAIN));
		}
	}

	/**
	 * @param int $order_id
	 * @return bool
	 */
	private function test_if_subscription($order_id)
	{
		if (($this->yaad_subscriptions != 'no') && //payment-gw is set to allow subscriptions
			function_exists('wcs_is_subscription')
		) { //woocommerce add-on is active
			if (
				wcs_is_subscription($order_id) ||
				wcs_order_contains_renewal($order_id) ||
				wcs_order_contains_subscription($order_id)
			) { //order should be treated as a subscription
				return true;
			}
		}
		return false;
	}

	function init_form_fields()
	{
		$this->form_fields = array_merge(
			$this->generate_general_fields(),
			$this->generate_display_fields(),
			$this->generate_advanced_fields(),
			$this->generate_log_fields()
		);
	} // End init_form_fields()

	function generate_log_fields()
	{
		$fields = array(
			'yaad_debug' => array(
				'title' => __('Debug', self::YAADPAY_TEXTDOMAIN),
				'type' => 'checkbox',
				'label' => __('Enable debug mode', self::YAADPAY_TEXTDOMAIN),
				'default' => 'no'
			),
			'yaad_extra_debug' => array(
				'title' => __('Detailed Log', self::YAADPAY_TEXTDOMAIN),
				'type' => 'checkbox',
				'label' => __('Enable detailed log mode', self::YAADPAY_TEXTDOMAIN),
				'default' => 'no'
			),
		);

		return $fields;
	}

	function generate_advanced_fields()
	{
		$fields = array(
			'yaad_invoices' => array(
				'title' => __('Invoices', self::YAADPAY_TEXTDOMAIN),
				'type' => 'checkbox',
				'description' => __('Support Invoices', self::YAADPAY_TEXTDOMAIN),
				'desc_tip' => __('Support Invoices', self::YAADPAY_TEXTDOMAIN),
			),
			// 'yaad_subscriptions' => array(
			// 	'title' => __( 'Subscriptions', self::YAADPAY_TEXTDOMAIN),
			// 	'type' => 'checkbox',
			// 	'description' => __( 'Support Woocommerce Subscriptions. Note: for subscriptions, payment type is always "Process"', self::YAADPAY_TEXTDOMAIN),
			// 	'desc_tip' => __( 'Support Woocommerce Subscriptions', self::YAADPAY_TEXTDOMAIN),
			// ),
			'yaad_payment_type' => array(
				'title' => __('Payment type', self::YAADPAY_TEXTDOMAIN),
				'type' => 'select',
				'options' => array(
					'Process'           =>  __('Process', self::YAADPAY_TEXTDOMAIN),
					self::YAAD_POSTPONE =>  __('Postpone', self::YAADPAY_TEXTDOMAIN),
					self::YAAD_J5       =>  __('J5', self::YAADPAY_TEXTDOMAIN),
					//					self::SUBSCRIPTION  =>  __( 'Subscription', self::YAADPAY_TEXTDOMAIN),
				),
			),
			// 'yaad_allow_saved_cc' => array(
			// 	'title' => __( 'Allow Saved CC', self::YAADPAY_TEXTDOMAIN),
			// 	'type' => 'checkbox',
			// 	'description' => __( 'This will allow returning customers to pay with a previous saved TOKEN', self::YAADPAY_TEXTDOMAIN ),
			// 	'default' => 'no',
			// ),
			// 			'yaad_TestTerm' => array(
			// 				'title' => __( 'Use TEST terminal', self::YAADPAY_TEXTDOMAIN),
			// 				'type' => 'checkbox',
			// 				'label' => __('Replace Live terminal with TEST terminal', self::YAADPAY_TEXTDOMAIN),
			// //				'description' => __('Masof: 0010070211, PassP: 1234. Active only when logged-in as ADMIN. NOTE: these transactions will not be charged', self::YAADPAY_TEXTDOMAIN),
			// 				'description' => __('Please consult 10bit support before activation.', self::YAADPAY_TEXTDOMAIN).'<br>'.__('Masof: 0010070211, PassP: 1234. Active only when logged-in as ADMIN. NOTE: these transactions will not be charged', self::YAADPAY_TEXTDOMAIN),
			// 			),

		);
		return $fields;
	}
	function generate_display_fields()
	{
		$fields = array(
			'title' => array(
				'title' => __('Title', self::YAADPAY_TEXTDOMAIN),
				'type' => 'text',
				'description' => __('This controls the title which the user sees during checkout.', self::YAADPAY_TEXTDOMAIN),
				'default' => __('Yaadpay Gateway', self::YAADPAY_TEXTDOMAIN),
			),
			'description' => array(
				'title' => __('Description', self::YAADPAY_TEXTDOMAIN),
				'type' => 'textarea',
				'description' => __('This controls the description which the user sees during checkout.', self::YAADPAY_TEXTDOMAIN),
				'default' => __('Pay via Yaadpay', self::YAADPAY_TEXTDOMAIN),
			),
			'yaad_language' => array(
				'title' => __('Language', self::YAADPAY_TEXTDOMAIN),
				'type' => 'select',
				'options' => array(
					'HEB' 	=>  __('Hebrew', self::YAADPAY_TEXTDOMAIN),
					'ENG' 	=>  __('English', self::YAADPAY_TEXTDOMAIN),
					'auto' 	=>  __('Auto', self::YAADPAY_TEXTDOMAIN),
				),
			),
			'yaad_currency' => array(
				'title' => __('Currency', self::YAADPAY_TEXTDOMAIN),
				'type' => 'select',
				'options' => array(
					'1'    =>  __('ILS', self::YAADPAY_TEXTDOMAIN),
					'2'    =>  __('USD', self::YAADPAY_TEXTDOMAIN),
					'3'    =>  __('Euro', self::YAADPAY_TEXTDOMAIN),
					'4'    =>  __('GBP', self::YAADPAY_TEXTDOMAIN),
					'auto' =>  __('Auto', self::YAADPAY_TEXTDOMAIN),
				),
				'default' => '1'
			),
			'yaad_iframe' => array(
				'title' => __('Use Iframe', self::YAADPAY_TEXTDOMAIN),
				'type' => 'checkbox',
				'label' => __('Load the secured YaadPay page in an iframe', self::YAADPAY_TEXTDOMAIN),
				'default' => 'no',
			),
			'yaad_iframe_width' => array(
				'title' => __(' Iframe Width', self::YAADPAY_TEXTDOMAIN),
				'type' => 'number',
				'description' => __('Set the Iframe width in PX , leave blank for 100%', self::YAADPAY_TEXTDOMAIN),
				'default' => 'no',
			),
			'yaad_iframe_height' => array(
				'title' => __(' Iframe Height', self::YAADPAY_TEXTDOMAIN),
				'type' => 'number',
				'description' => __('Set the Iframe height in PX ', self::YAADPAY_TEXTDOMAIN),
				'default' => '800',
			),
			'yaad_template' => array(
				'title' => __(' Payment Page Template', self::YAADPAY_TEXTDOMAIN),
				'type' => 'number',
				'description' => __('<a href="https://yaadpay.yaad.net/developers/article.php?id=67" target="_blank">Click Here</a> to see a list of available templates', self::YAADPAY_TEXTDOMAIN),
				'default' => '6',
			),
		);
		return $fields;
	}

	function generate_general_fields()
	{
		// if ($this->license==''){
		// 	$license_desc= __( 'Please enter your license key as received from http://www.10bit.co.il', self::YAADPAY_TEXTDOMAIN);
		// }
		// else
		// {
		// 	if ($this->license_type!='none'){
		// 		$license_desc= __('License level : '  .$this->license_type , self::YAADPAY_TEXTDOMAIN);

		// 	}
		// 	else{
		// 		$license_desc= __( 'Invalid license Key', self::YAADPAY_TEXTDOMAIN);
		// 	}
		// }

		$fields = array(
			'enabled' => array(
				'title' => __('Enable/Disable', self::YAADPAY_TEXTDOMAIN),
				'type' => 'checkbox',
				'label' => __('Enable yaadpay Payment', self::YAADPAY_TEXTDOMAIN),
				'default' => 'no',
			),
			// 'yaad_license' => array(
			// 	'title' => __( 'License', self::YAADPAY_TEXTDOMAIN),
			// 	'type' => 'text',
			// 	'description' => $license_desc,
			// 	'default' => 'test',
			// ),

			'yaad_termNo' => array(
				'title' => __('Terminal Number', self::YAADPAY_TEXTDOMAIN),
				'type' => 'text',
				'description' => __('Your terminal number as provided by Yaadpay', self::YAADPAY_TEXTDOMAIN),
			),
			'yaad_signature' => array(
				'title' => __('Authentication signature', self::YAADPAY_TEXTDOMAIN),
				'type' => 'text',
				'description' => __('Fraud prevention signature', self::YAADPAY_TEXTDOMAIN),
			),
			'yaad_PassP' => array(
				'title' => __('Remote password (PassP)', self::YAADPAY_TEXTDOMAIN),
				'type' => 'text',
				'label' => __('This password will be used for server to server action like subscriptions tokenized payments and refunds', self::YAADPAY_TEXTDOMAIN),
			),
			'yaad_maxPayments' => array(
				'title' => __('Max Payments', self::YAADPAY_TEXTDOMAIN),
				'type' => 'number',
				'description' => __('Set the maximum allowed payments.', self::YAADPAY_TEXTDOMAIN),
				'default' => '1',
			),
			'yaad_tiered_payments' => array(
				'title' => __('Tiered Payments', self::YAADPAY_TEXTDOMAIN),
				'type' => 'text',
				'description' => __('This Overrides the Max Payments setting !!! to use conditional payment simply enter a comma separated amounts e.g 200,400,600 -> this will set the payments to be 1 for lower than 200 , 2 for lower than 400 etc ...', self::YAADPAY_TEXTDOMAIN),
			),

		);
		return $fields;
	}


	/**
	 * Receipt Page
	 * @param $order_id
	 */
	function receipt_page($order_id)
	{
		echo $this->generate_yaadpay_form($order_id);
	}

	function startsWith($haystack, $needle)
	{
		// search backwards starting from haystack length characters from the end
		return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
	}


	/**
	 * Generate yaadpay button link
	 * @param int $order_id
	 * @return string
	 */
	public function generate_yaadpay_form($order_id)
	{

		self::log("[INFO]: Notify URL : " . $this->notify_url);
		$order = tb_wc_object::factory(tb_wc_object::ORDER, $order_id);

		$user_token_data = $this->get_user_meta_data($order->get_user_id());
		self::log("user saved cc data :" . print_r($user_token_data, true));

		$is_trial = $this->is_trial($order);
		if ($is_trial) {
			echo '<div class="trial-msg">' . __('This is a validation order only , your account will not be charged', self::YAADPAY_TEXTDOMAIN) . '</div>';
		}

		// $yaadpay_args = $this->collect_yaad_args($order, $is_trial);

		// self::log("Args :" . print_r($yaadpay_args, true));

		// $this->handle_saved_cc_payment($order_id, $yaadpay_args, $user_token_data);

		$queryString = $order->get_WC_order()->get_meta(self::YAADPAY_QUERY_STRING);
		$url = $this->get_url() . '?' . $queryString;

		if ($this->iframe) {
			$style = 'border:none; max-width:100%; margin:0 auto;';
			$width = !empty($this->iframe_width) ? $this->iframe_width . 'px' : '100%';
			$height = !empty($this->iframe_height) ? $this->iframe_height . 'px' : '800px';
			$iframe = sprintf('<iframe scrolling="no" style="%s" src="%s" width="%s" height="%s"></iframe>', $style, esc_url($url), $width, $height);
			return $iframe;
		}

		wp_redirect($url);
		exit;
	}
	//		found license

	/**
	 * @param WP_Error $error_obj
	 * @return void
	 */
	public function display_error_and_die($error_obj)
	{
		$payment_error = __('Payment failure, please try again or contact the store administrator', self::YAADPAY_TEXTDOMAIN);
		$payment_error .= '<br/>';
		$payment_error .= __('Error code :', self::YAADPAY_TEXTDOMAIN);
		$payment_error .= '<br/>';
		$payment_error .= $error_obj->get_error_code();
		$payment_error .= '<br/>';
		$payment_error .= __('Error text :', self::YAADPAY_TEXTDOMAIN);
		$payment_error .= '<br/>';
		$payment_error .= $error_obj->get_error_message($error_obj->get_error_code());
		$payment_error .= '<br/>';
		$payment_error .= '<br/>';
		$checkout_url = wc_get_checkout_url();
		$payment_error .= sprintf(__('Click <a href="%s">here </a>to return to the checkout page.', self::YAADPAY_TEXTDOMAIN), $checkout_url);
		wp_die($payment_error);
	}

	private function is_token_payment($yaad_token, $credit_card_type)
	{
		return ($yaad_token != '') && ($credit_card_type == 'saved') && $this->yaad_allow_saved_cc;
	}


	private function handle_saved_cc_payment($order_id, $yaadpay_args, $user_token_data)
	{
		self::log("[INFO]: " . __FUNCTION__ . ' Start');
		$credit_card_type = 'new';
		if (isset($_GET['credit_card_type'])) {
			$credit_card_type = sanitize_text_field($_GET['credit_card_type']);
		}

		self::log("[INFO]: credit_card_type: " . $credit_card_type);

		if ($this->is_token_payment($user_token_data[self::YAADPAY_TOKEN_USER], $credit_card_type)) {
			self::log("[INFO]: process saved cc payment");
			$order = tb_wc_object::factory(tb_wc_object::ORDER, $order_id);

			$payments = 1;
			if (isset($_GET['payments'])) {
				$payments = sanitize_text_field($_GET['payments']);
			}

			$yaadpay_args['Tash'] = $payments;

			$this->build_yaad_token_args($yaadpay_args, $order_id, $user_token_data[self::YAADPAY_TOKEN_USER], $user_token_data[self::YAADPAY_TMONTH_USER], $user_token_data[self::YAADPAY_TYEAR_USER]);

			if ($this->test_if_subscription($order_id)) {
				self::log('this order is a subscription');
				$this->unset_j5_payment_type($yaadpay_args);
			}
			self::log("[INFO]: yaadpay_args : " . print_r($yaadpay_args, true));

			$resp = $this->send_payment_request($yaadpay_args);

			$result_array = array();
			parse_str($resp, $result_array);
			self::log("[INFO]: ConfirmationCode: " . print_r($result_array, true));

			$order->add_order_note(sprintf('Yaad-Sarig payment status: %s, CCode=%s, Id=%s', ((($result_array['CCode'] == 0) || ($result_array['CCode'] == '700')) ? 'OK' : 'Failed'), $result_array['CCode'], $result_array['Id']));

			if (($result_array['CCode'] != 0) && ($result_array['CCode'] != '700')) {
				$err_obj = new WP_Error($result_array['CCode'], __('Saved CC payment failed', self::YAADPAY_TEXTDOMAIN));
				$this->display_error_and_die($err_obj);
			} else {

				$this->copy_token_data($order_id, $user_token_data, $result_array['Id']);

				if ($result_array['CCode'] == 0) {
					$order->payment_complete();
					$this->update_subscription_parent_order($order_id);
				} else { //J5
					$order->update_status('on-hold');
				}
				wp_redirect($this->get_return_url($order));
			}

			return $result_array['CCode'];
		}
	}

	/**
	 * @param $order_id
	 * @param $amount
	 * @param $manager_key
	 * @param $reason
	 * @return bool
	 */
	public function handle_refund_request($order_id, $amount, $reason)
	{
		self::log(sprintf('[INFO]: refund request, order-id: %s, amount: %s, reason: %s', $order_id, $amount, $reason));
		$order = tb_wc_object::factory(tb_wc_object::ORDER, $order_id);
		$token = get_post_meta($order_id, self::YAADPAY_TOKEN, true);
		if ($token == '') {
			$t_id = $this->get_yaadpay_transaction_id($order_id);
			self::log('[INFO]: no token, requesting...');
			if (($t_id == '') ||
				($this->request_token_data_by_trans_id($t_id, $order_id) == false)
			) {
				self::log('[INFO]: failed to get token');
				return false;
			}
			$token = get_post_meta($order_id, self::YAADPAY_TOKEN, true);
		}
		$tyear = get_post_meta($order_id, self::YAADPAY_TOKEF_YEAR, true);
		$tmonth = get_post_meta($order_id, self::YAADPAY_TOKEF_MONTH, true);

		$yaadpay_args = $this->collect_yaad_args($order, false);
		if (!$yaadpay_args['Coin']) {
			return false;
		}

		$this->build_yaad_token_args($yaadpay_args, $order_id, $token, $tmonth, $tyear);
		$this->unset_j5_payment_type($yaadpay_args);

		$managerKey = WC()->session->get('manager_key');
		if (empty($managerKey)) {
			return false;
		}

		$yaadpay_args['zPass'] = $managerKey;
		$yaadpay_args['Amount'] = $amount;
		$yaadpay_args['Tash'] = 1;
		$yaadpay_args['FixTash'] = 'True';
		$yaadpay_args['heshDesc'] = sprintf(
			'[refund~%s~1~%f]',
			sprintf(
				__('Refund for order %d', self::YAADPAY_TEXTDOMAIN),
				$order_id
			),
			$amount
		);

		WC()->session->set('manager_key', '');

		$resp = $this->send_payment_request($yaadpay_args);
		$result_array = array();
		parse_str($resp, $result_array);
		if ((int) $result_array['CCode'] == 0) {
			self::log('[INFO]: refund OK');
			return true;
		}
		$err_msg = sprintf("Yaadpay refund request failed: CCode: %s", $result_array['CCode']);
		self::log($err_msg);
		$order->add_order_note($err_msg);
		return false;
	}

	private function copy_token_data($order_id, $user_token_data, $transaction_id)
	{
		update_post_meta($order_id, self::YAADPAY_TOKEN, $user_token_data[self::YAADPAY_TOKEN_USER]);
		update_post_meta($order_id, self::YAADPAY_ID, $transaction_id);
		update_post_meta($order_id,  self::YAADPAY_TOKEF_YEAR, $user_token_data[self::YAADPAY_TYEAR_USER]);
		update_post_meta($order_id, self::YAADPAY_TOKEF_MONTH, $user_token_data[self::YAADPAY_TMONTH_USER]);
	}

	public function update_user_token($user_id, $cardToken, $tmonth, $tyear, $last4digits, $yaad_user_id)
	{
		update_user_meta($user_id, self::YAADPAY_TOKEN_USER, $cardToken);
		update_user_meta($user_id, self::YAADPAY_TMONTH_USER, $tmonth);
		update_user_meta($user_id, self::YAADPAY_TYEAR_USER, $tyear);
		if ($last4digits != '') {
			update_user_meta($user_id, self::YAADPAY_CC_LAST4_USER, $last4digits);
		}
		if ($yaad_user_id != '') {
			update_user_meta($user_id, self::YAADPAY_ID_USER, $yaad_user_id);
		}
	}


	function admin_options()
	{
?>
		<?php
		$title = __('Yaad pay payment gateway', self::YAADPAY_TEXTDOMAIN);
		$server = $_SERVER['HTTP_HOST'];
		?>
		<h2><?php echo $title; ?></h2>
		<div class="tenbit-notify">
			<span><?php _e('This is the return address for both the failure and success urls :', self::YAADPAY_TEXTDOMAIN); ?></span>
			<br />
			<span><?php echo $this->notify_url; ?></span>
			<br />
			<span><?php _e('If your site does NOT support HTTPS - change the address to HTTP instead of HTTPS', self::YAADPAY_TEXTDOMAIN); ?></span>
		</div>
		<ul class="tabs">
			<li class="tab-link current" data-tab="general" id="general-tab"><?php _e('General', self::YAADPAY_TEXTDOMAIN); ?></li>
			<li class="tab-link" data-tab="display" id="display-tab"><?php _e('Display', self::YAADPAY_TEXTDOMAIN); ?></li>
			<li class="tab-link" data-tab="advanced" id="advanced-tab"><?php _e('Advanced', self::YAADPAY_TEXTDOMAIN); ?></li>
			<li class="tab-link" data-tab="log" id="log-tab"><?php _e('Log', self::YAADPAY_TEXTDOMAIN); ?></li>
		</ul>
		<table id="general" class="form-table tab-content current">
			<?php
			$general_fields  = $this->generate_general_fields();
			$this->generate_settings_html($general_fields);
			?>
		</table>
		<table id="display" class="form-table tab-content">
			<?php
			$display_fields = $this->generate_display_fields();
			$this->generate_settings_html($display_fields);
			?>
		</table>
		<table id="advanced" class="form-table tab-content">
			<?php
			$advanced_fields = $this->generate_advanced_fields();
			$this->generate_settings_html($advanced_fields);
			?>
		</table>
		<table id="log" class="form-table tab-content">
			<?php
			$this->generate_settings_html($this->generate_log_fields());

			?>
			<tr>
				<td colspan="2">
					<?php
					echo '<button onclick="view_log();return false;" id="view-log"/>' . __('View log', self::YAADPAY_TEXTDOMAIN) . '</button>';
					echo '<br>';
					echo '<br>';
					echo '<div id="log-display">';
					echo '</div>';
					echo '<br>';
					echo '<button onclick="delete_log();return false;" id="delete-log"/>' . __('Delete log', self::YAADPAY_TEXTDOMAIN) . '</button>';
					?>
				</td>
			</tr>

		</table>
		<div class="tb-footer">
			<a href="mailto:info@10bit.co.il?Subject=<?php echo "$title - $server"; ?>" target="_blank" class="tenbit-footer-links">
				<img src="<?php echo plugin_dir_url(__FILE__); ?>../assets/images/email.png" />
			</a>
			<a href="https://www.youtube.com/channel/UCvMFC-PlSLBiDQUiZ0I39fg" target="_blank" class="tenbit-footer-links">
				<img src="<?php echo plugin_dir_url(__FILE__); ?>../assets/images/YouTube.png" />
			</a>
			<a href="https://www.facebook.com/pages/10Bit/376476385786130" target="_blank" class="tenbit-footer-links">
				<img src="<?php echo plugin_dir_url(__FILE__); ?>../assets/images/Facebook.png" />
			</a>
			<a href="http://www.10bit.co.il" target="_blank" class="tenbit-footer-links">
				<img src="<?php echo plugin_dir_url(__FILE__); ?>../assets/images/WWW.png" />
			</a>
		</div>


<?php
	}


	function process_payment($order_id)
	{


		$order = tb_wc_object::factory(tb_wc_object::ORDER, $order_id);
		$params = '';
		if (isset($_POST['yaad_payments'])) {
			$params .= '&payments=' . sanitize_text_field($_POST['yaad_payments']);
		}
		if (isset($_POST['credit_card_type'])) {
			$params .= '&credit_card_type=' . sanitize_text_field($_POST['credit_card_type']);
		}
		self::log('[INFO]: process_payment params:' . print_r($params, true));

		return array('result' => 'success', 'redirect' => $order->get_checkout_payment_url(true) . $params);
	}

	/**
	 * @return string
	 */
	public function get_currency()
	{
		if ($this->yaad_currency != 'auto') {
			return $this->yaad_currency;
		}

		$currency = get_woocommerce_currency();
		switch ($currency) {
			case 'ILS':
				$currency = '1';
				break;
			case 'USD':
				$currency = '2';
				break;
			case 'EUR':
				$currency = '3';
				break;
			case 'GBP':
				$currency = '4';
				break;
			default:
				$errorMessage = sprintf(
					__('Currency not supported: %s', self::YAADPAY_TEXTDOMAIN),
					$currency
				);
				if (is_ajax()) {
					if (is_admin()) {
						return false;
					}
					wc_add_notice($errorMessage, 'error');
					wp_send_json([
						'result'   => 'failure',
						'messages' => wc_print_notices(true),
						'refresh'  => false,
						'reload'   => false,
					]);
				}
				die($errorMessage);
				break;
		}
		return $currency;
	}

	/**
	 * @return string
	 */
	public function get_language()
	{
		$language = $this->yaad_language;
		if ($this->yaad_language == 'auto') {
			$language = get_bloginfo('language');
			if ($language == 'en-US') {
				$language = 'ENG';
			}
			if ($language == 'he-IL') {
				$language = 'HEB';
				return $language;
			}
			return $language;
		}
		return $language;
	}

	/**
	 * @param $amount
	 * @return int
	 */
	public function get_max_payments($amount)
	{
		$maxPayments = $this->maxPayments;
		if ($this->yaad_tiered_payments != '') {
			$maxPayments = 1;
			$pageant_levels = explode(',', $this->yaad_tiered_payments);
			foreach ($pageant_levels as &$level) {
				if ($amount <= $level) {
					break;
				}
				$maxPayments += 1;
			}
			return $maxPayments;
		}
		return $maxPayments;
	}

	/**
	 * @param $order
	 * @param $yaadpay_args
	 * @return array
	 */
	public function add_invoice_information(tb_wc_order $order, $yaadpay_args)
	{
		if ($this->yaad_invoices == 'no') {
			$yaadpay_args['SendHesh'] = 'True';
			$yaadpay_args['Pritim'] = 'False';
			return $yaadpay_args;
		}
		$invoice_lines_information = $this->build_item_lines($order);
		$invoice_lines_information .= $this->build_order_fees($order);
		$invoice_lines_information .= $this->build_shipping_line($order);
		$invoice_lines_information .= $this->build_discount_line($order);

		self::log("invoice information - " . $invoice_lines_information);


		$yaadpay_args['Pritim'] = 'True';
		$yaadpay_args['heshDesc'] = $invoice_lines_information;
		$yaadpay_args['SendHesh'] = 'True';
		$yaadpay_args['sendHeshSMS'] = 'True';
		return  $yaadpay_args;
	}

	/**
	 * @param $order
	 * @return string
	 */
	public function build_discount_line(tb_wc_order $order)
	{
		$discount = $order->get_total_discount(false);
		if ($discount > 0) {
			$line_item = "[";
			$line_item .= 999998;
			$line_item .= "~";
			$line_item .= __('Discount : ', self::YAADPAY_TEXTDOMAIN);
			$line_item .= "~";
			$line_item .= 1;
			$line_item .= "~";
			$line_item .= -$discount;
			$line_item .= "]";
			self::log("shipping line item - " . $line_item);

			return $line_item;
		}
		return '';
	}

	/**
	 * @param $order
	 * @return string
	 */
	public function build_shipping_line(tb_wc_order $order)
	{
		$shipping = round($order->get_shipping_total() + $order->get_shipping_tax(), 2);
		if ($shipping > 0) {
			$line_item = "[";
			$line_item .= 999999;
			$line_item .= "~";
			$line_item .= __('Shipping : ', self::YAADPAY_TEXTDOMAIN) . $order->get_shipping_method();
			$line_item .= "~";
			$line_item .= 1;
			$line_item .= "~";
			$line_item .= $shipping;
			$line_item .= "]";
			self::log("shipping line  - " . $line_item);

			return $line_item;
		}
		return '';
	}

	/**
	 * @param tb_wc_order $order
	 * @return string
	 */
	public function build_item_lines($order)
	{
		$item_line = '';

		/** @var tb_wc_item $item */
		foreach ($order->get_items() as $item) {
			//print_r($item);
			//die();

			$_product 		   = $item->get_product($order);
			$title    		   = $item->get_name();
			$sku 			   = $_product->get_sku();
			$qty 			   = $item->get_qty();
			$line_subtotal_tax = round($item->get_line_subtotal_tax(), 2);
			$line_subtotal 	   = round($item->get_line_subtotal(), 2);
			$parsed_title  	   = rawurlencode(preg_replace("/['\"&?~`,.]/", '', htmlspecialchars_decode($title)));
			$item_line .= "[";
			$item_line .= empty($sku) ? '0001' : $sku;
			$item_line .= "~";
			$item_line .= $parsed_title;
			$item_line .= "~";
			$item_line .= $qty;
			$item_line .= "~";
			$item_line .= round( ( ( $line_subtotal + $line_subtotal_tax ) / $qty ), 2 );
			$item_line .= "]";
			//				self::log( "item sku  - " . $sku );
			//				self::log( "item title  - " . $title );
			//				self::log( "item qty - " . $qty );
			//				self::log( "item subtotal  - " . $line_subtotal );
			self::log("item_line - " . $item_line);
		}

		return $item_line;
	}

	/**
	 * @param tb_wc_order $order
	 * @return string
	 */
	private function build_order_fees($order)
	{

		$item_line = '';

		/** @var tb_wc_item $fee */
		foreach ($order->get_fees() as $fee) {
			//print_r($item);
			//die();

			/** @var WC_Order_Item_Fee $wc_fee */
			self::log("fee - " . $fee);
			$wc_fee 	  = method_exists($fee, 'get_WC_object') ? $fee->get_WC_object() : $fee;
			self::log("wc_fee - " . $wc_fee);
			$title 		  = $fee->get_name();
			$parsed_title = rawurlencode(preg_replace("/['\"&?~`,.]/", '', htmlspecialchars_decode($title)));
			$item_line .= "[";
			$item_line .= '0001';
			$item_line .= "~";
			$item_line .= str_replace("'", "", $parsed_title);
			$item_line .= "~1~";
			$item_line .= round($wc_fee->get_total(), 2);
			$item_line .= "]";
			self::log("item_line - " . $item_line);
		}

		return $item_line;
	}

	public function get_3ds_url()
	{
		return defined('YAAD_3DS_URL') ? YAAD_3DS_URL : '';
	}

	public function get_invoice_link(\WC_Order $order)
	{
		$ccQueryString = $order->get_meta(self::YAADPAY_CC_PAYMENT);
		parse_str($ccQueryString, $ccResult);

		$tokenQueryString = $order->get_meta(self::YAADPAY_TOKEN_PAYMENT);
		parse_str($tokenQueryString, $tokenResult);

		$postponeQueryString = $order->get_meta(self::YAADPAY_POSTPONE_PAYMENT);
		parse_str($postponeQueryString, $postponeResult);

		if (!empty($ccResult['Hesh'])) {
			$hesh = $ccResult['Hesh'];
		} elseif (!empty($tokenResult['Hesh'])) {
			$hesh = $tokenResult['Hesh'];
		} elseif (!empty($postponeResult['HeshASM'])) {
			$hesh = $postponeResult['HeshASM'];
		} else {
			return '';
		}

		$args = array(
			'action' => 'APISign',
			'What'   => 'SIGN',
			'KEY'    => $this->get_signature(),
			'PassP'  => $this->decide_which_passp($order->get_id()),
			'Masof'  => $this->decide_which_masof($order->get_id()),
			'ACTION' => 'PrintHesh',
			'type'   => 'PDF',
			'asm'    => $hesh
		);

		$response = wp_remote_get(add_query_arg($args, $this->get_3ds_url()), array('timeout' => 60));
		if (is_wp_error($response)) {
			self::log(sprintf('[ERROR]: %s', $response->get_error_message()));
			return '';
		}

		if (empty($response['body'])) {
			return '';
		}

		$invoiceLink = $this->get_3ds_url() . '?' . $response['body'];
		$order->update_meta_data('yaad_invoice_link', $invoiceLink);
		$order->save();

		return $invoiceLink;
	}

	public function get_license()
	{
		$license = $this->get_option('yaad_license');
		//			self::log("[INFO]: found license: " . $license);

		$alternate_license = apply_filters('tb_yaadpay_replace_license_key', '');

		if (empty($alternate_license) == false) {
			self::log(sprintf("[INFO]: replacing license: %s with alternate license: %s", $license, $alternate_license));
			$license = $alternate_license;
		}
		self::extra_log("[INFO]: using license: " . $license);
		return $license;
	}

	public function define_demo_text()
	{
		$this->demo = $this->license_type == 'none';
		$this->demo_text = '';
		if ($this->demo) {
			$this->demo_text = ' - <b>The license is not valid for this domain, you may see this message until moving to your permanent domain</b> !';
		}
	}

	/**
	 * @return bool
	 */
	public function get_is_debug()
	{
		return $this->get_option('yaad_debug') == "yes";
	}

	public function get_is_extra_debug()
	{
		if ($this->get_is_debug()) {
			return $this->get_option('yaad_extra_debug') == "yes";
		}
		return false;
	}

	public function get_terminal_number()
	{
		$terminal = $this->get_option('yaad_termNo');
		//			self::log("[INFO]: original terminal: " .$terminal );

		$alternate_terminal = apply_filters('tb_yaadpay_replace_terminal_number', '');

		if (empty($alternate_terminal) == false) {
			self::log(sprintf("[INFO]: replacing terminal: %s , with alternate terminal: %s", $terminal, $alternate_terminal));
			$terminal = $alternate_terminal;
		}
		self::extra_log("[INFO]: using terminal: " . $terminal);
		return $terminal;
	}

	public function get_signature()
	{
		$signature = $this->get_option('yaad_signature');
		//			self::log("[INFO]: original signature: " . $signature);

		$alternate_signature = apply_filters('tb_yaadpay_replace_signature', '');

		if (empty($alternate_signature) == false) {
			self::log(sprintf("[INFO]: replacing signature: %s , with alternate signature: %s", $signature, $alternate_signature));
			$signature = $alternate_signature;
		}
		self::extra_log("[INFO]: using signature: " . $signature);
		return $signature;
	}

	/**
	 * @param $is_ssl
	 */
	public function build_notify_url($is_ssl)
	{
		$this->notify_url = add_query_arg('wc-api', 'WC_Gateway_Yaadpay', home_url('/'));
		$this->notify_url = $is_ssl ? str_replace('http:', 'https:', $this->notify_url) : str_replace('https:', 'http:', $this->notify_url);
	}

	final function get_license_level($key, $salt)
	{
		/*
            $server = $_SERVER['HTTP_HOST'];
            $server = str_replace('https://', '', $server);
            $server = str_replace('http://', '', $server);
            $server = str_replace('www.', '', $server);
            $crypt = md5($server . $salt);
            if ($crypt == $key) {
                return 'Standard';
            }

            $crypt = md5($server . $salt.'.silver');
            if ($crypt == $key) {
                return 'Premium';
            }

            $crypt = md5($server . $salt.'.gold');

            if ($crypt == $key) {
                return 'Ultimate';
            }*/
		return 'Premium';
	}

	public function process_refund($order_id, $amount = null, $reason = '')
	{
		if (($this->license_type == 'Premium') || ($this->license_type == 'Ultimate')) {
			return $this->handle_refund_request($order_id, $amount, $reason);
		}
		return false;
	}


	public function define_supported_functionality($license_level)
	{
		$this->supports = array(
			'senzey',
			'products',
		);
		if ($license_level == 'Premium' || $license_level == 'Ultimate') {
			$this->supports[] = 'refunds';
			$this->supports[] = 'Premium';
		}
		if ($license_level == 'Ultimate') {
			$this->supports[] = 'ultimate';
			$this->supports[] = 'subscriptions';
			$this->supports[] = 'subscription_cancellation';
			$this->supports[] = 'multiple_subscriptions';
			$this->supports[] = 'subscription_suspension';
			$this->supports[] = 'subscription_reactivation';
			$this->supports[] = 'subscription_amount_changes';
			$this->supports[] = 'subscription_date_changes';
			$this->supports[] = 'subscription_payment_method_change_customer';
			$this->supports[] = 'subscription_payment_method_change_admin';
			$this->supports[] = 'subscription_payment_method_change';
		}
	}

	/**
	 * @param $order
	 * @param $yaadpay_args
	 *
	 * @return mixed
	 */
	private function add_payments(tb_wc_order $order, $yaadpay_args)
	{

		$maxPayments          = $this->get_max_payments($order->get_total());
		$yaadpay_args['Tash'] = $maxPayments;
		if ($maxPayments == 1) {
			$yaadpay_args['FixTash'] = 'True';
		}

		return $yaadpay_args;
	}

	/**
	 * @param $language
	 * @param $yaadpay_args
	 *
	 * @return mixed
	 */
	private function add_english_messages_support($language, $yaadpay_args)
	{
		if ($language == 'ENG') {
			$yaadpay_args['ShowEngTashText'] = 'True';

			return $yaadpay_args;
		}

		return $yaadpay_args;
	}

	/**
	 * @param $yaadpay_args
	 *
	 * @param $is_trial
	 * @param int $order_id
	 *
	 * @return mixed
	 */
	private function add_j5_support($yaadpay_args, $is_trial, $order_id)
	{
		if ((($this->yaad_payment_type ==  self::YAAD_J5)  ||
				$is_trial) &&
			!$this->test_if_subscription($order_id)
		) {
			$yaadpay_args[self::YAAD_J5] = 'True';
		}

		return $yaadpay_args;
	}

	private function add_postpone_support($yaadpay_args, $is_trial, $order_id)
	{
		if ((($this->yaad_payment_type ==  self::YAAD_POSTPONE)  ||
				$is_trial) &&
			!$this->test_if_subscription($order_id)
		) {
			$yaadpay_args[self::YAAD_POSTPONE] = 'True';
		}

		return $yaadpay_args;
	}

	public function scheduled_subscription_payment($amount_to_charge, WC_Order  $wc_order)
	{
		self::log("[INFO]: scheduled_subscription_payment start ");
		$order = tb_wc_object::factory(tb_wc_object::ORDER, $wc_order);

		$result = $this->process_subscription_payment($order, $amount_to_charge);

		self::log("[INFO]: result  " . print_r($result, true));

		if (is_wp_error($result)) {
			$subscription = reset(wcs_get_subscriptions_for_renewal_order($order->get_id()));
			/*TODO: replace with:
$wc_parent_order = method_exists($subscription, 'get_parent') ? $subscription->get_parent() : $subscription->order;
WC_Subscriptions_Manager::process_subscription_payment_failure_on_order($wc_parent_order);
*/

			WC_Subscriptions_Manager::process_subscription_payment_failure_on_order($subscription->order);
			self::log("[INFO]: process_subscription_payment_failure_on_order  ");
		} else {
			WC_Subscriptions_Manager::process_subscription_payments_on_order($order->get_WC_object());

			self::log("[INFO]: process_subscription_payments_on_order  ");
		}
	}

	private function process_subscription_payment(tb_wc_order $order, $amount_to_charge)
	{

		self::log("[INFO]: " . __FUNCTION__ . " Start");

		$yaadpay_args = $this->build_yaadpay_args_for_renewal($order, $amount_to_charge);
		//			self::log("[INFO]: args: " . print_r($yaadpay_args,true));

		$resp = $this->send_payment_request($yaadpay_args);
		//			self::log("[INFO]: result: " .iconv("cp1255","UTF-8",$resp ));

		$result_array = array();
		parse_str($resp, $result_array);
		self::log("[INFO]: ConfirmationCode: " . print_r($result_array, true));

		$order->add_order_note(sprintf('Subscription Renewal %s: CCode=%s, Id=%s', ($this->is_token_payment_error($result_array) ? 'Failed' : 'OK'), $result_array['CCode'], $result_array['Id']));

		if ($this->is_token_payment_error($result_array)) {
			return new WP_Error('Renewal failed', __('renewal failed', '10bit-woocommerce-gateway-tranzila'));
		} else {
			$order->payment_complete();
		}

		return $result_array['CCode'];
	}


	/**
	 * @param int $order_id
	 * @param string $transaction_id
	 * @param string $token_code
	 * @param string $token_epiration_month
	 * @param string $token_expiration_year
	 * @return string|WP_Error
	 */
	public function process_token_payment($order_id, $transaction_id, $token_code, $token_epiration_month, $token_expiration_year)
	{

		self::log("[INFO]: " . __FUNCTION__ . " Start");
		self::log("[INFO]: process_token_payment" . " $order_id, $transaction_id, $token_code, $token_epiration_month, $token_expiration_year ");
		$order = tb_wc_object::factory(tb_wc_object::ORDER, $order_id);

		$yaadpay_args = $this->collect_yaad_args($order, false);
		parse_str(get_post_meta($order_id, 'yaad_credit_card_payment', true), $yaad_credit_card_payment_array);

		if(isset($yaad_credit_card_payment_array['CCode']) && $yaad_credit_card_payment_array['CCode'] == '700' && isset($yaad_credit_card_payment_array['Payments']) && $yaad_credit_card_payment_array['Payments'] > 0) {
			$yaadpay_args['Tash'] = $yaad_credit_card_payment_array['Payments'];
			if($yaad_credit_card_payment_array['Payments'] == 1) {
				$yaadpay_args['FixTash'] = 'True';
			}
		}

		$this->build_yaad_token_args($yaadpay_args, $order_id, $token_code, $token_epiration_month, $token_expiration_year, $transaction_id);

		$this->unset_j5_payment_type($yaadpay_args);

		$resp = $this->send_payment_request($yaadpay_args);

		$result_array = array();
		parse_str($resp, $result_array);
		self::log("[INFO]: ConfirmationCode: " . print_r($result_array, true));
		update_post_meta($order->get_id(), self::YAADPAY_TOKEN_PAYMENT, iconv('cp1255', 'UTF-8', $resp));

		if ($this->is_token_payment_error($result_array)) {
			$order->add_order_note(__('Yaadpay payment failed, ConfirmationCode: ', self::YAADPAY_TEXTDOMAIN) . $result_array['CCode']);
			return new WP_Error('Token payment failed', __('Token payment failed. Confirmation Code: ', self::YAADPAY_TEXTDOMAIN) . $result_array['CCode']);
		} else {
			$order->payment_complete();
		}

		return $result_array['CCode'];
	}

	/**
	 * @param int $order_id
	 * @param string $transaction_id
	 * @return string|WP_Error
	 */
	public function process_postpone_payment($order_id, $transaction_id)
	{
		self::log("[INFO]: " . __FUNCTION__ . " Start");
		$order = tb_wc_object::factory(tb_wc_object::ORDER, $order_id);

		$yaadpay_args = $this->collect_yaad_args($order, false);

		$this->build_yaad_postpone_args($yaadpay_args, $order_id, $transaction_id);
		$this->unset_postpone_payment_type($yaadpay_args);
		$resp = $this->send_payment_request($yaadpay_args);

		$result_array = array();
		parse_str($resp, $result_array);
		self::log("[INFO]: ConfirmationCode: " . print_r($result_array, true));
		update_post_meta($order->get_id(), self::YAADPAY_POSTPONE_PAYMENT, iconv('cp1255', 'UTF-8', $resp));

		if ($this->is_token_payment_error($result_array)) {
			$order->add_order_note(__('Yaadpay payment failed, ConfirmationCode: ', self::YAADPAY_TEXTDOMAIN) . $result_array['CCode']);
			return new WP_Error('Postpone payment failed', __('Postpone payment failed. Confirmation Code: ', self::YAADPAY_TEXTDOMAIN) . $result_array['CCode']);
		} else {
			$order->payment_complete();
		}

		return $result_array['CCode'];
	}



	/**
	 * @return bool
	 */
	private function IS_WPMLS_SUPPORT()
	{
		return $this->supports('subscriptions') && $this->yaad_WPLMS_HK;
	}

	public function request_token_data_by_trans_id($transaction_id, $order_id, $l4digits = '', $yaad_user_id = '')
	{

		self::log('[INFO]: order_id: ' . $order_id);
		$url = $this->get_url();

		//		$transaction_id = sanitize_text_field($_GET['Id']);
		$fields = array(
			'Masof'		=>	$this->decide_which_masof($order_id), //$this->yaad_termNo,
			'action' 	=> 'getToken',
			'TransId' 	=> $transaction_id,
			'UserId'    => 'True',
			'PassP'     => $this->decide_which_passp($order_id),
		);

		$string = '';
		foreach ($fields as $key => $val) {
			$string .= "$key=$val&";
		}
		self::log('[INFO] Token request: ' . $string);

		$result = wp_remote_post(
			$url,
			array(
				'method'      => 'POST',
				'timeout'     => 45,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => array(),
				'body'        => $fields,
				'cookies'     => array()
			)
		);

		if (is_wp_error($result)) {
			self::log(sprintf('[ERROR]: %s', $result->get_error_message()));
			throw new Exception(__('Unable to proceed with checkout.', self::YAADPAY_TEXTDOMAIN));
		} else {
			$token_result = array();
			parse_str($result['body'], $token_result);
			self::log('[DEBUG] Token response: ' . print_r($token_result, true));
			if ((int) $token_result['CCode'] == 0) {
				update_post_meta($order_id, self::YAADPAY_TOKEN, $token_result['Token']);
				update_post_meta($order_id, self::YAADPAY_ID, $token_result['Id']);
				update_post_meta($order_id,  self::YAADPAY_TOKEF_YEAR, '20' . substr($token_result['Tokef'], 0, 2));
				update_post_meta($order_id, self::YAADPAY_TOKEF_MONTH, (int) substr($token_result['Tokef'], 2, 2));

				$order = tb_wc_object::factory(tb_wc_object::ORDER, (int) $order_id);
				$user_id = $order->get_user_id();
				self::log('[INFO] user id: ' . print_r($user_id, true));
				if ($this->yaad_allow_saved_cc && $user_id) {
					$this->update_user_token($user_id, $token_result['Token'], (int) substr($token_result['Tokef'], 2, 2), '20' . substr($token_result['Tokef'], 0, 2), $l4digits, $yaad_user_id);
				} else {
					self::log('[INFO] user not found. order id: ' . $order_id);
				}
				return true;
			} else {
				$admin_email = get_option('admin_email');
				wp_mail($admin_email, 'Token generation failed', 'failed to generate token for transaction : ' . $transaction_id);
			}
		}
		return false;
	}

	/**
	 * @param string $l4disgits
	 * @return bool
	 */
	private function save_token_data($l4disgits)
	{
		$order_id = sanitize_text_field($_GET['Order']);
		$transaction_id = sanitize_text_field($_GET['Id']);
		$user_id = sanitize_text_field($_GET['UserId']);
		return $this->request_token_data_by_trans_id($transaction_id, $order_id, $l4disgits, $user_id);
	}

	private function build_yaad_token_args(&$yaadpay_args, $order_id, $yaadpay_token, $yaadpay_expiration_month, $yaadpay_expiration_year)
	{
		$yaadpay_args['Token'] = 'True';
		$yaadpay_args['moreDateFromToken'] = 'True';
		$yaadpay_args['CC'] = $yaadpay_token;
		$yaadpay_args['Tmonth'] = $yaadpay_expiration_month;
		$yaadpay_args['Tyear'] = $yaadpay_expiration_year;
		$yaadpay_args['PassP'] = $this->decide_which_passp($order_id); //$this->yaad_PassP;
		$yaadpay_args['action'] = 'soft';

		//$yaadpay_args['SendHesh']='False';
		//unset($yaadpay_args['heshDesc']);
		//unset($yaadpay_args['Pritim']);

	}

	private function build_yaad_postpone_args(&$yaadpay_args, $order_id, $transaction_id)
	{
		// TODO: SET CORRECT PARAMS:
		// action=commitTrans&Masof=0010020610&TransId=5343635&SendHesh=True&heshDesc=תשלום עבור הזמנה 1234&UTF8=True&UTF8out=True
		$yaadpay_args['Masof'] 	  = $this->decide_which_masof($order_id);
		$yaadpay_args['PassP']	  = $this->decide_which_passp($order_id);
		$yaadpay_args['TransId']  = $transaction_id;
		$yaadpay_args['SendHesh'] = 'True';
		$yaadpay_args['UTF8']     = 'True';
		$yaadpay_args['sendHeshSMS'] = 'True';
		$yaadpay_args['action']	  = 'commitTrans';

		// $yaadpay_args['CC']=$yaadpay_token;
		// $yaadpay_args['Tmonth']=$yaadpay_expiration_month;
		// $yaadpay_args['Tyear']=$yaadpay_expiration_year;
		// $yaadpay_args['moreDateFromToken']='True';

		//unset($yaadpay_args['heshDesc']);
		//unset($yaadpay_args['Pritim']);
	}

	private function build_yaadpay_args_for_renewal(tb_wc_order $order, $amount_to_charge)
	{
		self::log(__FUNCTION__ . ' Start');

		$subscription =	reset(wcs_get_subscriptions_for_renewal_order($order->get_id()));
		$parent_order_wc = $subscription->order;

		/** @var tb_wc_order $parent_order */
		$parent_order = tb_wc_object::factory(tb_wc_object::ORDER, $parent_order_wc);

		self::log("[INFO]: parent_order_id : " . $parent_order->get_id());

		$yaadpay_args = $this->collect_yaad_args($order, false);

		$this->unset_j5_payment_type($yaadpay_args);

		$yaadpay_token = get_post_meta($parent_order->get_id(), self::YAADPAY_TOKEN, true);
		self::log("[INFO]: yaadpay_token : " . $yaadpay_token);

		$yaadpay_expiration_month = get_post_meta($parent_order->get_id(), self::YAADPAY_TOKEF_MONTH, true);
		self::log("[INFO]: yaadpay_expiration_month : " . $yaadpay_expiration_month);

		$yaadpay_expiration_year = get_post_meta($parent_order->get_id(), self::YAADPAY_TOKEF_YEAR, true);
		self::log("[INFO]: yaadpay_expiration_year : " . $yaadpay_expiration_year);

		$this->build_yaad_token_args($yaadpay_args, $parent_order->get_id(), $yaadpay_token, $yaadpay_expiration_month, $yaadpay_expiration_year, $this->get_yaadpay_user_id($parent_order->get_id()));

		$yaadpay_args['UserId'] = $this->get_yaadpay_user_id($parent_order->get_id());

		self::log("[INFO]: yaadpay_args : " . print_r($yaadpay_args, true));

		return $yaadpay_args;
	}

	private function get_yaadpay_user_id($order_id)
	{
		$arg = get_post_meta($order_id, self::YAADPAY_CC_PAYMENT, true);
		$args_array = array();
		parse_str($arg, $args_array);
		if (isset($args_array['UserId'])) {
			return $args_array['UserId'];
		}
		return 'L' . $order_id;
	}

	private function get_yaadpay_transaction_id($order_id)
	{
		$arg = get_post_meta($order_id, self::YAADPAY_CC_PAYMENT, true);
		$args_array = array();
		parse_str($arg, $args_array);
		if (isset($args_array['Id'])) {
			return $args_array['Id'];
		}
		return '';
	}

	/**
	 * @param array $yaadpay_args
	 * @return void
	 */
	public function unset_j5_payment_type(&$yaadpay_args)
	{
		if (isset($yaadpay_args[self::YAAD_J5])) {
			$yaadpay_args[self::YAAD_J5] = 'False';
		}
	}

	public function unset_postpone_payment_type(&$yaadpay_args)
	{
		if (isset($yaadpay_args[self::YAAD_POSTPONE])) {
			$yaadpay_args[self::YAAD_POSTPONE] = 'False';
		}
	}

	public function send_payment_request($yaadpay_args)
	{

		$url = $this->get_url();

		$string = '';
		foreach ($yaadpay_args as $key => $val) {
			$string .= "$key=$val&";
		}

		self::log('[INFO]: url: ' . $url);
		self::log('[INFO]: request string: ' . $string);

		$yaad_post_result = wp_remote_post(
			$url,
			array(
				'method'      => 'POST',
				'timeout'     => 45,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => array(),
				'body'        => $yaadpay_args,
				'cookies'     => array()
			)
		);

		if (is_wp_error($yaad_post_result)) {
			self::log('[INFO]: send_payment_request - wp_remote_post failure: ' . $yaad_post_result->get_error_message());
			$result = false;
		} else {
			// self::log('[INFO]: curl success: ' . print_r($yaad_post_result, true));
			$result = $yaad_post_result['body'];
		}
		self::log(sprintf('[INFO]: response length: %s, type: %s', strlen($result), gettype($result)));
		self::log($result);
		// self::log("[INFO]: result: " .iconv("cp1255","UTF-8",$result ));


		return $result;
	}

	/**
	 * @param int $order_id
	 * @return string
	 */
	private function decide_which_masof($order_id)
	{
		$current_user = wp_get_current_user();
		$logged_in_as_admin = user_can($current_user, 'administrator');
		$test_term = get_post_meta($order_id, self::YAADPAY_TEST_TERM_META, true);
		if ($test_term != '') {
			return $test_term;
		}
		if ($logged_in_as_admin && $this->use_test_term) {
			WC_Gateway_Yaadpay::log(sprintf("Order id %s will be charged using TEST Terminal", $order_id));
			update_post_meta($order_id, self::YAADPAY_TEST_TERM_META, self::TEST_TERM);
			return self::TEST_TERM;
		}
		return $this->yaad_termNo;
	}

	/**
	 * @param int $order_id
	 * @return string
	 */
	private function decide_which_passp($order_id)
	{
		$current_user = wp_get_current_user();
		$logged_in_as_admin = user_can($current_user, 'administrator');
		$test_term = get_post_meta($order_id, self::YAADPAY_TEST_TERM_META, true);
		if (($test_term != '') || ($logged_in_as_admin && $this->use_test_term)) {
			return self::TEST_PassP;
		}
		return $this->yaad_PassP;
	}

	/**
	 * @param tb_wc_order $order
	 * @param bool $is_trial
	 * @return array|mixed
	 */
	public function collect_yaad_args($order, $is_trial)
	{

		self::log('[INFO]' . __FUNCTION__ . ': ' . print_r($order->get_WC_order(), true));

		self::log('[INFO]: order fees: ' . print_r($order->get_fees(), true));

		$total        = $is_trial ? '1' : $order->get_total();

		$billing_city = $order->get_billing_city();
		$billing_address = $order->get_billing_address_1() . ' ' . $order->get_billing_address_2();
		$billing_last_name = $order->get_billing_last_name() . $this->demo_text;
		$billing_first_name = $order->get_billing_first_name() . $this->demo_text;
		$yaadpay_args = array(
			'action'      => 'pay',
			'Info'        => __('Order', self::YAADPAY_TEXTDOMAIN) . ' ' . $order->get_id() . $this->demo_text,
			'Amount'      => $total,
			'Order'       => $order->get_id(),
			'email'       => $order->get_billing_email(),
			'ClientName'  => $billing_first_name,
			'ClientLName' => $billing_last_name,
			'street'      => empty($billing_address) ? 'N/A' : $billing_address,
			'city'        => empty($billing_city) ? 'N/A' : $billing_city,
			'zip'         => $order->get_billing_postcode(),
			'cell'        =>  $order->get_billing_phone(),
			'UserId'      => 'L' . $order->get_id(),
			'Sign'        => 'True',
			'MoreData'    => 'True',
			'BOF'         => 'True',
			'tmp'         => $this->yaad_template
		);

		$yaadpay_args["Masof"] = $this->decide_which_masof($order->get_id());
		$yaadpay_args["PassP"] = $this->decide_which_passp($order->get_id());

		$language                 = $this->get_language();
		$yaadpay_args['PageLang'] = $language;
		$yaadpay_args['UTF8']     = 'True';
		$yaadpay_args['Coin']     = $this->get_currency();


		$yaadpay_args = $this->add_j5_support($yaadpay_args, $is_trial, $order->get_id());
		$yaadpay_args = $this->add_postpone_support($yaadpay_args, $is_trial, $order->get_id());
		$yaadpay_args = $this->add_english_messages_support($language, $yaadpay_args);
		$yaadpay_args = $this->add_payments($order, $yaadpay_args);
		if (false == $is_trial) {
			$yaadpay_args = $this->add_invoice_information($order, $yaadpay_args);
			//				if ( $this->IS_WPMLS_SUPPORT() ) {
			//					$yaadpay_args = $this->add_wplms_support( $order, $yaadpay_args );
			//				}
		}

		return $yaadpay_args;
	}

	/**
	 * @return string
	 */
	public function get_url()
	{
		return $this->startsWith($this->yaad_termNo, '88') ? YAAD_LEUMI_GATEWAY_URL : YAAD_GATEWAY_URL;
	}

	private function validate_signature($order)
	{
		if ($this->check_yaad_signature($order) == false) {
			WC_Gateway_Yaadpay::log("possible fraud transaction");
			$payment_error = __('Payment failure, signature mismatch', self::YAADPAY_TEXTDOMAIN);
			wp_die($payment_error);
		}
	}


	private function save_query(tb_wc_order $order)
	{
		$query_vars = $_SERVER['QUERY_STRING'];
		$query_vars = str_replace('wc-api=WC_Gateway_Yaadpay&', '', $query_vars);
		update_post_meta($order->get_id(), self::YAADPAY_CC_PAYMENT, $query_vars);
		return $this->extract_l4digits($query_vars);
	}

	private function extract_l4digits($yaad_query_vars)
	{
		$args_array = array();
		parse_str($yaad_query_vars, $args_array);
		return $args_array['L4digit'];
	}

	/**
	 * @param tb_wc_order $order
	 */
	private function save_hk_data($order)
	{
		$HKId = isset($_GET['HKId']) ? (int) sanitize_text_field($_GET['HKId']) : '';
		if ($HKId != '') {
			update_post_meta($order->get_id(), 'HKId', $HKId);
		}
	}

	/**
	 * @param $order
	 * @param $text
	 * @return string
	 */
	private function process_successful_order(tb_wc_order $order, $text)
	{
		self::log("Amount :" . sanitize_text_field($_GET['Amount']));
		$order->add_order_note(__($text, self::YAADPAY_TEXTDOMAIN));
		$l4digits = $this->save_query($order);
		$this->save_hk_data($order);
		WC()->cart->empty_cart();
		return $l4digits;
	}


	private function process_error()
	{
		$payment_error = __('Payment failure, please try again or contact the store administrator', self::YAADPAY_TEXTDOMAIN);
		$payment_error .= '<br>';
		$payment_error .= sprintf(__('Click <a href="%s">here </a>to return to the checkout page.', self::YAADPAY_TEXTDOMAIN), wc_get_checkout_url());
		wp_die($payment_error);
	}

	/**
	 * @param $result_array
	 *
	 * @return bool
	 */
	private function is_token_payment_error($result_array)
	{
		return ((int) $result_array['CCode'] != 0) ? true : false;
	}

	/**
	 * @param int $user_id
	 * @return array
	 */
	public function get_user_meta_data($user_id)
	{
		$usr_token_data = array();
		$usr_token_data[self::YAADPAY_TOKEN_USER] = get_user_meta($user_id, self::YAADPAY_TOKEN_USER, true);
		$usr_token_data[self::YAADPAY_TYEAR_USER] = get_user_meta($user_id, self::YAADPAY_TYEAR_USER, true);
		$usr_token_data[self::YAADPAY_TMONTH_USER] = get_user_meta($user_id, self::YAADPAY_TMONTH_USER, true);
		$usr_token_data[self::YAADPAY_CC_LAST4_USER] = get_user_meta($user_id, self::YAADPAY_CC_LAST4_USER, true);
		return $usr_token_data;
	}

	public function payment_fields()
	{
		$token = get_user_meta(get_current_user_id(), self::YAADPAY_TOKEN_USER, true);
		$this->log("[INFO]: yaadpay token: " . $token);

		if (($token == '') || ($this->yaad_allow_saved_cc == false)) {
			echo $this->description;
			return;
		}
		$arr = array();
		if (isset($_POST['post_data'])) {
			parse_str($_POST['post_data'], $arr);
		}
		foreach ($arr as $key => $value) {
			$arr[$key] = sanitize_textarea_field($value);
		}
		$credit_card_type = isset($arr['credit_card_type']) == false ? 'new' : $arr['credit_card_type'];

		$new_checked = $credit_card_type == 'new' ? ' checked="checked"' : '';
		$saved_checked = '';

		$saved_disabled = 'disabled="disabled" style="background-color: lightgray;"';
		if ($credit_card_type == 'saved') {
			$saved_checked = 'checked="checked"';
			$saved_disabled = '';
		}

		echo '<input type="radio" style="display:inline" ' . $new_checked . ' id="credit_card_type_new" name="credit_card_type" value="new" onclick="
				document.getElementById(\'yaad_payments\').disabled = true;
				document.getElementById(\'yaad_payments\').style.backgroundColor = \'lightgray\'">'
			. __('New credit card', self::YAADPAY_TEXTDOMAIN) . '</input >';


		echo '<br>';
		echo '<input type="radio" style="display:inline" id="credit_card_type_saved"  name="credit_card_type"  ' . $saved_checked . '  value="saved" onclick="
				document.getElementById(\'yaad_payments\').disabled = false;
				document.getElementById(\'yaad_payments\').style.backgroundColor = \'white\'">'
			. __('Saved credit card that ends with : ', self::YAADPAY_TEXTDOMAIN) . get_user_meta(get_current_user_id(), self::YAADPAY_CC_LAST4_USER, true) . '
				</input >';


		echo '<br>';

		echo '<div id="saved_cc_area" style=" padding-right: 30px;">';
		$maxPayments = $this->get_max_payments($this->get_order_total());
		$this->log("[INFO]: Max payments : " . $maxPayments);

		if ($maxPayments == 1) return;

		$post_payments = isset($arr['payments']) ? $arr['payments'] : 1;

		_e('please select the number of payments', self::YAADPAY_TEXTDOMAIN);
		echo '<br>';
		echo '<label for="yaad_payments">' . __('Payments : ', self::YAADPAY_TEXTDOMAIN) . '</label><select id="yaad_payments" name="yaad_payments" ' . $saved_disabled . '>';
		for ($i = 1; $i <= $maxPayments; $i++) {
			$selected = $post_payments == $i ? ' selected ' : '';
			echo '<option ' . $selected . ' value=' . $i . '>' . $i . '</option>';
		}
		echo '</select>';

		echo '<div>';
	}
}




function yaad_break_out_of_frames()
{
	if (!is_preview()) {
		echo "\n<script type=\"text/javascript\">";
		echo "\n<!--";
		echo "\nif (window != top) {top.location.href = location.href;";
		echo "\nwindow.stop();";
		echo "\nif ($.browser.msie) {document.execCommand('Stop');}}";
		echo "\n-->";
		echo "\n</script>\n\n";
	}
}



add_action('wp_ajax_yaadpay_view_log',  'yaadpay_view_log_callback');

function yaadpay_view_log_callback()
{
	$logs_base_dir = WP_CONTENT_DIR . '/uploads/wc-logs/';
	if (is_multisite()) {
		$logs_base_dir = WP_CONTENT_DIR . '/uploads/sites/' . get_current_blog_id() . '/wc-logs/';
	}
	$logs          = glob( $logs_base_dir . '10bit-woocommerce-gateway-yaad*.log');
	$data = '';
	if (empty($logs) == false) {
		foreach($logs as $log) {
			$handle = fopen($log, "r");
			if ($handle) {
				while (($line = fgets($handle)) !== false) {
					$data 	.=	$line . '<br>';
				}
			}
			fclose($handle);
		}
	}
	die($data);
}

add_action('wp_ajax_yaadpay_delete_log',  'yaadpay_delete_log_callback');


function yaadpay_delete_log_callback()
{
	$logs_base_dir = WP_CONTENT_DIR . '/uploads/wc-logs/';
	if (is_multisite()) {
		$logs_base_dir = WP_CONTENT_DIR . '/uploads/sites/' . get_current_blog_id() . '/wc-logs/';
	}
	$logs          = glob($logs_base_dir . '10bit-woocommerce-gateway-yaadpay*.log');
	if (empty($logs) == false) {
		foreach($logs as $log) {
			unlink($log);
		}
	}
	die();
}

//function foo(){
//	WC_Gateway_Yaadpay::log('foo');
//}
//
//add_action( 'woocommerce_scheduled_subscription_payment_yaadpay' ,'foo',10,2 );

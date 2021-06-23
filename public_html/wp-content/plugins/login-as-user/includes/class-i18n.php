<?php
/* ======================================================
 # Login as User for WordPress - v1.4.0 (free version)
 # -------------------------------------------------------
 # For WordPress
 # Author: Web357 (Yiannis Christodoulou)
 # Copyright @ 2009-2021 Web357. All rights reserved.
 # License: GNU/GPLv3, http://www.gnu.org/licenses/gpl-3.0.html
 # Website: https:/www.web357.com
 # Demo: https://demo.web357.com/wordpress/login-as-user/wp-admin/
 # Support: support@web357.com
 # Last modified: Thursday 08 April 2021, 04:42:50 AM
 ========================================================= */
/**
 * Define the internationalization functionality
 */
class LoginAsUser_i18n {

	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'login-as-user',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages'
		);

	}
}
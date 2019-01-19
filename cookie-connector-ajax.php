<?php

add_action( 'wp_enqueue_scripts' , 'cookie_connector_secure_ajax', 10, 1 );
add_action( 'bb_logic_enqueue_scripts' , 'cookie_connector_js_translations', 50, 1 );

/**
 * Add Cookie Connector with secured access
 * add cookie security nonce that gets checked on call
 * @return [type] [description]
 */
function cookie_connector_secure_ajax() {
	wp_enqueue_script(
	  'cookie-connect-security',
	  COOKIECONNECTOR_URL . 'js/cookieconnector.js',
	  [ 'jquery' ],
	  false,
	  true
	);

	wp_localize_script(
	  'cookie-connect-security',
	  'cookie_ajax_object',
	  [
	    'ajax_url'  => admin_url( 'admin-ajax.php' ),
	    'security'  => wp_create_nonce( 'cookie-security-nonce' ),
	  ]
	);

}

/**
 * Add translation for Beavers Conditional Logic Modal
 * @return [type] [description]
 */
function cookie_connector_js_translations() {
	wp_localize_script(
	  'bb-logic-rules-cookie-connector',
	  'cookie_js_translations',
	  [
	    '__' => [
		    'cookie_value' => __( 'Cookie Value' , 'cookie-connector' ),
		    'cookie_connector' => __( 'Cookie Connector' , 'cookie-connector' ),
		    'cookie_name' => __( 'Cookie Name' , 'cookie-connector' ),
		    'cookie_value' => __( 'Value' , 'cookie-connector' ),
		    'expired_return_value' => __( 'Expired Return Value' , 'cookie-connector' ),
		]
	  ]
	);

}

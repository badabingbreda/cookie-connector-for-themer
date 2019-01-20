<?php

add_action( 'wp_ajax_setlanguage' , 'cookie_connector_set_my_cookie' );
add_action( 'wp_ajax_nopriv_setlanguage' , 'cookie_connector_set_my_cookie' );
add_action( 'wp_ajax_unsetlanguage' , 'cookie_connector_set_my_cookie' );
add_action( 'wp_ajax_nopriv_unsetlanguage' , 'cookie_connector_set_my_cookie' );


/**
 * Set the cookie, check for security nonce first
 * check for accepted cookie compliance from Cookie Notice plugin (we don't want to piss people off)
 *
 * Set the cookie using
 * cn (cookie name)
 * cv (cookie value)
 * valid (validity in seconds)
 *
 */
function cookie_connector_set_my_cookie() {

	// first check if this ajax call is
	// done using the script belonging to the installation
	//
	if( ! check_ajax_referer( 'cookie-security-nonce' , 'security' ) ) {

		wp_send_json_error( 'Invalid security token sent.' );

		wp_die();
	}

	// Check if visitor has accepted the cookies from Cookie Notice plugin
	// If you're using another plugin, you should write your own check here
	if ( !function_exists('cn_cookies_accepted') || !cn_cookies_accepted() ) {

	    wp_die();

	}

	if ( !defined( 'DOING_AJAX' ) ) define( 'DOING_AJAX' , TRUE );

	// set your cookie name here
	$cookie_name = 'mylanguage';
	$default_validity = 60 * 60;

	// try to get the cookie_value
 	$cookie_value = isset( $_GET['cv'] ) ? $_GET['cv'] : false;

 	// try to get the cookie validity period. If not default to default validity
 	$cookie_valid = isset( $_GET['valid'] ) ? $_GET['valid'] : $default_validity;


	// if the action is setlanguage we need a cookie_value (cv) because else it will fail. Check for it and return an error if there isn't one.
	if ( ! $cookie_value && $_GET['action'] == 'setlanguage' ) {

		wp_send_json_error( array( 'success' => false, 'error' => '402', 'message' => __( 'cookie not set, no value given. ( cv )' , 'cookie-connector' ) ) );

		wp_die();
	}


 	// check action parameter
 	// UNSET language
 	if ( 'unsetlanguage' == $_GET['action'] ) {

	 	setcookie( $cookie_name , 'unset value' , time() - 1 , COOKIEPATH, COOKIE_DOMAIN , isset($_SERVER["HTTPS"]) );

 		wp_send_json( array( 'success' => true, 'message' => __( "Done unsetting cookie '{$cookie_name}'." , 'cookie-connector' ) ) );

 	// check action parameter
 	// SET language
 	} else if ( 'setlanguage' == $_GET['action'] ) {

	 	setcookie( $cookie_name , $cookie_value , time() + $cookie_valid , COOKIEPATH, COOKIE_DOMAIN , isset($_SERVER["HTTPS"]), true );

 		wp_send_json( array( 'success' => true, 'message' => __( "Done setting cookie '{$cookie_name}' to value '{$cookie_value}' with validity $cookie_valid seconds." , 'cookie-connector' ) ) );
 	}

 	wp_die();
}

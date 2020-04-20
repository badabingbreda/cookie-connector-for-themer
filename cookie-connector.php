<?php
/**
 Plugin Name: Cookie Connector for Themer
 Description: Cookie Connector & Conditional Logic for Beaver Themer. Use Site Cookie for Queries and set Conditional Logic rules using Site Cookies.
 Version: 1.1.0
 Author: Didou Schol
 Text Domain: cookie-connector
 Domain Path: /languages
 Author URI: https://www.badabing.nl
 */

define( 'COOKIECONNECTOR_VERSION' 	, '1.1.0' );
define( 'COOKIECONNECTOR_DIR'		, plugin_dir_path( __FILE__ ) );
define( 'COOKIECONNECTOR_FILE'		, __FILE__ );
define( 'COOKIECONNECTOR_URL' 		, plugins_url( '/', __FILE__ ) );

// include the Conditional Logic rules
include_once( 'easy-bb-logic.php' );

// include the connector ajax
include_once( 'cookie-connector-ajax.php' );

// include the cookie-connector class
include_once( 'classes/class-cookie-connector.php' );

// setup textdomain for future translations
add_action( 'plugins_loaded', 'cookie_connector_setup_textdomain' );

// init the Connector for Cookies
add_action( 'init' , 'cookie_connector::init', 99, 1 );


/**
 * Function to load the textdomain
 * @return void
 * @since  1.1
 */
function cookie_connector_setup_textdomain(){
	//textdomain
	load_plugin_textdomain( 'cookie-connector', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}

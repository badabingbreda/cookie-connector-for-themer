<?php
/**
 * @package cookie connector for themer
 * @since 1.0.0
 */

/**
 * Check if the Theme Builder / Beaver Themer is 1.2 or higher
 */
if ( defined( 'FL_THEME_BUILDER_VERSION' ) && version_compare( FL_THEME_BUILDER_VERSION, '1.2', '>=' ) ) {

	add_action( 'bb_logic_init'				,  function() {
		require_once COOKIECONNECTOR_DIR . 'rules/cookie_connector/classes/class-bb-logic-rules-cookie-connector.php';
	});

	add_action( 'rest_api_init' 			, function() {
		require_once COOKIECONNECTOR_DIR . 'rest/classes/class-bb-logic-rest-cookie-connector.php';
	} );

	add_action( 'bb_logic_enqueue_scripts'	, function() {
		wp_enqueue_script(
			'bb-logic-rules-cookie-connector',
			COOKIECONNECTOR_URL . 'rules/cookie_connector/build/index.js',
			array( 'bb-logic-core' ),
			COOKIECONNECTOR_VERSION,
			true

		);
	});


}

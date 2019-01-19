<?php

/**
 * REST API methods to retreive data for WordPress rules.
 *
 * @since 0.1
 */
final class BB_Logic_REST_Cookie_Connector {

	/**
	 * REST API namespace
	 *
	 * @since 0.1
	 * @var string $namespace
	 */
	static protected $namespace = 'bb-logic/v1/cookieconnector';

	/**
	 * Register routes.
	 *
	 * @since  0.1
	 * @return void
	 */
	static public function register_routes() {

		// register_rest_route(
		// 	self::$namespace, '/your_command', array(
		// 		array(
		// 			'methods'  => WP_REST_Server::READABLE,
		// 			'callback' => __CLASS__ . '::your_command',
		// 		),
		// 	)
		// );

	}

	/**
	 * Returns an array of posts with each item
	 * containing a label and value.
	 *
	 * @since  0.1
	 * @param object $request
	 * @return array
	 */
	static public function your_command( $request ) {

		$response = array();

		/**
		 * get something
		 * because
		 */
		foreach ( array() as $item ) {
			$response[] = array(
				'label' => $item['label'],	// pretty name
				'value' => $item['name'],	// field_type
			);
		}

		//$response = array( array( 'label'=> 'field 1', 'value'=>'field1' ), array( 'label'=> 'field 2', 'value'=>'field2' ) );

		return rest_ensure_response( $response );
	}

}

BB_Logic_REST_Cookie_Connector::register_routes();

<?php
/**
 * Server side processing for ACF rules.
 *
 * @since 0.1
 */
final class BB_Logic_Rules_Cookie_Connector {
	/**
	 * Sets up callbacks for conditional logic rules.
	 *
	 * @since  0.1
	 * @return void
	 */
	static public function init() {
		BB_Logic_Rules::register( array(
			'cookieconnector/cookie' 		=> __CLASS__ . '::evaluate_rule',
		) );

	}
	/**
	 * Process an Esay ACF rule based on the object ID of the
	 * field location.
	 *
	 * @since  0.1
	 * @param string $object_id
	 * @param object $rule
	 * @return bool
	 */
	static public function evaluate_rule( $rule ) {

		$value = isset( $_COOKIE[ $rule->key ] ) ? $_COOKIE[ $rule->key ] : false;

		if ( is_array( $unserialized_value = json_decode( $value , true ) ) ) $value = $unserialized_value;

		if ( !isset( $_COOKIE[ $rule->key ] ) ) $value = $rule->expiredval;

		return BB_Logic_Rules::evaluate_rule( array(
			'value' 	=> $value,
			'operator' 	=> $rule->operator,
			'compare' 	=> $rule->compare,
			'isset'		=> $_COOKIE[ $rule->key ],
		) );
	}

}
BB_Logic_Rules_Cookie_Connector::init();

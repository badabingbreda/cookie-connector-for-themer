<?php

class cookie_connector {

	/**
	 * Plugin init
	 * @return void
	 */
	public static function init() {

		// check if Theme Builder / Beaver Themer is installed and actived
		if ( class_exists( 'FLThemeBuilder' ) ) {
			// add the actual field connector to themer
			add_action( 'fl_page_data_add_properties' ,  __CLASS__ . '::add_cookie_connector' );
			return false;
		}
		/* removed admin_notice, can be used without Themer for classes and script if needed */
		// add_action( 'admin_notices' , __CLASS__ . '::cookie_connector_admin_error_need_theme_builder' );

	}

	/**
	 * Admin area notice that flbuilder is not installed and/or activated
	 * @return [type] [description]
	 */
	function cookie_connector_admin_error_need_theme_builder() {
		$class = 'notice notice-error';
		$message = __( 'Sorry, in orde to use Cookie Connector you will need Beaver Theme Builder + Beaver Themer.', 'cookie-connector' );
		printf( '<div class="%s is-dismissible"><p>%s</p></div>', esc_attr( $class ), esc_html( $message ) );
	}


	/**
	 * function to add the acf connector to beaver themer
	 */
	public static function add_cookie_connector() {

		/**
		 *  Add a custom group
		 */
		FLPageData::add_group( 'cookie_connector', array(
			'label' => __( 'Cookie Connector', 'cookie-connector' )
		) );


		/**
		 *  Add a new property to custom group
		 */
		FLPageData::add_post_property( 'cookie_connector', array(
			'label'   => __( 'Cookie Value', 'cookie-connector' ),
			'group'   => 'cookie_connector',
			'type'    => 'string',
			'getter'  => array( __CLASS__ , 'get_cookie_value' ),
		) );

		FLPageData::add_post_property_settings_fields(
			'cookie_connector',
			array(
				'cookie_name' => array(
				    'type'          => 'text',
				    'label'         => __( 'Cookie Name', 'cookie-connector' ),
				    'default'       => '',
				    'maxlength'     => '',
				    'size'          => '15',
				    'placeholder'   => __( 'Cookie Name', 'cookie-connector' ),
				    'help'          => __( 'Enter the name of the cookie that you want to get.', 'cookie-connector' ),
					),
			)
		);

	}

	/**
	 * Get the cookie value
	 * @param  [type] $settings [description]
	 * @param  [type] $property [description]
	 * @return [type]           [description]
	 */
	public static function get_cookie_value ( $settings , $property ) {

		if ( isset( $settings->cookie_name ) ) {
			if ( isset( $_COOKIE[ $settings->cookie_name ] ) ) {
				return is_array( $unserialized_value = json_decode( $_COOKIE[ $settings->cookie_name ] , true ) ) ? $unserialized_value : $_COOKIE[ $settings->cookie_name ];
			} else {
				return '';
			}
		} else {
			return '';
		}

		return '';
	}
}

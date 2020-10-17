=== Cookie Connector For Themer ===
Contributors: badabingbreda
Donate link:
Tags: connector, cookie, beaver builder, beaver themer
Requires at least: 4.7
Tested up to: 5.5.1
Requires PHP: 5.6.3
Stable tag: 1.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Cookie Connector for (Beaver) Themer
====================================

### Plugin description
Cookie Connector for Beaver Themer is an unofficial addon-plugin for the popular Beaver Themer plugin. It allows you to read cookie-values using the Beaver Themer Connector and use Conditional Logic to hide/show seperate nodes (modules, columns and/or rows) using cookie values.

Cookie Connector also allows you to create cookies using an AJAX call. For security measures you will need to write the AJAX yourself, but an example file on how to do that can be found here, in the example folder:

[https://github.com/badabingbreda/cookie-connector-for-themer/](https://github.com/badabingbreda/cookie-connector-for-themer/)

**Using the Cookie Connector**
You can display the Cookie Connector wherever you'd normally insert it as a string, using either the *connect* or *insert* button.

**Using the Conditional Logic filter**
Because cookies have a certain validity, it can't return a value when the cookie isn't there or has become invalid. The Conditional Logic filter has an extra parameter to set a default value for whenever it doesn't return anything. Setting this parameter return that value whenever it doesn't exist.

**Writing cookies values**
Cookies are written before any headers are written to the visitor's browser. The downside to that is that cookies can only be read when the visitor's sends a request, since they are sent over WITH the request. This means that you can't write a cookie's value and immediately read that cookies new value, within a single run of a page-call.

To work around that, cookies can be written using an AJAX call.
"Cookie Connector for Themer" enqueues a script that registers the `cookieConnector` object, which handles the security and sending of requests.
Let's consider the following html-code that is used in a HTML module:

    <p><a href="javascript:cookieConnector.set( 'setmycookie' , { cv: 'my cookie value' , valid: 3600 } );">Set cookie value</a></p>
    <p><a href="javascript:cookieConnector.set( 'unsetmycookie' );">Unset cookie value</a></p>

The first parameter is the `actionname` that is going to be called in the PHP script, so in this example (see below) the part after 'wp_ajax_' and 'wp_ajax_nopriv_'.
You can also add an extra, optional, third parameter `debug` that will add a console.log dump of the response, should you need to know what's being answered:

    <p><a href="javascript:cookieConnector.set( 'setmycookie' , { cv: 'my cookie value' , valid: 3600 } , true );">Set cookie value</a></p>
    <p><a href="javascript:cookieConnector.set( 'unsetmycookie', {} , true );">Unset cookie value</a></p>

**Adding the PHP code to create/change/delete the cookie**
Clicking the link wil trigger an AJAX call that will set a cookie on the visitor's device, if their browser allows it.

On the server-side, you will need to add one or two ajax callbacks, depending if the call can be made without being logged in.

    <?php
        add_action( 'wp_ajax_setmycookie' , 'callback_setmycookie' );
        add_action( 'wp_ajax_nopriv_setmycookie' , 'callback_setmycookie' );
        add_action( 'wp_ajax_unsetmycookie' , 'callback_setmycookie' );
        add_action( 'wp_ajax_nopriv_unsetmycookie' , 'callback_setmycookie' );

        function callback_setmycookie() {
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
    		$default_validity = 60 * 60; // = 60 minutes

    		// try to get the cookie_value
    		$cookie_value = isset( $_GET['cv'] ) ? $_GET['cv'] : false;
    		// try to get the cookie validity period. If not default to default validity
    		$cookie_valid = isset( $_GET['valid'] ) ? $_GET['valid'] : $default_validity;

    		// if the action is setmycookie we need a cookie_value (cv) because else it will fail. Check for it and return an error if there isn't one.
    		if ( ! $cookie_value && $_GET['action'] == 'setmycookie' ) {
    		    wp_send_json_error( array( 'success' => false, 'error' => '402', 'message' => 'cookie not set, no value given. ( cv )' ) );
    		}

    		// check action parameter
    		// UNSET mycookie
    		if ( 'unsetmycookie' == $_GET['action'] ) {
    		 	setcookie( $cookie_name , 'unset value' , time() - 1 , COOKIEPATH, COOKIE_DOMAIN , isset($_SERVER["HTTPS"]) );
    		    wp_send_json( array( 'success' => true, 'message' => "Done unsetting cookie '{$cookie_name}'." ) );
    		} else if ( 'setmycookie' == $_GET['action'] ) {
    		    setcookie( $cookie_name , $cookie_value , time() + $cookie_valid , COOKIEPATH, COOKIE_DOMAIN , isset($_SERVER["HTTPS"]), true );
    		    wp_send_json( array( 'success' => true, 'message' => "Done setting cookie '{$cookie_name}' to value '{$cookie_value}' with validity $cookie_valid seconds." ) );

    		}
    		wp_die();
        }

It is advised to use wp_send_json with a 'success' parameter (either true or false) so that you check it in your javascript and add actions after sending the cookieConnector() command, for instance a reload of the page or forwarding to an url that you received from the server based on the click.
For instance, the javascript below will try to create the cookie. When successful it will display an alert on the browser and reload the page after 1.5 seconds.

    <script>
    		function cookie_trigger() {
    			jQuery.when( cookieConnector.set( 'setmycookie', { cv: jQuery( '#selectlanguage' ).val(), valid: 5 * 60 }, 1 ))
    	        .done( function( data ) {
	    	        if ( data.success ) {
    	                alert( data.message + '\r You can now safely shut down your browser, restart and visit this URL. This selectbox will reflect the last cookie value.' );
    	                setTimeout( function() { location.reload(); }, 1500);
    	            }
    	        });
    	    }
    </script>


**version history**

**1.2.0**

Removed admin_notice so that plugin can be used without Beaver Themer and Beaver Builder too (scripts), for ajax calls.

**1.1.0**

Updated the version because it works on WP 5.4 too

**1.0.1**

Updated example code

**1.0.0**

Initial release (January 18th, 2019)

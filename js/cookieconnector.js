/**
 * cookieConnector
 * @version  1.0.0
 * @author
 *
 * cookieConnector.set( 'mycookieaction' , { cn: 'cookie_name' , cv: 'cookie_value', valid: 60 * 60 } );
 * cookieConnector.unset( 'mycookieaction', { cn: 'cookie_name' } );
 *
 */
var cookieConnector = {
	set : function( action , _options , debug ) {

		var options = {
			cn: ('undefined' === typeof _options ) ? null: _options.cn,
			cv: ('undefined' === typeof _options ) ? null: _options.cv,
			valid: ('undefined' === typeof _options ) ? null: _options.valid
			}

		if ( !cookie_ajax_object.ajax_url ) {
			console.log( 'no cookie_ajax_object' );
			return false;
		}

		return this.get( action , options , debug );


	},
	unset: function( action , _options , debug ) {

		var options = {
			cn: ('undefined' === typeof _options ) ? null: _options.cn,
			cv: ('undefined' === typeof _options ) ? null: _options.cv,
			valid: ('undefined' === typeof _options ) ? null: _options.valid
			}

		if (!cookie_ajax_object.ajax_url ) {
			console.log( 'no cookie_ajax_object' );
			return false;
		}

		return this.get( action , options , debug );

	},
	get: function( action , options , debug ) {

		return jQuery.get( cookie_ajax_object.ajax_url , {
				action: action,
				security: cookie_ajax_object.security,
				cn: options.cn,
				cv: options.cv,
				valid: options.valid
		}, function (response ) {
			if ('undefined' !== response.success && false === response.success ) {
				if ( 'undefined' !== typeof debug ) console.log( response );
				//return response;
			}

			if ( 'undefined' !== typeof debug ) console.log( response.message );
			//return response;
		});

	}
}

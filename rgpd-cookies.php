<?php

/**
 * This file is part of the FoWeb package.
 *
 * (c) FoWeb Team
 */

use FoWeb\RgpdCookies\Shortcodes;
use FoWeb\RgpdCookies\Config;
use FoWeb\RgpdCookies\ContextInjector;
use FoWeb\RgpdCookies\Enqueueing;
use FoWeb\RgpdCookies\Api;

class RgpdCookies{

	public function __construct()
	{

		/**
		 * Check if Wordpress is loaded, FoWeb is currently made to work on a Wordpress environment.
		 * 
		 * @since 0.0.1
		 */		

		if ( ! \class_exists('\WP') )
		{

			// Just return, don't throw any error
			return;

		}

		
		/**
		 * Adding useful variables to the context
		 * 
		 * @since 0.0.1
		 */

		ContextInjector::addToContext();


		/**
		 * Adding css file using Wordpress function
		 * 
		 * @since 0.0.1
		 */

		add_action( 'wp_enqueue_scripts', array( 'FoWeb\RgpdCookies\Enqueueing', 'register'), 20 );


		/**
		 * Register Shortcodes on each requests
		 * 
		 * @since 0.0.1
		 */
		
		new Shortcodes();


		/**
		 * Register API endpoint
		 * 
		 * @since 0.0.1
		 */

		new Api();

	}


}


/**
 * Run FoWeb RGPD Cookies if "is_active" option is true
 * 
 * @since 0.0.1
 */


if(Config::getOption( "is_active" ) == true ){
	new RgpdCookies();
}







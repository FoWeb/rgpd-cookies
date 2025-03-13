<?php

/**
 * This file is part of the FoWeb package.
 *
 * (c) FoWeb Team
 */

namespace FoWeb\RgpdCookies;


use FoWeb\RgpdCookies\Config;


class Api{

	public function __construct(){

		
		// @ref https://wordpress.stackexchange.com/questions/382942/how-can-i-quickly-get-a-system-showing-the-uncaught-error-class-wp-site-healt
		if ( ! class_exists( 'WP_Site_Health' ) ) {
    		require_once ABSPATH . 'wp-admin/includes/class-wp-site-health.php';
		}

		\WP_Site_Health::get_instance();

		register_rest_route('fwrgpd', 'datas/', [
			'methods' => 'GET',
			'callback' => array($this, 'datas')
		]);


	}

	public function datas(){

		return json_encode(['config'       => Config::getConfigArray(),
							'popupContent' => do_shortcode('[fw_popup_content]')
						   ]);
	}




}
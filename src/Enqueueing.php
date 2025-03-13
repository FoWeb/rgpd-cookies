<?php

/**
 * This file is part of the FoWeb package.
 *
 * (c) FoWeb Team
 */

namespace FoWeb\RgpdCookies;


use FoWeb\RgpdCookies\Config;


class Enqueueing{

    public static function register()
    {

        if( true == Config::getOption( 'auto_register_style' ) || null === Config::getOption( 'auto_register_style' )){
            // Default style file
            $cssSrc = get_template_directory_uri() . '/vendor/foweb/rgpd-cookies/resources/assets/' . 'foweb_rgpd_cookies_style.css';

            // Check if custom style file exist
            if( Config::getOption( 'style' ) ){

                // If yes, replace the default one
                if( file_exists( get_template_directory() . Config::getOption( 'style' ) ) ){

                    $cssSrc = get_template_directory_uri() . Config::getOption( 'style' );
                }
            }

            // Register Style with WP function
            wp_register_style( 'FoWeb-RgpdCookies-Stylesheet', $cssSrc , [],  '0.0.1' , 'all' );

            // Enqueue Style with WP function
            wp_enqueue_style( 'FoWeb-RgpdCookies-Stylesheet' );
        }

        
        if( true == Config::getOption( 'auto_register_script' ) || null === Config::getOption( 'auto_register_script' )){

            $jsSrc = get_template_directory_uri() . '/vendor/foweb/rgpd-cookies/resources/assets/' . 'foweb_rgpd_cookies_script.js';

            if( Config::getOption( 'script' ) ){

                // If yes, replace the default one
                if( file_exists( get_template_directory() . Config::getOption( 'script' ) ) ){

                    $jsSrc = get_template_directory_uri() . Config::getOption( 'script' );
                }
            }

            // Register Script with WP function
            wp_register_script( 'FoWeb-RgpdCookies-Script', $jsSrc , [],  '0.0.1' , 'all' );

            // Enqueue Script with WP function
            wp_enqueue_script('FoWeb-RgpdCookies-Script');
        }
    }

}
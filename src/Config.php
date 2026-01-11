<?php

/**
 * This file is part of the FoWeb package.
 *
 * (c) FoWeb Team
 */

namespace FoWeb\RgpdCookies;


use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;


class Config{

    /**
     * Read and parse the config file
     *
     * @since 0.0.1
     */

    private static function readConfFile(): array
    {

        $defaultConfFile = dirname( __FILE__, 2 ) . '/resources/config/' . 'foweb_rgpd_cookies.yaml';

        try {

            $content = Yaml::parseFile( $defaultConfFile );
        
        } catch ( ParseException $exception ) {

            printf( 'Unable to parse the FoWeb RGPD default conf file: %s', $exception->getMessage() );
        
        }

        // Check if custom config exist

        $customConfFile = get_template_directory() . '/config/foweb_rgpd_cookies.yaml';

        if( file_exists( $customConfFile ) ){

            try {

                $contentCustomConfFile = Yaml::parseFile( $customConfFile );
            
            } catch ( ParseException $exception ) {

                printf( 'Unable to parse the FoWeb RGPD custom conf file: %s', $exception->getMessage() );
            
            }

            $content = array_replace_recursive($content, $contentCustomConfFile);
        }

        return $content;
    }

    /**
     * Get option from its name
     *
     * @since 0.0.1
     *
     * @param string $key The option name 
     */

    public static function getOption( string $key )
    {

        return self::readConfFile()['foweb_rgpd_cookies'][$key];
    }


    /**
     * Get all FoWeb RGPD Cookies options as an Array
     *
     * @since 0.0.1
     */

    public static function getOptions() : array
    {

        return self::readConfFile()['foweb_rgpd_cookies'];
    }


    /**
     * Final array to populate twig context
     *
     * @since 0.0.1
     */

    public static function getConfigArray(): array
    {
        $options = self::getOptions();
        $tmpSections = $options['sections'];
        $config = [];

        // Initial configuration setup
        $config['status']['as_to_be_displayed'] = false;
        $sections = [];

        // Iterate through each section
        foreach ($tmpSections as $section) {
            // Set cookie prefix and expiration days
            $prefix = $section['cookie_prefix'] ?? $options['cookies_prefix'];
            $section['expiration_days'] = $section['expiration_days'] ?? $options['expiration_days'];

            // Check if the cookie exists
            $cookieKey = $prefix . $section['key'];
            if (array_key_exists($cookieKey, $_COOKIE)) {
                // Set acceptance value and determine section values based on the cookie
                $section['acceptance_value'] = $section['acceptance_value'] ?? $options['acceptance_value'];
                $section['value']            = ($_COOKIE[$cookieKey] == $section['acceptance_value']);
                $section['raw_value']        = $section['value'] ? 2 : 1;
            } else {
                // Default values if the cookie does not exist
                $section['value']                       = false;
                $section['raw_value']                   = 0;
                $config['status']['as_to_be_displayed'] = true;
            }

            $sections[] = $section;
        }

        // Populate the final config array
        $config['sections']          = $sections;
        $config['site_privacy_page'] = $options['site_privacy_page'];
        $config['site_cookies_page'] = $options['site_cookies_page'];
        $config['cookies_prefix']    = $options['cookies_prefix'];
        $config['expiration_days']   = $options['expiration_days'];
        $config['domain']            = $options['domain'];
        $config['popup_title']       = $options['popup_title'];
        $config['popup_description'] = $options['popup_description'];

        return $config;
    }

}
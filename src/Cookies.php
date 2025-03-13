<?php

/**
 * This file is part of the FoWeb package.
 *
 * (c) FoWeb Team
 */

namespace FoWeb\RgpdCookies;


use FoWeb\RgpdCookies\Config;


class Cookies{


    /**
     * Public interface to retrieve the status of a cookie
     *
     * @since 0.0.1
     *
     * @param string $cookieKey The key of the Cookie, indicated in sections config part
     * 
     * @return boolean on acceptance status | default false
     */

    public static function Acceptance( string $cookieKey ) : bool
    {
        
        // Search for the index of $cookieKey within the 'sections' array in the configuration
        $key = array_search( $cookieKey, Config::getConfigArray()['sections'] );

        // Retrieve the 'value' associated with the found key in the 'sections' array
        $acceptanceStatus = Config::getConfigArray()['sections'][$key]['value'];

        // Check if the retrieved acceptance status is not true (false or falsy value)
        if ( ! boolval( $acceptanceStatus ) ) {
            // If not true, explicitly set $acceptanceStatus to false
            $acceptanceStatus = false;
        }

        // Return the acceptance status (either true or false)
        return $acceptanceStatus;
    }



}
<?php

/**
 * This file is part of the FoWeb package.
 *
 * (c) FoWeb Team
 */

namespace FoWeb\RgpdCookies;


use FoWeb\RgpdCookies\Config;

use FoWeb\RgpdCookies\Shortcodes;

use FoWeb\RgpdCookies\Test;


class ContextInjector{

    /**
     * Add all necessary variables to the context under the prefix fowebrgpd
     * 
     * @since 0.0.1
     * @return void 
     */


    public static function addToContext(): void
    {

        add_filter('timber/context', function ( $context ) {

            $context['fowebrgpd'] = Config::getConfigArray();

            return $context;
        });

    }


}
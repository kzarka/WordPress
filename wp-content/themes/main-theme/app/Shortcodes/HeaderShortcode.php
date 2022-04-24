<?php

namespace App\Shortcodes;

/**
 * TestShortcode
 */
class HeaderShortcode
{
    function __construct()
    {
        add_shortcode('header', array( $this, 'main' ));
    }

    public function main($atts)
    {
        renderTemplate('header/header');
    }
}



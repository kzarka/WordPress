<?php

namespace App\Shortcodes;

/**
 * TestShortcode
 */
class TestShortcode
{
    function __construct()
    {
        add_shortcode('test', array( $this, 'main' ));
    }

    public function main($atts)
    {
        $args = extract(shortcode_atts(array(
            'num' => null,
            'slide' => false,
        ), $atts));

        echo "num is" . $num;die;
    }
}



<?php

namespace App\Shortcodes;

/**
 * HeadingShortcode
 */
class HeadingShortcode
{
    function __construct()
    {
        add_shortcode('heading', array( $this, 'main' ));
    }

    public function main($atts)
    {
        $args = extract(shortcode_atts(array(
            'title' => 'HEADING',
            'desc' => '',
        ), $atts));

        return renderTemplateHTML('shortcodes/heading', ['title' => $title, 'desc' => $desc]);
    }
}



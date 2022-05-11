<?php

namespace App\Shortcodes;

/**
 * GalleryShortcode
 */
class GalleryShortcode
{
    function __construct()
    {
        add_shortcode('show_gallery', array( $this, 'main' ));
    }

    public function main($atts)
    {
        $args = extract(shortcode_atts(array(
            'title' => null,
        ), $atts));

        $slide = envira_get_gallery_attrs($atts);
    }
}



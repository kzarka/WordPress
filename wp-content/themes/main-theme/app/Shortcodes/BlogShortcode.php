<?php

namespace App\Shortcodes;

/**
 * BlogShortcode
 */
class BlogShortcode
{
    function __construct()
    {
        add_shortcode('blog', array( $this, 'main' ));
    }

    public function main($atts)
    {
    	$args = extract(shortcode_atts(array(
            'container' => true,
            'orderby' => 'new',
            'title' => 'Blog Posts',
            'desc' => ''
        ), $atts));

        renderTemplate('shortcodes/blog', [
            'data' => $data, 
            'container' => $container,
            'desc' => $desc,
            'title' => $title,
        ]);
    }
}



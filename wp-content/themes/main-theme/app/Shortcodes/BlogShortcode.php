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
        ), $atts));

        return renderTemplateHTML('shortcodes/blog', [
            'data' => $data, 
            'container' => $container,
            'desc' => $desc,
            'title' => $title,
        ]);
    }
}



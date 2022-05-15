<?php

namespace App\Shortcodes;

use App\Services\BlogService;
/**
 * BlogShortcode
 */
class BlogShortcode
{
    function __construct()
    {
        add_shortcode('blog', array( $this, 'main' ));
        $this->blogService = new BlogService();
    }

    public function main($atts)
    {
    	$args = extract(shortcode_atts(array(
            'container' => true,
            'orderby' => 'new',
            'limit' => 5,
            'desc' => ''
        ), $atts));

        $data = $this->blogService->getBlogPosts($limit); 
        return renderTemplateHTML('shortcodes/blog', [
            'data' => $data, 
            'container' => $container,
            'desc' => $desc,
            'title' => $title,
        ]);
    }
}



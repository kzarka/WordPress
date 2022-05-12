<?php

namespace App\Shortcodes;

use App\Services\ProductService;

/**
 * SliderShortcode
 */
class ProductShortcodes
{
    function __construct()
    {
        $this->productService = new ProductService;
        add_shortcode('shop_categories', array( $this, 'categoryProduct' ));
    }

    public function categoryProduct($atts)
    {
        extract( shortcode_atts( array(
            'container' => false,
            'title' => 'Featured Product',
            'desc' => '',
            'taxonomy' => ''
        ), $atts));

        $data = $this->productService->buildTopCategoryData($taxonomy);

        if (empty($data)) return;

        return renderTemplateHTML('shortcodes/category-product', ['container' => $container, 'title' => $title, 'desc' => $desc, 'data' => $data]);
    }
}



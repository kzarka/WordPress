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
        add_shortcode('product_featured', array( $this, 'featuredProduct' ));
        add_shortcode('shop_categories', array( $this, 'categoryProduct' ));
    }

    public function featuredProduct($atts)
    {
        extract( shortcode_atts( array(
            'container' => false,
            'title' => 'Featured Product',
            'desc' => ''
        ), $atts));

        renderTemplate('shortcodes/featured-product', ['container' => $container, 'title' => $title, 'desc' => $desc]);
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

        renderTemplate('shortcodes/category-product', ['container' => $container, 'title' => $title, 'desc' => $desc, 'data' => $data]);
    }
}



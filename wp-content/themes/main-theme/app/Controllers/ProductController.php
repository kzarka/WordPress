<?php

namespace App\Controllers;

/**
 * NavController
 */
class ProductController extends BaseController
{
	function __construct()
	{
		$this->registerHook();
	}

	public function registerHook()
	{
		add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
		remove_action( 'woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title', 10 );
		add_action('woocommerce_custom_product_loop_item', array($this, 'woocommerce_custom_product_loop_item'), 10 );
		add_action('woocommerce_sidebar', array($this, 'sidebar'), 10 );
	}

	function woocommerce_custom_product_loop_item() {
    	$this->renderTemplate('components/product-card', []);
	}

	function sidebar() {
		renderTemplate('sidebars/product');
	}
}


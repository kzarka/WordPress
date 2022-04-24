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
	}
}


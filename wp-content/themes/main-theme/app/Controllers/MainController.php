<?php

namespace App\Controllers;

use App\Controllers\NavController;
use App\Controllers\PaginationController;
use App\Controllers\ProductController;
use App\Controllers\SliderController;
use App\Controllers\ContactController;

/**
 * MainController
 */
class MainController extends BaseController
{
	function __construct()
	{
		new NavController();
		new PaginationController();
		new ProductController();
		new SliderController();
		new ContactController();
	}
}


<?php

namespace App\Controllers;

use App\Controllers\NavController;
use App\Controllers\PaginationController;
use App\Controllers\ProductController;
use App\Controllers\SliderController;
use App\Controllers\ContactController;
use App\Controllers\CustomerFeedbackController;

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
		new CustomerFeedbackController();
	}
}


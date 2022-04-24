<?php

namespace App\Controllers;

use App\Controllers\NavController;
use App\Controllers\PaginationController;
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
		new ContactController();
	}
}


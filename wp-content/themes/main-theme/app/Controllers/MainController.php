<?php

namespace App\Controllers;

use App\Controllers\NavController;
use App\Controllers\PaginationController;

/**
 * MainController
 */
class MainController extends BaseController
{
	function __construct()
	{
		new NavController();
		new PaginationController();
	}
}


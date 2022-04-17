<?php

namespace App\Controllers;

use App\Controllers\NavController;

/**
 * MainController
 */
class MainController extends BaseController
{
	function __construct()
	{
		new NavController();
	}
}


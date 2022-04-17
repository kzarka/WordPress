<?php
namespace App;

use App\Controllers\MainController;
use App\Shortcodes\RegisterShortcodes;
use App\Services\NavMenuService;

class Loader {
	
	function __construct()
	{
		$this->navMenuService = new NavMenuService;
		$this->register();
	}

	function register()
	{
		$this->navMenuService->init();
		new RegisterShortcodes;
		new MainController;
	}
}
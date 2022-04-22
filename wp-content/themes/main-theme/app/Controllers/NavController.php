<?php

namespace App\Controllers;

use App\Services\NavMenuService;
/**
 * NavController
 */
class NavController extends BaseController
{
	function __construct()
	{
		$this->navMenuService = new NavMenuService;
		$this->registerHook();
	}

	public function registerHook()
	{
		add_action( 'pc_nav_content', array($this, 'loadHeaderPC'));
	}

	public function loadHeaderPC()
	{
		$navPC = $this->navMenuService->loadHeaderPCNav();
		$this->renderTemplate('header/navbar/partials/pc-nav', ['items' => $navPC]);
	}
}


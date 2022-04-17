<?php

namespace App\Shortcodes;

use App\Shortcodes\TestShortcode;
use App\Shortcodes\GalleryShortcode;

/**
 * MainController
 */
class RegisterShortcodes
{
	function __construct()
	{
		$this->register();
	}

	public function register()
	{
		new TestShortcode();
		new GalleryShortcode();
	}
}


<?php

namespace App\Shortcodes;

use App\Shortcodes\TestShortcode;
use App\Shortcodes\GalleryShortcode;
use App\Shortcodes\HeaderShortcode;
use App\Shortcodes\SliderShortcode;

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
		new HeaderShortcode();
		new SliderShortcode();
	}
}


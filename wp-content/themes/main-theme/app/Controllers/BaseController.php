<?php

namespace App\Controllers;

/**
 * MainController
 */
class BaseController
{
	const VIEW_PATH = '/app/views/';
	public function baseView()
	{
		return get_template_directory() . self::VIEW_PATH;
	}

	public function renderTemplate($path, $args = [])
	{
		return renderTemplate($path, $args);
	}
}


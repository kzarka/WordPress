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
		add_action('wp_ajax_envira_gallery_remove_image', array($this, 'deleteAttachment'), 100);
	}

	public function loadHeaderPC()
	{
		$navPC = $this->navMenuService->loadHeaderPCNav();
		$this->renderTemplate('header/navbar/partials/pc-nav', ['items' => $navPC]);
	}

	public function deleteAttachment()
	{
		// $post_id      = absint( $_POST['post_id'] );
		$attach_id    = absint( $_POST['attachment_id'] );
		wp_delete_attachment($attach_id);
	}
}


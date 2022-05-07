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
		add_action( 'pc_nav_content', array($this, 'loadHeaderPC') );
		add_action( 'mobile_nav_content', array($this, 'loadHeaderSP') );
		add_action( 'my_footer', array($this, 'loadFooter') );
		add_action( 'wp_ajax_envira_gallery_remove_image', array($this, 'deleteAttachment'), 10 );
	}

	public function loadHeaderSP()
	{
		$navPC = $this->navMenuService->loadHeaderSPNav();
		$this->renderTemplate('header/navbar/partials/mobile-nav', ['items' => $navPC]);
	}

	public function loadHeaderPC()
	{
		$navPC = $this->navMenuService->loadHeaderPCNav();
		$this->renderTemplate('header/navbar/partials/pc-nav', ['items' => $navPC]);
	}

	public function loadFooter()
	{
		$navPC = $this->navMenuService->loadHeaderFooterNav();
		$this->renderTemplate('footer/footer', ['items' => $navPC]);
	}

	public function deleteAttachment()
	{
		$post_id      = absint( $_POST['post_id'] );
		$attach_id    = absint( $_POST['attachment_id'] );
		wp_delete_attachment($attach_id);
	}
}


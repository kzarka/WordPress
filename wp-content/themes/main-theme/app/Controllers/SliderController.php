<?php

namespace App\Controllers;

use App\Services\NavMenuService;
/**
 * SliderController
 */
class SliderController extends BaseController
{
    function __construct()
    {
        $this->navMenuService = new NavMenuService;
        $this->registerHook();
    }

    public function registerHook()
    {
        //add_action( 'init', array($this, 'registerPostType'));
    }

    public function loadHeaderPC()
    {
        $navPC = $this->navMenuService->loadHeaderPCNav();
        $this->renderTemplate('header/navbar/partials/pc-nav', ['items' => $navPC]);
    }

    public function registerPostType()
    {
        register_post_type( 'top_slider', // 投稿タイプ名の定義
            array(
                'labels' => array(
                'name' => __( 'スライダー設定' ), // 表示する投稿タイプ名
                'singular_name' => __( 'スライダー' )
            ),
                'public' => true,
                'menu_position' =>5,
                'menu_icon'     => 'dashicons-images-alt',
                'hierarchical' => true,
                'supports' => array('title','editor','page-attributes'),
                'show_in_rest' => true, 
            )
        );
    }
}


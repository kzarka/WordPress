<?php

namespace App\Controllers;

/**
 * CustomerFeedbackController
 */
class CustomerFeedbackController extends BaseController
{
    function __construct()
    {
        $this->registerHook();
    }

    public function registerHook()
    {
        add_action( 'init', array($this, 'registerPostType'));
    }

    public function registerPostType()
    {
        register_post_type( 'customer_feedback',
            array(
                'labels' => array(
                'name' => __( 'Feedback' ),
                'singular_name' => __( 'Feedback' )
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


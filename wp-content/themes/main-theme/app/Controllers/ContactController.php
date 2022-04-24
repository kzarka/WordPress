<?php

namespace App\Controllers;

use App\Services\NavMenuService;
/**
 * NavController
 */
class ContactController extends BaseController
{
	function __construct()
	{
		$this->navMenuService = new NavMenuService;
		$this->registerHook();
	}

	public function registerHook()
	{
		add_action( 'admin_post_nopriv_main_theme_add_contact', array($this, 'main_theme_contact') );
        add_action( 'admin_post_main_theme_add_contact', array($this, 'main_theme_contact'));
	}

    function main_theme_contact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reg_errors =  $this->registration_validation();
            $this->complete_registration($reg_errors);
        }
    }
    
    function registration_validation()  {
        $reg_errors = [];
        $request = $_POST;
        $request['name'] = trim($request['name']);
        $reg_errors['old_post'] = [
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'phone' => $request['body'],
        ];
        $reg_errors['errors'] = [];
        // user_email
        if(empty($request['name'])) {
            $reg_errors['errors']['name'][] = 'Cho chúng tôi biết tên của bạn.';
        }
        if(empty($request['body'])) {
            $reg_errors['errors']['body'][] = 'Bạn muốn gửi thông tin gì cho chúng tôi.';
        }
        return $reg_errors;
    }
    
    function complete_registration($reg_errors) {
        global $wpdb;
        session_start();
        $_SESSION["validate"] = $reg_errors;
        $register_page  = home_url( 'contact-us/' );
        if ( 1 > count( $reg_errors['errors'] ) ) {
            $post_id = wp_insert_post( [
                    'post_content'    =>  $_POST['body'],
                    'post_title' => $_POST['name'],
                    'post_type' => 'contact_us'
                ]
            );
            if ($post_id) {
                add_post_meta($post_id, 'contact_name', $_POST['name']);
                add_post_meta($post_id, 'contact_email', $_POST['email']);
                add_post_meta($post_id, 'phone', $_POST['phone']);
            }
            $_SESSION["success"] = true;
            wp_redirect(home_url());
        } else {
            wp_redirect($register_page);
        }
    }
}


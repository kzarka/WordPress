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
        $this->mainThemeRegisterContactPostType();
	}

	public function registerHook()
	{
		add_action( 'admin_post_nopriv_main_theme_add_contact', array($this, 'main_theme_contact') );
        add_action( 'admin_post_main_theme_add_contact', array($this, 'main_theme_contact'));
        add_shortcode( 'contact_us', array($this, 'formContactUs'));
	}

    public function mainThemeRegisterContactPostType()
    {
        register_post_type( 'contact_us',
            array(
                'labels' => array(
                    'name' => __( 'Contact' ),
                    'singular_name' => __( 'Contact' )
                ),
                'public' => true,
                'menu_position' => 10,
                'menu_icon'     => 'dashicons-feedback',
                'hierarchical' => true,
                'supports' => array('title', 'editor', 'excerpt', 'custom-fields', 'thumbnail',),
                'has_archive' => 'contact',
                'publicly_queryable' => true,
                'query_var' => true,
                'show_in_rest' => true
            )
        );
    }

    public function formContactUs()
    {
        $errors = [];
        $status = '';
        if ($_POST['submit_contact']) {
            $errors = $this->registration_validation();
            $status = $this->complete_registration($errors);
        }
        $error_name = '';
        $error_body = '';
        $error_email = '';
        if(isset($errors['errors'])) {
            if (isset($errors['errors']['full_name'])) {
                foreach($errors['errors']['full_name'] as $value) {
                    $error_name .= $value;
                }
            }
            if (isset($errors['errors']['body'])) {
                foreach($errors['errors']['body'] as $value) {
                    $error_body .= $value;
                }
            }

            if (isset($errors['errors']['email'])) {
                foreach($errors['errors']['email'] as $value) {
                    $error_email .= $value;
                }
            }
        }
        $output = ' <div class="form-horizontal">';
        if($status && $status == 'success') {
            $output .= '<div class="alert alert-success" role="alert">
                Bạn đã tạo thành công.
            </div>';
        }
        $output .= '  <form action="/contact-us" method="POST" id="contact_form" accept-charset="UTF-8" class="contact-form">
        <fieldset>
          <legend>Để lại lời nhắn</legend>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name">Tên của bạn</label>
            <div class="col-sm-10">
              <input type="text" id="contactFormName" required name="full_name" class="form-control" autocorrect="off" autocapitalize="off" placeholder="Tên" value="">';
        if ($error_name) {
            $output .= ' <small id="user-login-message" style="" class="form-text text-danger mb-4">'.  $error_name .'</small>';
        }
        $output .= '</div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name">Địa chỉ email</label>
            <div class="col-sm-10">
              <input type="email" id="contactFormEmail" required name="email" class="form-control" placeholder="Địa chỉ email" autocorrect="off" autocapitalize="off" value="">';

            if ($error_email) {
                $output .= ' <small id="user-login-message" style="" class="form-text text-danger mb-4">'.  $error_email .'</small>';
            }
         $output .= '</div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name">Số điện thoại</label>
            <div class="col-sm-10">
              <input type="number" id="contactFormPhone" name="Số điện thoại" class="form-control" placeholder="Phone" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name">Lời nhắn</label>
            <div class="col-sm-10"><grammarly-extension data-grammarly-shadow-root="true" style="position: absolute; top: 0px; left: 0px; pointer-events: none;" class="cGcvT"></grammarly-extension><grammarly-extension data-grammarly-shadow-root="true" style="mix-blend-mode: darken; position: absolute; top: 0px; left: 0px; pointer-events: none;" class="cGcvT"></grammarly-extension>
              <textarea class="form-control" required rows="10" id="contactFormMessage" name="body" placeholder="Lời nhắn" spellcheck="false"></textarea>';
        if ($error_body) {
                $output .= ' <small id="user-login-message" style="" class="form-text text-danger mb-4">'.$error_body.'</small>';
            }     
        $output .= '
            </div>
          </div>
          
        </fieldset>
        <div class="buttons submit">
          <div class="pull-right">
            <input class="btn btn-primary" id="submitMessage" name="submit_contact" type="submit" value="Gửi">
          </div>
        </div>

        </form> </div>';
        return $output;

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
        $request['full_name'] = trim($request['full_name']);
        $reg_errors['old_post'] = [
            'full_name' => $request['full_name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'phone' => $request['body'],
        ];
        $reg_errors['errors'] = [];
        // user_email
        if(empty($request['full_name'])) {
            $reg_errors['errors']['full_name'][] = 'Cho chúng tôi biết tên của bạn.';
        }
        if(empty($request['body'])) {
            $reg_errors['errors']['body'][] = 'Bạn muốn gửi thông tin gì cho chúng tôi.';
        }
        if(empty($request['email'])) {
            $reg_errors['errors']['email'][] = 'Cho chúng tôi biết địa chỉ email.';
        }
        if(!empty($request['email']) && $request['email']) {
            if(!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
                $reg_errors['errors']['email'][] = 'Email của bạn không đúng định dạng.';
            }
        }
        return $reg_errors;
    }
    
    function complete_registration($reg_errors) {
        if ( 1 > count( $reg_errors['errors'] ) ) {
            $post_id = wp_insert_post( [
                    'post_content'    =>  $_POST['body'],
                    'post_title' => $_POST['full_name'],
                    'post_type' => 'contact_us',
                    'post_author' => 0
                ]
            );
            if ($post_id) {
                add_post_meta($post_id, 'contact_name', $_POST['full_name']);
                add_post_meta($post_id, 'contact_email', $_POST['email']);
                add_post_meta($post_id, 'phone', $_POST['phone']);
            }
            return 'success';
        }

        return 'error';
    }
}


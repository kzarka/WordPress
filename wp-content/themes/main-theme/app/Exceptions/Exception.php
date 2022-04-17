<?php

class Exception {
    public function __construct() {
        // when the init action/event happens, call the wp_some_method
        add_action( 'init', array( $this, 'wp_some_method' ) );
    }
    function wp_some_method( $post_type ){
        throw new \Exception('error'); 
    }
}
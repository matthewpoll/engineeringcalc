<?php
/*
 * Plugin Name: jack plugin try
 * Description: jack one
 * Author: jack
 * Version: 1.0
 */

function include_jQuery() {
    if (!is_admin()) {
        wp_enqueue_script('jquery');
    }
}
add_action('init', 'include_jQuery');



add_action( 'wp_enqueue_scripts', 'inputtitle_submit_scripts' );  
add_action( 'wp_ajax_ajax-inputtitleSubmit', 'myajax_inputtitleSubmit_func' );
add_action( 'wp_ajax_nopriv_ajax-inputtitleSubmit', 'myajax_inputtitleSubmit_func' );
 
function inputtitle_submit_scripts() {
  wp_enqueue_script( "inputtitle_submit", plugin_dir_url( __FILE__ ) . 'js/inputtitle_submit.js', array( 'jquery' ) ); // new line
  wp_localize_script( 'inputtitle_submit', 'PT_Ajax', array(
        'ajaxurl'       => admin_url( 'admin-ajax.php' ),
        'nextNonce'     => wp_create_nonce( 'myajax-next-nonce' ))
    );
	
}
 
function myajax_inputtitleSubmit_func() {
	// check nonce
	$nonce = $_POST['nextNonce']; 	
	if ( ! wp_verify_nonce( $nonce, 'myajax-next-nonce' ) )
		die ( 'Busted!');
		
	// generate the response
	$response = json_encode( $_POST );
 
	// response output
	header( "Content-Type: application/json" );
	echo $response;
 
	// IMPORTANT: don't forget to "exit"
	exit;
	
}


add_action( 'init', 'register_shortcodes' );
function register_shortcodes() {
	add_shortcode( 'displaycalcs', 'mp_calcs_display' );
}

function mp_calcs_display() {
$output = <<<HTML

<input type="text" required="required" name="title" class="input-block-level" placeholder="Input Title">
		<button class="btn btn-large" id="next">Next</button>





HTML;
	return $output;
} 





<?php
/*
 * Plugin Name: piggin one
 * Description: A costing calculator for the engineering industry
 * Author: Matthew Pollard
 * Version: 1.0
 */



// loads the javascript scripts
function test_ajax_load_scripts() {
	// load our jquery file that sends the $.post request
	wp_enqueue_script( "ajax-test", plugin_dir_url( __FILE__ ) . '/ajax-test.js', array( 'jquery' ) );
 
	// make the ajaxurl var available to the above script
	wp_localize_script( 'ajax-test', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );	
}
add_action('wp_print_scripts', 'test_ajax_load_scripts');



// recieves request sent back
function text_ajax_process_request() {
	// first check if data is being sent and that it is the data we want
  	if ( isset( $_POST["post_var"] ) ) {
		// now set our response var equal to that of the POST var
		$response = $_POST["post_var"];
		// send the response back to the front end
		echo $response;
		die();
	}
}
add_action('wp_ajax_test_response', 'text_ajax_process_request');
























//shortcodeexample
add_action( 'init', 'register_shortcodes' );
function register_shortcodes() {
	add_shortcode( 'displaycalcs', 'mp_calcs_display' );
}

function mp_calcs_display() {
echo '<a class="ajax-link" href="#">click me</a>';
}

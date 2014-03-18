<?php
/*
 * Plugin Name: copy from stack exchange
 * Description: the stackexcahnge copy
 * Author: Matthew Pollard
 * Version: 1.0
 */
 
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
        $nonce = $_POST['nextNonce'];   
    if ( ! wp_verify_nonce( $nonce, 'myajax-next-nonce' ) )
        die ( 'Busted!');

    $numwelds = isset($_POST['numberofwelds']) ? $_POST['numberofwelds'] : '';
$numconwelds = isset($_POST['numberofconwelds']) ? $_POST['numberofconwelds'] : '';

if (is_numeric($numwelds) && is_numeric($numconwelds))
{
    $total = $numwelds + $numconwelds;
    $response = json_encode($total);
    header("Content-Type: application/json");  
    echo $response;
    exit;
} 
}
 function include_jQuery() {
    if (!is_admin()) {
        wp_enqueue_script('jquery');
    }
}
add_action('init', 'include_jQuery');

add_action( 'init', 'register_shortcodes' );
function register_shortcodes() {
    add_shortcode( 'displaycalcs', 'mp_calcs_display' );
}
function mp_calcs_display() {

            $output = <<<HTML

<form action="" method="post" name="formsubmit" >
<h1> Process </h1>
<p> operation type always robot </p>
Number of welds: <input type="number" name="numberofwelds" id="numberofwelds"  >
Number of construction welds: <input type="number" name="numberofconwelds" id="numberofconwelds"  >
Total one: <input type="text" name="totalone" id="totalone" disabled>
<input type="submit"  value="Calculate" id="formsubmit" name="formsubmit" >
<div id="result"> </div>
</form> 

HTML;
    return $output;
} 
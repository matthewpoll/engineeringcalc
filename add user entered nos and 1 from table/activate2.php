<?php
/*
 * Plugin Name: costing calculator 2
 * Description: A costing calculator for the engineering industry
 * Author: Matthew Pollard
 * Version: 1.0
 */


   // register 6 hooks for the tables 
register_activation_hook( __FILE__, 'mp_install_countries_table' );
register_activation_hook( __FILE__, 'mp_install_country_data' );
register_activation_hook( __FILE__, 'mp_install_machines_table' );
register_activation_hook( __FILE__, 'mp_install_machines_data' );
register_activation_hook( __FILE__, 'mp_install_settings_table' );
register_activation_hook( __FILE__, 'mp_install_settings_data' );
// end of register hook for the tables


// create countries table - table 1a
function mp_install_countries_table() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'countries';


	$sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        labour_cost INT,
        overheads FLOAT,
        profit FLOAT,
        UNIQUE KEY id (id)
    );";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}

// populate countries tables - table 1b
function mp_install_country_data() {

	global $wpdb;

	$table_name = $wpdb->prefix . 'countries';

	$rows = array(
		array(
			'id'          => '1',
			'name'        => 'UK',
			'labour_cost' => '20',
			'overheads'   => '0.45',
			'profit'      => '0.22'
		),
		array(
			'id'          => '2',
			'name'        => 'china',
			'labour_cost' => '6',
			'overheads'   => '0.27',
			'profit'      => '0.17'
		)
	);

	foreach ( $rows as $row ) {
		$wpdb->insert( $table_name, $row );
	}
}
// create machines table - table 2a
function mp_install_machines_table() {
	global $wpdb;
	$table_name2 = $wpdb->prefix . 'machines';

	$sql2 = "CREATE TABLE $table_name2 (
          id int(11) NOT NULL AUTO_INCREMENT,
          name varchar(255) DEFAULT NULL,
          rate int(11) NOT NULL,
          UNIQUE KEY id (id)
          ) ; ";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql2 );
}

function add_my_css_and_my_js_files(){
    wp_enqueue_script('jquery-validate-min', plugins_url('jquery_validate_min.js', __FILE__ ) ); // NOT a new line
	 	
}
add_action('wp_enqueue_scripts', "add_my_css_and_my_js_files"); 



// copied from reichert example
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

 global $wpdb;
$mp_country_table_info = $wpdb->prefix . 'countries '; //Good practice
$mpcountrys = $wpdb->get_var( "SELECT labour_cost FROM $mp_country_table_info WHERE id='2' ");
 
 
        $nonce = $_POST['nextNonce'];   
    if ( ! wp_verify_nonce( $nonce, 'myajax-next-nonce' ) )
        die ( 'Busted!');

    $numwelds = isset($_POST['numberofwelds']) ? $_POST['numberofwelds'] : '';
$numconwelds = isset($_POST['numberofconwelds']) ? $_POST['numberofconwelds'] : '';

if (is_numeric($numwelds) && is_numeric($numconwelds))
{
    $total = $numwelds + $numconwelds + $mpcountrys ;
    $response = json_encode($total);
    header("Content-Type: application/json");  
    echo $response;
    exit;
} 
}
// end of copied from riechert example









function include_jQuery() {
    if (!is_admin()) {
        wp_enqueue_script('jquery');
    }
}
add_action('init', 'include_jQuery');


// populate machines table 2b 
function mp_install_machines_data() {
	global $wpdb;
	$table_name_mach_in = $wpdb->prefix . 'machines';

	$machine_id   = '1';
	$machine_name = 'robot spot welder';
	$machine_rate = '91';

	$rows_affectedmac = $wpdb->insert( $table_name_mach_in, array( 'id' => $machine_id, 'name' => $machine_name, 'rate' => $machine_rate ) );
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $rows_affectedmac );
}

//creating settings table  - table 3a
function mp_install_settings_table() {
	global $wpdb;
	$table_name3 = $wpdb->prefix . 'settings';

	$sql5 = "CREATE TABLE $table_name3 (
          id int(11) NOT NULL AUTO_INCREMENT,
          robot_constructional INT,
          robot_stitching FLOAT,
          robot_addr_in FLOAT,
          robot_addr_out FLOAT,
          UNIQUE KEY id (id)
          ) ; ";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql5 );
}

//populate settings table 3b
function mp_install_settings_data() {
	global $wpdb;
	$table_name_sett_in = $wpdb->prefix . 'settings';

	$setting_id       = '1';
	$setting_con      = '3';
	$setting_stitc    = '1.8';
	$setting_rob_in   = '2.4';
	$setting_rob_out  = '2.4';
	$rows_affectedset = $wpdb->insert( $table_name_sett_in, array( 'id' => $setting_id, 'robot_constructional' => $setting_con, 'robot_stitching' => $setting_stitc, 'robot_addr_in' => $setting_rob_in, 'robot_addr_out' => $setting_rob_out ) );
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $rows_affectedset );
}

// end of  create table and populating them


/* 
DEACTIVATE PLUGIN CODE KEEP THIS
function mp_uninstall_countries_table() {
	global $wpdb;
	$thetable = $wpdb->prefix . 'countries';
	//Delete any options that's stored also?
	// delete_option('wp_yourplugin_version');
	$wpdb->query( "DROP TABLE IF EXISTS $thetable" );
}

register_deactivation_hook( __FILE__, 'mp_uninstall_countries_table' ); 
END OF DEACTIVATE PLUGIN CODE
 */







// EXAMPLE OF HOW TO USE GET RESULTS NO INCLUDED IN THIS PLUGIN
 /* function mp_getukcountryinfo() { 
global $wpdb;
$mp_country_table_info = $wpdb->prefix . 'countries '; //Good practice
$mpcountrys = $wpdb->get_results( "SELECT name FROM $mp_country_table_info WHERE id='1'; ");
// this is hardcoded so doesn't need sanitizing. If involves dynamic use  pg150 as an example! 

echo "<table>";
foreach($mpcountrys as $mpcountry){
echo "<tr>";
echo "<td>".$mpcountry->name."</td>";
echo "</tr>";
}
echo "</table>";

 } */
// END OF EXAMPLE OF HOW TO USE GET RESULTS


/* START OF RETRIEVING ENTERED NUMBERS. VALIDATE AND CALCULATE. RETURN TO BROWSER
$mp_country_table_info2 = $wpdb->prefix . 'settings';
$thepost = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $mp_country_table_info2 WHERE ID = 1" ) );
echo $thepost->robot_constructional; 

END OF RETRIEVING ENTERED NUMBERS. VALIDATE AND CALCULATE. RETURN TO BROWSER
*/ 




// shortcode to display calcs
add_action( 'init', 'register_shortcodes' );
function register_shortcodes() {
	add_shortcode( 'displaycalcs', 'mp_calcs_display' );
}

function mp_calcs_display() {
	//echo '<a class="ajax-link" href="#">click me</a>';
	
	$output = <<<HTML
	
<form action="" method="post" name="formsubmit" id="formsubmit"   >
<h1> Process </h1>
<p> operation type always robot </p>
Number of welds: <input type="number" name="numberofwelds" id="numberofwelds"  >
<br /> <br />
Number of construction welds: <input type="number" name="numberofconwelds" id="numberofconwelds"  >
<br /> <br />
Total one: <input type="text" name="totalone" id="totalone" disabled>
<br /> <br />
<input type="submit"  value="Calculate" id="submit" name="submit" class="ajax-link" >
<div id="result"> </div>
</form>
	
	 

	


 



<script type="text/javascript">
    jQuery(document).ready(function($) {
	
	
	
	
 
 
   $('#formsubmit').validate({
		rules:  {
		
		numberofwelds: "required",
		numberofconwelds: "required"
				},
				
		messages: {
		numberofwelds: "Please enter the number of welds",
		numberofconwelds: "Please enter number of con"
		},
		
		submitHandler: function(form) {
		form.submit();
		}		
		});
		

	// new added for ajax test
	
// new added for ajax test	
	
	
	
	
	
		
	
	}); // close jquery
	
	
			
	

	 
	</script>
HTML;


	return $output;
} 
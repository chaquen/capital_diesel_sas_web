<?php
/**
 * Plugin Name: JSON Basic Authentication
 * Description: Basic Authentication handler for the JSON API, used for development and debugging purposes
 * Author: WordPress API Team
 * Author URI: https://github.com/WP-API
 * Version: 0.1
 * Plugin URI: https://github.com/WP-API/Basic-Auth
 */

function json_basic_auth_handler( $user ) {
	global $wp_json_basic_auth_error;

	$wp_json_basic_auth_error = null;

	// Don't authenticate twice
	if ( ! empty( $user ) ) {
		return $user;
	}

	// Check that we're trying to authenticate
	if ( !isset( $_SERVER['PHP_AUTH_USER'] ) ) {
		return $user;
	}

	$username = $_SERVER['PHP_AUTH_USER'];
	$password = $_SERVER['PHP_AUTH_PW'];

	/**
	 * In multi-site, wp_authenticate_spam_check filter is run on authentication. This filter calls
	 * get_currentuserinfo which in turn calls the determine_current_user filter. This leads to infinite
	 * recursion and a stack overflow unless the current function is removed from the determine_current_user
	 * filter during authentication.
	 */
	remove_filter( 'determine_current_user', 'json_basic_auth_handler', 20 );

	$user = wp_authenticate( $username, $password );

	add_filter( 'determine_current_user', 'json_basic_auth_handler', 20 );

	if ( is_wp_error( $user ) ) {
		$wp_json_basic_auth_error = $user;
		return null;
	}

	$wp_json_basic_auth_error = true;

	return $user->ID;
}
add_filter( 'determine_current_user', 'json_basic_auth_handler', 20 );

function json_basic_auth_error( $error ) {
	// Passthrough other errors
	if ( ! empty( $error ) ) {
		return $error;
	}

	global $wp_json_basic_auth_error;

	return $wp_json_basic_auth_error;
}
add_filter( 'rest_authentication_errors', 'json_basic_auth_error' );


function pix_app_wc_order( $order_id ) {
	
	if ( ! $order = wc_get_order( $order_id ) ) {
	    return;
	}
 
	$order_arr = array();
	
    $order_arr["site"]["url"] = home_url();
    $order_arr["site"]["name"] = get_bloginfo();
    $order_arr["data"] = $order->get_data();
	$order_items = $order->get_items();
    foreach( $order_items as $item_id => $item ){
        $order_arr["items"][$item_id] = $item->get_data();
    }
    
    $order_json = json_encode($order_arr);
    $endpoint = file_get_contents('https://data.true-emotions.studio/app/pitstop/endpoint');
    
    $ch = curl_init();
	# Setup request to send json via POST.
	curl_setopt($ch, CURLOPT_URL, $endpoint);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $order_json );
	# Return response instead of printing.
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	# Send request.
	$result = curl_exec($ch);
	curl_close($ch);
	# Print response.
	//mail('s4asten@gmail.com', 'Order', $order_json, 'Content-Type: application/json;');
	
	// Further processing ...
	//if ($server_output == "OK") { ... } else { ... }
}
add_action( 'woocommerce_thankyou', 'pix_app_wc_order',  10, 1 );
add_action( 'woocommerce_resume_order', 'pix_app_wc_order',  10, 1 );


function pix_app_wpcf7_submit($contact_form, $abort, $submission) {
	//$abort = true;
	if ( $submission ) {
		
		$posted_arr = [];
		
		$posted_arr["site"]["url"] = home_url();
	    $posted_arr["site"]["name"] = get_bloginfo();
	    $posted_arr["data"] = $submission->get_posted_data();
		
		$order_json = json_encode($posted_arr);
	    $endpoint = file_get_contents('https://data.true-emotions.studio/app/pitstop/endpoint-cf7');

	    $ch = curl_init();
		# Setup request to send json via POST.
		curl_setopt($ch, CURLOPT_URL, $endpoint);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $order_json );
		# Return response instead of printing.
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		# Send request.
		$result = curl_exec($ch);
		curl_close($ch);
		# Print response.
		//wp_mail('s4asten@gmail.com', 'Order', $order_json, 'Content-Type: application/json;');
		
	}
}
add_filter( 'wpcf7_before_send_mail', 'pix_app_wpcf7_submit', 10, 3 );

<?php
/**
 *  Handles the custom login
 */

function loginValidation( $user,$pass ){
	global $reg_errors;
	$reg_errors = new WP_Error;

	// this returns the user ID and other info from the Email
	$access = get_user_by_email($user);

	if(!$access) {
		// if the user name doesn't exist
		$reg_errors->add('empty_username','Wrong Email or Password');
	}else{
		// check the user's login with their password
		if(!wp_check_password($pass, $access->user_pass, $access->ID)) {
			// if the password is incorrect for the specified user
			$reg_errors->add('empty_password', __('Wrong Email or Password'));
		}
	}

	if( empty($pass) || empty($user) ){
		$reg_errors->add('empty_password','kindly enter Email or Password');
	}


	if ( is_wp_error( $reg_errors ) ) {

		foreach ( $reg_errors->get_error_messages() as $error ) {

			echo '<div class="text-danger">';
			echo '<strong>ERROR</strong>: ';
			echo $error.'<br/>';
			echo '</div>';

		}

	}

}

function completeLogin(){
	global $reg_errors,$user,$pass;

	// this returns the user ID and other info from the Email
	$access = get_user_by_email($user);

	if ( 1 > count( $reg_errors->get_error_messages() ) ){

		wp_setcookie($user, $pass, true);
		wp_set_current_user($access->ID, $user);
		do_action('wp_login', $user);

		if($access->user_nicename  == "admin"){
			wp_redirect(home_url()); exit;
		}
		else {
			$redirect = $_GET['redirect_to'];
			if(!$redirect){wp_redirect(admin_url()); exit;}
			else{wp_redirect($redirect); exit;}
		}
	}
}

function loginFunc( $user,$pass ){
	global $user,$pass;

	loginValidation( $user,$pass );

	completeLgin( $user,$pass );

}
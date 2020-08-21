<?php
/**
 *  Handles the custom registration
 */

function registrationValidation( $fullName,$email,$password ){
	global $reg_errors;
	$reg_errors = new WP_Error;

	if ( empty( $password ) || empty( $email ) || empty($fullName) ) {
		$reg_errors->add('field', 'Required form field is missing');
	}
	if ( 5 > strlen( $password ) ) {
		$reg_errors->add( 'password', 'Password length must be greater than 5' );
	}
	if ( username_exists( $email ) ) {
		$reg_errors->add( 'user_name', 'Sorry, this Account already exists!' );
	}
	if ( !is_email( $email ) ) {
		$reg_errors->add( 'email_invalid', 'Email is not valid' );
	}
	if ( email_exists( $email ) ) {
		$reg_errors->add( 'email', 'Email Already in use' );
	}

	if ( is_wp_error( $reg_errors ) ) {

		foreach ( $reg_errors->get_error_messages() as $error ) {

			echo '<div class="text-danger">';
			echo '<strong>ERROR</strong>: ';
			echo $error. '<br/>';
			echo '</div>';

		}

	}


}

function completeRegistration(){
	global $reg_errors, $fullName, $email, $password;

	if ( 1 > count( $reg_errors->get_error_messages() ) ) {
		$userdata = array(
			'user_login'    =>   $email,
			'user_email'    =>   $email,
			'user_pass'     =>   $password,
			'fullName'      =>   $fullName,
		);
		# Adding user details
		$user = wp_insert_user( $userdata );

		# Adding User Phone Number
		update_user_meta($user,'phone_num',$phone_number);


        $to_customer      = "{{Site Name}} account successfully created";
        $message_customer = "Hello ".$first_name." ".$last_name.",\n Thank you for registering";
        wp_mail($email,$to_customer,$message_customer);

        $email_admin   = "{{Admin Email Address}}";
        $to_admin      = "{{Site Name}}- New user registered";
        $message_admin = "Hello,\n New user just registered";
        wp_mail($email_admin,$to_admin,$message_admin);


        $access = get_user_by_email($email);

        wp_setcookie($email, $password, true);
        wp_set_current_user($access->ID, $email);
        do_action('wp_login', $email);

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

function registerFunc($fullName,$email,$password){

	global $fullName,$email,$password;

	// sanitize user form input
	registrationValidation(
        $fullName,
        $email,
        $password
	);

	// call @function complete_registration to create the user
	// only when no WP_error is found
	completeRegistration(
		$fullName,
        $email,
        $password
	);


}
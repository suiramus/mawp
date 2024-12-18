<?php

/*
Plugin Name: Create a new admin user programmatically
Plugin URI: https://www.damiencarbery.com/2022/11/create-a-new-admin-user-programmatically/
Description: If you have ftp access you can create an admin user for yourself.
Author: Damien Carbery
Version: 0.1
*/

/* 
	Create a new admin user programmatically
	https://www.damiencarbery.com/2022/11/create-a-new-admin-user-programmatically/
	Code originally from https://wphub.me/create-new-wordpress-admin-user-programmatically/
	How to use:
	1. Upload this file in mu-plugins
	2. Open a page from site
	3. Remove this file after user creation
	4. Login
 */

function create_a_new_admin_account(){
	$user = 'adminusername';  // Change these values before you upload this file.
	$pass = 'VeryStrongPassword##24';
	$email = 'adminemail@eample.com';

	if ( !username_exists( $user )  && !email_exists( $email ) ) {
		$user_id = wp_create_user( $user, $pass, $email );
		$user = new WP_User( $user_id );
		$user->set_role( 'administrator' );
	}
}
add_action( 'init', 'create_a_new_admin_account' );
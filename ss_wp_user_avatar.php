<?php
/**
* Plugin Name: Manage User Avatar
* Plugin URI: https://wordpress.org/plugins/manage-user-avatar
* Description: WP Manager User Avatar plugin allows you to set your users avatar and select a uniform avatar theme for all users. You can set a avatar from the initial letter of username as done by Google.
* Version: 0.0.1
* Author: Escaleta
* License: GPLv2
* License URI: http://www.gnu.org/licenses/gpl-2.0.html
* Tags: Avatar, User profile, Profile pic, picture, WP avatar
*/

//Exit if accessed directly
if( !defined( 'ABSPATH' ) ){
	return;
}

class ESC_WP_Avatar{
	function __construct(){
		#This is the hook which will be used to attach the custom avatar to user profile.
		add_filter( 'get_avatar', array($this, 'esc_set_wp_avatar'), 10, 5);
	}

	function esc_set_wp_avatar($avatar, $id_or_email, $size, $default, $alt = ''){

		if (is_object($id_or_email) and property_exists($id_or_email, 'user_id') and is_numeric($id_or_email->user_id)) {	//check for user object
			$user_id = $id_or_email->user_id;
		}
		elseif (is_numeric($id_or_email) and $id_or_email > 0){		//check for user_id
			$user_id = $id_or_email;
		}
		elseif (is_string($id_or_email) and ($user = get_user_by('email', $id_or_email))) {		//check for user_email
			$user_id = $user->ID;
		}
		else {		//not a user then
			$user_id = null;
		}

		if($user_id){

			$user = get_userdata($user_id);
			$username = $user->data->user_login;
			$initial = strtolower($username[0]);
			
			//get the image by initia letter
			$avatar_url = plugin_dir_url(__FILE__).'assets/avatars/alphabets/'.$initial.'.png';

			return '<img src="'.$avatar_url.'" class="avatar avatar-64 photo" height="64" width="64">';
		}

		return $avatar;
	}

}

new ESC_WP_Avatar();
<?php

if(!defined('ABSPATH'))
	exit('Don\'t access source files directly!');

/**
 * Class member_approval_restriction
 *
 * Used for Restricting login access
 */
class member_approval_restriction {
	/**
	 * @param $user NULL|WP_User|WP_Error The current User Object WordPress is working with
	 *
	 * @return NULL|WP_User|WP_Error If the User is
	 */
	public static function maybe_prevent_login($user) {
		// Lets make sure that this is an attempt we need to work with
		if(!is_a($user, 'WP_User') // Make sure we're looking at a WP_User and not an Error
		   || $user->has_cap('manage_options') // Don't want to prevent Admins/Super Admins from logging in
		   || apply_filters('member_approval_disable_login_prevent', FALSE) /* To allow the process to be cancelled through code */) {

			return $user; // Then we'll just return what we have.
		}

		$opts = get_site_option('member-approval-opts', FALSE);

		if($opts['on-off'] === 'off')
			return $user; // We're not running right now.

		$user_needs_approval = get_user_meta($user->ID, 'requires_approval', TRUE); // If this meta key is set then we can't allow them to log in.

		if($user_needs_approval) {
			remove_all_actions('wp_login_failed'); // We don't want other plugins to record this as a failed login attempt. It only failed because the User isn't activated yet.

			return new WP_Error('require_approval', apply_filters('member_approval_error_message', $opts['message']) /* You can change the error message this way */); // We'll use WP_Error to keep the User from logging in. This way they should also see what went wrong.
		}

		return $user;
	}

	/**
	 * @param $user_id int The User's ID, as passed from user_register
	 *
	 * Used to add the meta key requires_approval to Users when they register, if needed.
	 */
	public static function maybe_add_meta($user_id) {
		$opts = get_site_option('member-approval-opts', FALSE);

		if($opts['on-off'] === 'off')
			return; // We're not running right now

		$applicable_roles = $opts['applicable-roles'];

		$user = new WP_User($user_id);

		if($user->has_cap('administrator'))
			return;

		foreach($user->roles as $role) {
			if($applicable_roles[$role]) // Checking to see if User was created in a Role that requires Approval
					update_user_meta($user_id, 'requires_approval', TRUE); // If this meta key is set then we can't allow them to log in.
			}
	}
}
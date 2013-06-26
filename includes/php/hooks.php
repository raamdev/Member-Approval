<?php

if(!defined('ABSPATH'))
	exit('Don\'t access source files directly!');

spl_autoload_register('member_approval_autoload'); // "Autoloader"

add_filter('authenticate', array('member_approval_restriction', 'maybe_prevent_login'), 40, 1); // We hook in at priority 40 because this needs to fire after WordPress's processes in `/wp-includes/user.php`.
add_action('user_register', array('member_approval_restriction', 'maybe_add_meta')); // For adding the Meta Key (if activated)

add_action('admin_menu', array('member_approval_admin', 'setup')); // Admin page setup
add_filter('plugin_action_links_'. plugin_basename(MEMBER_APPROVAL_ROOT . '/member-approval.php'), array('member_approval_admin', 'settings_link')); // Settings link in Plugins list

add_action('show_user_profile', array('member_approval_user_edits', 'add_field'));
add_action('edit_user_profile', array('member_approval_user_edits', 'add_field'));
add_action('edit_user_profile_update', array('member_approval_user_edits', 'save_field'));
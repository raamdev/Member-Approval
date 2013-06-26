<?php

if(!defined('ABSPATH'))
	exit('Don\'t access source files directly!');
/**
 * Class member_approval_admin
 *
 * Admin-side "stuff"
 */
class member_approval_admin {
	/**
	 * Sets up the Options Page on the `admin_menu` hook
	 */
	public static function setup() {
		add_options_page('Member Approval Settings', 'Member Approval', 'manage_options', 'member-approval', array('member_approval_admin', 'page'));
	}

	/**
	 * Controls Options Page content
	 */
	public static function page() {
		if(!current_user_can('manage_options'))
			wp_die(__('You do not have sufficient permissions to access this page.'));

		if(isset($_POST['submit'])) {
			$opts = $_POST['gsettings'];

			foreach($opts as $key => $value) {
				if(is_string($value))
					$opts[$key] = trim($value);
			}

			update_option('member-approval-opts', $opts);
		}

		else
			$opts = get_site_option('member-approval-opts', FALSE);

		$roles = get_editable_roles();

		if(!$opts) {
			$defaults = array();
			$defaults['on-off'] = 'off';
			$defaults['applicable-roles'] = array('subscriber' => 'Subscriber');
			$defaults['message'] = 'Your account is awaiting approval. Please try again later.';

			add_site_option('member-approval-opts', $defaults, '', FALSE);

			$opts = $defaults;
		}
		?>
		<div class="wrap">
			<div id="icon-options-general" class="icon32"><br></div><h2>Member Approval</h2>
			<div style="clear: both;"></div>
				<div id="member-approval-general-settings" class="member-approval-main-section">
					<form method="post" action="">
					<table class="form-table">
						<tbody>

							<tr valign="top">
								<th scope="row">
									<label for="gsettings[on-off]">New User Approval</label>
								</th>
								<td>
									<select name="gsettings[on-off]" id="approval-on-off">
										<option <?php if($opts['on-off'] === 'on') { echo 'selected="selected"'; } ?> value="on">ON</option>
										<option <?php if($opts['on-off'] === 'off') { echo 'selected="selected"'; } ?> value="off">OFF</option>
									</select>
									<p class="description">Make sure you have your settings done before turning this on.</p>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row">
									<label for="gsettings[applicable-roles]">Applicable Roles</label>
								</th>
								<td>
									<?php
										foreach($roles as $slug => $data) {
											if($slug !== 'administrator' || $slug = 'super-administrator') { // Administrators can't be blocked from logging in
												echo '<input type="checkbox" name="gsettings[applicable-roles][' . $slug . ']" ';

												if(isset($opts['applicable-roles'][$slug]))
													echo 'checked="checked"';

												echo ' value="' . $slug . '"/> ' . $data['name'] . '<br />';
											}
										}
									?>
									<p class="description">Select all Roles that, when Users register at that Role, should require the User to be Approved to log in.</p>
									<p class="description">NOTE: If you don't select any Roles, Member Approval won't do anything.</p>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row">
									<label for="gsettings[message]">Restriction Message</label>
								</th>
								<td>
									<input type="text" <?php echo 'value="' . $opts['message'] . '"'; ?> name="gsettings[message]" class="regular-text ltr" autocomplete="off"/>
									<p class="description">This is the message that will show up for the User when they attempt to log in while not Approved.</p>
								</td>
							</tr>

						</tbody>
					</table>
					<p class="submit">
						<input type="submit" name="submit" id="submit" class="button button-primary" value="Save All Changes">
					</p>
					</form>
				</div>
		</div>
		<?php
	}

	/**
	 * Adds the Settings link to the admin menu
	 *
	 * @param $links string
	 *
	 * @return string
	 *
	 * Originally found here: http://bavotasan.com/2009/a-settings-link-for-your-wordpress-plugins/
	 */
	public static function settings_link($links) {
		$settings_link = '<a href="options-general.php?page=member-approval">Settings</a>';
		array_unshift($links, $settings_link);
		return $links;
	}
}

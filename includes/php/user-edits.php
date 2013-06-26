<?php

if(!defined('ABSPATH'))
	exit('Don\'t access source files directly!');

class member_approval_user_edits {
	public static function add_field($user) {
		$user_needs_approval = get_user_meta($user->ID, 'requires_approval', TRUE);

		if($user_needs_approval) {

		?>
		<table class="form-table">
			<tr>
				<th><label for="address">This User needs to be Approved.<br /><strong>Approve Member now?</strong></label></th>
				<td>
					<select name="member_approval_yesno" style="width: 100px;">
						<option value="no">NO</option>
						<option value="yes">YES</option>
					</select>
					<p class="description">If you leave this set to NO, you can come back and Approve this User later.</p>
				</td>
			</tr>
		</table>
	<?php
		}
	}

	public static function save_field($user_id) {
		if (!current_user_can('edit_user', $user_id))
			return;

		if($_POST['member_approval_yesno'] === 'yes' && get_user_meta($user_id, 'requires_approval', TRUE))
			delete_user_meta($user_id, 'requires_approval');
	}
}
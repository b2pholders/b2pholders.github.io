<?php

namespace BPL\Jumi\Admin_Account_Update;

require_once 'bpl/menu.php';
require_once 'bpl/mods/ajax.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Menu\admin as menu_admin;

use function BPL\Mods\Ajax\check_input3;

use function BPL\Mods\Helpers\page_validate_admin;
use function BPL\Mods\Helpers\session_get;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$usertype     = session_get('usertype');
	$admintype    = session_get('admintype');
	$account_type = session_get('account_type');
	$user_id      = session_get('user_id');
	$username     = session_get('username');

	page_validate_admin($usertype, $admintype);

	$str = menu_admin($admintype, $account_type, $user_id, $username);

	$str .= check_input3();

	$str .= view_form();

	echo $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_form(): string
{
	return '<h1>Update Member Account</h1>
		<p>Enter member\'s Username to update.</p>
		<form name="regForm" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
		    <table class="category table table-striped table-bordered table-hover">
		        <tr>
		            <td><label for="username">Username: *</label></td>
		            <td><input type="text"
		                       name="username"
		                       id="username"
		                       size="40"
		                       required="required"
		                       style="float:left">
		                <a href="javascript:void(0)" onClick="checkInput(\'username\')"
		                   class="uk-button uk-button-primary"
		                   style="float:left">Check Username</a>
		                <div style="width:200px;
		                    height:20px;
		                    font-weight:bold;
		                    float:left;
		                    padding:7px 0 0 10px;" id="usernameDiv"></div>
		            </td>
		        </tr>
		    </table>
		</form>';
}
<?php

define('_JEXEC', 1);

define('JPATH_BASE', realpath(dirname(__FILE__) . '/../..'));
require_once JPATH_BASE . '/includes/defines.php';
require_once JPATH_BASE . '/includes/framework.php';

require_once JPATH_BASE . '/bpl/mods/url_sef_local.php';

use \Joomla\CMS\Factory;

use function \Onewayhi\Url\Local\SEF\sef;

/* */
$session  = Factory::getSession();
$usertype = $session->get('usertype', '');
$user_id  = $session->get('user_id', '');

$db = Factory::getDbo();

$currency = $db->setQuery(
	'SELECT currency ' .
	'FROM network_settings_ancillaries'
)->loadObject()->currency;

$settings_entry = $db->setQuery(
	'SELECT * ' .
	'FROM network_settings_entry'
)->loadObject();

?>
	<h1>Members</h1>
	<table class="category table table-striped table-bordered table-hover">
		<thead>
		<tr>
			<th>Date Registered</th>
			<th>Username</th>
			<th>Account</th>
			<th>Balance (<?php echo $currency; ?>)</th>
			<th>Stock Fund (<?php echo $currency; ?>)</th>
			<th>Actions</th>
		</tr>
		</thead>
		<tbody>
		<?php

		$users = $db->setQuery(
			'SELECT * ' .
			'FROM network_users ' .
			'ORDER BY id DESC'
		)->loadObjectList();

		foreach ($users as $user)
		{
			echo '
			<tr>
				<td>' . date('M j, Y - G:i', $user->date_registered) . '</td>
				<td><a href="' . sef(44) . '&uid=' .
				$user->id . '">' . $user->username . '</a></td>' .
				'<td>' . $settings_entry->{$user->account_type. '_package_name'} .
				'<td>' . number_format($user->balance, 2) . '</td>' .
				'<td>' . number_format($user->payout_transfer, 2) . '</td>';

			echo '<td>';

			if ($user->block == 0)
			{
				echo '<a href="' . sef(8) . '&uid=' . $user->id . '">Block</a>';
			}
			else
			{
				echo '<a href="' . sef(107) . '&uid=' . $user->id . '">Unblock</a>';
			}

			echo '</td>';

			echo '</tr>';
		}

		?>
		</tbody>
	</table>
<?php /* */ ?>
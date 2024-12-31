<?php

namespace BPL\Jumi\Reward_Redemption_Confirm;

require_once 'bpl/menu.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';
require_once 'bpl/plugins/phpqrcode/qrlib.php';

use Exception;
use QRcode;
use RuntimeException;
use const QR_ECLEVEL_L;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate as page_validate_reward;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\time;

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

	page_validate_reward();

	$str = menu($usertype, $admintype, $account_type, $user_id, $username);

	$uid = input_get('uid');

	if ($usertype === 'Admin' || $usertype === 'manager')
	{
		if ($uid === '')
		{
			$str .= view_incentives();
		}
		else
		{
			process_confirm($user_id, $uid);
		}
	}

	echo $str;
}

/**
 * @param $usertype
 * @param $admintype
 * @param $account_type
 * @param $user_id
 * @param $username
 *
 * @return string
 *
 * @since version
 */
function menu($usertype, $admintype, $account_type, $user_id, $username): string
{
	$str = '';

	switch ($usertype)
	{
		case 'Admin':
			$str .= menu_admin($admintype, $account_type, $user_id, $username);
			break;
		case 'manager':
			$str .= menu_manager();
			break;
	}

	return $str;
}

/**
 *
 * @return array|mixed
 *
 * @since version
 */
function incentives_pending()
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_incentive ' .
		'WHERE status = ' . $db->quote('Awaiting Delivery') .
		' ORDER BY incentive_id DESC'
	)->loadObjectList();
}

/**
 * @param $item_id
 *
 * @return mixed|null
 *
 * @since version
 */
function items_incentive($item_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_items_incentive ' .
		'WHERE item_id = ' . $db->quote($item_id)
	)->loadObject();
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_incentives(): string
{
	$incentives = incentives_pending();

	$str = '<h1>Pending Token Redemption</h1>
        <p>Confirm delivery of assets here.</p>';

	if (!empty($incentives))
	{
		$tokens = ['AET', 'B2P', 'TPAY', 'PESO'];
		$found  = false;

		$str .= '<table class="category table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Asset</th>
                    <th>Price (tkn.)</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Method</th>
                    <th>Option</th>
                </tr>
                </thead>
                <tbody>';

		foreach ($incentives as $incentive)
		{
			$item = items_incentive($incentive->item_id);

			foreach ($tokens as $token)
			{
				if ($item->item_name === $token || strpos($token, $item->item_name) !== false)
				{
					$found = true;
					break;
				}
			}

			$str .= '<tr>
				<td>' . date('M j, Y g:i A', $incentive->date) . '</td>
				<td><a href="' . sef(64) . qs() . 'uid=' . $item->item_id .
				'" target="_blank">' . $item->item_name . '</a></td>
				<td>' . $incentive->price . '</td>
				<td>' . $incentive->quantity . '</td>
				<td>' . $incentive->total_purchases . '</td>
				<td>' . ($found ? '<input type="button" class="uk-button uk-button-primary" value="' .
					$item->item_name . '" data-uk-modal="{target:\'#modal-' . $item->item_id . '\'}">' : 'n/a') . '</td>
				<td><a href="' . sef(78) . qs() . 'uid=' . $incentive->incentive_id .
				'" class="uk-button uk-button-primary">Confirm</a></td>
			</tr>';

			if ($found) {
				$str .= '<div id="modal-' . $item->item_id .
					'" class="uk-modal" aria-hidden="true" style="display: none; overflow-y: scroll; margin-top: 150px">
	            <div class="uk-modal-dialog" style="text-align: center">
	                <button type="button" class="uk-modal-close uk-close"></button>';

				$user = user($incentive->user_id);

				$contact_info = arr_contact_info($user);

				$messenger = '';

				if (!empty($contact_info))
				{
					$messenger = $contact_info['messenger'] ?? '';
				}

				$wallet_addr = has_wallet_addr($item->item_name, $user)
					? arr_payment_method($user)[strtolower($item->item_name)] : 'n/a';

				$contact = $messenger ? '<p><b>User Messenger URL:</b> ' . $messenger . '</p>' : '';
				$contact .= $user->email ? '<p><b>User Email Address:</b> ' . $user->email . '</p>' : '';

				$str .= '<img src="images/trust-wallet.svg" alt="" width="150px"><br>';
				$str .= $contact;
				$str .= '<img src="' . qr_code_generate($wallet_addr) .
					'" alt="QR Code Trust Wallet" style="width:250px;">';

				$str .= '<p>Please transfer <b>' . number_format($incentive->price, 8) . '</b> ' .
					$item->item_name . ' to the following Wallet Address:</p>
	                <p><b>' . $wallet_addr . '</b></p>
	            </div>
	        </div>';

				$str .= '</div>
	        </div>';
			}
		}

		$str .= '</tbody>
            </table>';
	}
	else
	{
		$str .= '<hr><p>No pending redemption.</p>';
	}

	return $str;
}

function arr_contact_info($user)
{
	$contact_info = empty($user->contact) ? '{}' : $user->contact;

	return json_decode($contact_info, true);
}

function arr_payment_method($user): array
{
	$payment_method = empty($user->payment_method) ? '{}' : $user->payment_method;

	return json_decode($payment_method, true);
}

function has_wallet_addr($item_name, $user): bool
{
	$arr = arr_payment_method($user);

	if ($arr)
	{
		foreach ($arr as $k => $v)
		{
			if (strtolower($item_name) === $k)
			{
				return true;
			}
		}
	}

	return false;
}

function qr_code_generate($address): string
{
	// Get the system's temporary directory
	$tempDir = sys_get_temp_dir();

	// Ensure the temporary directory is writable
	if (!is_writable($tempDir)) {
		throw new RuntimeException("Temporary directory is not writable.");
	}

	// Create a temporary image path
	$tempFile = tempnam($tempDir, 'qr');

	if ($tempFile === false) {
		throw new RuntimeException("Unable to create temporary file.");
	}

	// Generate the QR code and output it as an image
	QRcode::png($address, $tempFile, QR_ECLEVEL_L, 10);

	// Read the image file and encode it in base64
	$imageData = file_get_contents($tempFile);
	if ($imageData === false) {
		throw new RuntimeException("Unable to read temporary file.");
	}
	$imageData = base64_encode($imageData);

	// Remove the temporary file
	unlink($tempFile);

	// Return the image data as a base64-encoded string
	return 'data:image/png;base64,' . $imageData;
}

/**
 * @param $user_id
 * @param $uid
 *
 *
 * @since version
 */
function process_confirm($user_id, $uid)
{
	$db = db();

	try
	{
		$db->transactionStart();

		update_incentive($uid);

		logs($user_id, $uid);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();
		ExceptionHandler::render($e);
	}

	application()->redirect(Uri::root(true) . '/' . sef(78),
		'Rewards redemption delivery confirmed.', 'notice');
}

/**
 * @param $uid
 *
 * @return mixed|null
 *
 * @since version
 */
function user_incentive($uid)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users u, network_incentive i ' .
		'WHERE u.id = i.user_id ' .
		'AND i.incentive_id = ' . $db->quote($uid)
	)->loadObject();
}

/**
 * @param $user_id
 * @param $uid
 *
 *
 * @since version
 */
function logs($user_id, $uid)
{
	$db = db();

	$incentives = user_incentive($uid);

	$activity = '<b>Rewards Redemption Delivery Confirmation: </b>' .
		items_incentive($incentives->item_id)->item_name .
		' by <a href="' . sef(44) . qs() . 'uid=' . $incentives->user_id .
		'">' . $incentives->username . '</a>.';

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'upline_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($user_id),
			$db->quote(1),
			$db->quote(1),
			$db->quote($activity),
			$db->quote(time())
		]
	);
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function update_incentive($uid)
{
	$db = db();

	update(
		'network_incentive',
		['status = ' . $db->quote('Delivered')],
		['incentive_id = ' . $db->quote($uid)]
	);
}
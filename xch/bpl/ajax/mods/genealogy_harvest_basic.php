<?php

namespace BPL\Ajax\Mods\Harvest\Genealogy\Basic;

use Exception;

use function BPL\Mods\Local\Database\Query\fetch;
use function BPL\Mods\Local\Database\Query\fetch_all;
use function BPL\Mods\Local\Helpers\settings;

// Input validation with meaningful defaults
$id_user = filter_input(INPUT_POST, 'id_user', FILTER_VALIDATE_INT) ?? 0;
$plan = filter_input(INPUT_POST, 'plan', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';

try {
	echo generateNetworkTree($id_user, $plan);
} catch (Exception $e) {
	http_response_code(400);
	echo json_encode(['error' => $e->getMessage()]);
}

/**
 * Generates a JSON representation of the network tree
 * 
 * @param int $id_user User ID to generate tree for
 * @param string $plan Selected plan type
 * @return string JSON representation of the network tree
 * @throws Exception If invalid parameters provided
 */
function generateNetworkTree(int $id_user, string $plan): string
{
	if (!$id_user || !$plan) {
		throw new Exception('Invalid user ID or plan provided');
	}

	$head = harvest_user($id_user);

	if (!$head) {
		throw new Exception('User not found');
	}

	return json_encode(buildTreeData($head, $plan));
}

/**
 * Builds the tree data structure for a given user
 * 
 * @param object $user User object
 * @return array Tree data structure
 */
function buildTreeData(object $user): array
{
	// Step 1: Build the parent node
	$data = [
		'username' => $user->username,
		'details' => buildUserDetails($user)
	];

	// Step 2: Get and process direct children
	$children = getDownlines($user->id);

	if ($children) {
		$data['children'] = array_map(
			fn($child) => buildTreeData($child),
			$children
		);
	}

	return $data;
}

/**
 * Gets direct descendants (children) for a given user ID
 * 
 * @param int $userId Parent user ID
 * @return array Array of user objects
 */
function getDownlines(int $userId): array
{
	$harvest_id = user_harvest_basic($userId)->id;

	return fetch_all(
		'SELECT * ' .
		'FROM network_harvest_basic b ' .
		'INNER JOIN network_users u ' .
		'ON b.user_id = u.id ' .
		'WHERE harvest_upline_id = :harvest_upline_id',
		['harvest_upline_id' => $harvest_id]
	);
}

function buildUserDetails(object $user): array
{
	$balance = number_format($user->payout_transfer, 2);

	if (settings('ancillaries')->withdrawal_mode === 'standard') {
		$balance = number_format($user->balance, 2);
	}

	$details = [
		'username' => $user->username,
		'account' => settings('entry')->{$user->account_type . '_package_name'},
		'balance' => $balance,
		'bonus_harvest' => number_format(harvest_user($user->id)->bonus_harvest_basic_last, 2)
	];

	return $details;
}

/**
 * @param           $user_id
 *
 * @return mixed
 *
 * @since version
 */
function user_harvest_basic($user_id)
{
	return fetch(
		'SELECT * ' .
		'FROM network_harvest_basic ' .
		' WHERE user_id = :user_id' .
		' AND has_mature = :has_mature' .
		' AND is_active = :is_active',
		[
			'user_id' => $user_id,
			'has_mature' => '0',
			'is_active' => '1'
		]
	);
}

/**
 * @param $user_id
 *
 * @return mixed
 *
 * @since version
 */
function harvest_user($user_id)
{
	return fetch(
		'SELECT * ' .
		'FROM network_harvest ' .
		'WHERE user_id = :user_id',
		['user_id' => $user_id]
	);
}
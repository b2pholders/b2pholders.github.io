<?php

namespace BPL\Ajax\Mods\Binary\Genealogy;

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

	$head = userBinary($id_user);

	if (!$head) {
		throw new Exception('User not found');
	}

	return json_encode(buildTreeData($head, $plan));
}

function buildTreeData(object $user, string $plan): array
{
	// Step 1: Build the parent node
	$data = [
		'username' => $user->username,
		'details' => buildUserDetails($user, $plan)
	];

	// Step 2: Get and process direct children
	$children = getDownlines($user->id);

	if ($children) {
		$data['children'] = array_map(
			fn($child) => buildTreeData($child, $plan),
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
	return fetch_all(
		'SELECT * ' .
		'FROM network_users u ' .
		'INNER JOIN network_binary b ' .
		'ON u.id = b.user_id ' .
		'WHERE u.block = :block ' .
		'AND b.upline_id = :upline_id',
		[
			'upline_id' => $userId,
			'block' => 0
		]
	);
}

function buildUserDetails(object $user, string $plan): array
{
	$balance = number_format($user->payout_transfer, 2);

	if (settings('ancillaries')->withdrawal_mode === 'standard') {
		$balance = number_format($user->balance, 2);
	}

	$details = [
		'username' => $user->username,
		'account' => settings('entry')->{$user->account_type . '_package_name'},
		'balance' => $balance
	];

	$planAttributes = getPlanAttributes($user);

	if (isset($planAttributes[$plan])) {
		foreach ($planAttributes[$plan] as $field => $value) {
			$details[$field] = $value;
		}
	}

	return $details;
}

function userBinary($id_user)
{
	return fetch(
		'SELECT * ' .
		'FROM network_users u ' .
		'INNER JOIN network_binary b ' .
		'ON u.id = b.user_id ' .
		'WHERE u.id = :user_id',
		['user_id' => $id_user]
	);
}

function getPlanAttributes($user): array
{
	return [
		'binary_pair' => [
			'income_cycle' => number_format($user->income_cycle, 2),
			'position' => $user->position,
			'status' => ucfirst($user->status)
		],
		'passup_binary' => [
			'position' => $user->position,
			'passup_binary_bonus' => number_format($user->passup_binary_bonus, 2)
		]
	];
}
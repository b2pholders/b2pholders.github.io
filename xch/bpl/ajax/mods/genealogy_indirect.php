<?php

namespace BPL\Ajax\Mods\Indirect\Genealogy;

use Exception;

use function BPL\Mods\Local\Database\Query\fetch_all;
use function BPL\Mods\Local\Helpers\settings;
use function BPL\Mods\Local\Helpers\user;

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

	$head = user($id_user);

	if (!$head) {
		throw new Exception('User not found');
	}

	return json_encode(buildTreeData($head, $plan));
}

/**
 * Builds the tree data structure for a given user
 * 
 * @param object $user User object
 * @param string $plan Plan type
 * @return array Tree data structure
 */
function buildTreeData(object $user, string $plan): array
{
	$data = [
		'username' => $user->username,
		'details' => buildUserDetails($user, $plan)
	];

	$children = getDirects($user->id);

	if ($children) {
		$data['children'] = array_map(
			fn($child) => buildTreeData($child, $plan),
			$children
		);
	}

	return $data;
}

/**
 * Builds detailed user information including plan-specific attributes
 * 
 * @param object $user User object
 * @param string $plan Plan type
 * @return array User details
 */
function buildUserDetails(object $user, string $plan): array
{
	$details = [
		'username' => $user->username,
		'account' => settings('entry')->{$user->account_type . '_package_name'},
		'balance' => number_format($user->balance, 2)
	];

	$planAttributes = getPlanAttributes();

	if (isset($planAttributes[$plan])) {
		$planInfo = $planAttributes[$plan];
		$details['plan'] = $planInfo['code'];
		$details[$planInfo['field']] = number_format($user->{$planInfo['field']}, 2);
	}

	return $details;
}

/**
 * Retrieves direct children of a user
 * 
 * @param int $id Parent user ID
 * @return array Array of child users
 */
function getDirects(int $id): array
{
	return fetch_all(
		'SELECT * 
        FROM network_users 
        WHERE sponsor_id = :sponsor_id 
        AND block = :block',
		[
			'sponsor_id' => $id,
			'block' => 0
		]
	) ?: [];
}

/**
 * Returns plan attributes configuration
 * 
 * @return array Plan attributes configuration
 */
function getPlanAttributes(): array
{
	return [
		'indirect_referral' => ['code' => 'IR', 'field' => 'bonus_indirect_referral'],
		'unilevel' => ['code' => 'UB', 'field' => 'unilevel'],
		'echelon' => ['code' => 'EB', 'field' => 'bonus_echelon'],
		'leadership_binary' => ['code' => 'LB', 'field' => 'bonus_leadership'],
		'leadership_passive' => ['code' => 'LP', 'field' => 'bonus_leadership_passive']
	];
}
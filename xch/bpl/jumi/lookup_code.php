<?php

namespace BPL\Jumi\Lookup_Code;

require_once 'bpl/mods/helpers.php';

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\settings;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$code = input_get('code');

	page_validate();

	$str = menu();

	if ($code === '')
	{
		$str .= view_form();
	}
	else
	{
		$str .= view_result($code);
	}

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
	return '<h1>Search Code</h1>
	    <form method="post">
	        <table class="category table table-striped table-bordered table-hover">
	            <tr><td>
	                <input type="text" name="code" id="code" style="float:left" placeholder="Type code here">
	                <input type="submit" value="Search" class="uk-button uk-button-primary">                   
	            </td></tr>
	        </table>
	    </form>';
}

/**
 * @param $code
 *
 * @return mixed|null
 *
 * @since version
 */
function get_code($code)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_codes ' .
		'WHERE code LIKE ' . $db->quote($code)
	)->loadObject();
}

/**
 * @param $code
 *
 * @return string
 *
 * @since version
 */
function view_result($code): string
{
	$str = '<h1>Search Result</h1>';

	$result = get_code($code);

	if (!empty($result))
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
            <tr>
                <td style="width: 150px">Code:</td>
                <td>' . $result->code . '</td>
            </tr>
            <tr>
                <td style="width: 150px">User:</td>
                <td>';

		if ($result->user_id)
		{
			$member = user($result->user_id);

			$str .= '<a href="' . sef(44) . qs() . 'uid=' .
				$member->id . '">' . $member->username . '</a>';
		}
		else
		{
			$str .= ' --- ';
		}

		$str .= '</td>
            </tr>
            <tr>
                <td>Type:</td>
                <td>';

		$type_arr = explode('_', $result->type);
		$cd_type  = in_array('cd', $type_arr, true);

		$settings_entry = settings('entry');

		$str .= (!$cd_type ? $settings_entry->{$result->type . '_package_name'} :
			$settings_entry->{$type_arr[0] . '_package_name'} . ' CD');

		$str .= '</td>
            </tr>
        </table>';
	}
	else
	{
		$str .= '<p>Code not found!</p>';
	}

	$str .= '<a href="' . sef(42) . '" ' .
		'class="uk-button uk-button-primary">Search another code</a>';

	return $str;
}
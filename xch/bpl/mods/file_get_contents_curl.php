<?php

namespace BPL\Mods\File_Get_Contents_Curl;

/**
 * @param $url
 *
 * @return bool|string
 *
 * @since version
 */
function main($url)
{
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, (is_local() ? 3 : 2));
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, !is_local());
	curl_setopt($ch, CURLOPT_TIMEOUT, 1);
	curl_setopt($ch, CURLOPT_NOSIGNAL, 1);

	$data = curl_exec($ch);

	curl_close($ch);

	return $data;
}

/**
 * @param   bool  $state
 *
 * @return bool
 *
 * @since version
 */
function is_local(bool $state = true): bool
{
	return $state;
}
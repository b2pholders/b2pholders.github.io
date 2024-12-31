<?php

namespace BPL\Mods\API\Coinbrain\TokenPrice;

function main($url, $data)
{
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, (is_local() ? 3 : 2));
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, !is_local());
	curl_setopt($ch, CURLOPT_TIMEOUT, 1);
	curl_setopt($ch, CURLOPT_NOSIGNAL, true);

	$response = curl_exec($ch);

	curl_close($ch);

	return $response;
}

function is_local(bool $state = true): bool
{
	return $state;
}
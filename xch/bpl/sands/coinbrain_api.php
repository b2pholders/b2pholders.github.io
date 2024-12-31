<?php
//
//namespace BPL\Sands\API\Coinbrain\TokenPrice;
//
//$url = 'https://api.coinbrain.com/public/coin-info';
//
//$data = [
//	56 => ['0xac642e017764c4759efeb1c9ea0782cf5d1a81d1']
//];
//
//$results = json_decode(main($url, $data));
//$results = (array) $results[0];
//$price   = $results['priceUsd'];
//
//echo '<pre>';
//echo print_r($price, 1);
//echo '</pre>';
//
//function main($url, $data)
//{
//	$ch = curl_init();
//
//	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
//	curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
//	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
//	curl_setopt($ch, CURLOPT_HEADER, false);
//	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//	curl_setopt($ch, CURLOPT_URL, $url);
//	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
//	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, (is_local() ? 3 : 2));
//	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, !is_local());
//	curl_setopt($ch, CURLOPT_TIMEOUT, 1);
//	curl_setopt($ch, CURLOPT_NOSIGNAL, true);
//
//	$response = curl_exec($ch);
//
//	curl_close($ch);
//
//	return $response;
//}
//
//function is_local(bool $state = true): bool
//{
//	return $state;
//}
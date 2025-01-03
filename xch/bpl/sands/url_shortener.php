<?php
/*
This is a very basic example of a function that
uses v.gd's API in PHP to provide URL shortening.

For more details on the features and limitations
of the v.gd API please see the developer section
of our website at https://v.gd/developers.php

By Richard West for v.gd

All code in this file is released into the public
domain and may be used by anyone for any purpose.
*/

require_once '../bpl/mods/url_sef_local.php';

use function \Onewayhi\Url\Local\SEF\sef;

function vgdShorten($url, $shorturl = null)
{
	//$url - The original URL you want shortened
	//$shorturl - Your desired short URL (optional)

	//This function returns an array giving the results of your shortening
	//If successful $result["shortURL"] will give your new shortened URL
	//If unsuccessful $result["errorMessage"] will give an explanation of why
	//and $result["errorCode"] will give a code indicating the type of error

	//See https://v.gd/apishorteningreference.php#errcodes for an explanation of what the
	//error codes mean. In addition to that list this function can return an
	//error code of -1 meaning there was an internal error e.g. if it failed
	//to fetch the API page.

	$url      = urlencode($url);
	//$basepath = "https://v.gd/create.php?format=simple";
	//if you want to use is.gd instead, just swap the above line for the commented out one below
	$basepath = "https://is.gd/create.php?format=simple";
	$result                 = array();
	$result["errorCode"]    = -1;
	$result["shortURL"]     = null;
	$result["errorMessage"] = null;

	//We need to set a context with ignore_errors on otherwise PHP doesn't fetch
	//page content for failure HTTP status codes (v.gd needs this to return error
	//messages when using simple format)
	$opts    = array("http" => array("ignore_errors" => true));
	$context = stream_context_create($opts);

	if ($shorturl)
		$path = $basepath . "&shorturl=$shorturl&url=$url";
	else
		$path = $basepath . "&url=$url";

	$response = @file_get_contents($path, false, $context);

	if (!isset($http_response_header))
	{
		$result["errorMessage"] = "Local error: Failed to fetch API page";

		return ($result);
	}

	//Hacky way of getting the HTTP status code from the response headers
	if (!preg_match("{[0-9]{3}}", $http_response_header[0], $httpStatus))
	{
		$result["errorMessage"] = "Local error: Failed to extract HTTP status from result request";

		return ($result);
	}

	$errorCode = -1;
	switch ($httpStatus[0])
	{
		case 200:
			$errorCode = 0;
			break;
		case 400:
			$errorCode = 1;
			break;
		case 406:
			$errorCode = 2;
			break;
		case 502:
			$errorCode = 3;
			break;
		case 503:
			$errorCode = 4;
			break;
	}

	if ($errorCode == -1)
	{
		$result["errorMessage"] = "Local error: Unexpected response code received from server";

		return ($result);
	}

	$result["errorCode"] = $errorCode;
	if ($errorCode == 0)
		$result["shortURL"] = $response;
	else
		$result["errorMessage"] = $response;

	return ($result);
}


//some example code using the function above

$old_example = 'https://maps.google.co.uk/maps?f=q&source=s_q&hl=en&geocode=&q=louth&sll=53.800651,-4.064941&sspn=33.219383,38.803711&ie=UTF8&hq=&hnear=Louth,+United+Kingdom&z=14';
$new_example = 'http://onewayhi.com/account/' . sef(65) . '&s=admin';

$username = 'admin';

$result = vgdShorten($new_example, "onewayhi" . $username);
//below line would be how to request a custom URL instead of an automatically generated one
//in this case asking for https://v.gd/mytesturl
//$result = vgdShorten("https://www.reddit.com/","mytesturl");

if ($result["shortURL"])
	print("Success, your new shortened URL is " . $result["shortURL"] . "\n");
else
{
	print("There was an error, code: " . $result["errorCode"] . "\n");
	print($result["errorMessage"] . "\n");
}

if ($result["errorCode"] == 3)
{
	//Error code 3 means your app has exceeded our rate limit.
	//In a real app you'd take some action here to prevent it
	//from using v.gd again for 1 minute or so.
}
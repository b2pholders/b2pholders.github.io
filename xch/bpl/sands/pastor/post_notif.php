<?php

try
{
	$body = $_POST['paymentresponse'];

	$body = str_replace(' ', '+', $body);

	$Decodebody = base64_decode($body);

	$ServiceResponseWPF = new SimpleXMLElement($Decodebody);

	$application    = $ServiceResponseWPF->application;
	$responseStatus = $ServiceResponseWPF->responseStatus;

	// place merchant key here
	$cert = '';

	$forSign = '';

	$forSign .= $application->merchantid;
	$forSign .= $application->request_id;
	$forSign .= $application->response_id;
	$forSign .= $responseStatus->response_code;
	$forSign .= $responseStatus->response_message;
	$forSign .= $responseStatus->response_advise;
	$forSign .= $application->timestamp;
	$forSign .= $application->rebill_id;
	$forSign .= $cert;

	$_sign = hash('sha512', $forSign);

	echo 'DECODEd : </br></br> ';
	echo 'Response: ' . $ServiceResponseWPF->application->signature;
	echo '</br>computed:' . $_sign;

	if ($_sign === $ServiceResponseWPF->application->signature)
	{
		echo '</br>VALID SIGNATURE';
	}
	else
	{
		echo '</br>INVALID SIGNATURE';
	}

	$ourFileName = 'testFile2.txt';
	$ourFileHandle = fopen($ourFileName, 'wb') or die("can't open file");
	fclose($ourFileHandle);
	$myFile = 'testFile.txt';
	$fh = fopen($myFile, 'wb') or die("can't open file");

	fwrite($fh, $Decodebody . $body);
	fclose($fh);
}
catch (Exception $ex)
{
	echo $ex->getMessage();
}
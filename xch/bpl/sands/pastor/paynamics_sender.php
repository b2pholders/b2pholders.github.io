<?php

// <-- your merchant id here
$_mid = '';

$_requestid = substr(uniqid('', true), 0, 13);

$_ipaddress = '192.168.10.1';

// url where response is posted
$_noturl = '';

// url of merchant landing page
$_resurl = '';

// url of merchant landing page
$_cancelurl = '';

$_fname   = 'Juan';
$_mname   = 'dela';
$_lname   = 'Cruz';
$_addr1   = 'Dela Costa St.';
$_addr2   = 'Salcedo Village';
$_city    = 'makati';
$_state   = 'MM';
$_country = 'PH';
$_zip     = '1200';

// enabled
$_sec3d = '-';

$_email    = 'dummyemail.uno@gmail.com';
$_phone    = '3308772';
$_mobile   = '09171111111';
$_clientip = $_SERVER['REMOTE_ADDR'];
$_amount   = '1.00';
$_currency = 'PHP';

$forSign = '';

$forSign .= $_mid;
$forSign .= $_requestid;
$forSign .= $_ipaddress;
$forSign .= $_noturl;
$forSign .= $_resurl;
$forSign .= $_fname;
$forSign .= $_lname;
$forSign .= $_mname;
$forSign .= $_addr1;
$forSign .= $_addr2;
$forSign .= $_city;
$forSign .= $_state;
$forSign .= $_country;
$forSign .= $_zip;
$forSign .= $_email;
$forSign .= $_phone;
$forSign .= $_clientip;
$forSign .= $_amount;
$forSign .= $_currency;
$forSign .= $_sec3d;

// <-- your merchant key here
$cert = '';

$_sign = hash('sha512', $forSign . $cert);

$strxml = '';

$strxml .= '<?xml version="1.0" encoding="utf-8" ?>';
$strxml .= '<Request>';
$strxml .= '<orders>';
$strxml .= '<items>';
$strxml .= '<Items>';
$strxml .= '<itemname>item 1</itemname><quantity>1</quantity><amount>1.00</amount>';
$strxml .= '</Items>';
$strxml .= '</items>';
$strxml .= '</orders>';
$strxml .= '<mid>' . $_mid . '</mid>';
$strxml .= '<request_id>' . $_requestid . '</request_id>';
$strxml .= '<ip_address>' . $_ipaddress . '</ip_address>';
$strxml .= '<notification_url>' . $_noturl . '</notification_url>';
$strxml .= '<response_url>' . $_resurl . '</response_url>';
$strxml .= '<cancel_url>' . $_cancelurl . '</cancel_url>';
$strxml .= '<mtac_url>http://www.paynamics.com/index.html</mtac_url>';
$strxml .= '<descriptor_note>"My Descriptor .18008008008"</descriptor_note>';
$strxml .= '<fname>' . $_fname . '</fname>';
$strxml .= '<lname>' . $_lname . '</lname>';
$strxml .= '<mname>' . $_mname . '</mname>';
$strxml .= '<address1>' . $_addr1 . '</address1>';
$strxml .= '<address2>' . $_addr2 . '</address2>';
$strxml .= '<city>' . $_city . '</city>';
$strxml .= '<state>' . $_state . '</state>';
$strxml .= '<country>' . $_country . '</country>';
$strxml .= '<zip>' . $_zip . '</zip>';
$strxml .= '<secure3d>' . $_sec3d . '</secure3d>';
$strxml .= '<trxtype>sale</trxtype>';
$strxml .= '<email>' . $_email . '</email>';
$strxml .= '<phone>' . $_phone . '</phone>';
$strxml .= '<mobile>' . $_mobile . '</mobile>';
$strxml .= '<client_ip>' . $_clientip . '</client_ip>';
$strxml .= '<amount>' . $_amount . '</amount>';
$strxml .= '<currency>' . $_currency . '</currency>';
$strxml .= '<mlogo_url>http://domain.net/images/paytravel_logo.png</mlogo_url>';

// CC, GC, PP, DP
$strxml .= '<pmethod></pmethod>';

$strxml .= '<signature>' . $_sign . '</signature>';
$strxml .= '</Request>';

$b64string = base64_encode($strxml);

echo $_mid . '<hr>';
echo $cert . '<hr>';
echo $forSign . '<hr>';

echo '<pre>' . $strxml . '</pre><hr>';
echo $b64string . '<hr>';

$form = '';

$form .= '<form name="form1" method="post" action="https://test.ecommpay.net/webpaymentv2/default.aspx">';
$form .= '<input type="text" name="paymentrequest" id="paymentrequest" value="';
$form .= $b64string;
$form .= '" style="width:800px; padding: 10px;">';
$form .= '<input type="submit">';
$form .= '</form>';

echo $form;
<?php

namespace BPL\Mods\Mailer;

require_once 'bpl/mods/helpers.php';

use Exception;
use JConfig;

use Joomla\CMS\Factory;
use Joomla\CMS\Mail\Mail;
use Joomla\Registry\Registry;

use function BPL\Mods\Helpers\settings;

/**
 * @param          $message
 * @param          $subject
 * @param   array  $recipients
 *
 * @since version
 */
function main($message, $subject, array $recipients = [])
{
	/*$email_official = settings('ancillaries')->email_official;

	$mailer = Mail::getInstance();

	if (!is_local())
	{
		$conf = config();

// 		$mailer->isSMTP();
		$mailer->Host       = $conf->get('smtphost'); //'smtp.hostinger.com';
		$mailer->SMTPAuth   = $conf->get('smtpauth'); //'1';
		$mailer->Username   = $conf->get('smtpuser'); //'admin@wrhtrading.com';
		$mailer->Password   = $conf->get('smtppass'); //'Hpj9w9ebG2VW6xFQ';
		$mailer->SMTPSecure = $conf->get('smtpsecure'); //'none';
		$mailer->Port       = $conf->get('smtpport'); //587;
	}

	$sender = [$email_official, 'Alerts'];

	$mailer->setSender($sender);
	$mailer->addRecipient($email_official);

	if (!empty($recipients))
	{
		foreach ($recipients as $recipient)
		{
			if ($recipient !== '')
			{
				$mailer->addRecipient($recipient);
			}
		}
	}

	$mailer->setSubject($subject);
	$mailer->isHTML(true);
	$mailer->Encoding = 'base64';
	$mailer->setBody($message);
	$mailer->Send();*/
}

/**
 *
 * @return bool
 *
 * @since version
 */
function is_local(): bool
{
	$whitelist = ['127.0.0.1', '::1'];

	return in_array($_SERVER['REMOTE_ADDR'], $whitelist);
}

/**
 *
 * @return JConfig|Registry|object
 *
 * @since version
 */
function config()
{
	$conf = null;

	try
	{
		$conf = Factory::getConfig();
	}
	catch (Exception $e)
	{
	}

	return !is_null($conf) ? $conf : (object) [];
}
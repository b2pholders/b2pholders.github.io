<?php

namespace BPL\Lib\Local\Database;

use Joomla\CMS\Mail\Mail;

$dbhost = 'localhost';
$dbuser = 'usuario_aqui';
$dbpass = 'password_aqui';
$dbname = 'database_aqui';

// Seu e-mail aqui
$sendto = 'Eu <eu@exemplo.com>';

// O remetente. Pode ser backup@seusite.com
$sendfrom = 'Backup <backup@exemplo.com>';

// Assunto do e-mail
$sendsubject = 'Backup do site ' . date('d/m/Y');

// Corpo do e-mail
$bodyofemail = 'Backup diário do meu site';

$backupfile = 'Autobackup_' . date("Ymd") . '.sql';
$backupzip = $backupfile . '.tar.gz';
system("mysqldump -h $dbhost -u $dbuser -p$dbpass --lock-tables $dbname > $backupfile");
system("tar -czvf $backupzip $backupfile");

include('Mail.php');
include('Mail/mime.php');

$message = new Mail_mime();
$text = "$bodyofemail";
$message->setTXTBody($text);
$message->AddAttachment($backupzip);
$body = $message->get(array(
	'head_charset' => 'utf-8',
	'text_charset' => 'utf-8',
	'html_charset' => 'utf-8'
));
$extraheaders = array("From"=>"$sendfrom", "Subject"=>"$sendsubject");
$headers = $message->headers($extraheaders);
$mail = Mail::factory("mail");
$mail->send("$sendto", $headers, $body);

// Remover o arquivo do servidor (opcional)
unlink($backupzip);
unlink($backupfile);
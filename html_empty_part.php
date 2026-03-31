<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$htmlPart = new Horde_Mime_Part();
$htmlPart->setType('text/html');
$htmlPart->setCharset('UTF-8');
$htmlPart->setContents('');
$htmlPart->setDescription('HTML Version of Message');

/*
 * To add the Mime-Version-Header
 */
$htmlPart->isBasePart(true);

$mail = new Horde_Mime_Mail();
$mail->addHeaders([
    'From' => 'alice@test.local',
    'To' => 'jane@doe.local',
    'Subject' => 'Empty html part',
]);
$mail->setBasePart($htmlPart);

$transport = new Horde_Mail_Transport_Smtphorde([
    'localhost' => 'localhost',
    'host' => 'localhost',
    'port' => 1025,
    'username' => 'alice@test.local',
    'password' => 'alice',
    'secure' => false
]);

$mail->send($transport, false, false);

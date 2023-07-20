<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$basePart = new Horde_Mime_Part();
$basePart->setType('multipart/mixed');

$htmlPart1 = new Horde_Mime_Part();
$htmlPart1->setType('text/html');
$htmlPart1->setCharset('UTF-8');
$htmlPart1->setContents('<html><meta http-equiv="content-type" content="text/html; charset=UTF-8"><body>Hello Hello</body><html>');
$htmlPart1->setDescription('HTML Version of Message');
$basePart[] = $htmlPart1;

$htmlPart2 = new Horde_Mime_Part();
$htmlPart2->setType('text/html');
$htmlPart2->setCharset('UTF-8');
$htmlPart2->setContents('<html><meta http-equiv="content-type" content="text/html; charset=UTF-8"><body>Hope you are dooing fine</body><html>');
$htmlPart2->setDescription('HTML Version of Message');
$basePart[] = $htmlPart2;

/*
 * To add the Mime-Version-Header
 */
$basePart->isBasePart(true);

$mail = new Horde_Mime_Mail();
$mail->addHeaders([
    'From' => 'alice@test.local',
    'To' => 'jane@doe.local',
    'Subject' => 'Multipart with multiple parts',
]);
$mail->setBasePart($basePart);

$transport = new Horde_Mail_Transport_Smtphorde([
    'localhost' => 'localhost',
    'host' => 'localhost',
    'port' => 25,
    'username' => 'alice@test.local',
    'password' => 'alice',
    'secure' => false
]);

$mail->send($transport, false, false);
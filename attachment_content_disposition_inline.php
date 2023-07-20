<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$alternativePart = new Horde_Mime_Part();
$alternativePart->setType('multipart/alternative');

$htmlPart = new Horde_Mime_Part();
$htmlPart->setType('text/html');
$htmlPart->setCharset('UTF-8');
$htmlPart->setContents('<html><meta http-equiv="content-type" content="text/html; charset=UTF-8"><body>Hello Hello</body><html>');
$htmlPart->setDescription('HTML Version of Message');
$alternativePart[] = $htmlPart;

$textPart = new Horde_Mime_Part();
$textPart->setType('text/plain');
$textPart->setCharset('UTF-8');
$textPart->setContents('Hello Hello');
$textPart->setDescription('Plaintext Version of Message');
$alternativePart[] = $textPart;

$basePart = new Horde_Mime_Part();
$basePart->setType('multipart/mixed');
$basePart[] = $alternativePart;

$attachment1 = new Horde_Mime_Part();
$attachment1->setCharset('us-ascii');
$attachment1->setDisposition('inline');
$attachment1->setName('some.patch');
$attachment1->setContents('hello world');
$attachment1->setType('text/x-patch');
$basePart[] = $attachment1;

/*
 * To add the Mime-Version-Header
 */
$basePart->isBasePart(true);

$mail = new Horde_Mime_Mail();
$mail->addHeaders([
    'From' => 'alice@test.local',
    'To' => 'jane@doe.local',
    'Subject' => 'Patches',
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
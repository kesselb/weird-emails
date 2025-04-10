<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$contents = '<html><meta http-equiv="content-type" content="text/html; charset=UTF-8"><body>Hi, email with a quoted from header</body><html>';

$basePart = new Horde_Mime_Part();
$basePart->setType('text/html');
$basePart->setCharset('UTF-8');
$basePart->setContents($contents);
$basePart->setDescription('HTML Version of Message');

/*
 * To add the Mime-Version-Header
 */
$basePart->isBasePart(true);

$mail = new Horde_Mime_Mail();
$mail->addHeaders([
    'From' => "'alice@test.local'",
    'To' => 'jane@doe.local',
    'Subject' => 'Quoted from',
]);
$mail->setBasePart($basePart);

$transport = new Horde_Mail_Transport_Smtphorde([
    'localhost' => 'localhost',
    'host' => 'localhost',
    'port' => 1025,
    'username' => 'alice@test.local',
    'password' => 'alice',
    'secure' => false
]);

$mail->send($transport, false, false);

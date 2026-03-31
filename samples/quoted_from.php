<?php

declare(strict_types=1);

require __DIR__ . '/../config.php';

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
    'From' => "'walter@static.test'",
    'To' =>  'wendy@static.test',
    'Subject' => 'Quoted from',
]);
$mail->setBasePart($basePart);

// docker-imap-devel wont accept emails using a from header with quotes around
// workaround: use mailpit as recipient and export/import manually
$localTransport = new Horde_Mail_Transport_Smtphorde([
    'localhost' => 'localhost',
    'host' => 'localhost',
    'port' => 1025,
    'secure' => false,
]);

$mail->send($localTransport, false, false);

<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$attachment = new Horde_Mime_Part();
$attachment->setCharset('us-ascii');
$attachment->setDisposition('attachment');
$attachment->setName('some.patch');
$attachment->setContents('hello world');
$attachment->setType('text/x-patch');
$attachment->setTransferEncoding('base64');

/*
 * To add the Mime-Version-Header
 */
$attachment->isBasePart(true);

$mail = new Horde_Mime_Mail();
$mail->addHeaders([
    'From' => 'alice@test.local',
    'To' => 'jane@doe.local',
    'Subject' => 'Email with attachment only',
]);
$mail->setBasePart($attachment);

$transport = new Horde_Mail_Transport_Smtphorde([
    'localhost' => 'localhost',
    'host' => 'localhost',
    'port' => 1025,
    'username' => 'alice@test.local',
    'password' => 'alice',
    'secure' => false
]);

$mail->send($transport, false, false);

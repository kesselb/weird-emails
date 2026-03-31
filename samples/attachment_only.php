<?php

declare(strict_types=1);

require __DIR__ . '/../config.php';

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
    'From' => $defaultFrom,
    'To' =>  $defaultTo,
    'Subject' => 'Email with attachment only',
]);
$mail->setBasePart($attachment);

$mail->send($transport, false, false);

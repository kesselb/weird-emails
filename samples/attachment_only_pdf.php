<?php

declare(strict_types=1);

require __DIR__ . '/../config.php';

$attachment = new Horde_Mime_Part();
$attachment->setType('application/pdf');
$attachment->setDisposition('attachment');
$attachment->setName('document.pdf');
$attachment->setContents("%PDF-1.4\nTest PDF\n");
$attachment->setTransferEncoding('base64');

/*
 * To add the Mime-Version-Header
 */
$attachment->isBasePart(true);

$mail = new Horde_Mime_Mail();
$mail->addHeaders([
    'From' => $defaultFrom,
    'To' =>  $defaultTo,
    'Subject' => 'Single part attachment',
]);
$mail->setBasePart($attachment);

$mail->send($transport, false, false);

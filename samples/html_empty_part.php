<?php

declare(strict_types=1);

require __DIR__ . '/../config.php';

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
    'From' => $defaultFrom,
    'To' =>  $defaultTo,
    'Subject' => 'Empty html part',
]);
$mail->setBasePart($htmlPart);

$mail->send($transport, false, false);

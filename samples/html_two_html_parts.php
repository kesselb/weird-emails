<?php

declare(strict_types=1);

require __DIR__ . '/../config.php';

$basePart = new Horde_Mime_Part();
$basePart->setType('multipart/alternative');

$htmlPart1 = new Horde_Mime_Part();
$htmlPart1->setType('text/html');
$htmlPart1->setCharset('UTF-8');
$htmlPart1->setContents('<html><meta http-equiv="content-type" content="text/html; charset=UTF-8"><body><h1>Part 1</h1><p>This is part 1</p></body><html>');
$htmlPart1->setDescription('HTML Version of Message');
$basePart[] = $htmlPart1;

$htmlPart2 = new Horde_Mime_Part();
$htmlPart2->setType('text/html');
$htmlPart2->setCharset('UTF-8');
$htmlPart2->setContents('<html><meta http-equiv="content-type" content="text/html; charset=UTF-8"><body><h1>Part 2</h1><p>This is part 2</p></body><html>');
$htmlPart2->setDescription('HTML Version of Message');
$basePart[] = $htmlPart2;

/*
 * To add the Mime-Version-Header
 */
$basePart->isBasePart(true);

$mail = new Horde_Mime_Mail();
$mail->addHeaders([
    'From' => $defaultFrom,
    'To' =>  $defaultTo,
    'Subject' => 'Multipart alternative with two html parts',
]);
$mail->setBasePart($basePart);

$mail->send($transport, false, false);

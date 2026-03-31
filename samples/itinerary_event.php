<?php

declare(strict_types=1);

use Spatie\SchemaOrg\Schema;

require __DIR__ . '/../config.php';

$today = new DateTime();
$today->setTime(14, 0, 0);

$person = Schema::person()
    ->name('Alice');
$location = Schema::virtualLocation()
    ->name('Talk');
$event = Schema::event()
    ->name('Itinerary brainstorming')
    ->startDate((clone $today)->add(new DateInterval('P14D')))
    ->location($location);
$eventReservation = Schema::eventReservation()
    ->reservationId('3000-1')
    ->reservationStatus(\Spatie\SchemaOrg\ReservationStatusType::ReservationConfirmed)
    ->underName($person)
    ->reservationFor($event);

$script = $eventReservation->toScript();

$contents = '<html><meta http-equiv="content-type" content="text/html; charset=UTF-8"><body>Hi, lets do some itinerary brainstorming'
    . PHP_EOL . $script . '</body><html>';

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
    'From' => $defaultFrom,
    'To' =>  $defaultTo,
    'Subject' => 'Itinerary brainstorming',
]);
$mail->setBasePart($basePart);

$mail->send($transport, false, false);

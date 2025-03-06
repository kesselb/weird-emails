<?php

declare(strict_types=1);

use Spatie\SchemaOrg\Schema;

require __DIR__ . '/vendor/autoload.php';

$today = new DateTime();
$today->setTime(14, 0, 0);

$departureStation = Schema::trainStation()
    ->name('Berlin');
$arrivalStation = Schema::trainStation()
    ->name('Paris');
$trainTrip = Schema::trainTrip()
    ->departureStation($departureStation)
    ->departureTime((clone $today)->add(new DateInterval('P14D')))
    ->arrivalStation($arrivalStation)
    ->arrivalTime((clone $today)->add(new DateInterval('P14DT2H')));
$trainReservation = Schema::trainReservation()
    ->reservationId('2000-1')
    ->reservationStatus(\Spatie\SchemaOrg\ReservationStatusType::ReservationConfirmed)
    ->reservationFor($trainTrip);

$script = $trainReservation->toScript();

$contents = '<html><meta http-equiv="content-type" content="text/html; charset=UTF-8"><body>Hi, enjoy your trip from Berlin to Paris!'
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
    'From' => 'alice@test.local',
    'To' => 'jane@doe.local',
    'Subject' => 'Train trip from Berlin to Paris',
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

<?php

declare(strict_types=1);

use Spatie\SchemaOrg\Schema;

require __DIR__ . '/vendor/autoload.php';

$today = new DateTime();
$today->setTime(14, 0, 0);

$person = Schema::person()
    ->name('Alice');
$airline = Schema::airline()
    ->name('Sample Airline')
    ->iataCode('ABC');
$departureAirport = Schema::airport()
    ->name('Berlin')
    ->iataCode('BER');
$arrivalAirport = Schema::airport()
    ->name('Paris')
    ->iataCode('CDG');
$flight = Schema::flight()
    ->flightNumber('1000')
    ->provider($airline)
    ->departureAirport($departureAirport)
    ->departureTime((clone $today)->add(new DateInterval('P1D')))
    ->arrivalAirport($arrivalAirport)
    ->arrivalTime((clone $today)->add(new DateInterval('P1DT2H')));
$flightReservation = Schema::flightReservation()
    ->reservationId('1000-1')
    ->reservationStatus(\Spatie\SchemaOrg\ReservationStatusType::ReservationConfirmed)
    ->underName($person)
    ->reservationFor($flight);

$script = $flightReservation->toScript();

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
    'Subject' => 'Flight from Berlin to Paris',
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

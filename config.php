<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

/**
 * https://github.com/ChristophWurst/docker-imap-devel/
 */

$defaultFrom = 'walter@static.test';
$defaultTo = 'wendy@static.test';

$transport = new Horde_Mail_Transport_Smtphorde([
    'localhost' => 'localhost',
    'host' => 'localhost',
    'port' => 25,
    'username' => 'walter@static.test',
    'password' => 'staticpassword',
    'secure' => false,
]);

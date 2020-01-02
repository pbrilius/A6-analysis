<?php require_once __DIR__ . '/vendor/autoload.php';

use GO\Scheduler;

// Create a new scheduler
$scheduler = new Scheduler();

chdir(__DIR__);
$scheduler->raw('php spark spotify:grant')->hourly();

// Let the scheduler execute jobs which are due.
$scheduler->run();

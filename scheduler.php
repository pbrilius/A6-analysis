<?php require_once __DIR__ . '/vendor/autoload.php';

use GO\Scheduler;

// Create a new scheduler
$scheduler = new Scheduler();

chdir(__DIR__);
$scheduler->raw('php spark spotify:grant')->hourly();
$scheduler->raw('php spark spotify:access')->daily(22, 07);

// Let the scheduler execute jobs which are due.
$scheduler->run();

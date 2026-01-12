<?php
/**
 * Laravel index.php wrapper for subdirectory installation (/traderscap)
 * Properly sets up server variables to maintain subdirectory awareness
 */

// Ensure REQUEST_URI includes the subdirectory path for Laravel's URL generation
if (!str_contains($_SERVER['REQUEST_URI'], '/traderscap')) {
    $_SERVER['REQUEST_URI'] = '/traderscap' . $_SERVER['REQUEST_URI'];
}

// Set SCRIPT_NAME to the subdirectory entry point
if (!str_contains($_SERVER['SCRIPT_NAME'], '/traderscap')) {
    $_SERVER['SCRIPT_NAME'] = '/traderscap/index.php';
}

// Require the Laravel application
require __DIR__ . '/public/index.php';


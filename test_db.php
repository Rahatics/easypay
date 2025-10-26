<?php

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

// Test with root user first
$connections = [
    [
        'name' => 'Root user',
        'host' => '127.0.0.1',
        'database' => 'saimumba_easypay',
        'username' => 'root',
        'password' => '',
    ],
    [
        'name' => 'Provided credentials',
        'host' => '127.0.0.1',
        'database' => 'saimumba_easypay',
        'username' => 'saimumba_easypay',
        'password' => 'saimumba_easypay',
    ]
];

foreach ($connections as $connection) {
    echo "Testing connection with " . $connection['name'] . "...\n";

    try {
        // Create capsule instance
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => $connection['host'],
            'port'      => '3306',
            'database'  => $connection['database'],
            'username'  => $connection['username'],
            'password' => $connection['password'],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        // Test the connection
        $capsule->connection()->select('SELECT 1');
        echo "✓ Connection successful with " . $connection['name'] . "!\n";
        echo "Database: " . $connection['database'] . "\n";
        echo "User: " . $connection['username'] . "\n";
        break;
    } catch (Exception $e) {
        echo "✗ Connection failed with " . $connection['name'] . ": " . $e->getMessage() . "\n\n";
    }
}

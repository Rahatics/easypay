<?php
/**
 * Database Connection Test Script for cPanel
 * Upload this file to your cPanel and run it to test database connectivity
 */

// Include the autoloader
require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

// Load environment variables
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    echo "✓ Environment variables loaded\n";
} catch (Exception $e) {
    echo "⚠ Could not load .env file, using default values\n";
    // Set default values
    $_ENV['DB_HOST'] = 'localhost';
    $_ENV['DB_PORT'] = '3306';
    $_ENV['DB_DATABASE'] = 'saimumba_easypay';
    $_ENV['DB_USERNAME'] = 'saimumba_easypay';
    $_ENV['DB_PASSWORD'] = 'saimumba_easypay';
}

echo "Testing database connection with:\n";
echo "Host: " . $_ENV['DB_HOST'] . "\n";
echo "Database: " . $_ENV['DB_DATABASE'] . "\n";
echo "Username: " . $_ENV['DB_USERNAME'] . "\n";
// Don't echo password for security

// Create capsule instance
$capsule = new Capsule;

try {
    echo "Connecting to database...\n";
    
    $capsule->addConnection([
        'driver'    => 'mysql',
        'host'      => $_ENV['DB_HOST'],
        'port'      => $_ENV['DB_PORT'],
        'database'  => $_ENV['DB_DATABASE'],
        'username'  => $_ENV['DB_USERNAME'],
        'password' => $_ENV['DB_PASSWORD'],
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ]);

    // Test the connection
    $capsule->connection()->select('SELECT 1');
    echo "✓ Database connection successful!\n";
    
    // Show existing tables
    try {
        $tables = $capsule->schema()->getConnection()->select('SHOW TABLES');
        echo "Existing tables:\n";
        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            echo "- " . $tableName . "\n";
        }
    } catch (Exception $e) {
        echo "⚠ Could not retrieve table list: " . $e->getMessage() . "\n";
    }
    
} catch (Exception $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
    echo "Please check your database credentials in the .env file.\n";
}
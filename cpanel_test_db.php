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

// Create capsule instance with options to avoid plugin issues
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
        'options' => [
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
            // Disable SSL if it's causing issues
            PDO::MYSQL_ATTR_SSL_KEY => null,
            PDO::MYSQL_ATTR_SSL_CERT => null,
            PDO::MYSQL_ATTR_SSL_CA => null,
        ],
    ]);

    // Test the connection
    $capsule->connection()->select('SELECT 1');
    echo "✓ Database connection successful!\n";
    
    // Show existing tables using a simpler query
    try {
        $tables = $capsule->connection()->select('SHOW TABLES');
        echo "Existing tables:\n";
        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            echo "- " . $tableName . "\n";
        }
    } catch (Exception $e) {
        echo "⚠ Could not retrieve table list: " . $e->getMessage() . "\n";
        // Try alternative method
        try {
            $result = $capsule->connection()->select('SHOW TABLE STATUS');
            echo "Tables (alternative method):\n";
            foreach ($result as $row) {
                echo "- " . $row->Name . "\n";
            }
        } catch (Exception $e2) {
            echo "⚠ Alternative method also failed: " . $e2->getMessage() . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
    echo "Common solutions:\n";
    echo "1. Check your database credentials in the .env file\n";
    echo "2. Verify the database exists in your cPanel\n";
    echo "3. Check if your hosting provider requires a specific host (not localhost)\n";
    echo "4. Contact your hosting provider about the MySQL plugin issue\n";
}
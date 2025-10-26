<?php
/**
 * Manual Migration Script for cPanel Deployment
 * This script can be run directly on cPanel to set up the database
 */

// Include the autoloader
require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Database\Schema\Blueprint;

// Load environment variables
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} catch (Exception $e) {
    // If .env loading fails, set default values
    $_ENV['DB_HOST'] = $_ENV['DB_HOST'] ?? 'localhost';
    $_ENV['DB_PORT'] = $_ENV['DB_PORT'] ?? '3306';
    $_ENV['DB_DATABASE'] = $_ENV['DB_DATABASE'] ?? 'saimumba_easypay';
    $_ENV['DB_USERNAME'] = $_ENV['DB_USERNAME'] ?? 'saimumba_easypay';
    $_ENV['DB_PASSWORD'] = $_ENV['DB_PASSWORD'] ?? 'saimumba_easypay';
}

// Create capsule instance with options to avoid plugin issues
$capsule = new Capsule;

try {
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

    // Set the event dispatcher used by Eloquent models
    $capsule->setEventDispatcher(new Dispatcher(new Container));

    // Make this Capsule instance available globally via static methods
    $capsule->setAsGlobal();

    // Setup the Eloquent ORM
    $capsule->bootEloquent();

    echo "✓ Database connection established successfully\n";

} catch (Exception $e) {
    die("✗ Database connection failed: " . $e->getMessage() . "\n");
}

echo "Starting database migration...\n\n";

// Function to check if table exists using a simpler query
function tableExists($capsule, $tableName) {
    try {
        $result = $capsule->connection()->select("SHOW TABLES LIKE '$tableName'");
        return !empty($result);
    } catch (Exception $e) {
        echo "Warning: Could not check if table $tableName exists: " . $e->getMessage() . "\n";
        return false;
    }
}

// Function to create table with error handling
function createTable($capsule, $tableName, $callback) {
    try {
        if (!tableExists($capsule, $tableName)) {
            $capsule->schema()->create($tableName, $callback);
            echo "✓ Created $tableName table\n";
        } else {
            echo "✓ $tableName table already exists\n";
        }
    } catch (Exception $e) {
        echo "⚠ Warning: Could not create $tableName table: " . $e->getMessage() . "\n";
        // Try a simpler approach
        try {
            // Just check if we can access the table
            $capsule->connection()->select("SELECT 1 FROM $tableName LIMIT 1");
            echo "✓ $tableName table accessible\n";
        } catch (Exception $innerE) {
            echo "✗ $tableName table not accessible: " . $innerE->getMessage() . "\n";
        }
    }
}

try {
    // Create users table
    createTable($capsule, 'users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->string('api_key')->nullable();
        $table->string('secret_key')->nullable();
        $table->string('merchant_id')->nullable();
        $table->string('website_name')->nullable();
        $table->string('logo')->nullable();
        $table->rememberToken();
        $table->timestamps();
    });

    // Create password_reset_tokens table
    createTable($capsule, 'password_reset_tokens', function (Blueprint $table) {
        $table->string('email')->primary();
        $table->string('token');
        $table->timestamp('created_at')->nullable();
    });

    // Create failed_jobs table
    createTable($capsule, 'failed_jobs', function (Blueprint $table) {
        $table->id();
        $table->string('uuid')->unique();
        $table->text('connection');
        $table->text('queue');
        $table->longText('payload');
        $table->longText('exception');
        $table->timestamp('failed_at')->useCurrent();
    });

    // Create personal_access_tokens table
    createTable($capsule, 'personal_access_tokens', function (Blueprint $table) {
        $table->id();
        $table->morphs('tokenable');
        $table->string('name');
        $table->string('token', 64)->unique();
        $table->text('abilities')->nullable();
        $table->timestamp('last_used_at')->nullable();
        $table->timestamp('expires_at')->nullable();
        $table->timestamps();
    });

    // Create jobs table
    createTable($capsule, 'jobs', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('queue')->index();
        $table->longText('payload');
        $table->unsignedTinyInteger('attempts');
        $table->unsignedInteger('reserved_at')->nullable();
        $table->unsignedInteger('available_at');
        $table->unsignedInteger('created_at');
    });

    // Create job_batches table
    createTable($capsule, 'job_batches', function (Blueprint $table) {
        $table->string('id')->primary();
        $table->string('name');
        $table->integer('total_jobs');
        $table->integer('pending_jobs');
        $table->integer('failed_jobs');
        $table->longText('failed_job_ids');
        $table->mediumText('options')->nullable();
        $table->integer('cancelled_at')->nullable();
        $table->integer('created_at');
        $table->integer('finished_at')->nullable();
    });

    // Create sessions table
    createTable($capsule, 'sessions', function (Blueprint $table) {
        $table->string('id')->primary();
        $table->foreignId('user_id')->nullable()->index();
        $table->string('ip_address', 45)->nullable();
        $table->text('user_agent')->nullable();
        $table->longText('payload');
        $table->integer('last_activity')->index();
    });

    // Create orders table
    createTable($capsule, 'orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('order_id')->unique();
        $table->decimal('amount', 10, 2);
        $table->string('currency')->default('BDT');
        $table->string('status')->default('pending');
        $table->string('payment_method')->nullable();
        $table->string('transaction_id')->nullable();
        $table->text('description')->nullable();
        $table->string('customer_name')->nullable();
        $table->string('customer_email')->nullable();
        $table->string('customer_phone')->nullable();
        $table->text('customer_address')->nullable();
        $table->timestamps();
    });

    // Create merchant_gateways table
    createTable($capsule, 'merchant_gateways', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('gateway_name');
        $table->string('gateway_type');
        $table->json('credentials');
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });

    echo "\n✓ Migration process completed!\n";
    echo "Note: Some warnings may appear above, but the essential tables should be created.\n";

} catch (Exception $e) {
    echo "✗ Migration failed: " . $e->getMessage() . "\n";
    echo "You may need to create tables manually using your cPanel MySQL interface.\n";
}

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

// Create capsule instance
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

try {
    // Create users table
    if (!$capsule->schema()->hasTable('users')) {
        $capsule->schema()->create('users', function (Blueprint $table) {
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
        echo "✓ Created users table\n";
    } else {
        echo "✓ Users table already exists\n";
    }

    // Create password_reset_tokens table
    if (!$capsule->schema()->hasTable('password_reset_tokens')) {
        $capsule->schema()->create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
        echo "✓ Created password_reset_tokens table\n";
    } else {
        echo "✓ Password_reset_tokens table already exists\n";
    }

    // Create failed_jobs table
    if (!$capsule->schema()->hasTable('failed_jobs')) {
        $capsule->schema()->create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
        echo "✓ Created failed_jobs table\n";
    } else {
        echo "✓ Failed_jobs table already exists\n";
    }

    // Create personal_access_tokens table
    if (!$capsule->schema()->hasTable('personal_access_tokens')) {
        $capsule->schema()->create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
        echo "✓ Created personal_access_tokens table\n";
    } else {
        echo "✓ Personal_access_tokens table already exists\n";
    }

    // Create jobs table
    if (!$capsule->schema()->hasTable('jobs')) {
        $capsule->schema()->create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });
        echo "✓ Created jobs table\n";
    } else {
        echo "✓ Jobs table already exists\n";
    }

    // Create job_batches table
    if (!$capsule->schema()->hasTable('job_batches')) {
        $capsule->schema()->create('job_batches', function (Blueprint $table) {
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
        echo "✓ Created job_batches table\n";
    } else {
        echo "✓ Job_batches table already exists\n";
    }

    // Create sessions table
    if (!$capsule->schema()->hasTable('sessions')) {
        $capsule->schema()->create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
        echo "✓ Created sessions table\n";
    } else {
        echo "✓ Sessions table already exists\n";
    }

    // Create orders table
    if (!$capsule->schema()->hasTable('orders')) {
        $capsule->schema()->create('orders', function (Blueprint $table) {
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
        echo "✓ Created orders table\n";
    } else {
        echo "✓ Orders table already exists\n";
    }

    // Create merchant_gateways table
    if (!$capsule->schema()->hasTable('merchant_gateways')) {
        $capsule->schema()->create('merchant_gateways', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('gateway_name');
            $table->string('gateway_type');
            $table->json('credentials');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        echo "✓ Created merchant_gateways table\n";
    } else {
        echo "✓ Merchant_gateways table already exists\n";
    }

    echo "\n✓ All migrations completed successfully!\n";
    echo "Your database is now ready for use.\n";

} catch (Exception $e) {
    echo "✗ Migration failed: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

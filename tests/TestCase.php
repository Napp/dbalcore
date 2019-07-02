<?php

namespace Napp\Core\Dbal\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Napp\Core\Dbal\Builder\BuilderServiceProvider;
use Napp\Core\Dbal\Criteria\CriteriaServiceProvider;
use Orchestra\Testbench\Database\MigrateProcessor;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public static $migrated = false;

    /**
     * Set up the test
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->setUpTestDatabases();
    }

    public function setUpTestDatabases()
    {
        if (false === static::$migrated) {
            $this->dropAllTables();

            $this->migrateTables();

            static::$migrated = true;
        }

        $this->beginDatabaseTransaction();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            CriteriaServiceProvider::class,
            BuilderServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application   $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('cache.default', 'array');
        $app['config']->set('database.default', 'test');
        $app['config']->set('database.connections.test', [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'dbalcore_testing'),
            'username' => env('DB_USERNAME', 'username'),
            'password' => env('DB_PASSWORD', 'password'),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

    }

    /**
     * Drop all tables to start the test with fresh data
     */
    public function dropAllTables()
    {
        Schema::disableForeignKeyConstraints();
        collect(DB::select('SHOW TABLES'))
            ->map(function (\stdClass $tableProperties) {
                return get_object_vars($tableProperties)[key($tableProperties)];
            })
            ->each(function (string $tableName) {
                Schema::drop($tableName);
            });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Migrate the database
     * @param $paths
     */
    public function migrateTables()
    {
        $this->createTestUserTable();

        $migrator = new MigrateProcessor($this);
        $migrator->up();
    }

    private function createTestUserTable()
    {
        // hard code a test user database sense the migrate command can only take one migration path at the same time.
        $this->app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->nullable();
        });

        $this->app['db']->connection()->getSchemaBuilder()->create('rows', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('product_attribute_id')->nullable();
            $table->unsignedInteger('warehouse_id');
            $table->integer('quantity');
            $table->decimal('price')->nullable();

            $table->unique(['warehouse_id', 'product_id'], 'unique_stock');
            $table->unique(['warehouse_id', 'product_id', 'product_attribute_id'], 'unique_stock_attribute');
        });

        $this->app['db']->connection()->getSchemaBuilder()->create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        $this->app['db']->connection()->getSchemaBuilder()->create('role_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->timestamp('expires_at');
            $table->primary(['user_id', 'role_id']);
        });
    }

    /**
     * Begin a database transaction on the testing database.
     *
     * @return void
     */
    public function beginDatabaseTransaction()
    {
        $database = $this->app->make('db');

        $connection = $database->connection(null);
        $dispatcher = $connection->getEventDispatcher();

        $connection->unsetEventDispatcher();
        $connection->beginTransaction();
        $connection->setEventDispatcher($dispatcher);

        $this->beforeApplicationDestroyed(function () use ($database) {
            $connection = $database->connection(null);
            $dispatcher = $connection->getEventDispatcher();

            $connection->unsetEventDispatcher();
            $connection->rollback();
            $connection->setEventDispatcher($dispatcher);
            $connection->disconnect();
        });
    }
}

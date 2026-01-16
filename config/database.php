<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    */

    'default' => env('DB_CONNECTION', 'sqlsrv'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DB_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
            'busy_timeout' => null,
            'journal_mode' => null,
            'synchronous' => null,
            'transaction_mode' => 'DEFERRED',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                (PHP_VERSION_ID >= 80500 ? \PDO::MYSQL_ATTR_SSL_CA : \PDO::MYSQL_ATTR_SSL_CA) => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        // Koneksi Utama SQL Server (Master BP)
        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'db_master_bp'),
            'username' => env('DB_USERNAME', 'sa'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'encrypt' => env('DB_ENCRYPT', 'yes'),
            'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'true'),
        ],

        // Koneksi PT1 s/d PT4 menggunakan driver SQLSRV (Port 1433)
        'pt1' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => '1433',
            'database' => env('DB_DATABASE_PT1'), 
            'username' => env('DB_USERNAME', 'sa'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'encrypt' => env('DB_ENCRYPT', 'yes'),
            'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'true'),
        ],

        'pt2' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => '1433',
            'database' => env('DB_DATABASE_PT2'), 
            'username' => env('DB_USERNAME', 'sa'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'encrypt' => env('DB_ENCRYPT', 'yes'),
            'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'true'),
        ],

        'pt3' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => '1433',
            'database' => env('DB_DATABASE_PT3'), 
            'username' => env('DB_USERNAME', 'sa'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'encrypt' => env('DB_ENCRYPT', 'yes'),
            'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'true'),
        ],

        'pt4' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => '1433',
            'database' => env('DB_DATABASE_PT4'), 
            'username' => env('DB_USERNAME', 'sa'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'encrypt' => env('DB_ENCRYPT', 'yes'),
            'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'true'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    */

    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    */

    'redis' => [
        'client' => env('REDIS_CLIENT', 'phpredis'),
        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug((string) env('APP_NAME', 'laravel')).'-database-'),
            'persistent' => env('REDIS_PERSISTENT', false),
        ],
        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
            'max_retries' => env('REDIS_MAX_RETRIES', 3),
        ],
        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
            'max_retries' => env('REDIS_MAX_RETRIES', 3),
        ],
    ],

];
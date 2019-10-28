<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],
 
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        'mysql_modulos' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_MODULOS', '127.0.0.1'),
            'port' => env('DB_PORT_MODULOS', '3306'),
            'database' => env('DB_DATABASE_MODULOS', 'forge'),
            'username' => env('DB_USERNAME_MODULOS', 'forge'),
            'password' => env('DB_PASSWORD_MODULOS', ''),
            'unix_socket' => env('DB_SOCKET_MODULOS', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        'mysql_GLPI' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_GLPI', '127.0.0.1'),
            'port' => env('DB_PORT_GLPI', '3306'),
            'database' => env('DB_DATABASE_GLPI', 'forge'),
            'username' => env('DB_USERNAME_GLPI', 'forge'),
            'password' => env('DB_PASSWORD_GLPI', ''),
            'unix_socket' => env('DB_SOCKET_GLPI', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        'mysql_uath' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_UATH', '127.0.0.1'),
            'port' => env('DB_PORT_UATH', '3306'),
            'database' => env('DB_DATABASE_UATH', 'forge'),
            'username' => env('DB_USERNAME_UATH', 'forge'),
            'password' => env('DB_PASSWORD_UATH', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        'mysql_prueba' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_UATH', '127.0.0.1'),
            'port' => env('DB_PORT_UATH', '3306'),
            'database' => env('DB_DATABASE_PRUEBA', 'forge'),
            'username' => env('DB_USERNAME_UATH', 'forge'),
            'password' => env('DB_PASSWORD_UATH', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        'mysql_prueba2' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_PRUEBA2', '127.0.0.1'),
            'port' => env('DB_PORT_PRUEBA2', '3306'),
            'database' => env('DB_DATABASE_PRUEBA2', 'forge'),
            'username' => env('DB_USERNAME_PRUEBA2', 'forge'),
            'password' => env('DB_PASSWORD_PRUEBA2', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        'mysql_solicitudes' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_SOLICITUDES', '127.0.0.1'),
            'port' => env('DB_PORT_SOLICITUDES', '3306'),
            'database' => env('DB_DATABASE_SOLICITUDES', 'forge'),
            'username' => env('DB_USERNAME_SOLICITUDES', 'forge'),
            'password' => env('DB_PASSWORD_SOLICITUDES', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ], 
             'mysql_recaudaciones' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_RECAUDACIONES', '127.0.0.1'),
            'port' => env('DB_PORT_RECAUDACIONES', '3306'),
            'database' => env('DB_DATABASE_RECAUDACIONES', 'forge'),
            'username' => env('DB_USERNAME_RECAUDACIONES', 'forge'),
            'password' => env('DB_PASSWORD_RECAUDACIONES', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
		    'mysql_solicitudescj' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_SOLICITUDESCJ', '127.0.0.1'),
            'port' => env('DB_PORT_SOLICITUDESCJ', '3306'),
            'database' => env('DB_DATABASE_SOLICITUDESCJ', 'forge'),
            'username' => env('DB_USERNAME_SOLICITUDESCJ', 'forge'),
            'password' => env('DB_PASSWORD_SOLICITUDESCJ', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        'mysql_entrevista' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_ENTREVISTA', '127.0.0.1'),
            'port' => env('DB_PORT_ENTREVISTA', '3306'),
            'database' => env('DB_DATABASE_ENTREVISTA', 'forge'),
            'username' => env('DB_USERNAME_ENTREVISTA', 'forge'),
            'password' => env('DB_PASSWORD_ENTREVISTA', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];

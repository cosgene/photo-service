<?php

class Database {

    private static $instance = null;

    public static function connect() {
        if (self::$instance === null) {

            $config = [
                'host' => $_ENV['DB_HOST'],
                'dbname' => $_ENV['DB_NAME'],
                'user' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASS'],
                'port' => $_ENV['DB_PORT']
            ];

            $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";


            self::$instance = new PDO(
                $dsn,
                $config['user'],
                $config['password']
            );

            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$instance;
    }
}

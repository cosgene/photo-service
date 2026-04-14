<?php

class Database {

    private static $instance = null;

    public static function connect() {
        if (self::$instance === null) {

            $config = require __DIR__ . '/../../config/database.php';

            $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['dbname']}";

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

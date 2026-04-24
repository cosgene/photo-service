<?php

require_once __DIR__ . '/../Core/Database.php';

$envPath = __DIR__ . '/../config/env.php';

if (!file_exists($envPath)) {
    die("env.php NOT FOUND: " . $envPath);
}

require_once $envPath;

if (!function_exists('loadEnv')) {
    die("loadEnv() NOT FOUND in env.php");
}

loadEnv(__DIR__ . '/../.env');

$db = Database::connect();

$db->exec("TRUNCATE TABLE users");

echo "users cleared";

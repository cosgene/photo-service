<?php

require_once __DIR__ . '/../config/env.php';
loadEnv(__DIR__ . '/../.env');

require_once __DIR__ . '/../app/Controllers/BotController.php';

$controller = new BotController();
$controller->handle();

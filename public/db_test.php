<?php

try {
    $pdo = new PDO(
        "mysql:host=127.0.1.31;port=3306;dbname=photo_service;charset=utf8mb4",
        "root",
        "",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );

    echo "DB CONNECT OK<br>";

    $stmt = $pdo->query("SELECT * FROM roles");
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<pre>";
    print_r($roles);
    echo "</pre>";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}

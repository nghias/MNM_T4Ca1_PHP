<?php
$host = "sql100.infinityfree.com";
$dbname = "if0_40577807_demo";
$username = "if0_40577807";
$password = "Nghia13052004";

try {

    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $conn = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode(["error" => "Lỗi kết nối Database: " . $e->getMessage()]);
    exit();
}
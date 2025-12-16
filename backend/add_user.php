<?php
// ===== CORS Headers =====
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Xử lý preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Thông tin kết nối Database
$servername = "sql100.infinityfree.com";
$username   = "if0_40577807";
$password   = "Nghia13052004";
$dbname     = "if0_40577807_demo";

// Kết nối Database
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Kết nối DB thất bại",
        "data" => []
    ]);
    exit();
}

// Query lấy tất cả users
$sql = "SELECT id, username, email, created_at FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);

$users = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    
    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "message" => "Lấy dữ liệu thành công",
        "count" => count($users),
        "data" => $users
    ]);
} else {
    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "message" => "Không có dữ liệu",
        "count" => 0,
        "data" => []
    ]);
}

$conn->close();
?>
<?php
// ===== BẮT BUỘC: Đặt CORS headers ở ĐẦU FILE =====
header("Access-Control-Allow-Origin: http://deloyfe.somee.com"); // Thay * bằng domain cụ thể
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

// Xử lý preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Thông tin kết nối
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
        "message" => "Kết nối DB thất bại: " . $conn->connect_error
    ]);
    exit();
}

// Nhận dữ liệu JSON
$json_data = file_get_contents("php://input");
$data = json_decode($json_data, true); // Thêm true để convert sang array

// Kiểm tra dữ liệu
if(!empty($data['username']) && !empty($data['email'])){
    
    // Sử dụng Prepared Statement (An toàn hơn real_escape_string)
    $stmt = $conn->prepare("INSERT INTO users (username, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $data['username'], $data['email']);

    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode([
            "status" => "success", 
            "message" => "Thêm thành công user: " . $data['username']
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "status" => "error", 
            "message" => "Lỗi SQL: " . $stmt->error
        ]);
    }
    
    $stmt->close();
} else {
    http_response_code(400);
    echo json_encode([
        "status" => "error", 
        "message" => "Vui lòng nhập đầy đủ Username và Email!"
    ]);
}

$conn->close();
?>
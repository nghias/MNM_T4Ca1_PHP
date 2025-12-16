<?php
// Cho phép truy cập từ mọi nguồn (hoặc thay * bằng http://deloyfe.somee.com)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

// Xử lý preflight request (của trình duyệt)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

header("Content-Type: application/json; charset=UTF-8");

// 2. Thông tin kết nối (Lấy từ hình ảnh bạn gửi)
$servername = "sql100.infinityfree.com";
$username   = "if0_40577807";
$password   = "Nghia13052004";
$dbname     = "if0_40577807_demo"; // Tên DB đầy đủ (như hướng dẫn ở Bước 1)

// 3. Kết nối Database
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Kết nối DB thất bại: " . $conn->connect_error]);
    exit();
}

// 4. Nhận dữ liệu JSON từ Somee
$json_data = file_get_contents("php://input");
$data = json_decode($json_data);

// Kiểm tra dữ liệu có tồn tại không
if(isset($data->username) && isset($data->email) && !empty($data->username) && !empty($data->email)){
    
    // Chống SQL Injection
    $user = $conn->real_escape_string($data->username);
    $email = $conn->real_escape_string($data->email);

    // Câu lệnh Insert
    $sql = "INSERT INTO users (username, email) VALUES ('$user', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Thêm thành công user: " . $user]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi SQL: " . $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Vui lòng nhập đầy đủ Username và Email!"]);
}
// đâ

$conn->close();
?>
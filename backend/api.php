<?php
// Thông tin kết nối lấy từ hình ảnh của bạn
$servername = "sql100.infinityfree.com";
$username = "if0_40577807";
$password = "Nghia13052004";
$dbname = "if0_40577807_demo";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Thiết lập encoding UTF-8 để hiển thị tiếng Việt không bị lỗi
$conn->set_charset("utf8");

// --- PHẦN LẤY DỮ LIỆU ---

// SQL query: Thay 'users' bằng tên bảng thực tế của bạn trong phpMyAdmin
$sql = "SELECT id, username, email FROM users";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    // Đưa dữ liệu vào mảng
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Trả về dữ liệu dạng JSON
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>
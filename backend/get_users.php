<?php
// --- CẤU HÌNH CORS (BẮT BUỘC) ---
header("Access-Control-Allow-Origin: *"); // Cho phép mọi website lấy dữ liệu
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

// --- KẾT NỐI DATABASE ---
$servername = "sql100.infinityfree.com";
$username   = "if0_40577807";
$password   = "Nghia13052004";
$dbname     = "if0_40577807_demo"; // Đảm bảo bạn đã tạo DB tên 'demo' như bước trước

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die(json_encode(["error" => "Lỗi kết nối DB: " . $conn->connect_error]));
}

// --- LẤY DỮ LIỆU ---
$sql = "SELECT * FROM users ORDER BY id DESC"; // Lấy user mới nhất lên đầu
$result = $conn->query($sql);

$users = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Trả về JSON
echo json_encode($users);

$conn->close();
?>
<?php
header("Access-Control-Allow-Origin: *"); // Cho phép mọi nguồn truy cập
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Cho phép các phương thức
header("Access-Control-Allow-Headers: Content-Type"); // Cho phép gửi dữ liệu JSON

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}
// --- CẤU HÌNH KẾT NỐI ---
$servername = "sql100.infinityfree.com";
$username = "if0_40577807";
$password = "Nghia13052004";
$dbname = "if0_40577807_demo";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die(json_encode(["message" => "Kết nối thất bại: " . $conn->connect_error]));
}

// Lấy phương thức gửi lên (GET hoặc POST)
$method = $_SERVER['REQUEST_METHOD'];

// --- TRƯỜNG HỢP 1: LẤY DỮ LIỆU (GET) ---
if ($method == 'GET') {
    // LƯU Ý: Thay 'users' bằng tên bảng thực tế của bạn
    $sql = "SELECT id, username, email FROM users ORDER BY id DESC"; 
    $result = $conn->query($sql);

    $data = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    header('Content-Type: application/json');
    echo json_encode($data);
}

// --- TRƯỜNG HỢP 2: THÊM DỮ LIỆU (POST) ---
elseif ($method == 'POST') {
    // Nhận dữ liệu JSON từ file HTML gửi lên
    $input = json_decode(file_get_contents('php://input'), true);

    $user_name = $input['username'];
    $user_email = $input['email'];

    if(!empty($user_name) && !empty($user_email)){
        // LƯU Ý: Thay 'users' bằng tên bảng thực tế của bạn
        // Dấu ? là để bảo mật dữ liệu
        $stmt = $conn->prepare("INSERT INTO users (username, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $user_name, $user_email); // "ss" nghĩa là 2 chuỗi string

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Thêm thành công!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Lỗi: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Vui lòng nhập đủ thông tin!"]);
    }
}

$conn->close();
?>
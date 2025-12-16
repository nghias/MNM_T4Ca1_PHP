<?php
// Cấu hình header để trả về JSON và hỗ trợ tiếng Việt
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *"); // Cho phép gọi API từ domain khác (CORS)

// Thông tin kết nối từ hình ảnh
$host = 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com';
$port = '4000';
$db   = 'test';
$user = '4MoqUaUd1wnWMGN.root';
$pass = 'EeQm8Gx6DWUidjQi';

// Chuỗi kết nối (DSN)
$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Báo lỗi dạng Exception
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,     // Trả về mảng kết hợp
    PDO::ATTR_EMULATE_PREPARES   => false,
    // TiDB Cloud yêu cầu kết nối bảo mật (SSL). 
    // Dòng dưới giúp bỏ qua xác thực chứng chỉ CA nếu localhost không có sẵn (chỉ dùng khi dev)
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false, 
];

try {
    // 1. Tạo kết nối
    $pdo = new PDO($dsn, $user, $pass, $options);

    // 2. Viết câu truy vấn lấy các trường yêu cầu
    $sql = "SELECT MaPhong, Ten, Gia, DienTich, HinhAnh FROM phong";
    
    // 3. Thực thi truy vấn
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    // 4. Lấy dữ liệu
    $data = $stmt->fetchAll();

    // 5. Trả về kết quả dạng JSON
    echo json_encode([
        'status' => 'success',
        'count' => count($data),
        'data' => $data
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (\PDOException $e) {
    // Xử lý lỗi kết nối
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Lỗi kết nối CSDL: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>
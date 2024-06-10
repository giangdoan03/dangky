<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('./inc/essentials.php');
include('./inc/db_config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Nếu reCAPTCHA hợp lệ, xử lý dữ liệu form ở đây
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Mã hóa mật khẩu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Kết nối MySQL và lưu thông tin vào cơ sở dữ liệu
//        $conn = new mysqli('localhost', 'username', 'password', 'database');

        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        // Debugging: Kiểm tra tham số
        if (!$stmt = $conn->prepare("INSERT INTO admin_cred (admin_name, admin_pass) VALUES (?, ?)")) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }

        if (!$stmt->bind_param("ss", $username, $hashed_password)) {
            die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        if (!$stmt->execute()) {
            die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        $stmt->close();
        $conn->close();

        echo "Đăng ký thành công!";
}


?>

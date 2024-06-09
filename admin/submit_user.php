<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('./inc/essentials.php');
include('./inc/db_config.php');
require '../vendor/autoload.php'; // Đảm bảo autoload của Composer đã được nạp

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = '6LfNZPQpAAAAAH0fUPwlsBamTXzIdP7nPLb4Wy4I';
    $recaptcha_response = $_POST['recaptcha_response'];

    // Sử dụng cURL để xác minh reCAPTCHA
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $recaptcha_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'secret' => $recaptcha_secret,
        'response' => $recaptcha_response
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    // Kiểm tra lỗi cURL
    if (curl_errno($ch)) {
        $error_msg = 'cURL error: ' . curl_error($ch);
        file_put_contents('recaptcha_debug_log.txt', $error_msg, FILE_APPEND);
        die($error_msg);
    }

    curl_close($ch);

    // Debugging: Hiển thị phản hồi từ Google
    // var_dump($response); die();

    $responseKeys = json_decode($response, true);

    if ($responseKeys["success"] && $responseKeys["score"] >= 0.5) {
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
    } else {
        echo "reCAPTCHA không hợp lệ, vui lòng thử lại.";
    }
}


?>

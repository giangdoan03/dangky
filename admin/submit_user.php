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
        echo 'cURL error: ' . curl_error($ch);
    }

    curl_close($ch);

    // Debugging: Hiển thị phản hồi từ Google
//    var_dump($response); die();

    $responseKeys = json_decode($response, true);

    if ($responseKeys["success"] && $responseKeys["score"] >= 0.5) {
        // Nếu reCAPTCHA hợp lệ, xử lý dữ liệu form ở đây
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Kết nối MySQL và lưu thông tin vào cơ sở dữ liệu
//        $conn = new mysqli('localhost', 'username', 'password', 'database');

        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO admin_cred (sr_no, admin_name, admin_pass) VALUES (?, ?, ?)");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        echo "Đăng ký thành công!";
    } else {
        echo "reCAPTCHA không hợp lệ, vui lòng thử lại.";
    }
}


?>

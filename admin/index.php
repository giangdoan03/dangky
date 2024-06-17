<?php
ob_start();
require('./inc/essentials.php');
require('./inc/db_config.php');

session_start();
if ((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
    redirect('dashboard.php');
}
// Đặt múi giờ thành múi giờ Việt Nam
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login Panel</title>
    <?php require('inc/links.php'); ?>
    <style>
        div.login-form {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
        }
    </style>
</head>
<body class="bg-light">
<div class="login-form text-center rounded bg-white shadow overflow-hidden">
    <form method="POST">
        <h4 class="bg-dark text-white py-3">ADMIN LOGIN PANEL</h4>
        <div class="p-4">
            <div class="mb-3">
                <input name="admin_name" required type="text" class="form-control shadow-none text-center"
                       placeholder="Admin Name">
            </div>
            <div class="mb-4">
                <input name="admin_pass" required type="password" class="form-control shadow-none text-center"
                       placeholder="Password">
            </div>
            <button name="login" type="submit" class="btn text-white custom-bg shadow-none">LOGIN</button>
        </div>
    </form>
</div>
<?php if(isset($_POST['login'])) {
    $admin_name = mysqli_real_escape_string($conn,$_POST["admin_name"]);
    $admin_pass = mysqli_real_escape_string($conn,$_POST["admin_pass"]);
    $query = "SELECT * FROM admin_cred WHERE admin_name = '$admin_name'";


    // Lấy IP và thời gian hiện tại
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $login_time = date('Y-m-d H:i:s');


    // Kiểm tra thông tin đăng nhập của admin
    $sql = "SELECT sr_no, admin_pass FROM admin_cred WHERE admin_name = '$admin_name'";

    $stmt = $conn->prepare($sql);
//    var_dump($admin_name);
//    $stmt->bind_param("s", $admin_name);
    $stmt->execute();
    $stmt->store_result();  // Thêm dòng này để lưu kết quả
    $stmt->bind_result($admin_id, $hashed_password);
    $stmt->fetch();

    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($admin_pass, $row["admin_pass"])) {
            //        session_start();

//            // Kiểm tra địa chỉ IP là localhost hay không
//            if ($ip_address == '127.0.0.1' || $ip_address == '::1') {
//                $country = 'Localhost';
//                $region = 'Localhost';
//                $city = 'Localhost';
//            } else {
//                // Lấy thông tin địa lý từ IP
//                $api_url = "http://ip-api.com/json/$ip_address";
//                // Sử dụng cURL để lấy nội dung từ API
//                $ch = curl_init();
//                curl_setopt($ch, CURLOPT_URL, $api_url);
//                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//                $response = curl_exec($ch);
//                curl_close($ch);
//
//                if ($response === FALSE) {
//                    // Nếu không lấy được nội dung, báo lỗi
//                    die('Error occurred while trying to fetch the API.');
//                }
//
//                // Giải mã JSON
//                $location_info = json_decode($response, true);
//
//                // var_dump($location_info); die();
//
//                $country = $location_info['country'];
//                $region = $location_info['regionName'];
//                $city = $location_info['city'];
//            }
//
//            // Lưu thông tin đăng nhập vào cơ sở dữ liệu
//            $sql = "INSERT INTO admin_logins (admin_id, login_time, ip_address, country, region, city) VALUES (?, ?, ?, ?, ?, ?)";
//            $stmt = $conn->prepare($sql);
//            $stmt->bind_param("isssss", $admin_id, $login_time, $ip_address, $country, $region, $city);
//            $stmt->execute();
//            $stmt->close();


            $_SESSION['adminLogin'] = true;
            $_SESSION['adminId'] = $row['sr_no'];

            redirect('dashboard.php');

        } else {
            alert('error', 'Invalid username or password');
        }
    } else {
        alert('error', 'Login failed - Invalid Credentials');

    }


// See the password_hash() example to see where this came from.
//    $enteredPassword = "thanhxuan2024!@";
//    $hashedPassword = password_hash($enteredPassword, PASSWORD_DEFAULT);
//
//    echo $hashedPassword;
//
//    echo '<br>';
//
//    $hash = '$2y$10$.BUGZOpCuHpH/8Q16LrQ6uU0/yUwi.yOw74qGMjOzgkFI6q8H2Pzi';
//
//    if (password_verify('thanhxuan2024!@', $hash)) {
//        echo 'Password is valid!';
//    } else {
//        echo 'Invalid password.';
//    }

}?>
<?php require('inc/scripts.php'); ?>
<?php ob_end_flush(); ?>
</body>
</html>
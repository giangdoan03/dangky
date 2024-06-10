<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('./inc/essentials.php');
include('./inc/db_config.php');
adminLogin();
?>

<?php

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $message = "<span class='error'>Mật khẩu mới không khớp.</span>";
    } else {
        $user_id = $_SESSION['adminId'];
        $sql = "SELECT admin_pass FROM admin_cred WHERE sr_no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        $stmt->close();

        if (password_verify($current_password, $hashed_password)) {
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql = "UPDATE admin_cred SET admin_pass = ? WHERE sr_no = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $new_hashed_password, $user_id);
            $stmt->execute();
            $stmt->close();

            $message = "<span class='success'>Mật khẩu đã được đổi thành công.</span>";
        } else {
            $message = "<span class='error'>Mật khẩu hiện tại không đúng.</span>";
        }
    }
}
?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Panel - Settings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <?php require('inc/links.php'); ?>
    <style>
        .password-container {
            position: relative;
            /*display: inline-block;*/
        }
        .password-container input {
            padding-right: 30px;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 70%;
            transform: translateY(-50%);
            cursor: pointer;
        }
          .success {
            color: green;
        }
        .error {
            color: red;
        }
        .message_notify {
            margin-top: 20px;
        }
    </style>
</head>
<body class="bg-light">
<?php require('inc/header.php'); ?>
<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">ĐỔI MẬT KHẨU ADMIN</h3>
            <!-- General settings section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div style="max-width: 500px; margin: 0 auto">
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="password-container mb-3">
                                <label for="current_password">Mật khẩu hiện tại:</label>
                                <input type="password" class="form-control" name="current_password" id="current_password" required>
                                <span class="toggle-password" onclick="togglePassword('current_password')"><i class="fas fa-eye"></i></span>
                            </div>
                            <br>
                            <div class="password-container mb-3">
                                <label for="new_password">Mật khẩu mới:</label>
                                <input type="password" class="form-control" name="new_password" id="new_password" required>
                                <span class="toggle-password" onclick="togglePassword('new_password')"><i class="fas fa-eye"></i></span>
                            </div>
                            <br>
                            <div class="password-container">
                                <label for="confirm_password">Xác nhận mật khẩu mới:</label>
                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
                                <span class="toggle-password" onclick="togglePassword('confirm_password')"><i class="fas fa-eye"></i></span>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-outline-primary mt-3">Đổi mật khẩu</button>
                        </form>
                        <div class="message_notify"><?php if (!empty($message)) echo $message; ?></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php require('inc/scripts.php'); ?>
<script>
    function togglePassword(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);

        const icon = passwordField.nextElementSibling.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    }
</script>
</body>
</html>
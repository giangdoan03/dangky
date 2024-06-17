<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require('./inc/essentials.php');
include('./inc/db_config.php');
//include('./generate_pdf.php');
adminLogin();
?>
<?php

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['status'])) {
        $status = $_POST['status'];

        // Xóa hết dữ liệu cũ trong bảng
        $conn->query("UPDATE status_settings SET is_active = 0");

        // Cập nhật trạng thái mới
        $conn->query("UPDATE status_settings SET is_active = 1 WHERE status_name = '$status'");

        $message_notify = 'Cập nhật trạng thái thành công.';

//        echo "Cập nhật trạng thái thành công.";
    }
}

// Lấy trạng thái hiện tại từ cơ sở dữ liệu
$current_status = '';
$result = $conn->query("SELECT status_name FROM status_settings WHERE is_active = 1");
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $current_status = $row['status_name'];
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
    <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">
<?php require('inc/header.php'); ?>
<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">SETTINGS</h3>

            <?php if (!empty($message_notify)) { ?>
                <div class="col-xs-12">
                    <div id="successMessage"class="alert alert-success"><?php echo $message_notify; ?></div>
                </div>
            <?php } ?>
            <!-- General settings section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title m-0">General Settings</h5>
                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#general-s">
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>
                    </div>
                    <h6 class="card-subtitle mb-2 text-muted mb-1 fw-bold">Site Title</h6>
                    <p class="card-text" id="site_title"></p>
                    <h6 class="card-subtitle mb-2 text-muted mb-1 fw-bold">About us</h6>
                    <p class="card-text" id="site_about">content</p>
                </div>
            </div>

            <!-- Shutdown section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5>Setting Page</h5>
                    <form method="POST">
                        <div class="mt-3">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="flexRadioDefault1" name="status" value="Open" <?php if ($current_status == 'Open') echo 'checked'; ?>>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Mở Form Đăng ký
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="flexRadioDefault2" name="status" value="Maintenance" <?php if ($current_status == 'Maintenance') echo 'checked'; ?>>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Bảo trì hệ thống
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="flexRadioDefault3" name="status" value="Expired" <?php if ($current_status == 'Expired') echo 'checked'; ?>>
                                <label class="form-check-label" for="flexRadioDefault3">
                                    Hết hạn đăng ký
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="flexRadioDefault4" name="status" value="Notification" <?php if ($current_status == 'Notification') echo 'checked'; ?>>
                                <label class="form-check-label" for="flexRadioDefault4">
                                    Thông báo điểm chuẩn
                                </label>
                            </div>
                        </div>
                        <br>
                        <input type="submit" class="btn btn-outline-danger" value="Lưu trạng thái">
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<?php require('inc/scripts.php'); ?>
<script>

</script>
</body>
</html>
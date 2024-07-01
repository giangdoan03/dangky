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
        $notificationMessage = isset($_POST['notificationMessage']) ? $conn->real_escape_string($_POST['notificationMessage']) : '';

        // Xóa hết dữ liệu cũ trong bảng
        $conn->query("UPDATE status_settings SET is_active = 0");

        // Cập nhật trạng thái mới
        $conn->query("UPDATE status_settings SET is_active = 1 WHERE status_name = '$status'");

        // Lưu hoặc cập nhật nội dung TinyMCE nếu trạng thái là "Notification"
        // Kiểm tra nếu bản ghi tồn tại
        $result = $conn->query("SELECT id FROM notifications WHERE id = 1");
        if ($result->num_rows > 0) {
            // Cập nhật bản ghi nếu tồn tại
            $conn->query("UPDATE notifications SET message = '$notificationMessage' WHERE id = 1");
        } else {
            // Thêm bản ghi mới nếu không tồn tại
            $conn->query("INSERT INTO notifications (id, message) VALUES (1, '$notificationMessage')");
        }

        $message_notify = 'Cập nhật trạng thái thành công.';
    }
}

// Lấy trạng thái hiện tại từ cơ sở dữ liệu
$current_status = '';
$result = $conn->query("SELECT status_name FROM status_settings WHERE is_active = 1");
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $current_status = $row['status_name'];
}

// Lấy nội dung thông báo hiện tại
$notificationMessage = '';
$result = $conn->query("SELECT message FROM notifications WHERE id = 1");
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $notificationMessage = $row['message'];
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
    <style>
        .top_bar {
            display: flex;
            justify-content: space-between;
        }

        /*.notification-div {*/
        /*    display: none;*/
        /*    margin-top: 10px;*/
        /*}*/
    </style>
</head>
<body class="bg-light">
<?php require('inc/header.php'); ?>
<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">SETTINGS</h3>

            <?php if (!empty($message_notify)) { ?>
                <div class="col-xs-12">
                    <div id="successMessage" class="alert alert-success"><?php echo $message_notify; ?></div>
                </div>
            <?php } ?>
            <!-- General settings section -->
            <!-- Shutdown section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <form method="POST">
                        <div class="top_bar">
                            <h5>Cài đặt trang đăng ký tuyển sinh</h5>
                            <input type="submit" class="btn btn-outline-primary" value="Lưu trạng thái">
                        </div>
                        <div class="mt-4 mb-4">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="flexRadioDefault1" name="status"
                                       value="Open" <?php if ($current_status == 'Open') echo 'checked'; ?>>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Mở Form Đăng ký
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="flexRadioDefault2" name="status"
                                       value="Maintenance" <?php if ($current_status == 'Maintenance') echo 'checked'; ?>>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Bảo trì hệ thống
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="flexRadioDefault3" name="status"
                                       value="Expired" <?php if ($current_status == 'Expired') echo 'checked'; ?>>
                                <label class="form-check-label" for="flexRadioDefault3">
                                    Hết hạn đăng ký
                                </label>
                            </div>
                        </div>
                        <hr>
                        <div class="notification-div" id="notificationDiv">
                            <h5>Cài đặt trang thông báo tuyển sinh</h5>
                            <textarea class="form-control" id="notificationMessage" name="notificationMessage"
                                      rows="3"><?php echo $notificationMessage; ?></textarea>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<?php require('inc/scripts.php'); ?>
<script src="https://cdn.tiny.cloud/1/fsb5zl8xlbwzy1kkp690zztcwr3wnvtfmjhlp5q66vwz79s0/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // const notificationRadio = document.getElementById('flexRadioDefault4');
        // const notificationDiv = document.getElementById('notificationDiv');
        //
        // function toggleNotificationDiv() {
        //     if (notificationRadio.checked) {
        //         notificationDiv.style.display = 'block';
        //     } else {
        //         notificationDiv.style.display = 'none';
        //     }
        // }
        //
        // document.querySelectorAll('input[name="status"]').forEach(function (radio) {
        //     radio.addEventListener('change', toggleNotificationDiv);
        // });

        // Initial check
        // toggleNotificationDiv();

        // Initialize TinyMCE
        tinymce.init({
            selector: '#notificationMessage',
            menubar: false,
            plugins: 'link image code',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat | alignleft aligncenter alignright | code',
            tinycomments_mode: 'embedded',
        });
    });
</script>
</body>
</html>

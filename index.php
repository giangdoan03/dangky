<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta property="og:title" content="Tuyển sinh trường THCS Thanh Xuân">
    <meta property="og:description" content="Tuyển sinh trường THCS Thanh Xuân">
    <meta property="og:image" content="https://tuyensinh.thcsthanhxuan.vn/images/common/logo_thcs_thanh_xuan.png">
    <link rel="shortcut icon" type="image/png" href="./images/common/favicon.ico"/>
    <title>Đăng ký tuyển sinh</title>
    <?php require('inc/links.php'); ?>
    <style>
        .availability-form {
            margin-top: -50px;
            z-index: 2;
            position: relative;
        }

        .diem_chuan {
            min-height: 500px;
            padding: 50px 0;
            padding-top: 5px;
        }
        .diem_chuan .container p {
            margin-bottom: 8px;
        }

        .box_content {
            margin-top: 30px;
        }

        @media screen and (max-width: 575px) {
            .availability-form {
                margin-top: 25px;
                padding: 0 35px;
            }

        }
    </style>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-MJFNDXWJSJ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'G-MJFNDXWJSJ');
    </script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
</head>
<body class="bg-light">
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require('./admin/inc/essentials.php');
include('./admin/inc/db_config.php');


// Hàm để lấy URL gốc
function base_url()
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'];
    return $protocol . $domainName . '/';
}


// Truy vấn để lấy trạng thái hiện tại
$sql = "SELECT status_name FROM status_settings WHERE is_active = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $current_status = $row['status_name'];
} else {
    $current_status = "Not Set"; // Nếu không có trạng thái nào được thiết lập
}

// Lấy nội dung thông báo hiện tại
$notificationMessage = '';
$result = $conn->query("SELECT message FROM notifications ORDER BY id DESC LIMIT 1");
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $notificationMessage = $row['message'];
}
?>

<div class="page-register">
    <?php require('inc/header.php'); ?>


    <div class="diem_chuan">
        <div class="container">
            <div class="page_content">
                <?php echo $notificationMessage; ?>
            </div>
        </div>
    </div>

</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Include Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

<?php require('inc/footer.php'); ?>

</body>
</html>
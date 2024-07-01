<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require('./admin/inc/essentials.php');
include('./admin/inc/db_config.php');

// Function to get base URL
function base_url()
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'];
    return $protocol . $domainName . '/';
}
?>

<!doctype html>
<html lang="vi">
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
        /* CSS code here */
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
    <!-- reCAPTCHA v3 -->
    <script src="https://www.google.com/recaptcha/api.js?render=6LfNZPQpAAAAANu4PQ0RwHuWxkRnb5-1DhDtWHbx"></script>
</head>
<body class="bg-light">

<div class="page-register">
    <?php require('inc/header.php'); ?>
    <div class="page_w">
        <div class="container">
            <div class="page_content">
                <div class="wrapper" style="text-align: center">
                    <h2>Hướng dẫn đăng ký</h2>
                </div>
            </div>
        </div>
    </div>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('6LfNZPQpAAAAANu4PQ0RwHuWxkRnb5-1DhDtWHbx', {action: 'submit'}).then(function(token) {
                document.getElementById('recaptchaResponse').value = token;
            });
        });
    </script>
</div>
<?php require('inc/footer.php'); ?>
</body>
</html>

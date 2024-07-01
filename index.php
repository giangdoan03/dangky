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
    <div class="bl_header">
        <div class="container">
            <div class="header">
                <div class="banner">
                    <div class="logo">
                        <img src="./images/common/logo_thcs_thanh_xuan.png" alt="">
                    </div>
                    <div class="text">
                        <h1>TRƯỜNG THCS THANH XUÂN</h1>
                        <p>NHÂN CÁCH - TRI THỨC - KỸ NĂNG</p>
                    </div>
                </div>
                <div class="bg_truong">
                    <img src="./images/common/anh_2.png" alt="">
                </div>
            </div>
            <ul class="menu_top desktop-menu">
                <li class="menu-item">
                    <a href="https://thcsthanhxuan.edu.vn/homegd14">Trang chủ</a>
                </li>
                <li class="menu-item">
                    <a href="#">Thông tin tuyển sinh</a>
                </li>
                <li class="menu-item">
                    <a href="#">Đăng ký tuyển sinh</a>
                </li>
                <li class="menu-item">
                    <a href="<?php echo base_url(); ?>tra-cuu-diem.php">Tra cứu kết quả</a>
                </li>
                <li class="menu-item">
                    <a href="#">Hướng dẫn đăng ký</a>
                </li>
            </ul>
            <!-- Icon cho mobile -->
            <div class="mobile-icon" onclick="toggleMobileMenu()">☰</div>
        </div>
    </div>


    <?php if ($current_status == 'Open') { ?>
        <div class="container">
            <div id="box-title-register-success">
                <div class="alert alert-success" role="alert">
                    <p>Đăng ký hồ sơ trực tuyến thành công</p>
                    <p>Nhà trường đã gửi xác nhận đăng ký hồ sơ tuyển sinh qua email. Phụ huynh truy cập email để kiểm tra
                        thông tin đã đăng ký</p>
                </div>
            </div>
            <div id="register-content" class="register-content">
                <div id="box-title-register">
                    <h1 class="text-center mt-3 mb-3">Đăng ký hồ sơ tuyển sinh</h1>
                    <div class="alert alert-primary" role="alert">
                        Đăng ký hồ sơ trực tuyến: Hotline/Zalo: <a href="tel:+09216685555"><strong>092.1668.555</strong></a>
                    </div>
                </div>
                <div class="page-content">
                    <div class="title border-bottom">
                        <h5>I. THÔNG TIN CÁ NHÂN:</h5>
                    </div>
                    <form action="" id="saveStudent" enctype="multipart/form-data">
                        <div class="user-info mt-3">
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 col-sm-12">
                                    <div class="title mb-1">
                                        1. Họ và tên học sinh (viết đúng như GKS):<span class="text-red">*</span>
                                    </div>
                                    <input type="text" name="hoten_hocsinh" class="form-control" placeholder="Tên học sinh"
                                           required>
                                </div>
                                <div class="col-12 col-md-4 col-sm-12">
                                    <div class="title mb-1">
                                        2. Ngày sinh (dd/mm/yyyy): <span class="text-red">*</span>
                                    </div>
                                    <br class="d-none d-md-block d-lg-none">
                                    <input type="text" name="ngaysinh" id="datepicker" class="form-control"
                                           placeholder="Ngày sinh"
                                           required>
                                </div>
                                <div class="col-12 col-md-4 col-sm-12">
                                    <div class="title mb-1">
                                        3. Mã số học sinh theo CSDL của bộ (10 số): <span class="text-red">*</span>
                                    </div>
                                    <input type="text" name="ma_hocsinh" id="ma_hocsinh" class="form-control"
                                           placeholder="Nhập mã học sinh">
                                    <div id="check-student-code" style="font-size: 12px; color: red"></div>
                                    <div id="warningMessage" style="font-size: 12px; color: red"></div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 col-sm-12">
                                    <div class="title mb-1">
                                        4. Nơi sinh (Tỉnh/TP):<span class="text-red">*</span>
                                    </div>
                                    <input type="text" name="noisinh" class="form-control" placeholder="Nơi sinh" required>
                                </div>
                                <div class="col-12 col-md-4 col-sm-12">
                                    <div class="title mb-1">
                                        5. Giới tính: <span class="text-red">*</span>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" value="nam" type="radio" name="gioitinh"
                                               id="flexRadioDefault1" checked>
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Nam
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" value="nu" type="radio" name="gioitinh"
                                               id="flexRadioDefault2">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            Nữ
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-sm-12">
                                    <div class="title mb-1">
                                        6. Dân tộc: <span class="text-red">*</span>
                                    </div>
                                    <input type="text" name="dantoc" class="form-control" placeholder="Nhập dân tộc"
                                           required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6 col-sm-12">
                                    <div class="title mb-1">
                                        7. Học sinh lớp:<span class="text-red">*</span>
                                    </div>
                                    <input type="text" name="tenlop" class="form-control" placeholder="Nhập tên lớp"
                                           required>
                                </div>
                                <div class="col-12 col-md-6 col-sm-12">
                                    <div class="title mb-1">
                                        8. Trường tiểu học: <span class="text-red">*</span>
                                    </div>
                                    <input type="text" name="ten_truong" class="form-control" placeholder="Nhập tên trường"
                                           required>
                                </div>
                            </div>
                        </div>

                        <div class="title border-bottom mt-4 mb-3">
                            <h5>II. THÔNG TIN CHA MẸ/ NGƯỜI GIÁM HỘ HỌC SINH:</h5>
                        </div>
                        <div class="guardian-info">
                            <div class="row mb-4">
                                <div class="col-12 col-md-7 col-sm-12">
                                    <div class="title mb-1">
                                        1. Họ và tên cha:<span class="text-red">*</span>
                                    </div>
                                    <input type="text" name="hoten_cha" class="form-control" placeholder="Họ và tên cha"
                                           required>
                                </div>
                                <div class="col-12 col-md-5 col-sm-12">
                                    <div class="title mb-1">
                                        Điện thoại cha: <span class="text-red">*</span>
                                    </div>

                                    <input type="text" name="sdt_cha" class="form-control" placeholder="Điện thoại cha"
                                           required>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-7 col-sm-12">
                                    <div class="title mb-1">
                                        2. Họ và tên mẹ:<span class="text-red">*</span>
                                    </div>
                                    <input type="text" name="hoten_me" class="form-control" placeholder="Họ và tên mẹ"
                                           required>
                                </div>
                                <div class="col-12 col-md-5 col-sm-12">
                                    <div class="title mb-1">
                                        Điện thoại mẹ: <span class="text-red">*</span>
                                    </div>
                                    <input type="text" name="sdt_me" class="form-control" placeholder="Điện thoại mẹ"
                                           required>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-7 col-sm-12">
                                    <div class="title mb-1">
                                        3. Họ và tên người giám hộ(nếu có):
                                    </div>
                                    <input type="text" name="hoten_nguoi_giam_ho" class="form-control"
                                           placeholder="Nhập họ tên người giám hộ">
                                </div>
                                <div class="col-12 col-md-5 col-sm-12">
                                    <div class="title mb-1">
                                        Điện thoại người giám hộ:
                                    </div>
                                    <input type="text" name="sdt_nguoigiamho" class="form-control"
                                           placeholder="Nhập điện thoại người giám hộ">
                                </div>
                            </div>
                            <div class="address">
                                <div class="title mb-1">
                                    4. Địa chỉ thường trú trên CMND/CCCD:<span class="text-red">*</span>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-12 col-md-4 col-sm-12">
                                        <div class="title mb-1">
                                            Tỉnh thành:<span class="text-red">*</span>
                                        </div>
                                        <br class="d-none d-md-block d-lg-none">
                                        <select class="form-select" id="province" name="province">
                                            <!-- <option selected>Chọn tỉnh</option> -->
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4 col-sm-12">
                                        <div class="title mb-1">
                                            Quận huyện: <span class="text-red">*</span>
                                        </div>
                                        <br class="d-none d-md-block d-lg-none">
                                        <select class="form-select" id="district" name="district">
                                            <!-- <option selected>Quận huyện</option> -->
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4 col-sm-12">
                                        <div class="title mb-1">
                                            Địa chỉ số nhà, đường, xã phường: <span class="text-red">*</span>
                                        </div>

                                        <input type="text" name="address" class="form-control" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="title border-bottom mt-4 mb-3">
                            <h5>III. NHẬP ĐIỂM KTĐK CUỐI NĂM VÀ DIỆN ƯU TIÊN<small>(nếu có)</small></h5>
                        </div>

                        <div class="subject">
                            <div class="title mb-1 mt-2">
                                1. Điểm kiểm tra định kỳ cuối năm theo học bạ:
                            </div>
                            <div class="col-12 table-container">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col" style="width: 16%">Môn học</th>
                                        <th scope="col">Lớp 1</th>
                                        <th scope="col">Lớp 2</th>
                                        <th scope="col">Lớp 3</th>
                                        <th scope="col">Lớp 4</th>
                                        <th scope="col">Lớp 5</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">Tiếng việt</th>
                                        <td>
                                            <select class="form-select" id="tieng_viet_1" name="tiengviet-1"
                                                    onchange="get_subject(1)">
                                                <option value="10">10</option>
                                                <option value="9">9</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select" id="tieng_viet_2" name="tiengviet-2"
                                                    onchange="get_subject(2)">
                                                <option value="10">10</option>
                                                <option value="9">9</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select" id="tieng_viet_3" name="tiengviet-3"
                                                    onchange="get_subject(3)">
                                                <option value="10">10</option>
                                                <option value="9">9</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select" id="tieng_viet_4" name="tiengviet-4"
                                                    onchange="get_subject(4)">
                                                <option value="10">10</option>
                                                <option value="9">9</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select" id="tieng_viet_5" name="tiengviet-5"
                                                    onchange="get_subject(5)">
                                                <option value="10">10</option>
                                                <option value="9">9</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Toán</th>
                                        <td>
                                            <select class="form-select" id="toan_1" name="toan-1" onchange="get_subject(1)">
                                                <option value="10">10</option>
                                                <option value="9">9</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select" id="toan_2" name="toan-2" onchange="get_subject(2)">
                                                <option value="10">10</option>
                                                <option value="9">9</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select" id="toan_3" name="toan-3" onchange="get_subject(3)">
                                                <option value="10">10</option>
                                                <option value="9">9</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select" id="toan_4" name="toan-4" onchange="get_subject(4)">
                                                <option value="10">10</option>
                                                <option value="9">9</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select" id="toan_5" name="toan-5" onchange="get_subject(5)">
                                                <option value="10">10</option>
                                                <option value="9">9</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Ngoại ngữ</th>
                                        <td>
                                            <!--                                        <select style="display: none" class="form-select" id="ngoai_ngu_1" name="ngoaingu-1"-->
                                            <!--                                                onchange="get_subject(1)">-->
                                            <!--                                            <option value="0">10</option>-->
                                            <!--                                            <option value="0">9</option>-->
                                            <!--                                        </select>-->
                                        </td>
                                        <td>
                                            <!--                                        <select style="display: none" class="form-select" id="ngoai_ngu_2" name="ngoaingu-2"-->
                                            <!--                                                onchange="get_subject(2)">-->
                                            <!--                                            <option value="0">10</option>-->
                                            <!--                                            <option value="0">9</option>-->
                                            <!--                                        </select>-->
                                        </td>
                                        <td>
                                            <select class="form-select" id="ngoai_ngu_3" name="ngoaingu-3"
                                                    onchange="get_subject(3)">
                                                <option value="10">10</option>
                                                <option value="9">9</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select" id="ngoai_ngu_4" name="ngoaingu-4"
                                                    onchange="get_subject(4)">
                                                <option value="10">10</option>
                                                <option value="9">9</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select" id="ngoai_ngu_5" name="ngoaingu-5"
                                                    onchange="get_subject(5)">
                                                <option value="10">10</option>
                                                <option value="9">9</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Điểm quy đổi</th>
                                        <td>
                                            <input type="text" class="form-control" id="diem_quy_doi_1" name="diemquydoi-1"
                                                   value="2" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="diem_quy_doi_2" name="diemquydoi-2"
                                                   value="2" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="diem_quy_doi_3" name="diemquydoi-3"
                                                   value="2" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="diem_quy_doi_4" name="diemquydoi-4"
                                                   value="2" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="diem_quy_doi_5" name="diemquydoi-5"
                                                   value="2" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <input type="hidden" class="form-control" id="tong_diem_quy_doi"
                                               name="tongdiemquydoi" value="2" readonly>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--                    <div class="capacity">-->
                        <!--                        <div class="title mb-1 mt-2">-->
                        <!--                            2. Các năng lực, phẩm chất theo học bạ:-->
                        <!--                        </div>-->
                        <!--                        <div class="col-12">-->
                        <!--                            <table class="table table-bordered">-->
                        <!--                                <thead>-->
                        <!--                                <tr>-->
                        <!--                                    <th scope="col" style="width: 16%">Năng lực</th>-->
                        <!--                                    <th scope="col">Lớp 1</th>-->
                        <!--                                    <th scope="col">Lớp 2</th>-->
                        <!--                                    <th scope="col">Lớp 3</th>-->
                        <!--                                    <th scope="col">Lớp 4</th>-->
                        <!--                                    <th scope="col">Lớp 5</th>-->
                        <!--                                </tr>-->
                        <!--                                </thead>-->
                        <!--                                <tbody>-->
                        <!--                                <tr>-->
                        <!--                                    <th scope="row">Tự phục vụ, tự quản</th>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="tuquan-1">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="tuquan-2">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="tuquan-3">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="tuquan-4">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="tuquan-5">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                </tr>-->
                        <!--                                <tr>-->
                        <!--                                    <th scope="row">Hợp tác</th>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="hoptac-1">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="hoptac-2">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="hoptac-3">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="hoptac-4">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="hoptac-5">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                </tr>-->
                        <!--                                <tr>-->
                        <!--                                    <th scope="row">Tự học, giải quyết vấn đề</th>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="tuhoc-1">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="tuhoc-2">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="tuhoc-3">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="tuhoc-4">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="tuhoc-5">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                </tr>-->
                        <!--                                </tbody>-->
                        <!--                            </table>-->
                        <!--                        </div>-->
                        <!--                        <div class="col-12">-->
                        <!--                            <table class="table table-bordered">-->
                        <!--                                <thead>-->
                        <!--                                <tr>-->
                        <!--                                    <th scope="col" style="width: 16%">Phẩm chất</th>-->
                        <!--                                    <th scope="col">Lớp 1</th>-->
                        <!--                                    <th scope="col">Lớp 2</th>-->
                        <!--                                    <th scope="col">Lớp 3</th>-->
                        <!--                                    <th scope="col">Lớp 4</th>-->
                        <!--                                    <th scope="col">Lớp 5</th>-->
                        <!--                                </tr>-->
                        <!--                                </thead>-->
                        <!--                                <tbody>-->
                        <!--                                <tr>-->
                        <!--                                    <th scope="row">Chăm học, chăm làm</th>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="chamhoc-1">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="chamhoc-2">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="chamhoc-3">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="chamhoc-4">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="chamhoc-5">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                </tr>-->
                        <!--                                <tr>-->
                        <!--                                    <th scope="row">Tự tin, trách nhiệm</th>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="tutin-1">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="tutin-2">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="tutin-3">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="tutin-4">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="tutin-5">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                </tr>-->
                        <!--                                <tr>-->
                        <!--                                    <th scope="row">Trung thực, kỷ luật</th>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="kiluat-1">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="kiluat-2">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="kiluat-3">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="kiluat-4">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="kiluat-5">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                </tr>-->
                        <!--                                <tr>-->
                        <!--                                    <th scope="row">Đoàn kết, yêu thương</th>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="doanket-1">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="doanket-2">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="doanket-3">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="doanket-4">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                    <td>-->
                        <!--                                        <select class="form-select" name="doanket-5">-->
                        <!--                                            <option value="tot">Tốt</option>-->
                        <!--                                            <option value="dat">Đạt</option>-->
                        <!--                                        </select>-->
                        <!--                                    </td>-->
                        <!--                                </tr>-->
                        <!--                                </tbody>-->
                        <!--                            </table>-->
                        <!--                        </div>-->
                        <!--                    </div>-->
                        <div>
                            <div class="title mb-1">
                                2. Diện ưu tiên(nếu có):
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-7 col-sm-12">
                                    <div class="title mb-1">
                                        Diện ưu tiên:
                                    </div>
                                    <select class="form-select" name="dien_uu_tien" onchange="get_diem_uu_tien(this.value)">
                                        <option value="0">Không thuộc diện ưu tiên</option>
                                        <option value="1">1. Diện ưu tiên 1</option>
                                        <option value="2">2. Diện ưu tiên 2</option>
                                        <option value="3">3. Diện ưu tiên 3</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-5 col-sm-12">
                                    <div class="title mb-1">
                                        Điểm ưu tiên:
                                    </div>
                                    <input type="text" id="diem_uu_tien" name="diem_uu_tien" value="0" class="form-control"
                                           readonly>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="title mb-1">
                                3. Tổng điểm xét tuyển (tổng điểm quy đổi 5 năm học + điểm ưu tiên):<span
                                        class="text-red">*</span>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-5 col-sm-12">
                                    <input type="text" id="tong_diem_xet_tuyen" name="tong_diem_xet_tuyen" value="7"
                                           class="form-control" placeholder="" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="title border-bottom mt-4 mb-3">
                            <h5>IV. CÁC FILE ĐÍNH KÈM <small>(minh chứng, file ảnh/pdf dung lượng không quá 5Mb)</small>:
                            </h5>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4 col-sm-12">
                                <div class="title mb-1">
                                    Học bạ tiểu học <small>(.pdf)</small>:<span class="text-red">*</span>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="file" accept=".pdf" onchange="validateFile(this)" name="anh_hb_tieu_hoc"
                                           class="form-control" id="anh_hb_tieu_hoc" required>
                                </div>
                                <div class="img-preview">
                                    <img id="output-1"
                                         onerror="this.onerror=null;this.src='./images/common/default_filetype.png';">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-sm-12">
                                <div class="title mb-1">
                                    Giấy khai sinh bản chính <small>(Ảnh hoặc pdf)</small>:<span class="text-red">*</span>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="file" accept=".pdf, .jpg, .png" onchange="validateFile(this)"
                                           name="anh_giay_khai_sinh"
                                           class="form-control" id="anh_giay_khai_sinh" required>
                                </div>
                                <div class="img-preview">
                                    <img id="output-2"
                                         onerror="this.onerror=null;this.src='./images/common/default_filetype.png';"/>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-sm-12">
                                <div class="title mb-1">
                                    Giấy xác nhận ưu tiên (nếu có) <small>(Ảnh hoặc pdf)</small>:
                                </div>
                                <div class="input-group mb-3">
                                    <input type="file" accept=".pdf, .jpg, .png" onchange="validateFile(this)"
                                           name="anh_giay_xac_nhan_uu_tien"
                                           class="form-control" id="anh_giay_xac_nhan_uu_tien">
                                </div>
                                <div class="img-preview">
                                    <img id="output-3"
                                         onerror="this.onerror=null;this.src='./images/common/default_filetype.png';"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4 col-sm-12">
                                <div class="title mb-1">
                                    Ảnh 3x4 học sinh chụp trong 6 tháng gần đây:<span class="text-red">*</span>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="file" accept=".jpg, .png" onchange="validateFile(this)"
                                           name="anh_chan_dung"
                                           class="form-control" id="anh_chan_dung" required>
                                </div>
                                <div class="img-preview">
                                    <img id="output-4"
                                         onerror="this.onerror=null;this.src='./images/common/default_filetype.png';"/>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-sm-12">
                                <div class="title mb-1">
                                    Ảnh chụp 2 mặt CMND/CCCD của cha/mẹ/người giám hộ:<span class="text-red">*</span>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="file" accept=".pdf, .jpg, .png" onchange="validateFile(this)"
                                           name="anh_cccd" class="form-control"
                                           id="anh_cccd" required>
                                </div>
                                <div class="img-preview">
                                    <img id="output-5"
                                         onerror="this.onerror=null;this.src='./images/common/default_filetype.png';"/>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-sm-12">
                                <div class="title mb-1">
                                    Phiếu kê khai thông tin học sinh: <a href="/Mau_phieu_ke_khai_thong_tin_hoc_sinh.pdf"
                                                                         download>Tải file mẫu</a><span
                                            class="text-red">*</span>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="file" accept=".pdf" onchange="validateFile(this)" name="anh_ban_ck_cu_tru"
                                           class="form-control" id="anh_ban_ck_cu_tru" required>
                                </div>
                                <div class="img-preview">
                                    <img id="output-6"
                                         onerror="this.onerror=null;this.src='./images/common/default_filetype.png';"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4 col-sm-12">
                                <div class="title mb-1">
                                    Đơn đăng ký dự tuyển: <a href="/Don_dang_ky_du_tuyen.pdf" download>Tải file mẫu</a><span
                                            class="text-red">*</span>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="file" accept=".pdf" onchange="validateFile(this)" name="don_dk_du_tuyen"
                                           class="form-control" id="don_dk_du_tuyen" required>
                                </div>
                                <div class="img-preview">
                                    <img id="output-7"
                                         onerror="this.onerror=null;this.src='./images/common/default_filetype.png';"/>
                                </div>
                            </div>
                        </div>
                        <div class="title border-bottom mt-4 mb-3">
                            <h5>V. THÔNG TIN NGƯỜI KHAI HỒ SƠ:</h5>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4 col-sm-12">
                                <div class="title mb-1">
                                    Người khai hồ sơ:<span class="text-red">*</span>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="text" name="nguoi_khai_ho_so" placeholder="Nhập tên người khai hồ sơ"
                                           class="form-control" id="nguoi_khai_ho_so" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-sm-12">
                                <div class="title mb-1">
                                    Số điện thoại:<span class="text-red">*</span>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="text" name="sdt_nguoi_khai_ho_so"
                                           placeholder="Nhập số điện thoại người khai hồ sơ" class="form-control"
                                           id="sdt_nguoi_khai_ho_so" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-sm-12">
                                <div class="title mb-1">
                                    Email liên hệ(vui lòng sử dụng gmail):<span class="text-red">*</span>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="text" name="email_nguoi_khai_ho_so" placeholder="Nhập email"
                                           class="form-control" id="email_nguoi_khai_ho_so" required>
                                </div>
                            </div>
                        </div>
                        <p><i>Phụ huynh ghi nhớ địa chỉ email đã đăng ký để cập nhật thông tin từ nhà trường</i></p>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="cam_ket">
                                <label class="form-check-label" for="cam_ket">
                                    <b>Tôi cam đoan tất cả các thông tin đã khai trên là đúng sự thật. Nếu lời khai không
                                        đúng sự thật, mọi kết quả liên quan đều sẽ bị hủy.</b>
                                </label>
                            </div>
                        </div>
                        <div class="row mt-5 mb-5">
                            <div class="d-grid gap-2 col-sm-12 col-md-3 mx-auto btn-send-form" style="text-align: right;">
                                <button type="submit" id="button_dangKy" class="btn btn-primary" disabled>Đăng ký hồ sơ
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php } else if ($current_status == 'Maintenance') { ?>
        <div style="padding: 10px;text-align: center; height: 500px">
            <h2>Web site đang bảo trì hệ thống, Quý phụ huynh vui lòng chờ trong ít phút</h2>
        </div>
    <?php }  else if ($current_status == 'Expired') {?>
        <div style="color: red; padding: 10px; text-align: center; height: 500px">
            <h2>Hết hạn đăng ký hồ sơ</h2>
        </div>
    <?php } else if ($current_status == 'Notification') {?>
        <div class="diem_chuan">
            <div class="container">
<!--                <h2 class="title" style="text-align: center">THÔNG BÁO ĐIỂM TRÚNG TUYỂN VÀO LỚP 6 NĂM HỌC 2024-2025</h2>-->
<!--                <div class="box_content">-->
<!--                    <p> Hội đồng tuyển sinh Trường THCS CLC Thanh Xuân thông báo điểm trúng tuyển vào lớp 6 năm học 2024 - 2025 là:  <strong>51.40 điểm</strong></p>-->
<!--                    <p>* <strong>Lưu ý:</strong> Các trường hợp phúc khảo điểm kiểm tra phụ huynh học sinh vào mục <strong>Tra cứu thông tin thí sinh – Tra cứu kết quả</strong> để xem điểm.</p>-->
<!--                    <p>* Thời gian nộp hồ sơ nhập học:  <strong>ngày 19, 20/06/2024 (Sáng từ 7h30 đến 11h00, Chiều từ 14h00 đến 17h00)</strong></p>-->
<!--                    <p>* Hồ sơ nhập học bao gồm:</p>-->
<!--                    <p><strong>+ Bản chính học bạ cấp Tiểu học.</strong></p>-->
<!--                    <p><strong> + Phiếu kê khai thông tin học sinh (theo mẫu của nhà trường) kèm theo minh chứng về nơi thường trú (Căn cước công dân, truy cập định danh điện tử VNeID mức 2 của Bố (mẹ) hoặc người giám hộ học sinh đăng ký tuyển sinh hoặc giấy xác nhận thường trú do cơ quan có thẩm quyền cấp để đối chiếu)</strong></p>-->
<!--                    <p><strong>+ Bản sao giấy khai sinh</strong></p>-->
<!--                    <p><strong>+ Bản chính giấy xác nhận ưu tiên do cơ quan có thẩm quyền cấp (nếu có)</strong></p>-->
<!--                    <p><strong>(Trong trường hợp hồ sơ nhập học không khớp với Hồ sơ dự tuyển và không đúng với các quy định trong Kế hoạch tuyển sinh của nhà trường kết quả trúng tuyển sẽ bị hủy)</strong></p>-->
<!--                </div>-->

                <?php echo $notificationMessage; ?>


            </div>
        </div>
    <?php } ?>
    <?php


    // Hiển thị nội dung tương ứng với trạng thái hiện tại
//    switch ($current_status) {
//        case 'Open':
//            echo '<div style="background-color: green; padding: 10px;">Đang mở</div>';
//            $status_display = 'Open';
//            break;
//        case 'Maintenance':
//            echo '<div style="background-color: yellow; padding: 10px;">Bảo trì</div>';
//            $status_display = 'Maintenance';
//            break;
//        case 'Expired':
//            echo '<div style="background-color: red; padding: 10px;">Hết hạn</div>';
//            $status_display = 'Expired';
//            break;
//        default:
//            echo '<div style="background-color: gray; padding: 10px;">Chưa được thiết lập</div>';
//            $status_display = 'Open';
//            break;
//    }
//    ?>

</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Include Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Include Bootstrap Datepicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<!-- Include Bootstrap Datepicker Vietnamese localization -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.vi.min.js"></script>
<script type="text/javascript">
    function toggleMobileMenu() {
        var menu = document.querySelector('.menu_top');
        menu.classList.toggle('show-mobile-menu');
    }

    $(document).ready(function () {
        $('#datepicker').datepicker({
            format: 'dd/mm/yyyy',
            language: 'vi',
            autoclose: true
        });

        $('#province').change(function () {
            loadDistrict($(this).find(':selected').val())
        })

        $(".img-preview img").each(function () {
            if ($(this).attr('src') == '') {
                $(this).css("display", "none");
            } else {
                $(this).addClass("active");
            }
        });

        $('#cam_ket').click(function () {
            $('#button_dangKy').prop("disabled", !$("#cam_ket").prop("checked"));
        })


    });

    function validateTenDigitInteger(value) {
        return /^\d{10}$/.test(value);
    }

    // document.getElementById('ma_hocsinh').addEventListener('keyup', function () {
    //     const inputValue = this.value;
    //     const isValid = validateTenDigitInteger(inputValue);
    //
    //     const checkbox = document.getElementById('cam_ket');
    //     const button = document.getElementById('button_dangKy');
    //
    //     checkbox.checked = isValid;
    //     button.disabled = !isValid;
    // });

    // document.addEventListener("DOMContentLoaded", function () {
    //     var checkbox = document.getElementById("cam_ket");
    //     var input = document.getElementById("button_dangKy");
    //
    //     // Biến điều kiện
    //     var condition = true;
    //
    //     checkbox.addEventListener("change", function () {
    //         // Kiểm tra trạng thái của checkbox và điều kiện
    //         if (checkbox.checked && !check_unique) {
    //             input.disabled = false;
    //         } else {
    //             input.disabled = true;
    //         }
    //     });
    // });

    function loadProvince() {
        $("#province").children().remove();
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: "get=province"
        }).done(function (result) {
            $("#province").append($(result));
            // $(result).each(function() {

            // })
            loadDistrict(1);
        });
    }

    function loadDistrict(province_id) {
        $("#district").children().remove()
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: "get=district&province_id=" + province_id
        }).done(function (result) {
            $("#district").append($(result));

        });
    }

    function get_subject(value) {
        console.log('value', value)
        let idx1 = 'tieng_viet_' + value;
        let idx2 = 'toan_' + value;
        let idx3 = 'ngoai_ngu_' + value;
        let tong_diem_3_mon;
        let tv = document.getElementById(idx1).value;
        let t = document.getElementById(idx2).value;
        if (idx1 === 'tieng_viet_1' || idx1 === 'tieng_viet_2' || idx2 === 'toan_1' || idx2 === 'toan_2') {
            tong_diem_3_mon = Number(tv) + Number(t);
        } else {
            let nn = document.getElementById(idx3).value;
            tong_diem_3_mon = tong_diem_3_mon = Number(tv) + Number(t) + Number(nn);
        }


        // let nn = document.getElementById(idx3).value ? document.getElementById(idx3).value : 0;

        // console.log('tong diem 3 mon', Number(tv) + Number(t) + Number(nn));

        // let tong_diem_3_mon = Number(tv) + Number(t) + Number(nn);
        let he_so_quy_doi = 2
        if (tong_diem_3_mon === 30) {
            he_so_quy_doi = 2;
        } else if (tong_diem_3_mon === 29) {
            he_so_quy_doi = 1.75;
        } else if (tong_diem_3_mon === 28) {
            he_so_quy_doi = 1.5;
        } else if (tong_diem_3_mon === 27) {
            he_so_quy_doi = 1.25;
        } else if (tong_diem_3_mon === 20) {
            he_so_quy_doi = 2;
        } else if (tong_diem_3_mon === 19) {
            he_so_quy_doi = 1.75;
        } else if (tong_diem_3_mon === 18) {
            he_so_quy_doi = 1.5;
        }

        if (value === 1) {
            document.getElementById('diem_quy_doi_1').value = he_so_quy_doi;
        } else if (value === 2) {
            document.getElementById('diem_quy_doi_2').value = he_so_quy_doi;
        } else if (value === 3) {
            document.getElementById('diem_quy_doi_3').value = he_so_quy_doi;
        } else if (value === 4) {
            document.getElementById('diem_quy_doi_4').value = he_so_quy_doi;
        } else if (value === 5) {
            document.getElementById('diem_quy_doi_5').value = he_so_quy_doi;
        }

        let diem_quy_doi_1 = document.getElementById('diem_quy_doi_1').value;
        let diem_quy_doi_2 = document.getElementById('diem_quy_doi_2').value;
        let diem_quy_doi_3 = document.getElementById('diem_quy_doi_3').value;
        let diem_quy_doi_4 = document.getElementById('diem_quy_doi_4').value;
        let diem_quy_doi_5 = document.getElementById('diem_quy_doi_5').value;

        let tong_diem_quy_doi = Number(diem_quy_doi_1) + Number(diem_quy_doi_2) + Number(diem_quy_doi_3) + Number(diem_quy_doi_4) + Number(diem_quy_doi_5);
        let tongdiemquydoi = document.getElementById('tong_diem_quy_doi').value;
        get_total_score();

    }


    // init the countries
    loadProvince();

    function setupImagePreview(inputFileId, imagePreviewId) {
        const inputFile = document.getElementById(inputFileId);
        const imagePreview = document.getElementById(imagePreviewId);

        inputFile.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                if (file.type === 'application/pdf') {
                    imagePreview.src = './images/common/default_filetype.png'
                } else {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        imagePreview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            } else {
                imagePreview.src = ''; // Clear the preview if no file selected
            }
        });
    }

    setupImagePreview('anh_hb_tieu_hoc', 'output-1');
    setupImagePreview('anh_giay_khai_sinh', 'output-2');
    setupImagePreview('anh_giay_xac_nhan_uu_tien', 'output-3');
    setupImagePreview('anh_chan_dung', 'output-4');
    setupImagePreview('anh_cccd', 'output-5');
    setupImagePreview('anh_ban_ck_cu_tru', 'output-6');
    setupImagePreview('don_dk_du_tuyen', 'output-7');

    function validateFile(input) {
        if (input.files && input.files[0]) {
            var fileType = input.files[0].type; // Loại tệp
            var fileSize = input.files[0].size; // Kích thước của tệp
            var maxSize = 5 * 1024 * 1024; // Kích thước tối đa là 5MB (đơn vị là byte)

            // Kiểm tra nếu không phải là tệp PDF hoặc ảnh
            if (fileType !== "application/pdf" && !fileType.startsWith("image/")) {
                alert("Loại tệp không được hỗ trợ. Vui lòng chọn tệp PDF hoặc ảnh.");
                input.value = ""; // Xóa tệp khỏi trường input
                return;
            }

            // Kiểm tra kích thước của tệp
            if (fileSize > maxSize) {
                alert("Kích thước tệp quá lớn. Vui lòng chọn tệp có kích thước nhỏ hơn.");
                input.value = ""; // Xóa tệp khỏi trường input
            }
        }
    }


    function get_diem_uu_tien(value) {
        let diem = Number(value);
        if (diem) {
            if (diem === 1) {
                document.getElementById('diem_uu_tien').value = 1.5;
            } else if (diem === 2) {
                document.getElementById('diem_uu_tien').value = 1;
            } else if (diem === 3) {
                document.getElementById('diem_uu_tien').value = 0.5;
            } else {
                document.getElementById('diem_uu_tien').value = 0;
            }
            $("#anh_giay_xac_nhan_uu_tien").prop('required', true);

            // let tong_diem = document.getElementById('tong_diem_quy_doi').value;
            get_total_score();
        }
        if (value === '0') {
            document.getElementById('diem_uu_tien').value = 0;
            $("#anh_giay_xac_nhan_uu_tien").prop('required', false);
            get_total_score();
        }
    }


    var timeout = null;
    var check_unique = false;
    $('#ma_hocsinh').keyup(function () {
        console.log('check_unique', check_unique)
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            jQuery.ajax({
                type: "POST",
                url: "ajax.php",
                data: 'get=ma_hs_vld&ma_hs_vld=' + $("#ma_hocsinh").val(),
                success: function (data) {
                    if (data) {
                        var responseObject = JSON.parse(data);
                        if (responseObject.status === 300) {
                            $("#check-student-code").html(responseObject.message);
                            $("#check-student-code").css({'display': 'block'});
                            check_unique = true;
                            $('#button_dangKy').prop("disabled", true);
                        } else if (responseObject.status === 200) {
                            $("#check-student-code").css({'display': 'none'});
                            check_unique = false;
                            // $('#button_dangKy').prop("disabled", false);
                        } else if (responseObject.status === 201) {
                            $("#check-student-code").css({'display': 'block'});
                            check_unique = true;
                            // $('#button_dangKy').prop("disabled", false);
                            $("#check-student-code").html(responseObject.message);
                        }
                    } else {
                        $("#check-student-code").html('Mã học sinh là bắt buộc')
                    }
                },
                error: function () {

                }
            });
        }, 500);
    });

    function get_total_score() {
        let diem_quy_doi_1 = document.getElementById('diem_quy_doi_1').value;
        let diem_quy_doi_2 = document.getElementById('diem_quy_doi_2').value;
        let diem_quy_doi_3 = document.getElementById('diem_quy_doi_3').value;
        let diem_quy_doi_4 = document.getElementById('diem_quy_doi_4').value;
        let diem_quy_doi_5 = document.getElementById('diem_quy_doi_5').value;

        let diem_uu_tien = document.getElementById('diem_uu_tien').value;

        let tong_diem_quy_doi = Number(diem_quy_doi_1) + Number(diem_quy_doi_2) + Number(diem_quy_doi_3) + Number(diem_quy_doi_4) + Number(diem_quy_doi_5) + Number(diem_uu_tien);
        document.getElementById('tong_diem_xet_tuyen').value = tong_diem_quy_doi;
    }

    window.onload = function () {
        get_total_score();
    }

</script>

<script>
    $(document).on('submit', '#saveStudent', function (e) {
        e.preventDefault();
        var ma_hocsinh = document.getElementById('ma_hocsinh');
        var input = ma_hocsinh.value;
        var regex = /^\d{10}$/; // Biểu thức chính quy để kiểm tra xem đầu vào có chứa 10 chữ số hay không

        var warningMessage = document.getElementById('warningMessage');

        if (!regex.test(input)) {
            warningMessage.innerText = "Mã học sinh không hợp lệ. Phải là một số gồm 10 số";
            // ma_hocsinh.value = ""; // Xóa nội dung không hợp lệ
            ma_hocsinh.focus(); // Di chuyển trỏ chuột đến trường nhập liệu
            return;
        }

        // Nếu đầu vào hợp lệ, xóa thông báo
        warningMessage.innerText = "";

        var formData = new FormData(this);
        let anh_hb_tieu_hoc = document.getElementById('anh_hb_tieu_hoc');
        let anh_giay_khai_sinh = document.getElementById('anh_giay_khai_sinh');
        let anh_giay_xac_nhan_uu_tien = document.getElementById('anh_giay_xac_nhan_uu_tien');
        let anh_chan_dung = document.getElementById('anh_chan_dung');
        let anh_cccd = document.getElementById('anh_cccd');
        let anh_ban_ck_cu_tru = document.getElementById('anh_ban_ck_cu_tru');
        let don_dk_du_tuyen = document.getElementById('don_dk_du_tuyen');
        formData.append('picture_1', anh_hb_tieu_hoc.files[0]);
        formData.append('picture_2', anh_giay_khai_sinh.files[0]);
        formData.append('picture_3', anh_giay_xac_nhan_uu_tien.files[0]);
        formData.append('picture_4', anh_chan_dung.files[0]);
        formData.append('picture_5', anh_cccd.files[0]);
        formData.append('picture_6', anh_ban_ck_cu_tru.files[0]);
        formData.append('picture_7', don_dk_du_tuyen.files[0]);
        formData.append("save_student", true);

        $('#button_dangKy').prop("disabled", true);
        $('#button_dangKy').addClass('inactive');

        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function (responses) {
                console.log('response', responses)
                // Chuỗi JSON chứa nhiều phản hồi
                // var responses = '{"status":200,"message":"ok"}{"success":true}{"status":200,"message":"Student Created Successfully"}';

                // Tách các phản hồi JSON ra thành mảng
                var responseArray = responses.match(/({.*?})/g);

                // Xử lý từng phản hồi JSON
                try {
                    responseArray.forEach(function (response) {
                        var responseObject = JSON.parse(response);
                        // Kiểm tra trạng thái của phản hồi và thực hiện các hành động tương ứng
                        if (responseObject.status === 200) {
                            console.log("Status 200:", responseObject.message);
                            // Thực hiện hành động khi status là 200
                            $('#box-title-register-success').addClass('active');
                            $('#register-content').addClass('inactive');
                            $('#button_dangKy').prop("disabled", false);
                            $('#saveStudent')[0].reset();
                            $('#button_dangKy').removeClass('inactive');
                        } else {
                            console.log("responseObject", responseObject);
                            alert('Đã có lỗi xảy ra, vui lòng nhập lại');
                            $('#saveStudent')[0].reset();
                            $('#button_dangKy').removeClass('inactive');
                            $('.img-preview').remove();
                            // Thực hiện hành động khi status không phải là 200
                        }
                    });
                } catch (e) {
                    console.log(e)
                }
            }
        });

    });

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

<?php require('inc/footer.php'); ?>

</body>
</html>
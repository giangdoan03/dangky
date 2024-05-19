<?php
require('inc/essentials.php');
include('./inc/db_config.php');
adminLogin();
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
            <h3 class="mb-4">THÔNG TIN CHI TIẾT</h3>
            <!-- General settings section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="list-student card-body">
                    <div class="page-content">
                        <div class="title border-bottom">
                            <h5>I. THÔNG TIN CÁ NHÂN:</h5>
                        </div>
                        <form action="" id="saveStudent">
                            <?php
                            if (isset($_GET["id"])) {
                                $id = $_GET["id"];
                                $sql = "SELECT * FROM hoc_sinh AS a 
                                    INNER JOIN phu_huynh AS b ON a.id = b.id_hocsinh
                                    INNER JOIN province AS p ON p.province_id = b.id_tinh
                                    INNER JOIN district AS d ON d.district_id = b.id_huyen
                                    WHERE a.id = '$id'";
                                $result = mysqli_query($conn, $sql);
                                $resultCheck = mysqli_num_rows($result);

                                if ($resultCheck > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        ?>

                                        <div class="user-info mt-3">
                                            <div class="row mb-4">
                                                <div class="col-12 col-md-4 col-sm-12">
                                                    <div class="title mb-1">
                                                        1. Họ và tên học sinh :<span class="text-red">*</span>
                                                    </div>
                                                    <div>
                                                        <?php echo $row["hoten_hocsinh"]; ?>
                                                        <input type="hidden" id="ten_hoc_sinh" value="<?php echo $row["hoten_hocsinh"]; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4 col-sm-12">
                                                    <div class="title mb-1">
                                                        2. Ngày sinh (dd/mm/yyyy): <span class="text-red">*</span>
                                                    </div>
                                                    <br class="d-none d-md-block d-lg-none">
                                                    <div>
                                                        <?php echo $row["ngaysinh"]; ?>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4 col-sm-12">
                                                    <div class="title mb-1">
                                                        3. Mã số học sinh theo CSDL của bộ (10 số): <span
                                                                class="text-red">*</span>
                                                    </div>
                                                    <div>
                                                        <?php echo $row["ma_hocsinh"]; ?>
                                                        <input type="hidden" id="ma_hoc_sinh" value="<?php echo $row["ma_hocsinh"]; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-12 col-md-4 col-sm-12">
                                                    <div class="title mb-1">
                                                        4. Nơi sinh (Tỉnh/TP):<span class="text-red">*</span>
                                                    </div>
                                                    <div>
                                                        <?php echo $row["noisinh"]; ?>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4 col-sm-12">
                                                    <div class="title mb-1">
                                                        5. Giới tính: <span class="text-red">*</span>
                                                    </div>
                                                    <div>
                                                        <?php echo $row["gioitinh"] === 'nu' ? 'Nữ' : 'Nam'; ?>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4 col-sm-12">
                                                    <div class="title mb-1">
                                                        6. Dân tộc: <span class="text-red">*</span>
                                                    </div>
                                                    <div>
                                                        <?php echo $row["dantoc"]; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-6 col-sm-12">
                                                    <div class="title mb-1">
                                                        7. Học sinh lớp:<span class="text-red">*</span>
                                                    </div>
                                                    <div>
                                                        <?php echo $row["tenlop"]; ?>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-sm-12">
                                                    <div class="title mb-1">
                                                        8. Trường tiểu học: <span class="text-red">*</span>
                                                    </div>
                                                    <div>
                                                        <?php echo $row["ten_truong"]; ?>
                                                    </div>
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
                                                    <div>
                                                        <?php echo $row["ho_ten_cha"]; ?>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-5 col-sm-12">
                                                    <div class="title mb-1">
                                                        Điện thoại cha: <span class="text-red">*</span>
                                                    </div>
                                                    <div>
                                                        <?php echo $row["sdt_cha"]; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-12 col-md-7 col-sm-12">
                                                    <div class="title mb-1">
                                                        2. Họ và tên mẹ:<span class="text-red">*</span>
                                                    </div>
                                                    <div>
                                                        <?php echo $row["ho_ten_me"]; ?>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-5 col-sm-12">
                                                    <div class="title mb-1">
                                                        Điện thoại mẹ: <span class="text-red">*</span>
                                                    </div>
                                                    <div>
                                                        <?php echo $row["sdt_me"]; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-12 col-md-7 col-sm-12">
                                                    <div class="title mb-1">
                                                        3. Họ và tên người giám hộ(nếu có):
                                                    </div>
                                                    <div>
                                                        <?php echo $row["hoten_nguoi_giamho"]; ?>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-5 col-sm-12">
                                                    <div class="title mb-1">
                                                        Điện thoại người giám hộ:
                                                    </div>
                                                    <div>
                                                        <?php echo $row["sdt_nguoigiamho"]; ?>
                                                    </div>
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
                                                        <?php echo $row["name"]; ?>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-sm-12">
                                                        <div class="title mb-1">
                                                            Quận huyện: <span class="text-red">*</span>
                                                        </div>
                                                        <br class="d-none d-md-block d-lg-none">
                                                        <?php echo $row["name_district"]; ?>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-sm-12">
                                                        <div class="title mb-1">
                                                            Địa chỉ số nhà, đường, xã phường: <span
                                                                    class="text-red">*</span>
                                                        </div>

                                                        <div>
                                                            <?php echo $row["address"]; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            }
                            ?>

                            <?php

                            ?>
                            <div class="title border-bottom mt-4 mb-3">
                                <h5>III. NHẬP ĐIỂM KTDK CUỐI NĂM, CÁC NĂNG LỰC, PHẨM CHẤT VÀ DIỆN ƯU TIÊN <small>(nếu
                                        có)</small></h5>
                            </div>

                            <div class="subject">
                                <div class="title mb-1 mt-2">
                                    1. Điểm kiểm tra định kỳ cuối năm theo học bạ:
                                </div>
                                <div class="col-12">
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
                                            <input type="hidden" name="tieng_viet" value="1">
                                            <th scope="row">Tiếng việt</th>
                                            <?php
                                            if (isset($_GET["id"])) {
                                                $id = $_GET["id"];
                                                $sql = "SELECT * FROM diem WHERE id_hocsinh = '$id' AND ten_mon_hoc = 'tiengviet'";
                                                $result = mysqli_query($conn, $sql);
                                                $resultCheck = mysqli_num_rows($result);
                                                if ($resultCheck > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        ?>
                                                        <td>
                                                            <?php echo $row["diem_so"]; ?>
                                                        </td>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <th scope="row">Toán</th>
                                            <?php
                                            if (isset($_GET["id"])) {
                                                $id = $_GET["id"];
                                                $sql = "SELECT * FROM diem WHERE id_hocsinh = '$id' AND ten_mon_hoc = 'toan'";
                                                $result = mysqli_query($conn, $sql);
                                                $resultCheck = mysqli_num_rows($result);
                                                if ($resultCheck > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        ?>
                                                        <td>
                                                            <?php echo $row["diem_so"]; ?>
                                                        </td>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <th scope="row">Ngoại ngữ</th>
                                            <?php
                                            if (isset($_GET["id"])) {
                                                $id = $_GET["id"];
                                                $sql = "SELECT * FROM diem WHERE id_hocsinh = '$id' AND ten_mon_hoc = 'ngoaingu'";
                                                $result = mysqli_query($conn, $sql);
                                                $resultCheck = mysqli_num_rows($result);
                                                if ($resultCheck > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        ?>
                                                        <td>
                                                            <?php echo $row["diem_so"]; ?>
                                                        </td>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <th scope="row">Điểm quy đổi</th>
                                            <?php
                                            if (isset($_GET["id"])) {
                                                $id = $_GET["id"];
                                                $sql = "SELECT * FROM diem WHERE id_hocsinh = '$id' AND ten_mon_hoc = 'diemquydoi'";
                                                $result = mysqli_query($conn, $sql);
                                                $resultCheck = mysqli_num_rows($result);
                                                if ($resultCheck > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        ?>
                                                        <td>
                                                            <?php echo $row["diem_so"]; ?>
                                                        </td>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--                            <div class="capacity">-->
                            <!--                                <div class="title mb-1 mt-2">-->
                            <!--                                    3. Các năng lực, phẩm chất theo học bạ:-->
                            <!--                                </div>-->
                            <!--                                <div class="col-12">-->
                            <!--                                    <table class="table table-bordered">-->
                            <!--                                        <thead>-->
                            <!--                                        <tr>-->
                            <!--                                            <th scope="col" style="width: 16%">Năng lực</th>-->
                            <!--                                            <th scope="col">Lớp 1</th>-->
                            <!--                                            <th scope="col">Lớp 2</th>-->
                            <!--                                            <th scope="col">Lớp 3</th>-->
                            <!--                                            <th scope="col">Lớp 4</th>-->
                            <!--                                            <th scope="col">Lớp 5</th>-->
                            <!--                                        </tr>-->
                            <!--                                        </thead>-->
                            <!--                                        <tbody>-->
                            <!--                                        <tr>-->
                            <!--                                            <th scope="row">Tự phục vụ, tự quản</th>-->
                            <!--                                            --><?php
                            //                                            if (isset($_GET["id"])) {
                            //                                                $id = $_GET["id"];
                            //                                                $sql = "SELECT * FROM diem WHERE id_hocsinh = '$id' AND ten_mon_hoc = 'tuquan'";
                            //                                                $result = mysqli_query($conn, $sql);
                            //                                                $resultCheck = mysqli_num_rows($result);
                            //                                                if ($resultCheck > 0) {
                            //                                                    while ($row = mysqli_fetch_assoc($result)) {
                            //                                                        ?>
                            <!--                                                        <td>-->
                            <!--                                                            --><?php //echo $row["diem_so"] === 'tot' ? 'tốt' : 'đạt'; ?>
                            <!--                                                        </td>-->
                            <!--                                                        --><?php
                            //                                                    }
                            //                                                }
                            //                                            }
                            //                                            ?>
                            <!--                                        </tr>-->
                            <!--                                        <tr>-->
                            <!--                                            <th scope="row">Hợp tác</th>-->
                            <!--                                            --><?php
                            //                                            if (isset($_GET["id"])) {
                            //                                                $id = $_GET["id"];
                            //                                                $sql = "SELECT * FROM diem WHERE id_hocsinh = '$id' AND ten_mon_hoc = 'hoptac'";
                            //                                                $result = mysqli_query($conn, $sql);
                            //                                                $resultCheck = mysqli_num_rows($result);
                            //                                                if ($resultCheck > 0) {
                            //                                                    while ($row = mysqli_fetch_assoc($result)) {
                            //                                                        ?>
                            <!--                                                        <td>-->
                            <!--                                                            --><?php //echo $row["diem_so"] === 'tot' ? 'tốt' : 'đạt'; ?>
                            <!--                                                        </td>-->
                            <!--                                                        --><?php
                            //                                                    }
                            //                                                }
                            //                                            }
                            //                                            ?>
                            <!--                                        </tr>-->
                            <!--                                        <tr>-->
                            <!--                                            <th scope="row">Tự học, giải quyết vấn đề</th>-->
                            <!--                                            --><?php
                            //                                            if (isset($_GET["id"])) {
                            //                                                $id = $_GET["id"];
                            //                                                $sql = "SELECT * FROM diem WHERE id_hocsinh = '$id' AND ten_mon_hoc = 'tuhoc'";
                            //                                                $result = mysqli_query($conn, $sql);
                            //                                                $resultCheck = mysqli_num_rows($result);
                            //                                                if ($resultCheck > 0) {
                            //                                                    while ($row = mysqli_fetch_assoc($result)) {
                            //                                                        ?>
                            <!--                                                        <td>-->
                            <!--                                                            --><?php //echo $row["diem_so"] === 'tot' ? 'tốt' : 'đạt'; ?>
                            <!--                                                        </td>-->
                            <!--                                                        --><?php
                            //                                                    }
                            //                                                }
                            //                                            }
                            //                                            ?>
                            <!--                                        </tr>-->
                            <!--                                        </tbody>-->
                            <!--                                    </table>-->
                            <!--                                </div>-->
                            <!--                                <div class="col-12">-->
                            <!--                                    <table class="table table-bordered">-->
                            <!--                                        <thead>-->
                            <!--                                        <tr>-->
                            <!--                                            <th scope="col" style="width: 16%">Phẩm chất</th>-->
                            <!--                                            <th scope="col">Lớp 1</th>-->
                            <!--                                            <th scope="col">Lớp 2</th>-->
                            <!--                                            <th scope="col">Lớp 3</th>-->
                            <!--                                            <th scope="col">Lớp 4</th>-->
                            <!--                                            <th scope="col">Lớp 5</th>-->
                            <!--                                        </tr>-->
                            <!--                                        </thead>-->
                            <!--                                        <tbody>-->
                            <!--                                        <tr>-->
                            <!--                                            <th scope="row">Chăm học, chăm làm</th>-->
                            <!--                                            --><?php
                            //                                            if (isset($_GET["id"])) {
                            //                                                $id = $_GET["id"];
                            //                                                $sql = "SELECT * FROM diem WHERE id_hocsinh = '$id' AND ten_mon_hoc = 'chamhoc'";
                            //                                                $result = mysqli_query($conn, $sql);
                            //                                                $resultCheck = mysqli_num_rows($result);
                            //                                                if ($resultCheck > 0) {
                            //                                                    while ($row = mysqli_fetch_assoc($result)) {
                            //                                                        ?>
                            <!--                                                        <td>-->
                            <!--                                                            --><?php //echo $row["diem_so"] === 'tot' ? 'tốt' : 'đạt'; ?>
                            <!--                                                        </td>-->
                            <!--                                                        --><?php
                            //                                                    }
                            //                                                }
                            //                                            }
                            //                                            ?>
                            <!--                                        </tr>-->
                            <!--                                        <tr>-->
                            <!--                                            <th scope="row">Tự tin, trách nhiệm</th>-->
                            <!--                                            --><?php
                            //                                            if (isset($_GET["id"])) {
                            //                                                $id = $_GET["id"];
                            //                                                $sql = "SELECT * FROM diem WHERE id_hocsinh = '$id' AND ten_mon_hoc = 'tutin'";
                            //                                                $result = mysqli_query($conn, $sql);
                            //                                                $resultCheck = mysqli_num_rows($result);
                            //                                                if ($resultCheck > 0) {
                            //                                                    while ($row = mysqli_fetch_assoc($result)) {
                            //                                                        ?>
                            <!--                                                        <td>-->
                            <!--                                                            --><?php //echo $row["diem_so"] === 'tot' ? 'tốt' : 'đạt'; ?>
                            <!--                                                        </td>-->
                            <!--                                                        --><?php
                            //                                                    }
                            //                                                }
                            //                                            }
                            //                                            ?>
                            <!--                                        </tr>-->
                            <!--                                        <tr>-->
                            <!--                                            <th scope="row">Trung thực, kỷ luật</th>-->
                            <!--                                            --><?php
                            //                                            if (isset($_GET["id"])) {
                            //                                                $id = $_GET["id"];
                            //                                                $sql = "SELECT * FROM diem WHERE id_hocsinh = '$id' AND ten_mon_hoc = 'kiluat'";
                            //                                                $result = mysqli_query($conn, $sql);
                            //                                                $resultCheck = mysqli_num_rows($result);
                            //                                                if ($resultCheck > 0) {
                            //                                                    while ($row = mysqli_fetch_assoc($result)) {
                            //                                                        ?>
                            <!--                                                        <td>-->
                            <!--                                                            --><?php //echo $row["diem_so"] === 'tot' ? 'tốt' : 'đạt'; ?>
                            <!--                                                        </td>-->
                            <!--                                                        --><?php
                            //                                                    }
                            //                                                }
                            //                                            }
                            //                                            ?>
                            <!--                                        </tr>-->
                            <!--                                        <tr>-->
                            <!--                                            <th scope="row">Đoàn kết, yêu thương</th>-->
                            <!--                                            --><?php
                            //                                            if (isset($_GET["id"])) {
                            //                                                $id = $_GET["id"];
                            //                                                $sql = "SELECT * FROM diem WHERE id_hocsinh = '$id' AND ten_mon_hoc = 'doanket'";
                            //                                                $result = mysqli_query($conn, $sql);
                            //                                                $resultCheck = mysqli_num_rows($result);
                            //                                                if ($resultCheck > 0) {
                            //                                                    while ($row = mysqli_fetch_assoc($result)) {
                            //                                                        ?>
                            <!--                                                        <td>-->
                            <!--                                                            --><?php //echo $row["diem_so"] === 'tot' ? 'tốt' : 'đạt'; ?>
                            <!--                                                        </td>-->
                            <!--                                                        --><?php
                            //                                                    }
                            //                                                }
                            //                                            }
                            //                                            ?>
                            <!--                                        </tr>-->
                            <!--                                        </tbody>-->
                            <!--                                    </table>-->
                            <!--                                </div>-->
                            <!--                            </div>-->

                            <div>
                                <div class="title mb-1">
                                    2. Diện ưu tiên(nếu có):
                                </div>
                                <div class="row mb-4">
                                    <div class="col-12 col-md-7 col-sm-12">
                                        <?php
                                        if (isset($_GET["id"])) {
                                            $id = $_GET["id"];
                                            $sql = "SELECT * FROM hoc_sinh WHERE id = '$id'";
                                            $result = mysqli_query($conn, $sql);
                                            $resultCheck = mysqli_num_rows($result);
                                            if ($resultCheck > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                    <div>Diện ưu tiên: <?php echo $row["dien_uu_tien"]; ?></div>
                                                    <div>Điểm ưu tiên: <?php echo $row["diem_uu_tien"]; ?></div>
                                                    <div>
                                                        3. Tổng điểm xét tuyển (tổng điểm quy đổi 5 năm học + điểm ưu
                                                        tiên): <?php echo $row["tong_diem_xet_tuyen"]; ?>
                                                    </div>

                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="title border-bottom mt-4 mb-3">
                                <h5>IV. CÁC FILE ẢNH CHỨNG CHỈ ĐÍNH KÈM:</h5>
                            </div>
                            <div class="row gap-4">
                                <?php
                                if (isset($_GET["id"])) {
                                    $id = $_GET["id"];
                                    $sql = "SELECT h.ten_file, h.url_file, h.type_file FROM anh_chung_chi AS h
                                    INNER JOIN hoc_sinh AS a ON h.id_hocsinh = a.id
                                    WHERE a.id = '$id'";
                                    $result = mysqli_query($conn, $sql);
                                    $resultCheck = mysqli_num_rows($result);

                                    if ($resultCheck > 0) {
                                        $count = 0;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $path = ABOUT_IMAGE_PATH;
                                            $count ++;
                                            ?>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-3 col-xxl-3 col-sm-12">
                                                <div class="title mb-1">
                                                    <?php echo $row['ten_file']; ?>:<span class="text-red">*</span>
                                                </div>
                                                <div class="img-preview">
                                                    <?php if ($row['type_file'] == 'img') { ?>
                                                        <img src="<?php echo $path . $row['url_file']; ?>" alt="">
                                                    <?php } else { ?>
                                                        <div class="link-download">
                                                            <a href="<?php echo $path . $row['url_file']; ?>">Tải file tại đây</a>
                                                        </div>
                                                    <?php } ?>
                                                    <input type="hidden" id="duong_dan_anh_cc_<?php echo $count; ?>" value="<?php echo $path . $row['url_file']; ?>">
                                                </div>
                                            </div>

                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <div class="mt-4 mb-3">
                                <div id="downloadBtn">Download All Images as Zip</div>
                            </div>

                            <div class="title border-bottom mt-4 mb-3">
                                <h5>V. THÔNG TIN NGƯỜI KHAI HỒ SƠ:</h5>
                            </div>
                            <div class="row">
                                <?php
                                if (isset($_GET["id"])) {
                                    $id = $_GET["id"];
                                    $sql = "SELECT * FROM phu_huynh WHERE id_hocsinh = '$id'";
                                    $result = mysqli_query($conn, $sql);
                                    $resultCheck = mysqli_num_rows($result);
                                    if ($resultCheck > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <div class="col-12 col-md-4 col-sm-12">
                                                <div class="title mb-1">
                                                    Người khai hồ sơ: <?php echo $row['nguoi_khai_ho_so'] ?>
                                                </div>
                                                <div class="title mb-1">
                                                    Số điện thoại: <?php echo $row['sdt_nguoi_khai_ho_so'] ?>
                                                </div>
                                                <div class="title mb-1">
                                                    Email liên hệ: <?php echo $row['email_nguoi_khai_ho_so'] ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require('inc/scripts.php'); ?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<script>


    let ten_hoc_sinh = document.getElementById('ten_hoc_sinh').value;
    let ma_hoc_sinh = document.getElementById('ma_hoc_sinh').value;

    let array_name_cc = ['Học bạ tiểu học', 'Giấy khai sinh bản chính', 'Giấy xác nhận ưu tiên', 'Ảnh chân dung(3x4)', 'Ảnh chụp 2 mặt CMND_CCCD', 'Phiếu kê khai thông tin học sinh', 'Đơn đăng ký dự tuyển'];



    let duong_dan_anh_cc_1 = document.getElementById('duong_dan_anh_cc_1').value;
    let duong_dan_anh_cc_2 = document.getElementById('duong_dan_anh_cc_2').value;
    let duong_dan_anh_cc_3 = document.getElementById('duong_dan_anh_cc_3').value;
    let duong_dan_anh_cc_4 = document.getElementById('duong_dan_anh_cc_4').value;
    let duong_dan_anh_cc_5 = document.getElementById('duong_dan_anh_cc_5').value;
    let duong_dan_anh_cc_6 = document.getElementById('duong_dan_anh_cc_6').value;
    // let duong_dan_anh_cc_7 = document.getElementById('duong_dan_anh_cc_7').value;




    let duong_dan_anh_cc_7_element = document.getElementById('duong_dan_anh_cc_7');
    let duong_dan_anh_cc_7;

    // Example file URLs - product
    let fileUrls = [
        duong_dan_anh_cc_1,
        duong_dan_anh_cc_2,
        duong_dan_anh_cc_3,
        duong_dan_anh_cc_4,
        duong_dan_anh_cc_5,
        duong_dan_anh_cc_6,
        duong_dan_anh_cc_7,
        // Add more file URLs as needed
    ];

    if (duong_dan_anh_cc_7_element) {
        // Phần tử tồn tại, truy cập thuộc tính value
        duong_dan_anh_cc_7 = duong_dan_anh_cc_7_element.value;
        fileUrls = [
            duong_dan_anh_cc_1,
            duong_dan_anh_cc_2,
            duong_dan_anh_cc_3,
            duong_dan_anh_cc_4,
            duong_dan_anh_cc_5,
            duong_dan_anh_cc_6,
            duong_dan_anh_cc_7,
            // Add more file URLs as needed
        ];
    } else {
        // Phần tử không tồn tại, xử lý nó theo cách thích hợp


        let valueToRemove = 'Giấy xác nhận ưu tiên';

        array_name_cc = array_name_cc.filter(item => item !== valueToRemove);
        console.log('array_name_cc', array_name_cc);


        let index = 6; // chỉ số của phần tử cần xóa

        if (index > -1) {
            fileUrls.splice(index, 1); // Xóa 1 phần tử tại vị trí index
        }

        console.log(fileUrls); // Kết quả: [1, 2, 4, 5]
    }



    // let array_name_cc = ['Học bạ tiểu học', 'Giấy khai sinh bản chính', 'Giấy xác nhận ưu tiên', 'Ảnh chân dung(3x4)', 'Ảnh chụp 2 mặt CMND_CCCD', 'Phiếu kê khai thông tin học sinh', 'Đơn đăng ký dự tuyển'];
    document.addEventListener("DOMContentLoaded", function() {
        // Function to add files to zip
        async function addFilesToZip(fileUrls, zip) {
            const specialIndex = (fileUrls.length === 6) ? 2 : 3;

            for (let i = 0; i < fileUrls.length; i++) {
                const fileUrl = fileUrls[i];
                console.log(fileUrl); // Kết quả: [1, 2, 4, 5]

                if (fileUrl) {
                    try {
                        const response = await fetch(fileUrl);
                        const blob = await response.blob();
                        const fileType = getFileType(fileUrl);

                        const fileName = (i === specialIndex)
                            ? `${ten_hoc_sinh}_${ma_hoc_sinh}.${fileType}`
                            : `${array_name_cc[i]}.${fileType}`;

                        zip.file(fileName, blob);
                    } catch (error) {
                        console.error(`Failed to fetch or process file from ${fileUrl}:`, error);
                    }
                }
            }
        }

        // Function to get file extension
        function getFileType(url) {
            return url.split(".").pop();
        }

        // Function to initiate download
        function downloadZip(zip) {
            zip.generateAsync({ type: "blob" }).then(function (blob) {
                saveAs(blob, ten_hoc_sinh+'_'+ma_hoc_sinh+'.zip');
            });
        }

        // Example file URLs - product
        // const fileUrls = [
        //     duong_dan_anh_cc_1,
        //     duong_dan_anh_cc_2,
        //     duong_dan_anh_cc_3,
        //     duong_dan_anh_cc_4,
        //     duong_dan_anh_cc_5,
        //     duong_dan_anh_cc_6,
        //     duong_dan_anh_cc_7,
        //     // Add more file URLs as needed
        // ];


        // Example file URLs - dev

        // const fileUrls = [
        //     'https://cdnphoto.dantri.com.vn/HKEco-3Y-i3ztA1qNBq9LG4fIWs=/zoom/774_516/2024/03/04/gia-vang-manh-quan-2-1709511685085.jpg',
        //     'https://cdnphoto.dantri.com.vn/Vi9K9JeQhKJ8NYpdJX_2RU2NeEk=/thumb_w/1020/2024/05/06/1-1714959579652.jpg',
        //     'https://cdnphoto.dantri.com.vn/um_byuInXeEZ4W4ed_MIo4oYG3w=/thumb_w/1020/2024/05/06/4-nguoi-mua-duoc-huong-loi-1-edited-1714974993714.jpeg',
        //     'https://cdnphoto.dantri.com.vn/JJ7NZpmWOF01H_foGSXw5rmWqOM=/thumb_w/1020/2024/04/19/lavrovsputnik-crop-1713525596192.jpeg',
        //     'https://cdnphoto.dantri.com.vn/IKUZrjwOSebWAMGttvl4FhMTVZE=/thumb_w/1020/2024/05/02/latmat7-7-1714626596670.jpg',
        //     'https://cdnphoto.dantri.com.vn/gpQ79jLN-8it6hnMOwCwnahJ3bY=/thumb_w/1020/2024/05/06/gia-tinh-van-3-1714968411371.jpg',
        //     'https://cdnphoto.dantri.com.vn/gpQ79jLN-8it6hnMOwCwnahJ3bY=/thumb_w/1020/2024/05/06/gia-tinh-van-3-1714968411371.jpg'
        //     // Add more file URLs as needed
        // ];

        // Event listener for the download button
        document.getElementById("downloadBtn").addEventListener("click", function() {

            const zip = new JSZip();
            addFilesToZip(fileUrls, zip).then(() => {
                downloadZip(zip);
            });
        });
    });


</script>
</body>
</html>
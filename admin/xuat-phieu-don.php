<?php
require('inc/essentials.php');
include('./inc/db_config.php');
//include('./generate_pdf.php');
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
    <?php require('./inc/links.php'); ?>

    <style>
        body {
            background: rgb(204, 204, 204);
        }

        .print-content * {
            font-family: "Times New Roman";
        }

        .page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
        }

        .content-ticket p {
            font-size: 16px;
        }

        .page[size="A4"] {
            width: 210mm;
            height: 297mm;
        }

        .half-page {
            height: 148.5mm; /* Chia đôi chiều cao của trang A4 */
        }

        .content-box .avatar img {
            width: 150px;
            height: 200px;
            object-fit: contain;
        }

        .avatar {
            width: 150px;
            display: flex;
            align-items: center;
            position: absolute;
            left: 35px;
            top: 140px;
        }

        .body-ticket {
            max-width: 542px;
            margin: 0 auto;
            margin-right: 0;
            padding-right: 30px;
        }

        .info-ticket {
            width: 700px;
            position: relative;
        }

        .ticket-head .title-left {
            text-align: center;
            position: relative;
        }


        .ticket-head .title-right {
            text-align: center;
        }

        .tile-ticket {
            text-align: center;
            line-height: 23px;
            margin-top: 15px;
        }

        p.ten-truong {
            margin-top: 5px;
            font-size: 17px;
            position: relative;
        }

        p.ten-truong:after {
            content: '';
            height: 1px;
            width: 141px;
            background: #000000;
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
        }

        p.uy-ban {
            margin-bottom: 0;
            font-size: 16px;
        }

        p.quoc-hieu {
            margin-bottom: 0;
            font-size: 17px;
        }

        p.tieu-ngu {
            margin-top: 5px;
            font-size: 16px;
            position: relative;
        }

        p.tieu-ngu :after {
            content: '';
            height: 1px;
            width: 190px;
            background: #000000;
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
        }

        .thoi-gian {
            margin: 0;
        }

        .content-box {
            padding: 20px;
            display: flex;
            justify-content: space-between;
        }

        .ticket-head {
            display: flex;
            justify-content: space-between;
        }

        .body-ticket .content-ticket .two-column {
            display: flex;
            justify-content: space-between;
        }

        .address {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .half-page {
            width: 100%;
            display: flex;
            justify-content: center;
            box-sizing: border-box;
            padding: 20px;
            position: relative;
            padding-top: 0;
        }

        .half-page:last-child {
            border-bottom: none;
        }

        .half-page:last-child .avatar {
            top: 155px;
        }

        .tieu-de-chu-ky, .chu-ky-chu-tich {
            text-align: center;
            width: 200px;
            margin-left: auto;
            margin-top: 0px;
        }

        p.chu-ky-chu-tich {
            position: relative;
            top: 78px;
        }

        .title-to {
            margin-bottom: 5px;
        }
        .form-nhap-ma-hs {
            margin-bottom: 30px;
        }
        @media print {
            body, .page {
                background: white;
                margin: 0;
                box-shadow: none;
            }

            .no-print {
                display: none; /* Ẩn các phần tử có class no-print khi in */
            }

            .print-content {
                page-break-after: always; /* Tự động xuống trang mới sau mỗi phần */
            }

            @page {
                size: A4;
                /*margin: 20mm;*/
            }

            body {
                width: 210mm;
                height: 297mm;
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            /* Ẩn các phần tử mặc định của trình duyệt khi in */
            header, footer, .sticky-top, #dashboard-menu, .head-top {
                display: none !important;
            }

            .bg-light {
                background: transparent !important;
            }

            .list-pagination-top {
                display: none !important;
            }
        }
    </style>
</head>
<body class="bg-light">
<?php require('inc/header.php'); ?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <div class="head-top no-print">
                <h3 class="mb-4">Xuất phiếu theo mã học sinh</h3>
            </div>
            <!-- General settings section -->
            <div class="form-nhap-ma-hs no-print">
                <form action="xuat-phieu-don.php" method="get">
                    <div class="input-group" style="width: 350px">
                        <input type="text" class="form-control" placeholder="Nhập mã học sinh" id="ma_hoc_sinh" name="ma_hoc_sinh" required>
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Tìm kiếm</button>
                    </div>
                </form>
            </div>
            <?php
            // Thực hiện truy vấn
            $output = "";

            if (isset($_GET['ma_hoc_sinh'])) {
                $student_id = $_GET['ma_hoc_sinh'];

                // Sử dụng prepared statement để tránh SQL injection
                $sql = $conn->prepare("SELECT * FROM phieu_du_thi WHERE ma_hoc_sinh = ?");
                $sql->bind_param("s", $student_id);

                $sql->execute();
                $result = $sql->get_result();

                // Kiểm tra nếu có kết quả
                if ($result->num_rows > 0) {
                    // Lấy kết quả thành mảng
                    $row = $result->fetch_assoc();
                    $path = IMAGE_AVATAR_NEW_NAME;
                    $output = <<<HTML
                         <div size="A4" class="page print-content">
            <div class="content-box half-page">
                <div class="avatar">
                    <img src="{$path}{$row['ten_anh']}" alt="anh chan dung">
                </div>
                <div class="info-ticket">
                    <div class="ticket-head">
                    <div class="logo"><img style="width: 50px" src="./images/logo_thcs_thanh_xuan.png" alt=""></div>
                        <div class="title-left">
                            <p class="uy-ban">UBND QUẬN THANH XUÂN</p>
                            <p class="ten-truong"><strong>TRƯỜNG THCS THANH XUÂN</strong></p>
                        </div>
                        <div class="title-right">
                            <p class="quoc-hieu"><strong>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</strong></p>
                            <p class="tieu-ngu"><strong>Độc lập - Tự do - Hạnh phúc</strong></p>
                        </div>
                    </div>
                    <div class="tile-ticket">
                        <p><strong>PHIẾU DỰ KIỂM TRA ĐÁNH GIÁ NĂNG LỰC VÀO LỚP 6 <br>TRƯỜNG THCS THANH XUÂN NĂM HỌC 2024-2025</strong></p>
                    </div>
                    <div class="body-ticket">
                        <div class="content-ticket">
                            <div class="row">
                                <div class="two-column">
                                    <div class="column-item">
                                        <p>Họ và tên học sinh: <strong>{$row['hoten_hocsinh']}</strong></p>
                                        <p>Ngày tháng năm sinh: <strong>{$row['ngay_sinh']}</strong></p>
                                        <p>Số báo danh: <strong>{$row['so_bao_danh']}</strong></p>
                                    </div>
                                    <div class="column-item">
                                        <p>Giới tính: <strong>{$row['gioi_tinh']}</strong></p>
                                        <p></p>
                                        <p>Phòng kiểm tra: <strong>{$row['so_phong']}</strong></p>
                                    </div>
                                </div>
                                <div class="one-column">
                                    <p class="thoi-gian">Thời gian có mặt tại phòng kiểm tra: {$row['thoi_gian']}</p>
                                </div>
                                <div class="one-column">
                                    <div class="address">
                                        <p>Địa điểm dự kiểm tra: <strong>{$row['dia_diem']}</strong></p>
                                        <p>(Địa chỉ: {$row['dia_chi']})</p>
                                    </div>
                                </div>
                                <div class="one-column">
                                    <div class="text-right">
                                        <p class="title-to"><strong>HỘI ĐỒNG TUYỂN SINH</strong></p>
                                        <p class="tieu-de-chu-ky"><strong>Chủ tịch</strong></p>
                                        <p class="chu-ky-chu-tich"><strong>Nguyễn Thanh Huyền</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
HTML;
                } else {
                    $output = "<p>Không tìm thấy học sinh với mã này.</p>";
                }

                // Đóng statement và kết nối
                $sql->close();
                $conn->close();
            } else {
                $output = "<p>Vui lòng nhập mã học sinh.</p>";
            }

            echo $output;

            ?>

        </div>
    </div>
</div>
<div class="text-right mb-3">
    <button onclick="printPage()" class="no-print btn btn-outline-secondary" style="margin-right: 20px">In phiếu PDF</button>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


<?php require('inc/scripts.php'); ?>

<script type="text/javascript">

    function printPage() {
        window.print();
    }
</script>
</body>
</html>
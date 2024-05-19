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

        body #pdf-ticket * {
            font-family: "Times New Roman";
        }

        .page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
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
            left: 20px;
            top: 156px;
        }

        .body-ticket {
            max-width: 530px;
            margin: 0 auto;
        }

        .info-ticket {
            width: 650px;
            margin-left: 80px;
            position: relative;
            top: -28px;
        }

        .ticket-head .title-left {
            text-align: center;
            position: relative;
        }

        .ticket-head .title-left:before {
            content: '';
            background: url('./images/logo_thcs_thanh_xuan.png');
            background-repeat: repeat;
            background-size: 100%;
            display: block;
            width: 50px;
            height: 50px;
            position: absolute;
            left: -70px;
            top: 10px;
        }

        .ticket-head .title-right {
            text-align: center;
        }

        .tile-ticket {
            text-align: center;
            line-height: 23px;
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
            height: calc(297mm / 2);
            display: flex;
            justify-content: center;
            align-items: center;
            box-sizing: border-box;
            padding: 20px;
            border-bottom: 1px dashed #cccccc;
            position: relative;
        }

        .half-page:last-child {
            border-bottom: none;
        }

        .tieu-de-chu-ky, .chu-ky-chu-tich {
            text-align: center;
            width: 200px;
            margin-left: auto;
            margin-top: 0px;
        }

        p.chu-ky-chu-tich {
            position: relative;
            top: 60px;
        }

        .title-to {
            margin-bottom: 5px;
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
                margin: 20mm;
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
<?php
// Số bản ghi trên mỗi trang
$records_per_page = 4;

// Số bản ghi trong cơ sở dữ liệu
$sql_total_records = "SELECT COUNT(*) AS total_records FROM phieu_du_thi";

$result_total_records = $conn->query($sql_total_records);
$row_total_records = $result_total_records->fetch_assoc();
$total_records = $row_total_records['total_records'];

// Tính toán số lượng trang
$total_pages = ceil($total_records / $records_per_page);

// Trang hiện tại
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Tính toán vị trí bắt đầu của bản ghi
$start_from = ($current_page - 1) * $records_per_page;

// Câu truy vấn SQL
$sql_data = "SELECT * FROM phieu_du_thi LIMIT $start_from, $records_per_page";

// Thực thi câu truy vấn và lấy dữ liệu
$result_data = $conn->query($sql_data);


?>
<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <div class="head-top">
                <h3 class="mb-4">Xuất phiếu dự thi</h3>
            </div>
            <div class="list-pagination-top">
                <?php

                for ($i = 1; $i <= $total_pages; $i++) {
                    $active_class = ($current_page == $i) ? "active" : "";
                    echo "<a class='item $active_class' href='?page=$i'>$i</a>";
                }
                ?>
            </div>
            <!-- General settings section -->
            <?php
            // Thực hiện truy vấn
            $result = $conn->query("SELECT * FROM phieu_du_thi LIMIT 10");

            $students = [];
            if ($result_data->num_rows > 0) {
                while ($row = $result_data->fetch_assoc()) {
                    $students[] = $row;
                }
            } else {
                echo "0 results";
            }

            ?>

            <div id="pdf-ticket" class="pdf-content">

                <?php
                $path = IMAGE_AVATAR_PATH;
                for ($i = 0; $i < count($students); $i += 2) {
                    $student1 = $students[$i];
                    $student2 = isset($students[$i + 1]) ? $students[$i + 1] : null;

                    $html1 = <<<HTML
               <div size="A4" class="page print-content">
            <div class="content-box half-page">
                <div class="avatar">
                    <img src="{$path}{$student1['ten_anh']}" alt="anh chan dung">
                </div>
                <div class="info-ticket">
                    <div class="ticket-head">
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
                                        <p>Họ và tên học sinh: <strong>{$student1['hoten_hocsinh']}</strong></p>
                                        <p>Ngày tháng năm sinh: <strong>{$student1['ngay_sinh']}</strong></p>
                                        <p>Số báo danh: <strong>{$student1['so_bao_danh']}</strong></p>
                                    </div>
                                    <div class="column-item">
                                        <p>Giới tính: <strong>{$student1['gioi_tinh']}</strong></p>
                                        <p></p>
                                        <p>Phòng kiểm tra: <strong>{$student1['so_phong']}</strong></p>
                                    </div>
                                </div>
                                <div class="one-column">
                                    <p class="thoi-gian">Thời gian có mặt tại phòng kiểm tra: {$student1['thoi_gian']}</p>
                                </div>
                                <div class="one-column">
                                    <div class="address">
                                        <p>Địa điểm dự kiểm tra: <strong>{$student1['dia_diem']}</strong></p>
                                        <p>(Địa chỉ: {$student1['dia_chi']})</p>
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

                    echo $html1;

                    if ($student2) {
                        $html2 = <<<HTML
                <div class="content-box half-page">
                    <div class="avatar">
                        <img src="{$path}{$student2['ten_anh']}" alt="anh chan dung">
                    </div>
                    <div class="info-ticket">
                        <div class="ticket-head">
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
                                        <p>Họ và tên học sinh: <strong>{$student2['hoten_hocsinh']}</strong></p>
                                        <p>Ngày tháng năm sinh: <strong>{$student2['ngay_sinh']}</strong></p>
                                        <p>Số báo danh: <strong>{$student2['so_bao_danh']}</strong></p>
                                    </div>
                                    <div class="column-item">
                                        <p>Giới tính: <strong>{$student2['gioi_tinh']}</strong></p>
                                        <p></p>
                                        <p>Phòng kiểm tra: <strong>{$student2['so_phong']}</strong></p>
                                    </div>
                                </div>
                                <div class="one-column">
                                    <p class="thoi-gian">Thời gian có mặt tại phòng kiểm tra: {$student2['thoi_gian']}</p>
                                </div>
                                <div class="one-column">
                                    <div class="address">
                                        <p>Địa điểm dự kiểm tra: <strong>{$student2['dia_diem']}</strong></p>
                                        <p>(Địa chỉ: {$student2['dia_chi']})</p>
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
                </div>
                HTML;

                        echo $html2;
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="text-right mb-3">
    <button onclick="printPage()" class="no-print btn-primary">In trang này</button>
</div>

</div>
</div>
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
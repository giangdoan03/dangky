<?php
require('./admin/inc/essentials.php');
include('./admin/inc/db_config.php');

// Hàm để lấy URL gốc
function base_url() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'];
    return $protocol . $domainName . '/';
}

$student_info = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $ma_hoc_sinh = isset($_POST['ma_hoc_sinh']) ? $_POST['ma_hoc_sinh'] : '';

    // Chuẩn bị câu lệnh SQL
    $sql = "SELECT * FROM tra_cuu WHERE ma_hoc_sinh = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $ma_hoc_sinh); // Sử dụng "s" cho kiểu chuỗi
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Hiển thị thông tin học sinh
        $student_info .= "<h2>Thông tin học sinh</h2>";
        while ($row = $result->fetch_assoc()) {
            $student_info .= "Tên: " . $row["ho_ten_dem"] . " " . $row["ten"] . "<br>";
            $student_info .= "Ngày sinh: " . $row["ngay_sinh"] . "<br>";
            $student_info .= "Giới tính: " . $row["gioi_tinh"] . "<br>";
            $student_info .= "Dân tộc: " . $row["dan_toc"] . "<br>";
            $student_info .= "Số báo danh: " . $row["so_bao_danh"] . "<br>";
            $student_info .= "Phòng kiểm tra: " . $row["phong_kiem_tra"] . "<br>";
            $student_info .= "Địa điểm kiểm tra: " . $row["dia_diem_kiem_tra"] . "<br>";
            $student_info .= "Địa điểm có mặt: " . $row["thoi_gian_co_mat"] . "<br>";
            $student_info .= "<hr>"; // Thêm một đường kẻ ngang để phân tách các kết quả (nếu có nhiều hơn một kết quả)
        }
    } else {
        $student_info .= "<p>Không tìm thấy học sinh với mã: $ma_hoc_sinh</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

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

<div class="page-register">
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
            <div class="menu">
                <div class="menu-item">
                    <a href="https://thcsthanhxuan.edu.vn/homegd14">Trang chủ</a>
                </div>
                <div class="menu-item">
                    <a href="<?php echo base_url(); ?>tra-cuu-diem.php">Tra cứu thông tin thí sinh</a>
                </div>
            </div>
        </div>
        <div class="wraper" style="text-align: center">
            <h3>Tra cứu thông tin thí sinh, SBD, phòng thi</h3>
            <form action="tra-cuu-diem.php" method="post">
                <div style="display: flex; align-items: center; justify-content: center; margin-top: 30px">
                    <input type="text" style="width: 400px" class="form-control" placeholder="Nhập mã học sinh" id="student_id" name="ma_hoc_sinh" required>
                    <button class="btn btn-outline-secondary" type="submit" style="margin-left: 10px">Tìm kiếm</button>
                </div>
            </form>
        </div>
        <?php
        // Hiển thị thông tin học sinh nếu có
        if (!empty($student_info)) {
            echo '<div class="result" style="text-align: left; margin-top: 30px;">';
            echo $student_info;
            echo '</div>';
        }
        ?>
    </div>
</div>

</body>
</html>

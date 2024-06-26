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

$student_info = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = '6LfNZPQpAAAAAH0fUPwlsBamTXzIdP7nPLb4Wy4I';
    $recaptcha_response = $_POST['recaptcha_response'];

    // Sử dụng cURL để xác minh reCAPTCHA
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $recaptcha_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'secret' => $recaptcha_secret,
        'response' => $recaptcha_response
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    // Kiểm tra lỗi cURL
    if (curl_errno($ch)) {
        $error_msg = 'cURL error: ' . curl_error($ch);
        file_put_contents('recaptcha_debug_log.txt', $error_msg, FILE_APPEND);
        die($error_msg);
    }

    curl_close($ch);

    // Debugging: Hiển thị phản hồi từ Google
    // var_dump($response); die();

    $responseKeys = json_decode($response, true);

    if ($responseKeys["success"] && $responseKeys["score"] >= 0.5) {
        $ma_hoc_sinh = isset($_POST['ma_hoc_sinh']) ? $_POST['ma_hoc_sinh'] : '';
        $sdt_nguoi_dang_ky = isset($_POST['sdt_nguoi_dang_ky']) ? $_POST['sdt_nguoi_dang_ky'] : '';

        // Prepare SQL statement
        $sql = "SELECT * FROM tra_cuu WHERE ma_hoc_sinh = ? AND sdt_nguoi_dang_ky = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $ma_hoc_sinh, $sdt_nguoi_dang_ky);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ob_start(); // Start output buffering
                ?>
                <div class="student-info">
                    <div class="two-column">
                        <div class="column-left">
                            <p>Họ và tên: <strong><?php echo $row["ho_ten_dem"] . " " . $row["ten"]; ?></strong></p>
                            <p>Giới tính: <strong><?php echo $row["gioi_tinh"]; ?></strong></p>
                            <p>Số báo danh: <strong><?php echo $row["so_bao_danh"]; ?></strong></p>
                        </div>
                        <div class="column-right">
                            <p>Ngày sinh: <strong><?php echo $row["ngay_sinh"]; ?></strong></p>
                            <p>Dân tộc: <strong><?php echo $row["dan_toc"]; ?></strong></p>
                            <p>Phòng kiểm tra: <strong><?php echo $row["phong_kiem_tra"]; ?></strong></p>
                        </div>
                    </div>
                    <p class="p_dia_chi">Địa điểm kiểm tra:
                        <strong><?php echo $row["dia_diem_kiem_tra"]; ?></strong></p>
                    <div class="wrap-info-b">
<!--                        <p>Ngày kiểm tra: <strong>04/06/2024</strong></p>-->
<!--                        <p>Sáng kiểm tra môn Tiếng Việt, Tiếng Anh. Chiều kiểm tra môn Toán</p>-->
<!--                        <p>Thời gian có mặt tại địa điểm kiểm tra: <strong>--><?php //echo $row["thoi_gian_co_mat"]; ?><!--</strong>-->
<!--                        </p>-->
<!--                        <p><strong class="luu_y">Lưu ý: Thí sinh nhận phiếu dự kiểm tra tại phòng kiểm tra của-->
<!--                                mình.</strong></p>-->
<!--                        <div class="so_do">-->
<!--                            <p>-->
<!--                                <strong> Sơ đồ phòng kiểm tra </strong><a href="/so_do_phong_thi.pdf" download>Tải-->
<!--                                    về</a>-->
<!--                            </p>-->
<!--                        </div>-->
                    </div>
<!--                    <h2>Điểm kiểm tra</h2>-->
                    <table style="width: 100%">
                        <tr>
                            <th>Tiếng Việt</th>
                            <th>Tiếng Anh</th>
                            <th>Toán</th>
                            <th>Điểm ưu tiên</th>
                            <th>Điểm xét tuyển</th>
                            <th>Tổng điểm</th>
                        </tr>
                        <tr>
                            <td><?php echo !empty($row["diem_tieng_viet"]) ? $row["diem_tieng_viet"] : 'N/A'; ?></td>
                            <td><?php echo !empty($row["diem_tieng_anh"]) ? $row["diem_tieng_anh"] : 'N/A'; ?></td>
                            <td><?php echo !empty($row["diem_toan"]) ? $row["diem_toan"] : 'N/A'; ?></td>
                            <td><?php echo !empty($row["diem_uu_tien"]) ? $row["diem_uu_tien"] : 'N/A'; ?></td>
                            <td><?php echo !empty($row["diem_so_tuyen"]) ? $row["diem_so_tuyen"] : 'N/A'; ?></td>
                            <td><?php echo !empty($row["tong_diem_xet_tuyen"]) ? $row["tong_diem_xet_tuyen"] : 'N/A'; ?></td>
                        </tr>
                    </table>
                    <div class="mau_don_pk" style="text-align: right; margin-top: 10px">
                        Mẫu đơn phúc khảo: <a href="/maudonphuc_khao.doc" download>Tải file mẫu</a><span
                    </div>
                    <?php if ($row["diem_pk_tieng_viet"] && $row["diem_pk_tieng_anh"] && $row["diem_pk_toan"]) { ?>
                        <h2 class="phuc_khao">Điểm sau khi phúc khảo:</h2>
                        <table style="width: 100%" class="table_phuc_khao">
                            <tr>
                                <th>Tiếng Việt</th>
                                <th>Tiếng Anh</th>
                                <th>Toán</th>
                                <th>Điểm ưu tiên</th>
                                <th>Điểm xét tuyển</th>
                                <th>Tổng điểm</th>
                            </tr>
                            <tr>
                                <td><?php echo !empty($row["diem_pk_tieng_viet"]) ? $row["diem_pk_tieng_viet"] : 'N/A'; ?></td>
                                <td><?php echo !empty($row["diem_pk_tieng_anh"]) ? $row["diem_pk_tieng_anh"] : 'N/A'; ?></td>
                                <td><?php echo !empty($row["diem_pk_toan"]) ? $row["diem_pk_toan"] : 'N/A'; ?></td>
                                <td><?php echo !empty($row["diem_uu_tien"]) ? $row["diem_uu_tien"] : 'N/A'; ?></td>
                                <td><?php echo !empty($row["diem_so_tuyen"]) ? $row["diem_so_tuyen"] : 'N/A'; ?></td>
                                <td><?php echo !empty($row["tong_diem_xt_sau_pk"]) ? $row["tong_diem_xt_sau_pk"] : 'N/A'; ?></td>
                            </tr>
                        </table>
                    <?php } ?>
                </div>
                <?php
                $student_info .= ob_get_clean(); // Store buffered output into $student_info
            }
        } else {
            $student_info .= "<p>Không tìm thấy học sinh với mã: <strong>$ma_hoc_sinh</strong></p>";
        }

        $stmt->close();
        $conn->close();
    } else {
        $mess_error_captcha = 'reCAPTCHA verification failed!';
//        echo "reCAPTCHA verification failed!";
    }
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
                    <h3>TRA CỨU KẾT QUẢ</h3>
                    <form id="lookup-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="form_tra_cuu" style="display: flex; align-items: center; justify-content: center; margin-top: 30px">
                            <input type="text" style="width: 220px; margin-right: 10px" class="form-control" placeholder="Nhập mã học sinh" id="student_id" name="ma_hoc_sinh" required>
                            <input type="text" style="width: 220px" class="form-control" placeholder="SĐT người đăng ký hồ sơ" id="sdt_nguoi_dang_ky" name="sdt_nguoi_dang_ky" required>
                            <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                            <button class="btn btn-outline-secondary" type="submit" style="margin-left: 10px">Tìm kiếm</button>
                        </div>
                        <div class="bl_error">
                            <?php echo isset($mess_error_captcha) ? $mess_error_captcha : ''; ?>
                        </div>
                    </form>
                </div>
                <?php
                // Display student information if available
                if (!empty($student_info)) {
                    echo '<div class="result">';
                    echo $student_info;
                    echo '</div>';
                }
                ?>
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

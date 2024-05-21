<?php

// Require the Composer autoloader
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


use Google\Client;
use Google\Service\Sheets;


include('./admin/inc/db_config.php');
include('./admin/inc/essentials.php');

$provinceId = isset($_POST['province_id']) ? $_POST['province_id'] : 0;
$districtId = isset($_POST['district_id']) ? $_POST['district_id'] : 0;
$command = isset($_POST['get']) ? $_POST['get'] : "";
$ten_lop = isset($_POST['ten_lop']) ? $_POST['ten_lop'] : "";
$ma_lop = isset($_POST['ma_lop']) ? $_POST['ma_lop'] : "";
$ma_hs_vld = isset($_POST['ma_hs_vld']) ? $_POST['ma_hs_vld'] : "";

$hoten_hocsinh = isset($_POST['hoten_hocsinh']) ? mysqli_real_escape_string($conn, $_POST['hoten_hocsinh']) : '';
$ngaysinh = isset($_POST['ngaysinh']) ? mysqli_real_escape_string($conn, $_POST['ngaysinh']) : '';
$ma_hocsinh = isset($_POST['ma_hocsinh']) ? mysqli_real_escape_string($conn, $_POST['ma_hocsinh']) : '';
$noisinh = isset($_POST['noisinh']) ? mysqli_real_escape_string($conn, $_POST['noisinh']) : '';
$gioitinh = isset($_POST['gioitinh']) ? mysqli_real_escape_string($conn, $_POST['gioitinh']) : '';
$dantoc = isset($_POST['dantoc']) ? mysqli_real_escape_string($conn, $_POST['dantoc']) : '';
$tenlop = isset($_POST['tenlop']) ? mysqli_real_escape_string($conn, $_POST['tenlop']) : '';
$ten_truong = isset($_POST['ten_truong']) ? mysqli_real_escape_string($conn, $_POST['ten_truong']) : '';
$dien_uu_tien = isset($_POST['dien_uu_tien']) ? mysqli_real_escape_string($conn, $_POST['dien_uu_tien']) : '';
$diem_uu_tien = isset($_POST['diem_uu_tien']) ? mysqli_real_escape_string($conn, $_POST['diem_uu_tien']) : '';
$tong_diem_xet_tuyen = isset($_POST['tong_diem_xet_tuyen']) ? mysqli_real_escape_string($conn, $_POST['tong_diem_xet_tuyen']) : '';

$ho_ten_cha =  isset($_POST['hoten_cha']) ? mysqli_real_escape_string($conn, $_POST['hoten_cha']) : '';
$sdt_cha = isset($_POST['sdt_cha']) ? mysqli_real_escape_string($conn, $_POST['sdt_cha']) : '';
$ho_ten_me = isset($_POST['hoten_me']) ? mysqli_real_escape_string($conn, $_POST['hoten_me']) : '';
$sdt_me = isset($_POST['sdt_me']) ? mysqli_real_escape_string($conn, $_POST['sdt_me']) : '';
$hoten_nguoi_giamho = isset($_POST['hoten_nguoi_giam_ho'] ) ? mysqli_real_escape_string($conn, $_POST['hoten_nguoi_giam_ho']) : '';
$sdt_nguoigiamho = isset($_POST['sdt_nguoigiamho']) ? mysqli_real_escape_string($conn, $_POST['sdt_nguoigiamho']) : '';
$id_tinh = isset($_POST['province']) ? mysqli_real_escape_string($conn, $_POST['province']) : '';
$id_huyen =  isset($_POST['district']) ? mysqli_real_escape_string($conn, $_POST['district']) : '';
$nguoi_khai_ho_so = isset($_POST['nguoi_khai_ho_so']) ? mysqli_real_escape_string($conn, $_POST['nguoi_khai_ho_so']) : '';
$sdt_nguoi_khai_ho_so = isset($_POST['sdt_nguoi_khai_ho_so']) ? mysqli_real_escape_string($conn, $_POST['sdt_nguoi_khai_ho_so']) : '';
$email_nguoi_khai_ho_so = isset($_POST['email_nguoi_khai_ho_so']) ? mysqli_real_escape_string($conn, $_POST['email_nguoi_khai_ho_so']) : '';
$address = isset($_POST['address']) ? mysqli_real_escape_string($conn, $_POST['address']) : '';

$anh_hb_tieu_hoc =  isset($_FILES['anh_hb_tieu_hoc']) ? mysqli_real_escape_string($conn, $_FILES['anh_hb_tieu_hoc']['size']) : '';
$anh_giay_khai_sinh = isset($_FILES['anh_giay_khai_sinh']) ? mysqli_real_escape_string($conn, $_FILES['anh_giay_khai_sinh']['size']) : '';
$anh_giay_xac_nhan_uu_tien = isset($_FILES['anh_giay_xac_nhan_uu_tien']) ? $_FILES['anh_giay_xac_nhan_uu_tien']['size'] : '';
$anh_chan_dung =  isset($_FILES['anh_chan_dung']) ? mysqli_real_escape_string($conn, $_FILES['anh_chan_dung']['size']) : '';
$anh_cccd = isset($_FILES['anh_cccd']) ? mysqli_real_escape_string($conn, $_FILES['anh_cccd']['size']) : '';
$anh_ban_ck_cu_tru = isset($_FILES['anh_ban_ck_cu_tru']) ? mysqli_real_escape_string($conn, $_FILES['anh_ban_ck_cu_tru']['size']) : '';
$don_dk_du_tuyen = isset($_FILES['don_dk_du_tuyen']) ? mysqli_real_escape_string($conn, $_FILES['don_dk_du_tuyen']['size']) : '';

switch ($command) {
    case "province":
        $statement = "SELECT province_id,name FROM province";
        $dt = mysqli_query($conn, $statement);
        while ($result = mysqli_fetch_array($dt)) {
            echo $result = "<option value=" . $result['province_id'] . ">" . $result['name'] . "</option>";
        }
        break;

    case "district":
        $result1 = "";
        $statement = "SELECT district_id,name_district FROM district WHERE province_id=" . $provinceId;
        $dt = mysqli_query($conn, $statement);

        while ($result = mysqli_fetch_array($dt)) {
            $result1 .= "<option value=" . $result['district_id'] . ">" . $result['name_district'] . "</option>";
        }
        echo $result1;
        break;

    case "ma_hs_vld":

        $query = "SELECT * FROM hoc_sinh WHERE ma_hocsinh='" . $ma_hs_vld . "'";
        $result = mysqli_query($conn, $query);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            $res = [
                'status' => 300,
                'message' => 'Mã học sinh đã tồn tại'
            ];
            echo json_encode($res);
            return;
        } else {
            $res = [
                'status' => 200,
                'message' => 'ok'
            ];
            echo json_encode($res);
        }
        break;

}

//if ($ma_hs_vld == 'ma_hs_vld') {
//
//}
if (isset($_POST['save_student'])) {

    if ($hoten_hocsinh == NULL || $ngaysinh == NULL || $ma_hocsinh == NULL || $noisinh == NULL || $gioitinh == NULL || $dantoc == NULL || $tenlop == NULL || $ten_truong == NULL || $dien_uu_tien == NULL || $diem_uu_tien == NULL || $tong_diem_xet_tuyen == NULL ||
        $ho_ten_cha == NULL || $sdt_cha == NULL || $ho_ten_me == NULL || $sdt_me == NULL || $id_tinh == NULL || $id_huyen == NULL || $address == NULL || $anh_hb_tieu_hoc == 0 || $anh_giay_khai_sinh == 0 || $anh_chan_dung == 0 || $anh_cccd == 0 || $anh_ban_ck_cu_tru == 0 || $don_dk_du_tuyen == 0)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }
    header('Content-Type: text/html; charset=utf-8');

    $hoten_hocsinh = mb_strtoupper($hoten_hocsinh, 'UTF-8');
    $ho_ten_cha = mb_strtoupper($ho_ten_cha, 'UTF-8');
    $ho_ten_me = mb_strtoupper($ho_ten_me, 'UTF-8');
    $nguoi_khai_ho_so = mb_strtoupper($nguoi_khai_ho_so, 'UTF-8');
    $hoten_nguoi_giamho = mb_strtoupper($hoten_nguoi_giamho, 'UTF-8');

    $gt = ($gioitinh && $gioitinh === 'nu') ? 'Nữ' : 'Nam';

    // Format date of birth
//    $timestamp = strtotime($ngaysinh);

    $ngaysinh = $ngaysinh->format('d/m/Y');

    date_default_timezone_set('Asia/Ho_Chi_Minh'); // Thiết lập múi giờ cho Việt Nam
    $thoi_gian = new DateTime();
    $thoi_gian = $thoi_gian->format("d/m/Y H:i:s");

    // Bắt đầu một giao dịch
    $conn->begin_transaction();

    try {

        // Thực hiện chèn dữ liệu vào bảng học sinh

        $query_hocsinh = "INSERT INTO hoc_sinh (hoten_hocsinh,ngaysinh,ma_hocsinh,noisinh,gioitinh,dantoc,tenlop,ten_truong,dien_uu_tien,diem_uu_tien,tong_diem_xet_tuyen,id_lop,thoi_gian) 
    VALUES ('$hoten_hocsinh','$ngaysinh','$ma_hocsinh','$noisinh','$gioitinh','$dantoc','$tenlop','$ten_truong','$dien_uu_tien','$diem_uu_tien','$tong_diem_xet_tuyen','1','$thoi_gian')";
        $query_run_hs = mysqli_query($conn, $query_hocsinh);

        if($query_run_hs != '1') {
            $res = [
                'status' => 300,
                'message' => 'Đã có lỗi trong quá trình gửi Form, Vui lòng thử lại'
            ];
            echo json_encode($res);
            return;
        }

        $id_hoc_sinh = $conn->insert_id;
        // Thực hiện chèn dữ liệu vào bảng phụ huynh

        $query_ph = "INSERT INTO phu_huynh (ho_ten_cha,sdt_cha,ho_ten_me,sdt_me,hoten_nguoi_giamho,sdt_nguoigiamho,id_tinh,id_huyen,nguoi_khai_ho_so,email_nguoi_khai_ho_so,sdt_nguoi_khai_ho_so,address,id_hocsinh) VALUES ('$ho_ten_cha','$sdt_cha','$ho_ten_me','$sdt_me','$hoten_nguoi_giamho','$sdt_nguoigiamho','$id_tinh','$id_huyen','$nguoi_khai_ho_so','$email_nguoi_khai_ho_so','$sdt_nguoi_khai_ho_so','$address','$id_hoc_sinh')";
        $query_run = mysqli_query($conn, $query_ph);
        if($query_run != '1') {
            $res = [
                'status' => 300,
                'message' => 'Đã có lỗi trong quá trình gửi Form, Vui lòng thử lại'
            ];
            echo json_encode($res);
            return;
        }
        $subjects = array("tiengviet", "toan", "ngoaingu");
        $subjects_mh = array("tiengviet", "toan", "ngoaingu", "diemquydoi");
        $classes = array("Lớp 1", "Lớp 2", "Lớp 3", "Lớp 4", "Lớp 5");

        // Thực hiện chèn dữ liệu vào bảng điểm

        $result = [];
        foreach ($subjects_mh as $k => $subject) {
            $ten_nhom = 'mon_hoc';
            $id_monhoc = $k + 1;
            foreach ($classes as $k1 => $class) {
                $k2 = $k1 + 1;
                if (isset($_POST["$subject-$k2"])) {
                    $score = $_POST["$subject-$k2"];
                    $result[] = $score;
                } else {
                    $score = '';
                    $result[] = '';
                }

                $sql_diem = "INSERT INTO diem (id_hocsinh,id_monhoc,diem_so,ten_lop,id_lop,ten_nhom,ten_mon_hoc) VALUES ('$id_hoc_sinh', '$id_monhoc', '$score', '$class', '$k2', '$ten_nhom','$subject')";
                $query_diem = mysqli_query($conn, $sql_diem);
                if($query_diem != '1') {
                    $res = [
                        'status' => 300,
                        'message' => 'Đã có lỗi trong quá trình gửi Form, Vui lòng thử lại'
                    ];
                    echo json_encode($res);
                    return;
                }
            }
        }

//        $nang_luc = array("tuquan", "hoptac", "tuhoc");
//
//        foreach ($nang_luc as $key_nl => $vl_nl) {
//            $ten_nhom_2 = 'nang_luc';
//            $id_nangluc = $key_nl + 1;
//            foreach ($classes as $k_l => $vl_class) {
//                $k_l_2 = $k_l + 1;
//                $score = $_POST["$vl_nl-$k_l_2"];
//                $sql_2 = "INSERT INTO diem (id_hocsinh,id_monhoc,diem_so,ten_lop,id_lop,ten_nhom,ten_mon_hoc) VALUES ('$id_hocsinh', '$id_nangluc', '$score', '$vl_class', '$k_l_2','$ten_nhom_2','$vl_nl')";
//                if ($conn->query($sql_2) !== TRUE) {
//                    echo "Error: " . $sql_2 . "<br>" . $conn->error;
//                }
//            }
//        }

//
//        $pham_chat = array("chamhoc", "tutin", "kiluat", "doanket");
//
//        foreach ($pham_chat as $key_pc => $vl_pc) {
//            $ten_nhom_3 = 'pham_chat';
//            $id_phamchat = $key_pc + 1;
//            foreach ($classes as $kl_pc => $vll_pc) {
//                $klpc = $kl_pc + 1;
//                $score = $_POST["$vl_pc-$klpc"];
//                $sql_3 = "INSERT INTO diem (id_hocsinh,id_monhoc,diem_so,ten_lop,id_lop,ten_nhom,ten_mon_hoc) VALUES ('$id_hocsinh', '$id_phamchat', '$score', '$vll_pc', '$klpc', '$ten_nhom_3','$vl_pc')";
//                if ($conn->query($sql_3) !== TRUE) {
//                    echo "Error: " . $sql_3 . "<br>" . $conn->error;
//                }
//            }
//        }

        $anh_chung_chi = array("Học bạ tiểu học", "Giấy khai sinh bản chính", "Giấy xác nhận ưu tiên", "Ảnh chân dung(3x4)", "Ảnh chụp 2 mặt CMND/CCCD", "Phiếu kê khai thông tin học sinh", "Đơn đăng ký dự tuyển");
        $k = 0;
        foreach ($anh_chung_chi as $key_cc => $vl_cc) {
            $idxPicture = 'picture_' . ($key_cc + 1);

            // Kiểm tra xem tệp đã được tải lên chưa
            if (!isset($_FILES[$idxPicture]) || $_FILES[$idxPicture]['error'] === UPLOAD_ERR_NO_FILE) {
                // Nếu không có tệp hoặc không có lỗi, bỏ qua và tiếp tục vòng lặp
                continue;
            }

            $img_r = uploadImage($_FILES[$idxPicture], ABOUT_FOLDER);

            // Xác định loại tệp
            $ext = pathinfo($_FILES[$idxPicture]['name'], PATHINFO_EXTENSION);
            $type = '';

            switch ($ext) {
                case 'pdf':
                case 'docx':
                    $type = $ext;
                    break;
                case 'jpg':
                case 'jpeg':
                case 'png':
                    $type = 'img';
                    break;
                case 'webp':
                    $type = 'webp';
                    break;
                default:
                    // Xử lý mở rộng không hợp lệ nếu cần
                    break;
            }

            if ($img_r === 'inv_img' || $img_r === 'inv_size' || $img_r === 'upd_failed') {
                // Xử lý lỗi khi tải lên tệp
                echo $img_r;
            } else {
                // Thực hiện thêm vào cơ sở dữ liệu nếu không có lỗi khi tải lên tệp
                $sql_4 = "INSERT INTO anh_chung_chi (ten_file,id_hocsinh,url_file,type_file) VALUES ('$vl_cc','$id_hoc_sinh','$img_r','$type')";
                $query_chung_chi = mysqli_query($conn, $sql_4);
                if ($query_chung_chi == '1') {
                    $k++;
                } else {
                    echo "Error: " . $sql_4 . "<br>" . $conn->error;
                }
            }
        }


        if ($k == '6' || $k == '7') {
            // gửi email cảm ơn
            sendMail($email_nguoi_khai_ho_so, $hoten_hocsinh, $ma_hocsinh, $ngaysinh);
            // data send google sheet

            date_default_timezone_set('Asia/Ho_Chi_Minh'); // Thiết lập múi giờ cho Việt Nam

            $current_time_vn = new DateTime();
            $current_time_vn = $current_time_vn->format("d/m/Y H:i:s");
            $values = [
                // Mỗi item trong mảng $values là 1 cột
                [
                    $current_time_vn, $ma_hocsinh, $hoten_hocsinh, $ngaysinh, $noisinh, $gt, $dantoc, $ten_truong, $tenlop, $dien_uu_tien,
                    $diem_uu_tien, $tong_diem_xet_tuyen, $ho_ten_cha, $sdt_cha, $ho_ten_me, $sdt_me, $hoten_nguoi_giamho, $sdt_nguoigiamho, $address,
                    $nguoi_khai_ho_so, $sdt_nguoi_khai_ho_so, $email_nguoi_khai_ho_so,
                    $result[0], $result[1], $result[2], $result[3], $result[4], $result[5], $result[6],
                    $result[7], $result[8], $result[9], $result[10], $result[11], $result[12], $result[13],
                    $result[14], $result[15], $result[16], $result[17], $result[18], $result[19]
                ]
            ];
//            sendDataGoogleSheet($values);
        } else {
            $res = [
                'status' => 300,
                'message' => 'Đã có lỗi trong quá trình gửi Form, Vui lòng thử lại'
            ];
            echo json_encode($res);
            return;
        }


        // Nếu mọi thứ thành công, commit giao dịch
        $conn->commit();

        $res = [
            'status' => 200,
            'message' => 'Student Created Successfully'
        ];
        echo json_encode($res);

    } catch (Exception $e) {
        // Nếu có lỗi xảy ra, rollback giao dịch
        $conn->rollback();
        echo "Có lỗi xảy ra: " . $e->getMessage();
        $res = [
            'status' => 402,
            'message' => 'Student Not Created'
        ];
    }

    // Đóng kết nối
    $conn->close();
}


function sendMail($email_nguoi_khai_ho_so, $hoten_hocsinh, $ma_hocsinh, $ngaysinh)
{
    try {
        // SMTP configuration

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'tuyensinhthcsthanhxuan@gmail.com'; // Your email address
        $mail->Password = 'tvyxpaiflfqiljeh'; // Your email password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->CharSet = 'UTF-8'; // Đặt mã hóa UTF-8
        $mail->Encoding = 'base64'; // Hoặc đặt kiểu ký tự base64

        // Sender and recipient
        $mail->setFrom('doangiang665@gmail.com', 'Tuyển sinh THCS Thanh Xuân');
        $mail->addAddress($email_nguoi_khai_ho_so, 'Recipient Name');

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Tuyển sinh THCS Thanh Xuân - Đăng kí hồ sơ tuyển sinh thành công';


        // Đọc nội dung của tập tin mẫu email HTML
        $templateFile = __DIR__ . '/email.html';
        $htmlContent = file_get_contents($templateFile);

        $htmlContent = str_replace('{{ hoten_hocsinh }}', $hoten_hocsinh, $htmlContent);
        $htmlContent = str_replace('{{ ma_hocsinh }}', $ma_hocsinh, $htmlContent);
        $htmlContent = str_replace('{{ ngaysinh }}', $ngaysinh, $htmlContent);

        // Sử dụng nội dung của tập tin mẫu email HTML
//                echo $htmlContent;

        // Thêm nội dung của tập tin mẫu vào trong phần body của email
        $mail->Body = $htmlContent;

        // Đặt định dạng email là HTML
        $mail->isHTML(true);

        // Send email
        $mail->send();

        // Return success response
//        $res['mail_success'] = [
//            'status' => 200,
//            'message' => 'ok'
//        ];
//        echo json_encode($res);
    } catch (Exception $e) {
        // Return error response
        $response = array('success' => false, 'error' => $mail->ErrorInfo);
        echo json_encode($response);
    }
}


function sendDataGoogleSheet($values)
{
    try {
        $serviceAccountFilePath = __DIR__ . '/service-account-file-2.json';

        // Google Sheet ID and range
        $spreadsheetId = '1AfC8qZayrTB1wBrS5eybXBVBxOkWUBkBHJr7QSm6L_Y';
        $range = 'Tuyensinh';

        // Create Google Client and authenticate using service account
        $client = new Google_Client();
        $client->setAuthConfig($serviceAccountFilePath);
        $client->addScope(Google_Service_Sheets::SPREADSHEETS);
        $service = new Google_Service_Sheets($client);
        // Append data to the sheet

        $body = new Google_Service_Sheets_ValueRange([
            'values' => $values
        ]);
        $params = [
            'valueInputOption' => 'RAW'
        ];
        $result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);



        // Print the response
        error_log(json_encode($result));
    } catch (Exception $e) {
    }
}


if (isset($_POST['update_student'])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);

    if ($name == NULL || $email == NULL || $phone == NULL || $course == NULL) {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    $query = "UPDATE students SET name='$name', email='$email', phone='$phone', course='$course' WHERE id='$student_id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'Student Updated Successfully'
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Student Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}


if (isset($_GET['student_id'])) {
    $student_id = mysqli_real_escape_string($conn, $_GET['student_id']);

    $query = "SELECT * FROM students WHERE id='$student_id'";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) == 1) {
        $student = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'Student Fetch Successfully by id',
            'data' => $student
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 404,
            'message' => 'Student Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}


if (isset($_POST['delete_student'])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);

    $query = "DELETE FROM students WHERE id='$student_id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'Student Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Student Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}

exit();
?>
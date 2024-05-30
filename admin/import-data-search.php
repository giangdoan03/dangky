<?php
require('./inc/essentials.php');
include('./inc/db_config.php');
require '../vendor/autoload.php'; // Đảm bảo autoload của Composer đã được nạp

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if (isset($_POST['importSubmit'])) {
    // Kiểm tra xem đã chọn file và file có phải là file Excel không
    if (!empty($_FILES['file']['name']) && isExcelFile($_FILES['file']['tmp_name'])) {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        $worksheet = $spreadsheet->getActiveSheet();
        $worksheet_arr = $worksheet->toArray();
//        echo '<pre>';
//        var_dump($worksheet_arr);

        // Xóa hàng tiêu đề
        unset($worksheet_arr[0]);


        // Lặp qua từng hàng và thêm hoặc cập nhật dữ liệu trong cơ sở dữ liệu
        foreach ($worksheet_arr as $row) {
            // Sử dụng prepared statement để tránh SQL Injection
            $stmt = $conn->prepare("SELECT id FROM tra_cuu WHERE ma_hoc_sinh = ?");
            $stmt->bind_param("s", $row[1]);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Lấy id của bản ghi tương ứng với ma_hoc_sinh
                $data = $result->fetch_assoc();
                $id = $data['id'];

                // Chuẩn bị câu lệnh UPDATE
                $stmt = $conn->prepare("UPDATE tra_cuu SET ma_hoc_sinh = ?, ho_ten_dem = ?, ten = ?, ngay_sinh = ?, gioi_tinh = ?, dan_toc = ?, so_bao_danh = ?, phong_kiem_tra = ?, dia_diem_kiem_tra = ?, thoi_gian_co_mat = ?, diem_tieng_viet = ?, diem_tieng_anh = ?, diem_toan = ?, diem_uu_tien = ?, diem_so_tuyen = ?, tong_diem_xet_tuyen = ? WHERE id = ?");

                // Bind các tham số
                $stmt->bind_param("ssssssssssssssssi", $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12], $row[13], $row[14], $row[15], $id);
            } else {
                // Chuẩn bị câu lệnh INSERT
                $stmt = $conn->prepare("INSERT INTO tra_cuu (ma_hoc_sinh, ho_ten_dem, ten, ngay_sinh, gioi_tinh, dan_toc, so_bao_danh, phong_kiem_tra, dia_diem_kiem_tra, thoi_gian_co_mat, diem_tieng_viet, diem_tieng_anh, diem_toan, diem_uu_tien, diem_so_tuyen, tong_diem_xet_tuyen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                // Bind các tham số
                $stmt->bind_param("ssssssssssssssss", $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12], $row[13], $row[14], $row[15]);
            }

            // Thực thi câu lệnh SQL
            $stmt->execute();

            // Kiểm tra xem câu lệnh SQL có lỗi không
            if ($stmt->errno) {
                echo "Lỗi SQL: " . $stmt->error;
            }
        }


        // Đóng kết nối cơ sở dữ liệu
        $conn->close();

        $qstring = '?status=succ';
    } else {
        $qstring = '?status=invalid_file';
    }
}

// Hàm kiểm tra file có phải là file Excel hay không
function isExcelFile($filename) {
    $mime_types = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $filename);
    finfo_close($finfo);
    return in_array($mime_type, $mime_types);
}
// Redirect to the listing page
header("Location: nhap-du-lieu-tra-cuu.php".$qstring);
?>


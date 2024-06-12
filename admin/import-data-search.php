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

        // Xóa hàng tiêu đề
        unset($worksheet_arr[0]);

        // Biến để kiểm tra xem có hàng nào được chèn thành công hay không
        $success = false;

        // Lặp qua từng hàng và thêm hoặc cập nhật dữ liệu trong cơ sở dữ liệu
        foreach ($worksheet_arr as $row) {
//            echo '<pre/>';
//            var_dump($row);
            // Kiểm tra xem ma_hoc_sinh có hợp lệ không
            if (empty($row[1])) {
//                echo "Lỗi: ma_hoc_sinh không được bỏ trống trong hàng: " . json_encode($row);
                continue; // Bỏ qua hàng này nếu ma_hoc_sinh bị thiếu
            }

            // Sử dụng prepared statement để tránh SQL Injection
            $stmt = $conn->prepare("SELECT id FROM tra_cuu WHERE ma_hoc_sinh = ?");
            if ($stmt === false) {
                die("Lỗi khi chuẩn bị câu lệnh SELECT: " . $conn->error);
            }

            $stmt->bind_param("s", $row[0]);
            $stmt->execute();
            $result = $stmt->get_result();

//            echo $result->num_rows;die();

            if ($result->num_rows > 0) {
                // Lấy id của bản ghi tương ứng với ma_hoc_sinh
                $data = $result->fetch_assoc();
                $id = $data['id'];

                // Đóng câu lệnh SELECT trước khi tạo câu lệnh UPDATE mới
                $stmt->close();

                // Chuẩn bị câu lệnh UPDATE
                $stmt = $conn->prepare("UPDATE tra_cuu SET ma_hoc_sinh = ?, ho_ten_dem = ?, ten = ?, ngay_sinh = ?, gioi_tinh = ?, dan_toc = ?, so_bao_danh = ?, sdt_nguoi_dang_ky = ?, phong_kiem_tra = ?, dia_diem_kiem_tra = ?, thoi_gian_co_mat = ?, diem_tieng_viet = ?, diem_tieng_anh = ?, diem_toan = ?, diem_uu_tien = ?, diem_so_tuyen = ?, tong_diem_xet_tuyen = ?, diem_pk_tieng_viet = ?, diem_pk_tieng_anh = ?, diem_pk_toan = ?, tong_diem_xt_sau_pk = ? WHERE id = ?");
                if ($stmt === false) {
                    die("Lỗi khi chuẩn bị câu lệnh UPDATE: " . $conn->error);
                }

                // Bind các tham số
                $stmt->bind_param("sssssssssssssssssssssi", $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12], $row[13], $row[14], $row[15], $row[16], $row[17], $row[18], $row[19], $row[20], $id);
            } else {
                // Đóng câu lệnh SELECT trước khi tạo câu lệnh INSERT mới
                $stmt->close();

                // Chuẩn bị câu lệnh INSERT
                $stmt = $conn->prepare("INSERT INTO tra_cuu (ma_hoc_sinh, ho_ten_dem, ten, ngay_sinh, gioi_tinh, dan_toc, so_bao_danh, sdt_nguoi_dang_ky, phong_kiem_tra, dia_diem_kiem_tra, thoi_gian_co_mat, diem_tieng_viet, diem_tieng_anh, diem_toan, diem_uu_tien, diem_so_tuyen, tong_diem_xet_tuyen, diem_pk_tieng_viet, diem_pk_tieng_anh, diem_pk_toan, tong_diem_xt_sau_pk) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                if ($stmt === false) {
                    die("Lỗi khi chuẩn bị câu lệnh INSERT: " . $conn->error);
                }

                // Bind các tham số
                $stmt->bind_param("sssssssssssssssssssss", $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12], $row[13], $row[14], $row[15], $row[16], $row[17], $row[18], $row[19], $row[20]);

            }

            // Thực thi câu lệnh SQL
            $stmtSuccess = $stmt->execute();

            // Nếu không có lỗi, gán giá trị true cho biến $success
            if ($stmtSuccess) {
                $success = true;
            }

            // Đóng câu lệnh chuẩn bị
            $stmt->close();
        }

        // Kiểm tra xem có dữ liệu được chèn thành công hay không
        if ($success) {
            echo "Dữ liệu đã được chèn thành công vào cơ sở dữ liệu.";
        } else {
            echo "Không có dữ liệu nào được chèn vào cơ sở dữ liệu.";
        }

        // Đóng kết nối cơ sở dữ liệu
        $conn->close();

        $qstring = '?status=succ';
    } else {
        $qstring = '?status=invalid_file';
    }
}

// Hàm kiểm tra file có phải là file Excel hay không
function isExcelFile($filename)
{
    $mime_types = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $filename);
    finfo_close($finfo);
    return in_array($mime_type, $mime_types);
}

// Redirect to the listing page
header("Location: nhap-du-lieu-tra-cuu.php" . $qstring);
?>


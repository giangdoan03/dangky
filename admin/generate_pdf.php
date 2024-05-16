<?php
require('inc/essentials.php');
include('./inc/db_config.php');

adminLogin();

require_once '../vendor/autoload.php'; // Đường dẫn đến thư viện Dompdf

use Dompdf\Dompdf;

// Tạo một đối tượng Dompdf
$dompdf = new Dompdf();

// Chuẩn bị nội dung HTML để chèn vào tệp PDF
$html_content = '<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif; /* Chọn font hỗ trợ tiếng Việt */
        }
    </style>
</head>
<body>';

// Số bản ghi trên mỗi trang
$records_per_page = 96;

// Trang hiện tại, mặc định là 1 nếu không có tham số 'page'
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Tính toán vị trí bắt đầu của bản ghi
$start_from = ($current_page - 1) * $records_per_page;

// Câu truy vấn SQL để lấy dữ liệu từ cơ sở dữ liệu
$sql = "SELECT * FROM hoc_sinh LIMIT $start_from, $records_per_page";

// Thực thi câu truy vấn và lấy dữ liệu
$result = $conn->query($sql);

// Kiểm tra kết quả truy vấn
if ($result->num_rows > 0) {
    // Duyệt qua từng bản ghi và thêm vào nội dung HTML
    while ($row = $result->fetch_assoc()) {
        // Thêm dữ liệu của mỗi bản ghi vào nội dung HTML
        $html_content .= "<p>{$row['ma_hocsinh']} - {$row['hoten_hocsinh']}</p>"; // Thay 'column1', 'column2' bằng các cột tương ứng trong bảng của bạn
    }
} else {
    // Hiển thị thông báo nếu không có bản ghi nào được tìm thấy
    $html_content .= "<p>Không có bản ghi nào phù hợp.</p>";
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();

// Kết thúc nội dung HTML
$html_content .= '</body></html>';


// Load nội dung HTML vào tài liệu PDF
$dompdf->loadHtml($html_content);

// Cấu hình và render tài liệu PDF
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Đặt tên tệp PDF
$pdf_filename = 'document.pdf';

// Lưu hoặc xuất tệp PDF
$dompdf->stream($pdf_filename);

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // Kiểm tra xem có lỗi trong quá trình upload không
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Upload error!");
    }

    // Đảm bảo file upload là file zip
    $fileType = mime_content_type($file['tmp_name']);
    if ($fileType !== 'application/zip') {
        die("Please upload a valid ZIP file.");
    }

    // Đặt đường dẫn lưu trữ file tạm thời
    $uploadDir = __DIR__ . '/images/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Đổi tên file zip
    $zipFileName = 'new_name.zip'; // Đổi tên tùy ý ở đây
    $uploadFile = $uploadDir . $zipFileName;

    // Di chuyển file upload tới thư mục đích
    if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
        // Mở file zip và giải nén
        $zip = new ZipArchive;
        if ($zip->open($uploadFile) === TRUE) {
            $extractPath = $uploadDir . pathinfo($zipFileName, PATHINFO_FILENAME);
            if (!is_dir($extractPath)) {
                mkdir($extractPath, 0777, true);
            }

            $zip->extractTo($extractPath);
            $zip->close();
            echo "File uploaded and extracted to $extractPath";
        } else {
            echo "Failed to open ZIP file.";
        }
    } else {
        echo "Failed to move uploaded file.";
    }
} else {
    echo "No file uploaded.";
}
?>

<?php

// Frontend purpose data

define('SITE_URL', 'http://127.0.0.1/dangky/giang');
define('ABOUT_IMAGE_PATH', SITE_URL.'images/anh_chung_chi/');
define('IMAGE_AVATAR_PATH', SITE_URL.'images/anh_chan_dung/');


// backend upload process needs this data

define('UPLOAD_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/giang/dangky/images/');
define('ABOUT_FOLDER', 'anh_chung_chi/');
function adminLogin()
{
    session_start();
    if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
        echo "<script>
        window.location.href='index.php';
    </script>";
        exit();
    }
//    session_regenerate_id(true);
}

function redirect($url)
{
    echo "<script>
        window.location.href='$url';
    </script>";
    exit();
}

function alert($type, $msg)
{
    $bs_class = ($type == 'success') ? 'alert-success' : 'alert-danger';
    echo <<< alert
<div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
  <strong class="me-3">$msg</strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
alert;
}

function uploadImage($image, $folder)
{
    // Kiểm tra xem có lỗi khi tải tệp lên không
    if ($image['error'] === UPLOAD_ERR_NO_FILE) {
        // Trả về một giá trị để chỉ ra rằng không có tệp nào được tải lên
        return 'no_file';
    }

    // Kiểm tra xem loại MIME của tệp hợp lệ không
    $valid_mime = ['image/jpeg', 'image/png', 'image/webp', 'application/pdf', 'application/docx', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid_mime)) {
        return 'inv_img'; // Loại MIME không hợp lệ hoặc định dạng
    } elseif (($image['size'] / (1024 * 1024)) > 2) {
        return 'inv_size'; // Kích thước không hợp lệ, lớn hơn 2MB
    } else {
        // Xử lý và lưu tệp vào thư mục đích
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);

        // Nếu biến $ext không được định nghĩa hoặc là rỗng, xác định phần mở rộng từ loại MIME
        if (!$ext) {
            $ext = pathinfo($image['tmp_name'], PATHINFO_EXTENSION);
        }

        $rname = 'IMG_' . rand(11111, 99999) . ".$ext";
        $img_path = UPLOAD_IMAGE_PATH . $folder . $rname;
        if (move_uploaded_file($image['tmp_name'], $img_path)) {
            return $rname;
        } else {
            return 'upd_failed'; // Lỗi khi di chuyển tệp
        }
    }
}


function deleteImage($image, $folder)
{
    if (is_file(UPLOAD_IMAGE_PATH.$folder.$image) && @unlink(UPLOAD_IMAGE_PATH.$folder.$image)) {
        return true;
    } else {
        return false;
    }
}

?>
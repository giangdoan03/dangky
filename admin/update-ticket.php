<?php
require('./inc/essentials.php');
include('./inc/db_config.php');
adminLogin();
?>
<?php
// Lấy dữ liệu từ form
$id_ticket = isset($_POST['id']) ? $_POST['id'] : '';
$hoten_hocsinh = isset($_POST['hoten_hocsinh']) ? $_POST['hoten_hocsinh'] : '';
$ma_hoc_sinh = isset($_POST['ma_hoc_sinh']) ? $_POST['ma_hoc_sinh'] : '';
$gioi_tinh = isset($_POST['gioi_tinh']) ? $_POST['gioi_tinh'] : '';
$ngay_sinh = isset($_POST['ngay_sinh']) ? $_POST['ngay_sinh'] : '';
$so_bao_danh =isset( $_POST['so_bao_danh']) ? $_POST['so_bao_danh'] : '';
$so_phong = isset($_POST['so_phong']) ? $_POST['so_phong'] : '';
$thoi_gian = isset($_POST['thoi_gian']) ? $_POST['thoi_gian'] : '';
$dia_diem = isset($_POST['dia_diem']) ? $_POST['dia_diem'] : '';
$dia_chi = isset($_POST['dia_chi']) ? $_POST['dia_chi'] : '';
$ten_anh = isset( $_POST['ten_anh']) ?  $_POST['ten_anh'] : '';


// Cập nhật thông tin học sinh trong cơ sở dữ liệu
$sql = "UPDATE phieu_du_thi SET hoten_hocsinh='$hoten_hocsinh', ma_hoc_sinh='$ma_hoc_sinh', gioi_tinh='$gioi_tinh', ngay_sinh='$ngay_sinh', so_bao_danh='$so_bao_danh' , so_phong='$so_phong', thoi_gian='$thoi_gian', dia_diem='$dia_diem', dia_chi='$dia_chi', ten_anh='$ten_anh' WHERE id='$id_ticket'";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

?>

<br>
<a href="edit-ticket.php?id=<?php echo $id_ticket; ?>">Go Back</a>
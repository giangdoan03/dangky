<?php
require('./inc/essentials.php');
include('./inc/db_config.php');
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
    <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">
<?php require('inc/header.php'); ?>

<?php
// Lấy ID người dùng từ tham số URL

// Lấy id của học sinh từ URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Lấy thông tin học sinh từ cơ sở dữ liệu
$sql = "SELECT * FROM phieu_du_thi WHERE id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $ticket = $result->fetch_assoc();
} else {
    echo "No student found!";
    exit;
}

?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h2>Edit Student</h2>
            <form method="post" action="edit-ticket.php?id=<?php echo $id; ?>">
                <input type="hidden" name="id" value="<?php echo $ticket['id']; ?>">
                <div class="input-group mb-3">
                    <span class="input-group-text">Tên học sinh</span>
                    <input type="text" class="form-control" placeholder="Nhập tên học sinh" name="hoten_hocsinh" value="<?php echo $ticket['hoten_hocsinh']; ?>" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Mã học sinh</span>
                    <input type="text" class="form-control" placeholder="Nhập tên học sinh" name="ma_hoc_sinh" value="<?php echo $ticket['ma_hoc_sinh']; ?>" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Giới tính</span>
                    <input type="text" class="form-control" placeholder="Giới tính" name="gioi_tinh" value="<?php echo $ticket['gioi_tinh']; ?>" required>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text">Ngày sinh</span>
                    <input type="text" class="form-control" placeholder="Ngày sinh" name="ngay_sinh" value="<?php echo $ticket['ngay_sinh']; ?>" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Số báo danh</span>
                    <input type="text" class="form-control" placeholder="Số báo danh" name="so_bao_danh" value="<?php echo $ticket['so_bao_danh']; ?>" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Số phòng</span>
                    <input type="text" class="form-control" placeholder="Số phòng" name="so_phong" value="<?php echo $ticket['so_phong']; ?>" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Thời gian</span>
                    <input type="text" class="form-control" placeholder="Thời gian" name="thoi_gian" value="<?php echo $ticket['thoi_gian']; ?>" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Địa điểm</span>
                    <input type="text" class="form-control" placeholder="Địa điểm" name="dia_diem" value="<?php echo $ticket['dia_diem']; ?>" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Địa chỉ</span>
                    <input type="text" class="form-control" placeholder="Địa chỉ" name="dia_chi" value="<?php echo $ticket['dia_chi']; ?>" required>
                </div>
                <small style="color: red">Nhập đúng tên ảnh upload trong file .zip</small>
                <div class="input-group mb-3">
                    <span class="input-group-text">Tên ảnh</span>
                    <input type="text" class="form-control" placeholder="Tên ảnh" name="ten_anh" value="<?php echo $ticket['ten_anh']; ?>" required>
                </div>

                <button type="submit" class="btn btn-outline-secondary">Update</button>
            </form>
        </div>
    </div>
</div>

<?php require('inc/scripts.php'); ?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>

</script>
</body>
</html>
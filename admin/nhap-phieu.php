<?php
require('./inc/essentials.php');
include('./inc/db_config.php');
//include('./generate_pdf.php');
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
    <?php require('./inc/links.php'); ?>
</head>
<body class="bg-light">
<?php require('inc/header.php'); ?>
<?php
// Số bản ghi trên mỗi trang
$records_per_page = 96;

// Số bản ghi trong cơ sở dữ liệu
$sql_total_records = "SELECT COUNT(*) AS total_records FROM phieu_du_thi";

$result_total_records = $conn->query($sql_total_records);
$row_total_records = $result_total_records->fetch_assoc();
$total_records = $row_total_records['total_records'];

// Tính toán số lượng trang
$total_pages = ceil($total_records / $records_per_page);

// Trang hiện tại
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Tính toán vị trí bắt đầu của bản ghi
$start_from = ($current_page - 1) * $records_per_page;

// Câu truy vấn SQL
$sql_data = "SELECT * FROM phieu_du_thi ORDER BY id DESC LIMIT $start_from, $records_per_page";

// Thực thi câu truy vấn và lấy dữ liệu
$result_data = $conn->query($sql_data);


// Get status message
if (!empty($_GET['status'])) {
    switch ($_GET['status']) {
        case 'succ':
            $statusType = 'alert-success';
            $statusMsg = 'Member data has been imported successfully.';
            break;
        case 'err':
            $statusType = 'alert-danger';
            $statusMsg = 'Something went wrong, please try again.';
            break;
        case 'invalid_file':
            $statusType = 'alert-danger';
            $statusMsg = 'Please upload a valid Excel file.';
            break;
        default:
            $statusType = '';
            $statusMsg = '';
    }
}

?>
<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">Nhập phiếu dự thi</h3>

            <div class="action-in">
                <p>Tổng: <strong><?php echo $total_records; ?></strong> phiếu</p>

                <div class="">

                </div>
            </div>
            <!-- General settings section -->
            <!-- Display status message -->
            <?php if (!empty($statusMsg)) { ?>
                <div class="col-xs-12 p-3">
                    <div class="alert <?php echo $statusType; ?>"><?php echo $statusMsg; ?></div>
                </div>
            <?php } ?>
            <div class="card border-0 shadow-sm mb-4" id="importFrm">
                <div class="list-student card-body">
                    <div class="row-one">
                        <div class="form-import">
                            <form action="importData.php" method="post" enctype="multipart/form-data">
                                <div class="row" style="align-items: center">
                                    <div class="col-auto" style="margin-bottom: 20px">
                                        <label for="file" style="color: red;">Chọn file excel:</label>
                                        <label for="fileInput" class="visually-hidden">File</label>
                                        <input type="file" class="form-control" name="file" id="fileInput">
                                    </div>
                                    <div class="col-auto">
                                        <input type="submit" style="margin-top: 18px;" class="btn btn-primary mb-3" name="importSubmit" value="Import">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="import_file_zip" style="margin-bottom: 20px">
                            <form action="upload.php" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-auto">
                                        <label for="file" style="color: red">(File .zip khi giải nén phải có kiểu: ten_file.zip/ten_anh.jpg):</label>
                                        <input type="file" class="form-control" name="file" id="file" accept=".zip">
                                    </div>
                                    <div class="col-auto">
                                        <button style="margin-top: 23px" type="submit" class="btn btn-primary">Upload</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="row">
                        <table class="table table-triped table-bordered">
                            <thead class="table-dark">
                            <tr>
                                <td>STT</td>
                                <td>Họ tên học sinh</td>
                                <td>Mã học sinh</td>
                                <td>Giới tính</td>
                                <td>Ngày sinh</td>
                                <td>Số báo danh</td>
                                <td>Số phòng</td>
                                <td>Thời gian</td>
                                <td>Địa điểm</td>
                                <td>Địa chỉ</td>
                                <td>Ảnh(3x4)</td>
                                <td>Trạng thái</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // get member record from the database
                            $result = $conn->query("SELECT * FROM phieu_du_thi");
                            if ($result->num_rows > 0) {
                                $path = IMAGE_AVATAR_NEW_NAME;
                                $i = 0;
                                while ($row = $result->fetch_assoc()) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row['hoten_hocsinh']; ?></td>
                                        <td><?php echo $row['ma_hoc_sinh']; ?></td>
                                        <td><?php echo $row['gioi_tinh']; ?></td>
                                        <td><?php echo $row['ngay_sinh']; ?></td>
                                        <td><?php echo $row['so_bao_danh']; ?></td>
                                        <td><?php echo $row['so_phong']; ?></td>
                                        <td><?php echo $row['thoi_gian']; ?></td>
                                        <td><?php echo $row['dia_diem']; ?></td>
                                        <td><?php echo $row['dia_chi']; ?></td>
                                        <td><img style="width: 50px" src="<?php echo $path.$row['ten_anh']; ?>" alt=""></td>
                                        <td><?php echo $row['trang_thai']; ?></td>
                                    </tr>
                                    <?php

                                }
                            } else { ?>
                                <tr>
                                    <td colspan="12">Không tìm thấy hồ sơ...</td>
                                </tr>
                                <?php

                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<?php require('inc/scripts.php'); ?>

<script>

</script>
</body>
</html>
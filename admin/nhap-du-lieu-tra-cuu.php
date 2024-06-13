<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


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
// Lấy ID người dùng từ tham số URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    // Truy vấn để xóa người dùng
    $sql = "DELETE FROM phieu_du_thi WHERE id = $userId";

    if ($conn->query($sql) === TRUE) {
        echo "Xóa hồ sơ thành công";
        $qstring = '?trangthai=succ';
    } else {
        $qstring = '?trangthai=invalid_file';
        echo "Lỗi: " . $conn->error;
    }
    // Redirect to the listing page
    header("Location: nhap-phieu.php".$qstring);
}

// Get status message
if (!empty($_GET['trangthai'])) {
    switch ($_GET['trangthai']) {
        case 'succ':
            $statusType = 'alert-success';
            $statusMsg = 'Xóa thành công.';
            break;
        case 'err':
            $statusType = 'alert-danger';
            $statusMsg = 'Đã có lỗi xảy ra, vui lòng thử lại.';
            break;
        case 'invalid_file':
            $statusType = 'alert-danger';
            $statusMsg = 'Vui lòng thử lại.';
            break;
        default:
            $statusType = '';
            $statusMsg = '';
    }
}

?>


<?php
// Số bản ghi trên mỗi trang
$records_per_page = 24;

// Số bản ghi trong cơ sở dữ liệu
$sql_total_records = "SELECT COUNT(*) AS total_records FROM tra_cuu";

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
$sql_data = "SELECT * FROM tra_cuu LIMIT $start_from, $records_per_page";

// Thực thi câu truy vấn và lấy dữ liệu
$result_data = $conn->query($sql_data);


$statusMsgDelAll = '';

// Get status message
if (!empty($_GET['status'])) {
    switch ($_GET['status']) {
        case 'succ':
            $statusType = 'alert-success';
            $statusMsg = 'Nhập File danh sách tra cứu thành công.';
            break;
        case 'err':
            $statusType = 'alert-danger';
            $statusMsg = 'Đã có lỗi xảy ra, vui lòng thử lại';
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


function deleteFilesInFolder($folderPath) {
    $files = glob($folderPath . '/*'); // Lấy tất cả các file trong folder

    foreach($files as $file) {
        if(is_file($file)) {
            unlink($file); // Xóa file
        }
    }
}

// Function to delete all data in a table

// Function to delete all data in a table
function deleteDataInTable($conn, $tableName) {
    $sql = "DELETE FROM $tableName";
    if ($conn->query($sql) === TRUE) {
        return "Dữ liệu trong bảng $tableName đã được xóa thành công.";
    } else {
        return "Lỗi khi xóa dữ liệu: " . $conn->error;
    }
}
// Khai báo biến $statusMsg và đặt giá trị ban đầu là rỗng

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_all'])) {
    // Đường dẫn tương đối tới thư mục (tính từ thư mục gốc của dự án web)
    $relativeFolderPath = 'dangky/admin/images/new_name';

    // Lấy thông tin domain hiện tại
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $domain = $protocol . "://" . $_SERVER['HTTP_HOST'];

    // Tạo đường dẫn URL đầy đủ
    $folderUrl = $domain . '/' . $relativeFolderPath;

    // Lấy đường dẫn vật lý tuyệt đối từ đường dẫn tương đối
    $absoluteFolderPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $relativeFolderPath;


    // Kiểm tra nếu thư mục tồn tại
    if (is_dir($absoluteFolderPath)) {
        // Tên bảng MySQL
        $tableName = 'tra_cuu';

        // Xóa file trong folder
        deleteFilesInFolder($absoluteFolderPath);

        // Xóa dữ liệu trong bảng MySQL
        deleteDataInTable($conn, $tableName);

        // Set status type based on success or error
        $statusTypeDelAll = 'Xóa thành công';
        $type_mess = 'alert-success';
        echo '<script>window.location.replace("' . $_SERVER['PHP_SELF'] . '");</script>';
        exit;
    } else {
        echo "Thư mục không tồn tại hoặc không hợp lệ: $absoluteFolderPath<br>";
        $statusTypeDelAll = 'Đã có lỗi, vui lòng thử lại';
        $type_mess = 'alert-danger';
    }

}

?>
<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">Nhập dữ liệu tra cứu</h3>

            <div class="action-in action_tra_cuu">
                <p>Tổng: <strong><?php echo $total_records; ?></strong> thí sinh</p>

                <div class="btn_reset">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="submit" class="btn btn-outline-danger" onclick="confirmDelete()" name="delete_all" value="Xóa toàn bộ dữ liệu tra cứu">
                    </form>
                </div>
            </div>
            <!-- General settings section -->
            <!-- Display status message -->
            <?php if (!empty($statusMsg)) { ?>
                <div class="col-xs-12 p-3">
                    <div id="successMessage"class="alert <?php echo $statusType; ?>"><?php echo $statusMsg; ?></div>
                </div>
            <?php } ?>
            <?php if (!empty($statusTypeDelAll)) { ?>
                <div class="alert <?php echo $type_mess; ?>">
                    <?php echo $statusTypeDelAll; ?>
                </div>
            <?php } ?>
            <div class="card border-0 shadow-sm mb-4" id="importFrm">
                <div class="list-student card-body">
                    <div class="row-one">
                        <div class="form-import">
                            <form action="import-data-search.php" method="post" enctype="multipart/form-data">
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

                    </div>
                    <div class="list-pagination-top">
                        <?php

                        for ($i = 1; $i <= $total_pages; $i++) {
                            $active_class = ($current_page == $i) ? "active" : "";
                            echo "<a class='item $active_class' href='?page=$i'>$i</a>";
                        }
                        ?>
                    </div>
                    <div class="row">
                        <table class="table table-triped table-bordered">
                            <thead class="table-dark">
                            <tr>
                                <td>STT</td>
                                <td>Mã học sinh</td>
                                <td>Họ tên đệm</td>
                                <td>Tên</td>
                                <td>Ngày sinh</td>
                                <td>Giới tính</td>
                                <td>Dân tộc</td>
                                <td>Số báo danh</td>
                                <td>SĐT người đăng ký</td>
                                <td>Phòng kiểm tra</td>
                                <td>Địa điểm kiểm tra</td>
                                <td>Thời gian có mặt</td>
                                <td>Điểm tiếng việt</td>
                                <td>Điểm tiếng Anh</td>
                                <td>Điểm Toán</td>
                                <td>Điểm ưu tiên</td>
                                <td>Điểm sơ tuyển</td>
                                <td>Tổng điểm xét tuyền</td>


                                <td>Điểm phúc khảo Tiếng viẹt</td>
                                <td>Điểm phúc khảo Tiếng Anh</td>
                                <td>Điểm phúc khảo Toán</td>
                                <td>Tổng điểm xét tuyển sau phúc khảo</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // get member record from the database
                            $result = $conn->query("SELECT * FROM tra_cuu");
                            if ($result_data->num_rows > 0) {
                                $path = IMAGE_AVATAR_NEW_NAME;
                                $i = 0;
                                while ($row = $result_data->fetch_assoc()) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row['ma_hoc_sinh']; ?></td>
                                        <td><?php echo $row['ho_ten_dem']; ?></td>
                                        <td><?php echo $row['ten']; ?></td>
                                        <td><?php echo $row['ngay_sinh']; ?></td>
                                        <td><?php echo $row['gioi_tinh']; ?></td>
                                        <td><?php echo $row['dan_toc']; ?></td>
                                        <td><?php echo $row['so_bao_danh']; ?></td>
                                        <td><?php echo $row['sdt_nguoi_dang_ky']; ?></td>
                                        <td><?php echo $row['phong_kiem_tra']; ?></td>
                                        <td><?php echo $row['dia_diem_kiem_tra']; ?></td>
                                        <td><?php echo $row['thoi_gian_co_mat']; ?></td>
                                        <td><?php echo $row['diem_tieng_viet']; ?></td>
                                        <td><?php echo $row['diem_tieng_anh']; ?></td>
                                        <td><?php echo $row['diem_toan']; ?></td>
                                        <td><?php echo $row['diem_uu_tien']; ?></td>
                                        <td><?php echo $row['diem_so_tuyen']; ?></td>
                                        <td><strong><?php echo $row['tong_diem_xet_tuyen']; ?></strong></td>

                                        <td><?php echo $row['diem_pk_tieng_viet']; ?></td>
                                        <td><?php echo $row['diem_pk_tieng_anh']; ?></td>
                                        <td><?php echo $row['diem_pk_toan']; ?></td>
                                        <td><strong><?php echo $row['tong_diem_xt_sau_pk']; ?></strong></td>

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
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    // Hàm xác nhận xóa trước khi xóa
    function confirmDelete(userId) {
        if (confirm("Bạn có chắc chắn muốn xóa bản ghi này không?")) {
            window.location.href = 'nhap-du-lieu-tra-cuu.php?id=' + userId; // Chuyển hướng để xóa
        }
    }
    // Kiểm tra xem trang có chứa tham số "?status=succ" không
    if (window.location.search.includes('?status=succ')) {
        // Nếu có, thì sau 1 giây, thực hiện chuyển hướng URL mới không có tham số "?status=succ"
        setTimeout(function() {
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            window.history.pushState({ path: newurl }, '', newurl);
        }, 2000); // 1000ms = 1 giây
    }

    // Kiểm tra xem trang có chứa tham số "?status=succ" không
    if (window.location.search.includes('?trangthai=succ')) {
        // Nếu có, thì sau 1 giây, thực hiện chuyển hướng URL mới không có tham số "?status=succ"
        setTimeout(function() {
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            window.history.pushState({ path: newurl }, '', newurl);
        }, 2000); // 1000ms = 1 giây
    }
    // Kiểm tra xem có thông báo thành công không
    var successMessage = document.getElementById("successMessage");

    if (successMessage) {
        // Nếu có, sau 1 giây, ẩn hoặc xóa lớp của thông báo đó
        setTimeout(function() {
            successMessage.classList.remove("alert-success"); // Xóa lớp
            successMessage.style.display = "none"; // Hoặc ẩn thông báo
        }, 2000); // 1000ms = 2 giây
    }
    function confirmDelete() {
        if (confirm("Bạn có chắc chắn muốn xóa toàn bộ dữ liệu không?")) {
            console.log('34234234')
            // Tải lại trang sau 2 giây

        }
    }
</script>
<script>

</script>
</body>
</html>
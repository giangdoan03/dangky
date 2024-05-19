<?php
require('inc/essentials.php');
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

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    // Truy vấn để xóa người dùng
    $sql = "DELETE FROM hoc_sinh WHERE id = $userId";
    $sql2 = "DELETE FROM phu_huynh WHERE id_hocsinh = $userId";
    $sql3 = "DELETE FROM diem WHERE id_hocsinh = $userId";
    $sql4 = "DELETE FROM anh_chung_chi WHERE id_hocsinh = $userId";

    if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE && $conn->query($sql3) === TRUE && $conn->query($sql4) === TRUE) {
        echo "Xóa hồ sơ thành công";
        $qstring = '?status=succ';
    } else {
        $qstring = '?status=invalid_file';
        echo "Lỗi: " . $conn->error;
    }
    // Redirect to the listing page
    header("Location: profile-list.php".$qstring);
}

// Get status message
if (!empty($_GET['status'])) {
    switch ($_GET['status']) {
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
$records_per_page = 50;

// Số bản ghi trong cơ sở dữ liệu
$sql_total_records = "SELECT COUNT(*) AS total_records FROM hoc_sinh";

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
$sql_data = "SELECT * FROM hoc_sinh LIMIT $start_from, $records_per_page";

// Thực thi câu truy vấn và lấy dữ liệu
$result_data = $conn->query($sql_data);

?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">Danh sách học sinh</h3>
            <!-- General settings section -->
            <?php if (!empty($statusMsg)) { ?>
                <div class="col-xs-12 p-3">
                    <div id="successMessage" class="alert <?php echo $statusType; ?>"><?php echo $statusMsg; ?></div>
                </div>
            <?php } ?>
            <div class="card border-0 shadow-sm mb-4">
                <div class="list-student card-body">
                    <table>
                        <tr>
                            <th>STT</th>
                            <th>Mã Học sinh</th>
                            <th>Họ tên học sinh</th>
                            <th>Ngày sinh</th>
                            <th>Nơi sinh</th>
                            <th>Giới tính</th>
                            <th>Dân tộc</th>
                            <th>Tên lớp</th>
                            <th>Tên trường</th>
                            <th>Điện ưu tiên</th>
                            <th>Điểm ưu tiên</th>
                            <th>Tổng điểm xét tuyển</th>
                            <th>Thao tác</th>
                        </tr>
                        <?php
                        $sql = "SELECT id,ma_hocsinh,hoten_hocsinh,ngaysinh,noisinh,gioitinh,dantoc,tenlop,ten_truong,dien_uu_tien,diem_uu_tien,tong_diem_xet_tuyen FROM hoc_sinh ORDER BY id DESC";
                        $result = $conn->query($sql_data);
                        if ($result->num_rows > 0) {
                            // output data of each row
                            $headers = $col = "";
                            $count = 0;
                            while ($row = $result->fetch_assoc()) {
                                $count++;
                                echo "<tr>";
                                echo "<td>" . $count . "</td>";
                                echo "<td>" . "<a href='student.php?id=".$row['id']."'>".$row['ma_hocsinh']."</a>" . "</td>";
                                echo "<td>" . $row['hoten_hocsinh'] . "</td>";
                                echo "<td>" . $row['ngaysinh'] . "</td>";
                                echo "<td>" . $row['noisinh'] . "</td>";
                                echo "<td>" . $row['gioitinh'] . "</td>";
                                echo "<td>" . $row['dantoc'] . "</td>";
                                echo "<td>" . $row['tenlop'] . "</td>";
                                echo "<td>" . $row['ten_truong'] . "</td>";
                                echo "<td>" . $row['dien_uu_tien'] . "</td>";
                                echo "<td>" . $row['diem_uu_tien'] . "</td>";
                                echo "<td>" . $row['tong_diem_xet_tuyen'] . "</td>";
                                echo "<td><a href='javascript:void(0);' onclick='confirmDelete({$row['id']});'>Xóa</a></td>";
                                echo "</tr>";
                            }

                        } else {
                            echo "0 results";
                        }
                        ?>
                    </table>
                </div>
            </div>

            <!-- General settings modal section -->

            <div class="modal fade" id="general-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
                 aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="general_s_form" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">General Settings</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12 ps-0 mb-3">
                                    <label class="form-label fw-bold">Site Title</label>
                                    <input type="text" name="site_title" id="site_title_inp"
                                           class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-12 p-0 mb-3">
                                    <label class="form-label fw-bold">About us</label>
                                    <textarea name="site_about" id="site_about_inp" class="form-control shadow-none"
                                              rows="6" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button"
                                        onclick="site_title.value = general_data.site_title; site_about.value = general_data.site_about"
                                        class="btn text-secondary shadow-none" data-bs-dismiss="modal">
                                    CANCEL
                                </button>
                                <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
</div>
<?php require('inc/scripts.php'); ?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    // Hàm xác nhận xóa trước khi xóa
    function confirmDelete(userId) {
        if (confirm("Bạn có chắc chắn muốn xóa bản ghi này không?")) {
            window.location.href = 'profile-list.php?id=' + userId; // Chuyển hướng để xóa
        }
    }
    // Kiểm tra xem trang có chứa tham số "?status=succ" không
    if (window.location.search.includes('?status=succ')) {
        // Nếu có, thì sau 1 giây, thực hiện chuyển hướng URL mới không có tham số "?status=succ"
        setTimeout(function() {
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            window.history.pushState({ path: newurl }, '', newurl);
        }, 1000); // 1000ms = 1 giây
    }
    // Kiểm tra xem có thông báo thành công không
    var successMessage = document.getElementById("successMessage");

    if (successMessage) {
        // Nếu có, sau 1 giây, ẩn hoặc xóa lớp của thông báo đó
        setTimeout(function() {
            successMessage.classList.remove("alert-success"); // Xóa lớp
            successMessage.style.display = "none"; // Hoặc ẩn thông báo
        }, 1000); // 1000ms = 2 giây
    }
</script>
</body>
</html>
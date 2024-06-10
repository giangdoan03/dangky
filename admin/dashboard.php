<?php
// Kết nối đến cơ sở dữ liệu và bao gồm tệp liên quan
include('./inc/db_config.php');
require('./inc/essentials.php');

// Hàm để xác thực đăng nhập của quản trị viên
adminLogin();

// Số bản ghi trên mỗi trang
$records_per_page = 50;

// Xác định trang hiện tại
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Tính offset (vị trí bắt đầu của bản ghi cho trang hiện tại)
$offset = ($current_page - 1) * $records_per_page;

// Lấy tổng số bản ghi
$sql_total_records = "SELECT COUNT(*) AS total_records FROM admin_logins WHERE admin_id = ?";
$stmt = $conn->prepare($sql_total_records);
$stmt->bind_param("i", $_SESSION['adminId']);
$stmt->execute();
$result_total_records = $stmt->get_result();
$row_total_records = $result_total_records->fetch_assoc();
$total_records = $row_total_records['total_records'];

// Tính tổng số trang
$total_pages = ceil($total_records / $records_per_page);

// Lấy dữ liệu cho trang hiện tại
$sql = "SELECT login_time, ip_address, country, region, city FROM admin_logins WHERE admin_id = ? ORDER BY login_time DESC LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $_SESSION['adminId'], $offset, $records_per_page);
$stmt->execute();
$result = $stmt->get_result();

// Đặt múi giờ thành múi giờ Việt Nam
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Dashboard</title>
    <!-- Bao gồm các tệp liên quan -->
    <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">
<!-- Header -->
<?php require('inc/header.php'); ?>

<!-- Main Content -->
<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h1>Thông tin đăng nhập</h1>
            <!-- Bảng dữ liệu -->
            <table>
                <thead>
                <tr>
                    <th>Thời gian đăng nhập</th>
                    <th>Địa chỉ IP</th>
                    <th>Quốc gia</th>
                    <th>Vùng</th>
                    <th>Thành phố</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo date('d/m/Y H:i:s', strtotime($row['login_time'])); ?></td>
                        <td><?php echo $row['ip_address']; ?></td>
                        <td><?php echo $row['country']; ?></td>
                        <td><?php echo $row['region']; ?></td>
                        <td><?php echo $row['city']; ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            <!-- Phân trang -->
            <div class="pagination">
                <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                    <a href="?page=<?php echo $page; ?>" <?php if ($current_page == $page) echo 'class="active"'; ?>><?php echo $page; ?></a>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</div>

<!-- Bao gồm các tệp liên quan -->
<?php require('inc/scripts.php'); ?>
</body>
</html>

<?php
// Đóng kết nối và các câu lệnh prepare
$stmt->close();
$conn->close();
?>

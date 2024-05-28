<?php
require('./admin/inc/essentials.php');
include('./admin/inc/db_config.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tìm kiếm học sinh</title>
</head>
<body>
<h1>Tìm kiếm học sinh</h1>
<form action="index.php" method="post">
    <label for="student_id">Mã học sinh:</label>
    <input type="text" id="student_id" name="student_id" required>
    <button type="submit">Tìm kiếm</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root"; // Thay bằng username của bạn
    $password = ""; // Thay bằng password của bạn
    $dbname = "school";

    // Tạo kết nối
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $student_id = $_POST['student_id'];

    // Chuẩn bị câu lệnh SQL
    $sql = "SELECT * FROM students WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Hiển thị thông tin học sinh
        echo "<h2>Thông tin học sinh</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "Mã học sinh: " . $row["student_id"] . "<br>";
            echo "Tên: " . $row["name"] . "<br>";
            echo "Tuổi: " . $row["age"] . "<br>";
            echo "Lớp: " . $row["class"] . "<br>";
            echo "<hr>"; // Thêm một đường kẻ ngang để phân tách các kết quả (nếu có nhiều hơn một kết quả)
        }
    } else {
        echo "<p>Không tìm thấy học sinh với mã: $student_id</p>";
    }

    $stmt->close();
    $conn->close();
}
?>
</body>
</html>

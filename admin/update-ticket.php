<?php
require('./inc/essentials.php');
include('./inc/db_config.php');
adminLogin();
?>
<?php

// Lấy dữ liệu từ form
$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$age = $_POST['age'];

// Cập nhật thông tin học sinh trong cơ sở dữ liệu
$sql = "UPDATE phieu_du_thi SET name='$name', email='$email', age=$age WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>

<br>
<a href="edit_student.php?id=<?php echo $id; ?>">Go Back</a>
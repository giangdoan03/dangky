<?php
require('inc/essentials.php');
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
    <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">
<?php require('inc/header.php'); ?>
<?php
// Số bản ghi trên mỗi trang
$records_per_page = 96;

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
$sql_data = "SELECT * FROM hoc_sinh ORDER BY id DESC LIMIT $start_from, $records_per_page";

// Thực thi câu truy vấn và lấy dữ liệu
$result_data = $conn->query($sql_data);

?>
<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">Phiếu dự thi</h3>

            <div class="action-in">
                <p>Tổng: <strong><?php echo $total_records; ?></strong> phiếu</p>

                <div class="">

                </div>
            </div>
            <!-- General settings section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="list-student card-body">
                    <div class="list-pagination-top">
                        <?php

                        for ($i = 1; $i <= $total_pages; $i++) {
                            $active_class = ($current_page == $i) ? "active" : "";
                            echo "<a class='item $active_class' href='?page=$i'>$i</a>";
                        }
                        ?>
                    </div>
                    <table>
                        <tr>
                            <th>
                                <div> <span>All</span></div>
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th>STT</th>
                            <th>Mã Học sinh</th>
                            <th>Họ tên học sinh</th>
                            <th>Ngày sinh</th>
                            <th>Nơi sinh</th>
                            <th>Giới tính</th>
                            <th>Số báo danh</th>
                            <th>Phòng kiểm tra</th>
                            <th>Ảnh (3x4)</th>
                            <th>In phiếu</th>
                        </tr>


                        <?php
                        $result = $conn->query($sql_data);
                        if ($result->num_rows > 0) {
                            // output data of each row
                            $headers = $col = "";
                            $count = 0;
                            while ($row = $result->fetch_assoc()) {
                                $path = IMAGE_AVATAR_PATH;
                                $count++;
                                ?>
                        <tr>
                                <td><input type="checkbox" class="checkbox" data-id="<?php echo $row['id']; ?>"></td>
                                <td><?php echo $count; ?></td>
                                <td><a href="student.php?id=<?php echo $row['id']; ?>"><?php echo $row['ma_hocsinh']; ?></a></td>
                                <td><?php echo $row['hoten_hocsinh']; ?></td>
                                <td><?php echo $row['ngaysinh']; ?></td>
                                <td><?php echo $row['noisinh']; ?></td>
                                <td><?php echo $row['gioitinh']; ?></td>
                                <td><?php echo $row['dantoc']; ?></td>
                                <td>Số báo danh</td>
                                <td>
                                    <label for="inputFile_<?php echo $row['id']; ?>" style="cursor: pointer;">
                                        <img
                                                onerror="this.onerror=null;this.src='../images/common/default_filetype.png';"
                                                id="anh_chan_dung_<?php echo $row['id']; ?>"
                                                class="anh_chan_dung" src="<?php echo $path . $row['ten_anh']; ?>"
                                                alt="Ảnh học sinh"
                                        >
                                    </label>
                                    <input type="file" id="inputFile_<?php echo $row['id']; ?>" style="display: none;" onchange="updateImage(<?php echo $row['id']; ?>)">
                                </td>
                                <td>Xuất phiếu</td>
                        </tr>
                                <?php
                            }

                        } else {
                            echo "0 results";
                        }
                        ?>
                    </table>
                    <div class="list-pagination">
                        <?php

                        for ($i = 1; $i <= $total_pages; $i++) {
                            $active_class = ($current_page == $i) ? "active" : "";
                            echo "<a class='item $active_class' href='?page=$i'>$i</a>";
                        }
                        ?>
                    </div>
                    <button id="downloadPdfBtn">Generate PDF</button>
                </div>
            </div>

        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


<?php require('inc/scripts.php'); ?>

<script>
    function updateImage(studentId) {
        const inputFile = document.getElementById(`inputFile_${studentId}`);
        const image = document.getElementById(`anh_chan_dung_${studentId}`);

        const file = inputFile.files[0];
        if (file) {
            const imageURL = URL.createObjectURL(file);
            image.src = imageURL;
            // Có thể thêm mã Ajax để tải lên và lưu trữ ảnh tại đây
        } else {
            // Nếu không có tệp được chọn, hiển thị ảnh mặc định
            image.src = '../images/common/default_filetype.png';
        }
    }
    document.getElementById("checkAll").onclick = function() {
        var checkboxes = document.getElementsByClassName("checkbox");
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }
    };

    var checkboxes = document.getElementsByClassName("checkbox");
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].onclick = function() {
            var checkedCount = document.querySelectorAll('.checkbox:checked').length;
            document.getElementById("checkAll").checked = checkedCount === checkboxes.length;
        };
    }

    document.getElementById("downloadPdfBtn").addEventListener("click", function(event) {
        console.log("Button clicked!");
        event.preventDefault();
        // Tạo một yêu cầu tải xuống
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'generate_pdf.php', true);
        xhr.responseType = 'blob'; // Sử dụng kiểu dữ liệu blob để tải xuống tệp
        xhr.onload = function() {
            // Kiểm tra nếu yêu cầu thành công
            if (this.status === 200) {
                // Tạo một URL tạm thời cho dữ liệu blob
                var url = window.URL.createObjectURL(this.response);
                // Tạo một thẻ a ẩn để tải xuống tệp
                var a = document.createElement('a');
                a.href = url;
                a.download = 'ten-file.pdf'; // Đặt tên tệp tải xuống
                document.body.appendChild(a);
                a.click(); // Kích hoạt sự kiện click trên thẻ a để tải xuống tệp
                // Xóa URL tạm thời sau khi tệp được tải xuống
                window.URL.revokeObjectURL(url);
            }
        };
        // Gửi yêu cầu
        xhr.send();
    });

</script>
</body>
</html>
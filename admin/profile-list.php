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
<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">Danh sách học sinh</h3>
            <!-- General settings section -->
            <div class="card border-0 shadow-sm mb-4">
                <!--                <div class="card-body">-->
                <!--                    <div class="d-flex align-items-center justify-content-between mb-3">-->
                <!--                        <h5 class="card-title m-0">General Settings</h5>-->
                <!--                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"-->
                <!--                                data-bs-target="#general-s">-->
                <!--                            <i class="bi bi-pencil-square"></i> Edit-->
                <!--                        </button>-->
                <!--                    </div>-->
                <!--                    <h6 class="card-subtitle mb-2 text-muted mb-1 fw-bold">Site Title</h6>-->
                <!--                    <p class="card-text" id="site_title"></p>-->
                <!--                    <h6 class="card-subtitle mb-2 text-muted mb-1 fw-bold">About us</h6>-->
                <!--                    <p class="card-text" id="site_about">content</p>-->
                <!--                </div>-->


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
                        </tr>


                        <?php
                        $sql = "SELECT id,ma_hocsinh,hoten_hocsinh,ngaysinh,noisinh,gioitinh,dantoc,tenlop,ten_truong,dien_uu_tien,diem_uu_tien,tong_diem_xet_tuyen FROM hoc_sinh ORDER BY id DESC";
                        $result = $conn->query($sql);
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
<script>

</script>
</body>
</html>
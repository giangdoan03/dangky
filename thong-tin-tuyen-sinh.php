<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta property="og:title" content="Tuyển sinh trường THCS Thanh Xuân">
    <meta property="og:description" content="Tuyển sinh trường THCS Thanh Xuân">
    <meta property="og:image" content="https://tuyensinh.thcsthanhxuan.vn/images/common/logo_thcs_thanh_xuan.png">
    <link rel="shortcut icon" type="image/png" href="./images/common/favicon.ico"/>
    <title>Đăng ký tuyển sinh</title>
    <?php require('inc/links.php'); ?>
    <style>
        .availability-form {
            margin-top: -50px;
            z-index: 2;
            position: relative;
        }

        .diem_chuan {
            min-height: 500px;
            padding: 50px 0;
            padding-top: 5px;
        }
        .diem_chuan .container p {
            margin-bottom: 8px;
        }

        .box_content {
            margin-top: 30px;
        }

        @media screen and (max-width: 575px) {
            .availability-form {
                margin-top: 25px;
                padding: 0 35px;
            }

        }
    </style>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-MJFNDXWJSJ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'G-MJFNDXWJSJ');
    </script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
</head>
<body class="bg-light">
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require('./admin/inc/essentials.php');
include('./admin/inc/db_config.php');


// Hàm để lấy URL gốc
function base_url()
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'];
    return $protocol . $domainName . '/';
}


// Truy vấn để lấy trạng thái hiện tại
$sql = "SELECT status_name FROM status_settings WHERE is_active = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $current_status = $row['status_name'];
} else {
    $current_status = "Not Set"; // Nếu không có trạng thái nào được thiết lập
}

// Lấy nội dung thông báo hiện tại
$notificationMessage = '';
$result = $conn->query("SELECT message FROM notifications ORDER BY id DESC LIMIT 1");
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $notificationMessage = $row['message'];
}
?>

<div class="page-register">
    <?php require('inc/header.php'); ?>


    <div class="diem_chuan">
        <div class="container">
            <div class="page_content">
                <?php echo $notificationMessage; ?>
            </div>
        </div>
    </div>

</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Include Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Include Bootstrap Datepicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<!-- Include Bootstrap Datepicker Vietnamese localization -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.vi.min.js"></script>
<script type="text/javascript">

    $(document).ready(function () {
        $('#datepicker').datepicker({
            format: 'dd/mm/yyyy',
            language: 'vi',
            autoclose: true
        });

        $('#province').change(function () {
            loadDistrict($(this).find(':selected').val())
        })

        $(".img-preview img").each(function () {
            if ($(this).attr('src') == '') {
                $(this).css("display", "none");
            } else {
                $(this).addClass("active");
            }
        });

        $('#cam_ket').click(function () {
            $('#button_dangKy').prop("disabled", !$("#cam_ket").prop("checked"));
        })


    });

    function validateTenDigitInteger(value) {
        return /^\d{10}$/.test(value);
    }

    // document.getElementById('ma_hocsinh').addEventListener('keyup', function () {
    //     const inputValue = this.value;
    //     const isValid = validateTenDigitInteger(inputValue);
    //
    //     const checkbox = document.getElementById('cam_ket');
    //     const button = document.getElementById('button_dangKy');
    //
    //     checkbox.checked = isValid;
    //     button.disabled = !isValid;
    // });

    // document.addEventListener("DOMContentLoaded", function () {
    //     var checkbox = document.getElementById("cam_ket");
    //     var input = document.getElementById("button_dangKy");
    //
    //     // Biến điều kiện
    //     var condition = true;
    //
    //     checkbox.addEventListener("change", function () {
    //         // Kiểm tra trạng thái của checkbox và điều kiện
    //         if (checkbox.checked && !check_unique) {
    //             input.disabled = false;
    //         } else {
    //             input.disabled = true;
    //         }
    //     });
    // });

    function loadProvince() {
        $("#province").children().remove();
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: "get=province"
        }).done(function (result) {
            $("#province").append($(result));
            // $(result).each(function() {

            // })
            loadDistrict(1);
        });
    }

    function loadDistrict(province_id) {
        $("#district").children().remove()
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: "get=district&province_id=" + province_id
        }).done(function (result) {
            $("#district").append($(result));

        });
    }

    function get_subject(value) {
        console.log('value', value)
        let idx1 = 'tieng_viet_' + value;
        let idx2 = 'toan_' + value;
        let idx3 = 'ngoai_ngu_' + value;
        let tong_diem_3_mon;
        let tv = document.getElementById(idx1).value;
        let t = document.getElementById(idx2).value;
        if (idx1 === 'tieng_viet_1' || idx1 === 'tieng_viet_2' || idx2 === 'toan_1' || idx2 === 'toan_2') {
            tong_diem_3_mon = Number(tv) + Number(t);
        } else {
            let nn = document.getElementById(idx3).value;
            tong_diem_3_mon = tong_diem_3_mon = Number(tv) + Number(t) + Number(nn);
        }


        // let nn = document.getElementById(idx3).value ? document.getElementById(idx3).value : 0;

        // console.log('tong diem 3 mon', Number(tv) + Number(t) + Number(nn));

        // let tong_diem_3_mon = Number(tv) + Number(t) + Number(nn);
        let he_so_quy_doi = 2
        if (tong_diem_3_mon === 30) {
            he_so_quy_doi = 2;
        } else if (tong_diem_3_mon === 29) {
            he_so_quy_doi = 1.75;
        } else if (tong_diem_3_mon === 28) {
            he_so_quy_doi = 1.5;
        } else if (tong_diem_3_mon === 27) {
            he_so_quy_doi = 1.25;
        } else if (tong_diem_3_mon === 20) {
            he_so_quy_doi = 2;
        } else if (tong_diem_3_mon === 19) {
            he_so_quy_doi = 1.75;
        } else if (tong_diem_3_mon === 18) {
            he_so_quy_doi = 1.5;
        }

        if (value === 1) {
            document.getElementById('diem_quy_doi_1').value = he_so_quy_doi;
        } else if (value === 2) {
            document.getElementById('diem_quy_doi_2').value = he_so_quy_doi;
        } else if (value === 3) {
            document.getElementById('diem_quy_doi_3').value = he_so_quy_doi;
        } else if (value === 4) {
            document.getElementById('diem_quy_doi_4').value = he_so_quy_doi;
        } else if (value === 5) {
            document.getElementById('diem_quy_doi_5').value = he_so_quy_doi;
        }

        let diem_quy_doi_1 = document.getElementById('diem_quy_doi_1').value;
        let diem_quy_doi_2 = document.getElementById('diem_quy_doi_2').value;
        let diem_quy_doi_3 = document.getElementById('diem_quy_doi_3').value;
        let diem_quy_doi_4 = document.getElementById('diem_quy_doi_4').value;
        let diem_quy_doi_5 = document.getElementById('diem_quy_doi_5').value;

        let tong_diem_quy_doi = Number(diem_quy_doi_1) + Number(diem_quy_doi_2) + Number(diem_quy_doi_3) + Number(diem_quy_doi_4) + Number(diem_quy_doi_5);
        let tongdiemquydoi = document.getElementById('tong_diem_quy_doi').value;
        get_total_score();

    }


    // init the countries
    loadProvince();

    function setupImagePreview(inputFileId, imagePreviewId) {
        const inputFile = document.getElementById(inputFileId);
        const imagePreview = document.getElementById(imagePreviewId);
        if (inputFile) {
            inputFile.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    if (file.type === 'application/pdf') {
                        imagePreview.src = './images/common/default_filetype.png'
                    } else {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            imagePreview.src = e.target.result;
                        }
                        reader.readAsDataURL(file);
                    }
                } else {
                    imagePreview.src = ''; // Clear the preview if no file selected
                }
            });
        }

    }

    setupImagePreview('anh_hb_tieu_hoc', 'output-1');
    setupImagePreview('anh_giay_khai_sinh', 'output-2');
    setupImagePreview('anh_giay_xac_nhan_uu_tien', 'output-3');
    setupImagePreview('anh_chan_dung', 'output-4');
    setupImagePreview('anh_cccd', 'output-5');
    setupImagePreview('anh_ban_ck_cu_tru', 'output-6');
    setupImagePreview('don_dk_du_tuyen', 'output-7');

    function validateFile(input) {
        if (input.files && input.files[0]) {
            var fileType = input.files[0].type; // Loại tệp
            var fileSize = input.files[0].size; // Kích thước của tệp
            var maxSize = 5 * 1024 * 1024; // Kích thước tối đa là 5MB (đơn vị là byte)

            // Kiểm tra nếu không phải là tệp PDF hoặc ảnh
            if (fileType !== "application/pdf" && !fileType.startsWith("image/")) {
                alert("Loại tệp không được hỗ trợ. Vui lòng chọn tệp PDF hoặc ảnh.");
                input.value = ""; // Xóa tệp khỏi trường input
                return;
            }

            // Kiểm tra kích thước của tệp
            if (fileSize > maxSize) {
                alert("Kích thước tệp quá lớn. Vui lòng chọn tệp có kích thước nhỏ hơn.");
                input.value = ""; // Xóa tệp khỏi trường input
            }
        }
    }


    function get_diem_uu_tien(value) {
        let diem = Number(value);
        if (diem) {
            if (diem === 1) {
                document.getElementById('diem_uu_tien').value = 1.5;
            } else if (diem === 2) {
                document.getElementById('diem_uu_tien').value = 1;
            } else if (diem === 3) {
                document.getElementById('diem_uu_tien').value = 0.5;
            } else {
                document.getElementById('diem_uu_tien').value = 0;
            }
            $("#anh_giay_xac_nhan_uu_tien").prop('required', true);

            // let tong_diem = document.getElementById('tong_diem_quy_doi').value;
            get_total_score();
        }
        if (value === '0') {
            document.getElementById('diem_uu_tien').value = 0;
            $("#anh_giay_xac_nhan_uu_tien").prop('required', false);
            get_total_score();
        }
    }


    var timeout = null;
    var check_unique = false;
    $('#ma_hocsinh').keyup(function () {
        console.log('check_unique', check_unique)
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            jQuery.ajax({
                type: "POST",
                url: "ajax.php",
                data: 'get=ma_hs_vld&ma_hs_vld=' + $("#ma_hocsinh").val(),
                success: function (data) {
                    if (data) {
                        var responseObject = JSON.parse(data);
                        if (responseObject.status === 300) {
                            $("#check-student-code").html(responseObject.message);
                            $("#check-student-code").css({'display': 'block'});
                            check_unique = true;
                            $('#button_dangKy').prop("disabled", true);
                        } else if (responseObject.status === 200) {
                            $("#check-student-code").css({'display': 'none'});
                            check_unique = false;
                            // $('#button_dangKy').prop("disabled", false);
                        } else if (responseObject.status === 201) {
                            $("#check-student-code").css({'display': 'block'});
                            check_unique = true;
                            // $('#button_dangKy').prop("disabled", false);
                            $("#check-student-code").html(responseObject.message);
                        }
                    } else {
                        $("#check-student-code").html('Mã học sinh là bắt buộc')
                    }
                },
                error: function () {

                }
            });
        }, 500);
    });

    function get_total_score() {
        let diem_quy_doi_1 = document.getElementById('diem_quy_doi_1');
        let diem_quy_doi_2 = document.getElementById('diem_quy_doi_2');
        let diem_quy_doi_3 = document.getElementById('diem_quy_doi_3');
        let diem_quy_doi_4 = document.getElementById('diem_quy_doi_4');
        let diem_quy_doi_5 = document.getElementById('diem_quy_doi_5');
        let diem_uu_tien = document.getElementById('diem_uu_tien');

        console.log(diem_quy_doi_1); // Kiểm tra xem phần tử có được tìm thấy không
        console.log(diem_quy_doi_2);
        console.log(diem_quy_doi_3);
        console.log(diem_quy_doi_4);
        console.log(diem_quy_doi_5);
        console.log(diem_uu_tien);

        if (diem_quy_doi_1 && diem_quy_doi_2 && diem_quy_doi_3 && diem_quy_doi_4 && diem_quy_doi_5 && diem_uu_tien) {
            let tong_diem_quy_doi = Number(diem_quy_doi_1.value || 0) + Number(diem_quy_doi_2.value || 0) + Number(diem_quy_doi_3.value || 0) + Number(diem_quy_doi_4.value || 0) + Number(diem_quy_doi_5.value || 0) + Number(diem_uu_tien.value || 0);
            document.getElementById('tong_diem_xet_tuyen').value = tong_diem_quy_doi;
        } else {
            console.error('Không tìm thấy các phần tử quy đổi điểm trong DOM.');
        }
    }


    window.onload = function () {
        get_total_score();
    }

</script>

<script>
    $(document).on('submit', '#saveStudent', function (e) {
        e.preventDefault();
        var ma_hocsinh = document.getElementById('ma_hocsinh');
        var input = ma_hocsinh.value;
        var regex = /^\d{10}$/; // Biểu thức chính quy để kiểm tra xem đầu vào có chứa 10 chữ số hay không

        var warningMessage = document.getElementById('warningMessage');

        if (!regex.test(input)) {
            warningMessage.innerText = "Mã học sinh không hợp lệ. Phải là một số gồm 10 số";
            // ma_hocsinh.value = ""; // Xóa nội dung không hợp lệ
            ma_hocsinh.focus(); // Di chuyển trỏ chuột đến trường nhập liệu
            return;
        }

        // Nếu đầu vào hợp lệ, xóa thông báo
        warningMessage.innerText = "";

        var formData = new FormData(this);
        let anh_hb_tieu_hoc = document.getElementById('anh_hb_tieu_hoc');
        let anh_giay_khai_sinh = document.getElementById('anh_giay_khai_sinh');
        let anh_giay_xac_nhan_uu_tien = document.getElementById('anh_giay_xac_nhan_uu_tien');
        let anh_chan_dung = document.getElementById('anh_chan_dung');
        let anh_cccd = document.getElementById('anh_cccd');
        let anh_ban_ck_cu_tru = document.getElementById('anh_ban_ck_cu_tru');
        let don_dk_du_tuyen = document.getElementById('don_dk_du_tuyen');
        formData.append('picture_1', anh_hb_tieu_hoc.files[0]);
        formData.append('picture_2', anh_giay_khai_sinh.files[0]);
        formData.append('picture_3', anh_giay_xac_nhan_uu_tien.files[0]);
        formData.append('picture_4', anh_chan_dung.files[0]);
        formData.append('picture_5', anh_cccd.files[0]);
        formData.append('picture_6', anh_ban_ck_cu_tru.files[0]);
        formData.append('picture_7', don_dk_du_tuyen.files[0]);
        formData.append("save_student", true);

        $('#button_dangKy').prop("disabled", true);
        $('#button_dangKy').addClass('inactive');

        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function (responses) {
                console.log('response', responses)
                // Chuỗi JSON chứa nhiều phản hồi
                // var responses = '{"status":200,"message":"ok"}{"success":true}{"status":200,"message":"Student Created Successfully"}';

                // Tách các phản hồi JSON ra thành mảng
                var responseArray = responses.match(/({.*?})/g);

                // Xử lý từng phản hồi JSON
                try {
                    responseArray.forEach(function (response) {
                        var responseObject = JSON.parse(response);
                        // Kiểm tra trạng thái của phản hồi và thực hiện các hành động tương ứng
                        if (responseObject.status === 200) {
                            console.log("Status 200:", responseObject.message);
                            // Thực hiện hành động khi status là 200
                            $('#box-title-register-success').addClass('active');
                            $('#register-content').addClass('inactive');
                            $('#button_dangKy').prop("disabled", false);
                            $('#saveStudent')[0].reset();
                            $('#button_dangKy').removeClass('inactive');
                        } else {
                            console.log("responseObject", responseObject);
                            alert('Đã có lỗi xảy ra, vui lòng nhập lại');
                            $('#saveStudent')[0].reset();
                            $('#button_dangKy').removeClass('inactive');
                            $('.img-preview').remove();
                            // Thực hiện hành động khi status không phải là 200
                        }
                    });
                } catch (e) {
                    console.log(e)
                }
            }
        });

    });

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

<?php require('inc/footer.php'); ?>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload and Send Emails</title>
    <?php require('inc/links.php'); ?>
    <style>
        /* Biểu tượng loading spinner */
        .action .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: #3498db;
            border-radius: 50%;
            width: 25px; /* Kích thước chiều rộng của spinner */
            height: 25px; /* Kích thước chiều cao của spinner */
            animation: spin 1s linear infinite;
            display: none; /* Ẩn ban đầu */
            position: absolute;
            right: -11px;
            top: 23px;
        }

        .action {
            width: 230px;
            position: relative;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body class="bg-light">
<?php require('inc/header.php'); ?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h1>Upload and Send Emails</h1>
            <form id="uploadForm" enctype="multipart/form-data">
                <input type="file" class="form-control" name="file" id="file" required>
                <div class="action">
                    <button type="submit" class="btn btn-outline-primary mt-3" id="uploadButton">Upload and Send Emails</button>
                    <div class="spinner" id="loadingIcon"></div> <!-- Spinner loading -->
                </div>
            </form>
            <div id="status"></div>
            <div id="successCount"></div> <!-- Hiển thị số lượng email gửi thành công -->
        </div>
    </div>
</div>

<script>
    document.getElementById('uploadForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var fileInput = document.getElementById('file');
        if (fileInput.files.length == 0) {
            alert('Please select a file.');
            return;
        }

        var formData = new FormData();
        formData.append('file', fileInput.files[0]);

        var uploadButton = document.getElementById('uploadButton');
        var loadingIcon = document.getElementById('loadingIcon');

        uploadButton.disabled = true; // Tắt nút upload để tránh gửi nhiều lần
        loadingIcon.style.display = 'inline-block'; // Hiển thị spinner loading

        fetch('upload_data_email.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    processBatches(data.batches, uploadButton, loadingIcon);
                } else {
                    document.getElementById('status').innerText = data.message;
                    uploadButton.disabled = false; // Bật lại nút upload nếu có lỗi
                    loadingIcon.style.display = 'none'; // Ẩn spinner loading nếu có lỗi
                }
            })
            .catch(error => {
                console.error('Error:', error);
                uploadButton.disabled = false; // Bật lại nút upload nếu có lỗi
                loadingIcon.style.display = 'none'; // Ẩn spinner loading nếu có lỗi
            });
    });

    function processBatches(batches, uploadButton, loadingIcon) {
        let index = 0;
        let totalSuccessCount = 0; // Biến tổng số lượng email gửi thành công
        let successEmailsDiv = document.getElementById('successEmails');

        function sendNextBatch() {
            if (index < batches.length) {
                fetch('send_batch.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(batches[index])
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Hiển thị email đã gửi thành công ngay lập tức
                            if (data.successfulRecipients && Array.isArray(data.successfulRecipients)) {
                                data.successfulRecipients.forEach(recipient => {
                                    let p = document.createElement('p');
                                    p.innerText = 'Email sent to: ' + recipient;
                                    successEmailsDiv.appendChild(p); // Thêm email vào danh sách
                                });
                            }
                            totalSuccessCount += data.successCount; // Cập nhật tổng số lượng email gửi thành công
                        } else {
                            document.getElementById('status').innerText += data.message + '\n';
                        }
                        index++;
                        sendNextBatch();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            } else {
                document.getElementById('status').innerText += 'All batches processed. Total success count: ' + totalSuccessCount + '\n'; // Hiển thị tổng số lượng email gửi thành công
                document.getElementById('successCount').innerText = 'Total successful emails sent: ' + totalSuccessCount; // Hiển thị số lượng email gửi thành công
                uploadButton.disabled = false; // Bật lại nút upload sau khi hoàn thành
                loadingIcon.style.display = 'none'; // Ẩn spinner loading sau khi hoàn thành
            }
        }

        sendNextBatch();
    }

</script>
</body>
</html>

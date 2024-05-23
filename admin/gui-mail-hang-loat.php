<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload and Send Emails</title>
    <style>
        /* Biểu tượng loading spinner */
        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: #3498db;
            border-radius: 50%;
            width: 20px; /* Kích thước chiều rộng của spinner */
            height: 20px; /* Kích thước chiều cao của spinner */
            animation: spin 1s linear infinite;
            display: none; /* Ẩn ban đầu */
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>
<h1>Upload and Send Emails</h1>
<form id="uploadForm" enctype="multipart/form-data">
    <input type="file" name="file" id="file" required>
    <button type="submit" id="uploadButton">Upload and Send Emails</button>
    <div class="spinner" id="loadingIcon"></div> <!-- Spinner loading -->
</form>
<div id="status"></div>

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
                    processBatches(data.batches);
                } else {
                    document.getElementById('status').innerText = data.message;
                }
                uploadButton.disabled = false; // Bật lại nút upload sau khi hoàn thành
                loadingIcon.style.display = 'none'; // Ẩn spinner loading
            })
            .catch(error => {
                console.error('Error:', error);
                uploadButton.disabled = false; // Bật lại nút upload nếu có lỗi
                loadingIcon.style.display = 'none'; // Ẩn spinner loading
            });
    });

    function processBatches(batches) {
        let index = 0;
        let totalSuccessCount = 0; // Biến tổng số lượng email gửi thành công

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
                            document.getElementById('status').innerText += 'Batch ' + (index + 1) + ' sent successfully!\n';
                            // Kiểm tra xem successfulRecipients có tồn tại và là một mảng không
                            if (data.successfulRecipients && Array.isArray(data.successfulRecipients)) {
                                data.successfulRecipients.forEach(recipient => {
                                    document.getElementById('status').innerText += 'Email sent to: ' + recipient.email + '\n'; // Hiển thị tên email đã gửi thành công
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
                document.getElementById('status').innerText += 'All batches processed. Total success count: ' + totalSuccessCount; // Hiển thị tổng số lượng email gửi thành công
            }
        }

        sendNextBatch();
    }
</script>
</body>
</html>

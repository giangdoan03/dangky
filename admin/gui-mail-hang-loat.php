<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload and Send Emails</title>
    <style>
        .loading {
            display: none; /* Ẩn icon loading ban đầu */
        }
    </style>
</head>
<body>
<h1>Upload and Send Emails</h1>
<form id="uploadForm" enctype="multipart/form-data">
    <input type="file" name="file" id="file" required>
    <button type="submit" id="uploadButton">Upload and Send Emails</button>
    <img src="loading.gif" alt="Loading..." class="loading" id="loadingIcon"> <!-- Biểu tượng loading -->
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

        document.getElementById('uploadButton').disabled = true; // Tắt nút upload để tránh gửi nhiều lần
        document.getElementById('loadingIcon').style.display = 'inline-block'; // Hiển thị icon loading

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
                document.getElementById('uploadButton').disabled = false; // Bật lại nút upload sau khi hoàn thành
                document.getElementById('loadingIcon').style.display = 'none'; // Ẩn icon loading
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('uploadButton').disabled = false; // Bật lại nút upload nếu có lỗi
                document.getElementById('loadingIcon').style.display = 'none'; // Ẩn icon loading
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
                            data.successfulRecipients.forEach(recipient => {
                                document.getElementById('status').innerText += 'Email sent to: ' + recipient.email + '\n'; // Hiển thị tên email đã gửi thành công
                            });
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

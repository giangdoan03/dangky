<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload and Send Emails</title>
</head>
<body>
<h1>Upload and Send Emails</h1>
<form id="uploadForm" enctype="multipart/form-data">
    <input type="file" name="file" id="file" required>
    <button type="submit">Upload and Send Emails</button>
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
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    function processBatches(batches) {
        let index = 0;

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
                        document.getElementById('status').innerText += data.message + '\n';
                        index++;
                        sendNextBatch();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            } else {
                document.getElementById('status').innerText += 'All batches processed.';
            }
        }

        sendNextBatch();
    }
</script>
</body>
</html>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Panel - Settings</title>
    <?php require('inc/links.php'); ?>
    <style>

    </style>
</head>
<body class="bg-light">
<?php require('inc/header.php'); ?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h1>Send Bulk Email</h1>
            <form action="send_emails.php" method="post" enctype="multipart/form-data">
                <label for="file">Select CSV file:</label>
                <input type="file" class="form-control" name="file" id="file" accept=".xlsx" required><br>
                <button type="submit" class="btn btn-outline-secondary">Send Emails</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>



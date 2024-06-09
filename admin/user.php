<?php
require('inc/essentials.php');
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

    <script src="https://www.google.com/recaptcha/api.js?render=6LfNZPQpAAAAANu4PQ0RwHuWxkRnb5-1DhDtWHbx"></script>
    <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">
<?php require('inc/header.php'); ?>
<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">THÊM USER ADMIN</h3>
            <!-- General settings section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div style="max-width: 500px; margin: 0 auto">
                        <form action="submit_user.php" method="post" id="myForm">
                            <input type="text" class="form-control mb-3" name="username" placeholder="Username" required>
                            <input type="password" class="form-control mb-3" name="password" placeholder="Password" required>
                            <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                            <button type="submit" class="btn btn-primary mb-3">Tạo mới</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('6LfNZPQpAAAAANu4PQ0RwHuWxkRnb5-1DhDtWHbx', {action: 'submit'}).then(function(token) {
            document.getElementById('recaptchaResponse').value = token;
        });
    });
</script>
<?php require('inc/scripts.php'); ?>
</body>
</html>
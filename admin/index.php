<?php
ob_start();
require('./inc/essentials.php');
require('./inc/db_config.php');

session_start();
if ((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
    redirect('dashboard.php');
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login Panel</title>
    <?php require('inc/links.php'); ?>
    <style>
        div.login-form {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
        }
    </style>
</head>
<body class="bg-light">
<div class="login-form text-center rounded bg-white shadow overflow-hidden">
    <form method="POST">
        <h4 class="bg-dark text-white py-3">ADMIN LOGIN PANEL</h4>
        <div class="p-4">
            <div class="mb-3">
                <input name="admin_name" required type="text" class="form-control shadow-none text-center"
                       placeholder="Admin Name">
            </div>
            <div class="mb-4">
                <input name="admin_pass" required type="password" class="form-control shadow-none text-center"
                       placeholder="Password">
            </div>
            <button name="login" type="submit" class="btn text-white custom-bg shadow-none">LOGIN</button>
        </div>
    </form>
</div>
<?php if(isset($_POST['login'])) {
    $admin_name = mysqli_real_escape_string($conn,$_POST["admin_name"]);
    $admin_pass = mysqli_real_escape_string($conn,$_POST["admin_pass"]);
    $query = "SELECT * FROM admin_cred WHERE admin_name = '$admin_name'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($admin_pass, $row["admin_pass"])) {
            //        session_start();
            $_SESSION['adminLogin'] = true;
            $_SESSION['adminId'] = $row['sr_no'];
            redirect('dashboard.php');

        } else {
            alert('error', 'Invalid username or password');
        }
    } else {
        alert('error', 'Login failed - Invalid Credentials');

    }
}?>
<?php require('inc/scripts.php'); ?>
<?php ob_end_flush(); ?>
</body>
</html>
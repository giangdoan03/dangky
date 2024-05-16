<?php
require('../inc/essentials.php');
adminLogin();

if (isset($_POST['get_all_student'])){
    $res = selectAll('students');
    $i = 0;


}
?>
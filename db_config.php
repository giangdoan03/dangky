<?php
$servername='localhost';
$username='root';
$password='';
$dbname = "dangky";
$conn=mysqli_connect($servername,$username,$password,"$dbname");
mysqli_set_charset($conn, 'UTF8');
if(!$conn){
    die('Could not Connect MySql Server:' .mysql_error());
}
?>
<?php 
session_start();
require("connect_db.php");

$email = $_POST['email'];
$pass = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email' AND password='$pass'";
$result = $connect->query($sql);

if($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $_SESSION['email'] = $row['email'];
    $_SESSION['role'] = $row['role'];
    if($row['role'] == 'admin') {
        header('Location: admin_dashboard.php');
    } else {
        header('Location: user_dashboard.php');
    }
} else {
    echo"Invalid login! <a href='index.php'>Try again</a>";
}
?>
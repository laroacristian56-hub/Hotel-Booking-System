<?php 
require("connect_db.php");

$email = $_POST['email'];
$fullname = $_POST['fullname'];
$phonenumber = $_POST['phonenumber'];
$password = $_POST['password'];
$role = "user";
$created_at = date("Y/m/d");

$sql = "INSERT into users(full_name, email, password, phone_number, role, created_at)VALUE('$fullname','$email','$password','$phonenumber','$role','$created_at')";
if($connect->query($sql)==true) {
    echo"Data inserted successfully";
} else {
    echo"Error".$connect->error;
}

$connect->close();

?>
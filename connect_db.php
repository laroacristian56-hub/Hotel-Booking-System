<?php 

$servername = "localhost";
$username = "root";
$password = "";
$databasename = "hotel-booking-database";

$connect = new mysqli($servername, $username, $password, $databasename);

if($connect->connect_error) {
    die("Connection failed!". $connect->connect_error);
}

?>
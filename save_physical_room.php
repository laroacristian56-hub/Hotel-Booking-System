<?php
include 'connect_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    // --- CASE 1: DELETE ROOM ---
    if ($action == 'delete') {
        $id = $_POST['id'];
        $sql = "DELETE FROM rooms WHERE id='$id'";
        if (mysqli_query($connect, $sql)) {
            echo "deleted";
        } else {
            echo "Error: " . mysqli_error($connect);
        }
        exit; // Stop here
    }

    // --- CASE 2: ADD or EDIT ROOM ---
    $room_number = $_POST['room_number'];
    $room_type_id = $_POST['room_type_id'];
    $status = $_POST['status'];

    if ($action == 'add') {
        // Check for duplicates first
        $check = mysqli_query($connect, "SELECT * FROM rooms WHERE room_number = '$room_number'");
        if (mysqli_num_rows($check) > 0) {
            echo "Error: Room Number already exists!";
            exit;
        }
        $sql = "INSERT INTO rooms (room_number, room_type_id, status) VALUES ('$room_number', '$room_type_id', '$status')";
    
    } else if ($action == 'edit') {
        $id = $_POST['room_id']; // Get the ID of the room we are editing
        $sql = "UPDATE rooms SET room_number='$room_number', room_type_id='$room_type_id', status='$status' WHERE id='$id'";
    }

    if (mysqli_query($connect, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>
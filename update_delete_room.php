<?php
include 'connect_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Check if it is a DELETE request
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $id = $_POST['room_id'];
        $sql = "DELETE FROM room_types WHERE id='$id'";
        
        if (mysqli_query($connect, $sql)) {
            echo "deleted";
        } else {
            echo "Error deleting: " . mysqli_error($connect);
        }
        exit;
    }

    // Otherwise, it is an UPDATE request
    $id = $_POST['room_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $capacity = $_POST['capacity'];
    $description = $_POST['description'];

    // Check if a new image was uploaded
    if (!empty($_FILES['room_image']['name'])) {
        $image = $_FILES['room_image']['name'];
        $target = "uploads/" . basename($image);
        move_uploaded_file($_FILES['room_image']['tmp_name'], $target);
        
        $sql = "UPDATE room_types SET name='$name', price_per_night='$price', capacity='$capacity', description='$description', image_path='$image' WHERE id='$id'";
    } else {
        // Update without changing image
        $sql = "UPDATE room_types SET name='$name', price_per_night='$price', capacity='$capacity', description='$description' WHERE id='$id'";
    }

    if (mysqli_query($connect, $sql)) {
        echo "updated";
    } else {
        echo "Error updating: " . mysqli_error($connect);
    }
}
?>
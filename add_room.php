<?php
include 'connect_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $capacity = $_POST['capacity'];
    $description = $_POST['description'];

    $image = $_FILES['room_image']['name'];
    $target = "uploads/" . basename($image);

    $sql = "INSERT INTO room_types (name, description, price_per_night, capacity, image_path) 
            VALUES ('$name', '$description', '$price', '$capacity', '$image')";

    if (mysqli_query($connect, $sql)) {
        // 1. GET THE ID OF THE NEWLY CREATED ROOM
        $new_id = mysqli_insert_id($connect);
        
        move_uploaded_file($_FILES['room_image']['tmp_name'], $target);

        ?>
        <div class="room-card" 
             style="cursor: pointer;"
             onclick="openEditModal(
                '<?php echo $new_id; ?>', 
                '<?php echo addslashes($name); ?>', 
                '<?php echo $price; ?>', 
                '<?php echo $capacity; ?>', 
                '<?php echo addslashes($description); ?>'
             )">
             
            <img src="uploads/<?php echo $image; ?>" alt="Room Image">
            <div class="room-card-body">
                <h3><?php echo $name; ?></h3>
                <p class="price">₱<?php echo number_format($price, 2); ?></p>
                <p style="font-size: 14px; color: #555;">Capacity: <?php echo $capacity; ?> persons</p>
            </div>
        </div>
        <?php
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>
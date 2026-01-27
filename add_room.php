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
        move_uploaded_file($_FILES['room_image']['tmp_name'], $target);

        ?>
        <div class="room-card">
            <img src="uploads/<?php echo $image; ?>" alt="Room Image">
            <div class="room-card-body">
                <h3><?php echo $name; ?></h3>
                <p class="price">₱<?php echo number_format($price, 2); ?></p>
                <p style="font-size: 14px; color: #555;">Capacity: <?php echo $capacity; ?> persons</p>
            </div>
        </div>
        <?php
    } else {
        echo "Error"; // Simple error message
    }
}
?>
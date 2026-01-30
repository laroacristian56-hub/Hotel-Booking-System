<?php
include 'connect_db.php';

$sql = "SELECT id, name FROM room_types ORDER BY name ASC";
$result = mysqli_query($connect, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "<option value='".$row['id']."'>".$row['name']."</option>";
    }
} else {
    echo "<option value='' disabled>No room types found</option>";
}
?>
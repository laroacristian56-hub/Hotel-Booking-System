<?php
include 'connect_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];
    $new_status = $_POST['status'];

    // Update the Booking Status
    $sql = "UPDATE bookings SET status = '$new_status' WHERE id = '$booking_id'";

    if (mysqli_query($connect, $sql)) {
        
        $query = "SELECT room_id FROM bookings WHERE id = '$booking_id'";
        $result = mysqli_query($connect, $query);
        
        if ($row = mysqli_fetch_assoc($result)) {
            $room_id = $row['room_id'];

            //Update the Physical Room Status automatically
            // Check if theres a valid room_id
            if (!empty($room_id)) {
                
                if ($new_status == 'confirmed') {
                    // If confirmed, the room is now Occupied
                    $room_sql = "UPDATE rooms SET status = 'occupied' WHERE id = '$room_id'";
                    mysqli_query($connect, $room_sql);
                
                } elseif ($new_status == 'checked_out' || $new_status == 'cancelled') {
                    
                    $room_sql = "UPDATE rooms SET status = 'available' WHERE id = '$room_id'";
                    mysqli_query($connect, $room_sql);
                }
            }
        }

        echo "success";
    } else {
        echo "Error updating record: " . mysqli_error($connect);
    }
}
?>
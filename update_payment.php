<?php
include 'connect_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_id = $_POST['payment_id'];
    $new_status = $_POST['status'];

    // 1. UPDATE PAYMENT STATUS
    $sql = "UPDATE payments SET status = '$new_status' WHERE id = '$payment_id'";

    if (mysqli_query($connect, $sql)) {
        
        // --- LOGIC CHAIN: IF REFUNDED, CANCEL EVERYTHING ---
        if ($new_status == 'refunded') {
            
            // A. FIND THE LINKED BOOKING
            $find_booking = mysqli_query($connect, "SELECT booking_id FROM payments WHERE id = '$payment_id'");
            $row = mysqli_fetch_assoc($find_booking);
            $booking_id = $row['booking_id'];

            if (!empty($booking_id)) {
                // B. CANCEL THE BOOKING
                mysqli_query($connect, "UPDATE bookings SET status = 'cancelled' WHERE id = '$booking_id'");

                // C. FREE UP THE ROOM (Find which room was used)
                $find_room = mysqli_query($connect, "SELECT room_id FROM bookings WHERE id = '$booking_id'");
                $room_row = mysqli_fetch_assoc($find_room);
                $room_id = $room_row['room_id'];

                if (!empty($room_id)) {
                    mysqli_query($connect, "UPDATE rooms SET status = 'available' WHERE id = '$room_id'");
                }
            }
        }
        
        // --- LOGIC CHAIN: IF PAID (VERIFIED), CONFIRM BOOKING ---
        // Optional: If you want verifying payment to auto-confirm the booking
        if ($new_status == 'paid') {
             $find_booking = mysqli_query($connect, "SELECT booking_id FROM payments WHERE id = '$payment_id'");
             $row = mysqli_fetch_assoc($find_booking);
             $booking_id = $row['booking_id'];
             
             if (!empty($booking_id)) {
                 mysqli_query($connect, "UPDATE bookings SET status = 'confirmed' WHERE id = '$booking_id'");
                 
                 // Note: We don't mark room 'occupied' yet because check-in might be next month.
                 // Usually, rooms become 'occupied' only upon actual Check-In.
                 // But if you want to reserve it immediately, you can add that logic here.
             }
        }

        echo "success";
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>
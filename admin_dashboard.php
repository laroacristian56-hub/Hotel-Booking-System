<?php
include 'connect_db.php';
session_start();

// FETCH ROOMS
$room_sql = "SELECT * FROM room_types";
$room_result = mysqli_query($connect, $room_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/theme.css">
    <title>Hotel Booking System</title>
    <style>
        
    </style>
</head>
<body>

    <div id="profile-modal-bg">
        <div id="profile-modal-content">
            <span class="close-btn" onclick="closeProfile()">&times;</span>
            <img src="assets/admin.png" alt="admin-profile">
            <h2>ADMIN</h2>
            <br><hr><br>
            <button type="button" id="settings-btn"><i class="bi bi-gear-fill"></i> Settings</button>
            <br><br>
            <button type="button" id="logout-btn"><i class="bi bi-box-arrow-right"></i> Logout</button>
        </div>
    </div>

    <section id="sidebar">
        <a href="admin_dashboard.php" id="home-btn"><img src="assets/logo/logo.png" alt="logo"></a>
        <br><br><br>
        <button id="dashboard-btn" class="sidebar-btn" onclick="openDashboardPage()"><i class="bi bi-window-sidebar"></i>&nbsp; Dashboard</button>
        <button id="rooms-btn" class="sidebar-btn" onclick="openRoomPage()"><i class="bi bi-house-gear"></i>&nbsp; Rooms</button>
        <button id="booking-btn" class="sidebar-btn" onclick="openBookingPage()"><i class="bi bi-calendar-check"></i>&nbsp; Booking</button>
        <button id="payment-btn" class="sidebar-btn" onclick="openPaymentPage()"><i class="bi bi-credit-card"></i>&nbsp; Payment</button>
        <button id="reports-btn" class="sidebar-btn" onclick="openReportsPage()"><i class="bi bi-bar-chart-line"></i>&nbsp; Reports</button>
    </section>
    
    <main>
        <nav id="header">
            <h2 id="mainTitleText">Dashboard</h2>
            <div id="head-right">
                <div id="realtime-clock" class="d-none d-md-block text-secondary small fw-bold px-3"></div>
                <button title="profile-btn" type="button" onclick="openProfile()"><i class="bi bi-person-circle"></i></button>
            </div>
        </nav>

        <section id="dashboard-page">
            <p>Dashboard</p>
            <button onclick="toggleTheme()">Toggle Theme</button>
        </section>

        <section id="rooms-page">
            <button id="openAddRoomBtn" class="add-btn">+ Add New Room</button>

            <div id="addRoomModal" class="modal">
                <div class="modal-content">
                    <span class="close-modal">&times;</span>
                    <h2 style="text-align: center; margin-bottom: 20px;">Add New Room Type</h2>
                    
                    <form id="addRoomForm" enctype="multipart/form-data">
                        <p>Room Type Name</p>
                        <input type="text" name="name" placeholder="e.g. Deluxe Suite" required>

                        <p>Price per Night</p>
                        <input type="number" name="price" placeholder="e.g. 1500" required>

                        <p>Max Capacity (Persons)</p>
                        <input type="number" name="capacity" placeholder="e.g. 2" required>

                        <p>Description</p>
                        <textarea name="description" rows="4" placeholder="List amenities like AC, WiFi..."></textarea>

                        <p>Room Image</p>
                        <input type="file" name="room_image" required>

                        <button type="submit" class="submit-btn">Add Room</button>
                    </form>
                </div>
            </div>


            <div class="room-list-container" id="roomContainer">
                <?php 
                if (mysqli_num_rows($room_result) > 0) {
                    while($row = mysqli_fetch_assoc($room_result)) {
                ?>
                    <div class="room-card">
                        <img src="uploads/<?php echo $row['image_path']; ?>" alt="Room Image">
                        <div class="room-card-body">
                            <h3><?php echo $row['name']; ?></h3>
                            <p class="price">₱<?php echo number_format($row['price_per_night'], 2); ?></p>
                            <p style="font-size: 14px; color: #555;">Capacity: <?php echo $row['capacity']; ?> persons</p>
                        </div>
                    </div>
                <?php 
                    }
                } else {
                    echo "<p id='no-rooms-msg'>No rooms added yet.</p>";
                }
                ?>
            </div>
        </section>

        <section id="booking-page">
            <p>Booking</p>
        </section>
        <section id="payment-page">
            <p>Payment</p>
        </section>
        <section id="reports-page">
            <p>Reports</p>
        </section>
    </main>
</body>
<script src="script/admin_dashboard.js"></script>

</html>
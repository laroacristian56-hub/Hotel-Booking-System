<?php
include 'connect_db.php';
session_start();

// FETCH ROOMS
$room_sql = "SELECT * FROM room_types";
$room_result = mysqli_query($connect, $room_sql);

// FETCH BOOKINGS
$booking_sql = "SELECT b.*, u.full_name, r.name as room_name 
                FROM bookings b 
                JOIN users u ON b.user_id = u.id 
                JOIN room_types r ON b.room_type_id = r.id 
                ORDER BY b.created_at DESC";
$booking_result = mysqli_query($connect, $booking_sql);

// FETCH ROOM TYPES FOR DROPDOWN
$types_sql = "SELECT * FROM room_types";
$types_result = mysqli_query($connect, $types_sql);

// FETCH PHYSICAL ROOMS (INVENTORY)
$inventory_sql = "SELECT rooms.*, room_types.name as type_name 
                  FROM rooms 
                  JOIN room_types ON rooms.room_type_id = room_types.id 
                  ORDER BY rooms.room_number ASC";
$inventory_result = mysqli_query($connect, $inventory_sql);

// FETCH PAYMENTS
$payment_sql = "SELECT p.*, b.id as booking_ref, u.full_name 
                FROM payments p 
                JOIN bookings b ON p.booking_id = b.id 
                JOIN users u ON b.user_id = u.id 
                ORDER BY p.payment_date DESC";
$payment_result = mysqli_query($connect, $payment_sql);

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

<!-- =================== MODALS ======================= -->
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
<!-- =================== Add room MODAL ======================= -->
    <div id="addRoomModal" class="modal">
                <div class="modal-content">
                    <span class="close-modal">&times;</span>
                    <h2 style="text-align: center; margin-bottom: 20px; font-size: 1.2rem;">Add New Room Type</h2>
                    <br><br>
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
<!-- =================== Edit room MODAL ======================= -->
<div id="editRoomModal" class="modal">
            <div class="modal-content">
                <span class="close-modal" onclick="closeEditModal()">&times;</span>
                <h2 style="text-align: center; margin-bottom: 20px; font-size: 1.2rem;">Edit Room Details</h2>
                <br><br>
                <form id="editRoomForm" enctype="multipart/form-data">
                    <input type="hidden" name="room_id" id="edit_room_id">

                    <label>Room Name</label>
                    <input type="text" name="name" id="edit_name" required>

                    <label>Price per Night</label>
                    <input type="number" name="price" id="edit_price" required>

                    <label>Max Capacity</label>
                    <input type="number" name="capacity" id="edit_capacity" required>

                    <label>Description</label>
                    <textarea name="description" id="edit_description" rows="4"></textarea>

                    <label>Change Image (Optional)</label>
                    <input type="file" name="room_image">

                    <div style="display: flex; gap: 10px; margin-top: 15px;">
                        <button type="button" onclick="deleteRoom()" style="background: #dc3545; color: white; border: none; padding: 10px; flex: 1; border-radius: 4px; cursor: pointer;">Delete Room</button>
                        <button type="submit" class="submit-btn" style="flex: 1;">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

<!-- =================== Add/Edit Physical Room MODAL ======================= -->
 <div id="physicalRoomModal" class="modal">
            <div class="modal-content">
                <span class="close-modal" onclick="closePhysicalModal()">&times;</span>
                <h2 id="physicalModalTitle" style="text-align: center; margin-bottom: 20px; font-size: 1.2rem;">Add Physical Room</h2>
                <br><br>
                <form id="physicalRoomForm">
                    <input type="hidden" name="action" id="phy_action" value="add">
                    <input type="hidden" name="room_id" id="phy_room_id">

                    <label>Room Number</label>
                    <input type="text" name="room_number" id="phy_room_number" placeholder="e.g. 101" required>

                    <label>Room Type Category</label>
                    <select name="room_type_id" id="phy_room_type" required style="width: 100%; padding: 8px; margin-bottom: 15px; border-radius: 4px; border: 1px solid var(--border-color); background: var(--input-bg); color: var(--txt-color);">
                        <?php 
                        // Reuse the types result from the top of your file
                        mysqli_data_seek($types_result, 0);
                        while($type = mysqli_fetch_assoc($types_result)) {
                            echo "<option value='".$type['id']."'>".$type['name']."</option>";
                        }
                        ?>
                    </select>

                    <label>Current Status</label>
                    <select name="status" id="phy_status" style="width: 100%; padding: 8px; margin-bottom: 15px; border-radius: 4px; border: 1px solid var(--border-color); background: var(--input-bg); color: var(--txt-color);">
                        <option value="available">Available</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="occupied">Occupied</option>
                    </select>

                    <button type="submit" class="submit-btn">Save Room</button>
                </form>
            </div>
        </div>

    <section id="sidebar">
        <a href="admin_dashboard.php" id="home-btn"><img src="assets/logo/logo.png" alt="logo"></a>
        <p style="font-size: 1.2rem; font-weight: bold; width: 100%; text-align: center;">IvoryLuxe</p><br>
        <br>
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
                <button type="button" id="theme-toggle-btn" onclick="toggleTheme()"><i class="bi bi-moon-stars-fill"></i></button>
                <button title="profile-btn" type="button" onclick="openProfile()"><i class="bi bi-person-circle"></i></button>
            </div>
        </nav>

        <section id="dashboard-page">
            <p>Dashboard</p>
            
        </section>

        <section id="rooms-page">
            <button id="openAddRoomBtn" class="add-btn">+ Add New Room Type</button>
            <button onclick="openPhysicalModal('add')" class="add-btn" style="margin:0;">+ Add Room</button>

            
            <br><br><br>
            <h2 style="font-size: 1.2rem; margin-bottom: 0.5rem; margin-left: 1rem;">Room Types</h2>
            <div class="room-list-container" id="roomContainer">
            <?php 
            if (mysqli_num_rows($room_result) > 0) {
                while($row = mysqli_fetch_assoc($room_result)) {
            ?>
                <div class="room-card" 
                    style="cursor: pointer;"
                    onclick="openEditModal(
                        '<?php echo $row['id']; ?>', 
                        '<?php echo addslashes($row['name']); ?>', 
                        '<?php echo $row['price_per_night']; ?>', 
                        '<?php echo $row['capacity']; ?>', 
                        '<?php echo addslashes($row['description']); ?>'
                    )">
                    
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
                echo "<p id='no-rooms-msg'>No room types added yet.</p>";
            }
            ?>
        </div>


        <div class="inventory-section">
            <div style="display: flex; justify-content: space-between; align-items: center; margin: auto; margin-bottom: 15px; ">
                <h3>Room Management</h3>
        
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Room No.</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="inventoryTableBody">
                        <?php 
                        
                        $inventory_sql = "SELECT rooms.*, room_types.name as type_name 
                                        FROM rooms 
                                        JOIN room_types ON rooms.room_type_id = room_types.id 
                                        ORDER BY rooms.room_number ASC";
                        $inventory_result = mysqli_query($connect, $inventory_sql);

                        if (mysqli_num_rows($inventory_result) > 0) {
                            while($inv = mysqli_fetch_assoc($inventory_result)) {
                        ?>
                        <tr>
                            <td><strong><?php echo $inv['room_number']; ?></strong></td>
                            <td><?php echo $inv['type_name']; ?></td>
                            <td>
                                <span class="status-badge status-<?php echo $inv['status']; ?>">
                                    <?php echo ucfirst($inv['status']); ?>
                                </span>
                            </td>
                            <td>
                                <button class="edit-btn-small" 
                                    onclick="openPhysicalModal('edit', '<?php echo $inv['id']; ?>', '<?php echo $inv['room_number']; ?>', '<?php echo $inv['room_type_id']; ?>', '<?php echo $inv['status']; ?>')"
                                    style="background:#ffc107; color:black; border:none; padding:5px 10px; border-radius:4px; cursor:pointer; margin-right:5px;">
                                    Edit
                                </button>
                                
                                <button class="delete-btn-small" 
                                    onclick="deletePhysicalRoom(<?php echo $inv['id']; ?>)"
                                    style="background:#dc3545; color:white; border:none; padding:5px 10px; border-radius:4px; cursor:pointer;">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='4' style='text-align:center;'>No rooms added yet.</td></tr>";
                        }
                        ?>
                    </tbody>
                    </table>
                </div>
        </div>


        </section>

        <section id="booking-page">
            <br>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Guest Name</th>
                            <th>Room Type</th>
                            <th>Check-In</th>
                            <th>Check-Out</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (mysqli_num_rows($booking_result) > 0) {
                            while($book = mysqli_fetch_assoc($booking_result)) {
                                // Color code the status
                                $status_color = 'black';
                                if($book['status'] == 'pending') $status_color = '#ffc107'; // Orange
                                if($book['status'] == 'confirmed') $status_color = '#28a745'; // Green
                                if($book['status'] == 'cancelled') $status_color = '#dc3545'; // Red
                        ?>
                        <tr>
                            <td>#<?php echo $book['id']; ?></td>
                            <td><?php echo $book['full_name']; ?></td>
                            <td><?php echo $book['room_name']; ?></td>
                            <td><?php echo date('M d, Y', strtotime($book['check_in_date'])); ?></td>
                            <td><?php echo date('M d, Y', strtotime($book['check_out_date'])); ?></td>
                            <td>₱<?php echo number_format($book['total_price'], 2); ?></td>
                            
                            <td>
                                <select onchange="updateStatus(this, '<?php echo $book['id']; ?>')" 
                                        style="color: <?php echo $status_color; ?>; font-weight:bold; border: 1px solid #ccc; padding: 5px; border-radius: 4px;">
                                    <option value="pending" <?php if($book['status']=='pending') echo 'selected'; ?>>Pending</option>
                                    <option value="confirmed" <?php if($book['status']=='confirmed') echo 'selected'; ?>>Confirmed</option>
                                    <option value="cancelled" <?php if($book['status']=='cancelled') echo 'selected'; ?>>Cancelled</option>
                                    <option value="checked_out" <?php if($book['status']=='checked_out') echo 'selected'; ?>>Checked Out</option>
                                </select>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='7' style='text-align:center;'>No bookings found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
        <section id="payment-page">
            <p>Payment</p>

        <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Ref #</th>
                            <th>Guest Name</th>
                            <th>Booking ID</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Method</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (mysqli_num_rows($payment_result) > 0) {
                            while($pay = mysqli_fetch_assoc($payment_result)) {
                                // Color coding
                                $badge_class = 'status-' . $pay['status']; // e.g., status-paid
                        ?>
                        <tr>
                            <td><small><?php echo $pay['transaction_reference']; ?></small></td>
                            <td><?php echo $pay['full_name']; ?></td>
                            <td>#<?php echo $pay['booking_ref']; ?></td>
                            <td><strong>₱<?php echo number_format($pay['amount'], 2); ?></strong></td>
                            <td><?php echo ucfirst($pay['payment_type']); ?></td>
                            <td><?php echo $pay['payment_method']; ?></td>
                            <td><?php echo date('M d, Y', strtotime($pay['payment_date'])); ?></td>
                            <td>
                                <span class="status-badge <?php echo $badge_class; ?>">
                                    <?php echo ucfirst($pay['status']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if($pay['status'] == 'pending') { ?>
                                    <button onclick="updatePayment(<?php echo $pay['id']; ?>, 'paid')" 
                                            style="background:#28a745; color:white; border:none; padding:5px 10px; border-radius:4px; cursor:pointer;">
                                        Verify
                                    </button>
                                <?php } elseif($pay['status'] == 'paid') { ?>
                                    <button onclick="updatePayment(<?php echo $pay['id']; ?>, 'refunded')" 
                                            style="background:#dc3545; color:white; border:none; padding:5px 10px; border-radius:4px; cursor:pointer;">
                                        Refund
                                    </button>
                                <?php } else { echo "-"; } ?>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='9' style='text-align:center;'>No payment records found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </section>
        <section id="reports-page">
            <p>Reports</p>
        </section>
        <footer>
        <p>&copy; 2026 Ivory Luxe Hotel. All rights reserved.</p>
        </footer>
    </main>
</body>
<script src="script/admin_dashboard.js"></script>

</html>
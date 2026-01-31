<?php
session_start();
include 'connect_db.php';

// SECURITY CHECK
// If user_id is missing, or if they are an ADMIN trying to access user page, kick them out.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] == 'admin') {
    header("Location: index.php");
    exit();
}

// --- prevent the admin to access user dashboard ---
// 1. Check if logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// 2. Check if role is CORRECT
if ($_SESSION['role'] === 'admin') {
    // If an Admin tries to access this page, back to Admin Dashboard
    header("Location: admin_dashboard.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$full_name = $_SESSION['full_name'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/User_roompage.css">
    <link rel="stylesheet" href="css/theme.css">
    <title>Hotel Booking System</title>
    <style>
        
    </style>

</head>
<body>
    <div id="profile-modal-bg">
    <div id="profile-modal-content">
        <span class="close-btn" onclick="closeProfile()">&times;</span>
        
        <?php 
            // Default image
            $profile_img = 'assets/assets/default_profile.png'; 
            
            // If Admin, use admin image
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                $profile_img = 'assets/admin.png';
            }
        ?>
        <img src="<?php echo $profile_img; ?>" alt="profile" style="object-fit:cover;">

        <h2><?php echo isset($_SESSION['full_name']) ? $_SESSION['full_name'] : 'Guest'; ?></h2>
        <br><br>
        <p style="color: #666; margin-top: -15px; text-transform: uppercase; font-size: 12px;">
            <?php echo isset($_SESSION['role']) ? $_SESSION['role'] : ''; ?>
        </p>

        <br><hr><br>
        
        <button type="button" id="settings-btn"><i class="bi bi-gear-fill"></i> Settings</button>
        <br><br>
        
        <button type="button" id="logout-btn" onclick="confirmLogout()">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </div>
</div>

    <section id="sidebar">
        <a href="admin_dashboard.php" id="home-btn"><img src="assets/logo/logo.png" alt="logo"></a>
        <p style="font-size: 1.2rem; font-weight: bold; width: 100%; text-align: center;">IvoryLuxe</p><br>
        <br>
        <button id="dashboard-btn" class="sidebar-btn" onclick="openDashboardPage()"><i class="bi bi-window-sidebar"></i>&nbsp; Dashboard</button>
        <button id="rooms-btn" class="sidebar-btn" onclick="openRoomPage()"><i class="bi bi-house-gear"></i>&nbsp; Browse Rooms</button>
        <button id="booking-btn" class="sidebar-btn" onclick="openBookingPage()"><i class="bi bi-calendar-check"></i>&nbsp; Booking</button>
        <button id="payment-btn" class="sidebar-btn" onclick="openPaymentPage()"><i class="bi bi-credit-card"></i>&nbsp; Payment history</button>
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

        <section id="rooms-page" class="container">
    
        <div class="search-container">
            <form method="GET" action="user_dashboard.php" style="display: flex; gap: 15px; flex-wrap: wrap;">
            
                <div class="input-group">
                <label>Check-in</label>
                    <input type="date" name="checkin" 
                    min="<?php echo date('Y-m-d'); ?>" 
                    value="<?php echo isset($_GET['checkin']) ? $_GET['checkin'] : ''; ?>" 
                    required>
                </div>

                <div class="input-group">
                    <label>Check-out</label>
                    <input type="date" name="checkout" 
                    min="<?php echo date('Y-m-d'); ?>" 
                    value="<?php echo isset($_GET['checkout']) ? $_GET['checkout'] : ''; ?>" 
                    required>
                </div>
                
                <div class="input-group">
                    <label>Guests</label>
                    <input type="number" name="guests" min="1" value="<?php echo isset($_GET['guests']) ? $_GET['guests'] : '1'; ?>" placeholder="1">
                </div>

                <button type="submit" class="search-btn"><i class="bi bi-search"></i> Find Rooms</button>
                
                <?php if(isset($_GET['guests'])): ?>
                    <a href="user_dashboard.php" class="reset-link">Reset Filter</a>
                <?php endif; ?>
            </form>
            </div>
            <br><br>
            <div class="room-grid">
            <?php
            // --- PHP FILTER LOGIC ---
            $min_guests = isset($_GET['guests']) && is_numeric($_GET['guests']) ? $_GET['guests'] : 0;

            $sql = "SELECT rt.*, COUNT(r.id) as available_count 
                    FROM room_types rt 
                    JOIN rooms r ON rt.id = r.room_type_id 
                    WHERE r.status = 'available' 
                    AND rt.capacity >= '$min_guests' 
                    GROUP BY rt.id 
                    HAVING available_count > 0
                    ORDER BY rt.price_per_night ASC";

            $result = mysqli_query($connect, $sql);

            if(mysqli_num_rows($result) > 0) {
                while($room = mysqli_fetch_assoc($result)) {
                    
                    // Handle Image
                    $img_path = !empty($room['image_path']) ? "uploads/".$room['image_path'] : "assets/room_placeholder.jpg";
            ?>
            
            <div class="room-card">
                <div class="room-img" style="background-image: url('<?php echo $img_path; ?>');">
                    <span class="price-badge">₱<?php echo number_format($room['price_per_night']); ?> / night</span>
                </div>
                
                <div class="room-details">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <h3><?php echo $room['name']; ?></h3>
                        <span style="background: #e6fffa; color: #0D300D; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; border: 1px solid #0D300D;">
                            <?php echo $room['available_count']; ?> Available room(s)
                        </span>
                    </div>
                    
                    <div class="room-meta">
                        <span><i class="bi bi-people-fill"></i> <?php echo $room['capacity']; ?> Guests</span>
                        <span><i class="bi bi-wifi"></i> Free WiFi</span>
                    </div>
                    
                    <p><?php echo substr($room['description'], 0, 80); ?>...</p>
                    
                    <button class="book-btn" onclick="openBookingModal('<?php echo $room['id']; ?>', '<?php echo $room['name']; ?>', '<?php echo $room['price_per_night']; ?>')">
                        Book Now
                    </button>
                </div>
            </div>

            <?php 
                }
            } else {
                // Fallback: If no rooms are "Available" status
                echo "<div style='grid-column: 1/-1; text-align: center; padding: 40px; color: var(--txt-color); opacity: 0.7;'>
                        <h3>No rooms available right now.</h3>
                        <p>All rooms might be occupied or under maintenance. Please try different dates.</p>
                    </div>";
            }
            ?>
        </div>
        </section>

        <section id="booking-page">
            
        </section>
        <section id="payment-page">
            <p>Payment</p>

    
        </section>
        <section id="reports-page">
            <p>Reports</p>
        </section>
        <footer class="site-footer">
        <div class="footer-container">
            
            <div class="footer-col">
                <h3>IvoryLuxe Hotel</h3>
                <p>Experience luxury and comfort in the heart of the city. Your perfect getaway awaits.</p>
                <div class="social-links">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-twitter-x"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="user_home.php">Home</a></li>
                    <li><a href="#rooms-page">Our Rooms</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Legal</h4>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Refund Policy</a></li>
                    <li><a href="#">FAQs</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Contact Us</h4>
                <ul class="contact-info">
                    <li><i class="bi bi-geo-alt-fill"></i> 123 Luxury Ave, Quezon City</li>
                    <li><i class="bi bi-telephone-fill"></i> +63 912 345 6789</li>
                    <li><i class="bi bi-envelope-fill"></i> reservations@ivoryluxe.com</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date("Y"); ?> IvoryLuxe Hotel. All rights reserved.</p>
        </div>
    </footer>
    </main>
</body>
<script src="script/dashboard.js"></script>

</html>
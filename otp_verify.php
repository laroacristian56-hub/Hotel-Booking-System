<?php
session_start();
include 'connect_db.php';

// Prevent direct access: User must have passed the password check first
if (!isset($_SESSION['temp_user_id'])) {
    header("Location: index.php");
    exit();
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_otp = $_POST['otp_code'];
    $user_id = $_SESSION['temp_user_id'];
    
    // 1. Fetch the real OTP and Expiry from DB
    $sql = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);

    $db_otp = $row['otp'];
    $db_expiry = $row['otp_expiry'];
    $current_time = date("Y-m-d H:i:s");

    // 2. Verify Logic
    if ($db_otp == $user_otp) {
        // Check if expired
        if ($db_expiry > $current_time) {
            
            // --- SUCCESS! PROMOTING SESSION ---
            
            // A. Set the REAL session variables (Login is now complete)
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role']; 
            $_SESSION['full_name'] = $row['full_name'];

            // B. Clear the OTP from DB so it can't be reused
            mysqli_query($connect, "UPDATE users SET otp = NULL, otp_expiry = NULL WHERE id = '$user_id'");
            
            // C. Remove temporary session
            unset($_SESSION['temp_user_id']);

            // D. Redirect based on role
            if($row['role'] == 'admin'){
                header("Location: admin_dashboard.php");
            } else {
                header("Location: user_dashboard.php");
            }
            exit();

        } else {
            $error = "OTP has expired. Please try logging in again.";
        }
    } else {
        $error = "Invalid OTP code. Please check your email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/theme.css">
    <title>Verify Login - IvoryLuxe</title>
    <style>
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css");
        @import url('https://fonts.googleapis.com/css2?family=Google+Sans:ital,opsz,wght@0,17..18,400..700;1,17..18,400..700&display=swap');

        body {
            font-family: "Google Sans", sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: var(--main-bg);
            margin: 0;
        }
        .otp-card {
            background: var(--body-bg);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
            width: 100%;
            max-width: 350px;
            border: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .otp-card h2 {
            margin-top: 0;
            color: var(--txt-color); 
        }
        .otp-card p {
            color: #666;
            margin-bottom: 25px;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
            letter-spacing: 8px; 
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            outline: none;
            transition: border 0.3s;
        }
        input[type="text"]:focus {
            border-color: var(--main-color);
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: var(--main-color);
            color: var(--sidebar-txt-color);
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }
        button:hover {
            background-color: #145231;
        }
        .error-msg {
            background-color: var(--body-bg);
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
            border: 1px solid #f5c6cb;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            color: #777;
            text-decoration: none;
            font-size: 14px;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="otp-card">
        <h2>Authentication</h2>
        <p>Please enter the 6-digit code sent to your email address.</p>
        
        <?php if($error): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="otp_code" maxlength="6" placeholder="000000" required autocomplete="off" autofocus>
            <button type="submit">Verify Login</button>
        </form>
        
        <a href="index.php" class="back-link">← Cancel and Go Back</a>
    </div>

</body>
<script>
    // --- DARK THEME TOGGLE ---
function toggleTheme() {
    document.body.classList.toggle('dark-theme');
    const themeBtn = document.getElementById('theme-toggle-btn');
    if (document.body.classList.contains('dark-theme')) {
        themeBtn.innerHTML = '<i class="bi bi-sun-fill"></i>';
    } else {
        themeBtn.innerHTML = '<i class="bi bi-moon-stars-fill"></i>';
    }
    
    // Save preference to local storage
    if (document.body.classList.contains('dark-theme')) {
        localStorage.setItem('theme', 'dark');
    } else {
        localStorage.setItem('theme', 'light');
    }
}

// Check preference on load
if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark-theme');
    const themeBtn = document.getElementById('theme-toggle-btn');
    themeBtn.innerHTML = '<i class="bi bi-sun-fill"></i>';
}
</script>
</html>
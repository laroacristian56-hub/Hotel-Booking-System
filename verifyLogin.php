<?php
session_start();
include 'connect_db.php';
include 'send_email.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($connect, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        if ($password == $row['password']) {
            
            // --- ADMIN LOGIN (Bypass OTP) ---
            if ($row['role'] == 'admin') {
                // Set session variables
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['role'] = $row['role']; 
                $_SESSION['full_name'] = $row['full_name'];

                // Direct redirect to Admin Dashboard
                echo "<script>window.location.href='admin_dashboard.php';</script>";
                exit();
            }

            // --- USER LOGIN (Require OTP) ---
            else {
                // Generate OTP
                $otp = rand(100000, 999999);
                $expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));

                // Save to DB
                $update_sql = "UPDATE users SET otp = '$otp', otp_expiry = '$expiry' WHERE id = " . $row['id'];
                mysqli_query($connect, $update_sql);

                // SEND EMAIL via PHPMailer
                if (sendOTPEmail($email, $otp)) {
                    // Success: Set TEMP session and move to OTP Page
                    $_SESSION['temp_user_id'] = $row['id'];
                    echo "<script>alert('OTP sent to your email!'); window.location.href = 'otp_verify.php';</script>";
                
                } else {
                    echo "<script>alert('Error: Could not send OTP email. Check internet or credentials.'); window.location.href = 'index.php';</script>";
                }
            }

        } else {
            echo "<script>alert('Invalid Password'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('User not found'); window.location.href='index.php';</script>";
    }
}
?>
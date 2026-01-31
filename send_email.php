<?php

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendOTPEmail($recipientEmail, $otp) {
    $mail = new PHPMailer(true);

    try {
        // 1. Server Settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        
        // --- YOUR GMAIL CREDENTIALS ---
        $mail->Username   = 'apksci60@gmail.com';         // Replace with your Gmail
        $mail->Password   = 'zkzy wqxn ghvi xjju';          // App password for Gmail
        // ------------------------------
        
        $mail->SMTPSecure = 'ssl'; 
        $mail->Port       = 465;                            // 587 for TLS, 465 for SSL

        // 2. Recipients
        $mail->setFrom('apksci60@gmail.com', 'Hotel Admin'); // Sender
        $mail->addAddress($recipientEmail);                    // Receiver

        // 3. Content
        $mail->isHTML(true);
        $mail->Subject = 'Your Login Verification Code';
        
        // HTML Email Body
        $mail->Body = "
<div style='background-color: #f4f4f4; padding: 40px 0; font-family: \"Helvetica Neue\", Helvetica, Arial, sans-serif; color: #333;'>
    
    <div style='max-width: 500px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05);'>
        
        <div style='background-color: #0D300D; padding: 30px 20px; text-align: center;'>
            <h1 style='color: #ffffff; margin: 0; font-size: 24px; letter-spacing: 2px; text-transform: uppercase;'>IvoryLuxe Hotel</h1>
        </div>

        <div style='padding: 40px 30px; text-align: center;'>
            <h2 style='color: #0D300D; margin-top: 0; font-size: 20px;'>Verification Required</h2>
            <p style='font-size: 15px; color: #666; line-height: 1.6; margin-bottom: 30px;'>
                You are attempting to sign in to your IvoryLuxe account. Please use the code below to complete your login.
            </p>

            <div style='margin: 0 auto 30px auto; width: fit-content; background: #f8f9fa; border: 1px dashed #0D300D; padding: 15px 30px; border-radius: 6px;'>
                <span style='display: block; font-size: 32px; font-weight: bold; letter-spacing: 8px; color: #0D300D;'>$otp</span>
            </div>

            <p style='font-size: 14px; color: #888; margin-bottom: 5px;'>This code will expire in <strong>5 minutes</strong>.</p>
            <p style='font-size: 13px; color: #aaa; margin-top: 0;'>If you did not initiate this login, please ignore this email.</p>
        </div>

        <div style='background-color: #f1f1f1; padding: 15px; text-align: center; font-size: 12px; color: #888;'>
            <p style='margin: 0;'>&copy; " . date("Y") . " IvoryLuxe Hotel. All rights reserved.</p>
            <p style='margin: 5px 0 0 0;'>Quezon City, Metro Manila</p>
        </div>
    </div>
</div>
";
        
        $mail->AltBody = "Your OTP is: $otp"; // For non-HTML mail clients

        $mail->send();
        return true;
    } catch (Exception $e) {
        // For debugging purposes only (remove in production)
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}
?>
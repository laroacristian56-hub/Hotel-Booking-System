<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/create-account.css">
    <link rel="stylesheet" href="css/theme.css">
    <title>Hotel Booking - Create Account</title>
</head>
<body>
    <main>
        <form action="verifyCreateAccount.php" method="post" id="createAccountForm">
            <h2 style="width: 100%; text-align: center;">Create Account</h2><br><br>
            <section>
                <input type="text" name="email" id="email" placeholder="Email"><br>
            </section>
            <section>
                <input type="text" name="fullname" id="fullname" placeholder="Fullname">
            </section>
            <section>
                <input type="number" name="phonenumber" id="phonenumber" placeholder="Phone number">
            </section>
            <section>
                <input type="password" name="password" id="password" placeholder="Password">
            </section>
            <section>
                <input type="password" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password">
            </section>
            
            <br><br>
            <button type="submit">Create Account</button><br><br>

            <p>Already have an account? <a href="index.php">Login here</a></p>
        </form>
    </main>
</body>
</html>

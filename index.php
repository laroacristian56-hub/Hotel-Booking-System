<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/theme.css">
    <title>Hotel Booking - Login</title>
</head>
<body>
    <main>
        <form action="verifyLogin.php" method="post" id="loginForm">
            <h2 style="width: 100%; text-align: center;">Welcome Back</h2><br><br>
            <section>
                <input type="text" name="email" id="email" placeholder="Email"><br>
            </section>
            <section>
                <input type="password" name="password" id="password" placeholder="Password">
                <button type="button" id="eyeBtn" onclick="toggleEyePass()"><i class="bi bi-eye-fill"></i></button>
            </section>
            <div id="options">
                <div style="display: flex; align-items: center;">
                    <input type="checkbox" id="rememberMe">&nbsp;
                    <label for="rememberMe">Stay signed in</label>
                </div>
                
                <a href="">Forgot password?</a>
            </div>
            
            <br><br>
            <button type="submit">Login</button>

            <p>Not registered? <a href="create_account.php">Register here</a></p>
        </form>
    </main>
</body>

<script src="script/script.js"></script>
</html>

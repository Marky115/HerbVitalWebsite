<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HerbVita</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container1">
        <div class="loginImg">
            <img src="./img/loginImg.png" alt="loginImg">
        </div>
        <div class="loginContent">
            <h2>Login</h2>

            <?php
         
            if (isset($_SESSION['signup_success'])) {
                echo '<div class="success-message">' . htmlspecialchars($_SESSION['signup_success']) . '</div>';
                unset($_SESSION['signup_success']);
            }

         
            if (isset($_SESSION['login_error'])) {
                echo '<div class="error-message">' . htmlspecialchars($_SESSION['login_error']) . '</div>';
                unset($_SESSION['login_error']);
            }
            ?>

            <form action="login-process.php" method="post">
                <label for="userID">User ID:</label>
                <input type="text" id="userID" name="userID" required><br><br>
    
                <label for="passwordHash">Password:</label>
                <input type="password" id="passwordHash" name="passwordHash" required><br><br>
    
                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        </div>
    </div>
</body>
</html>